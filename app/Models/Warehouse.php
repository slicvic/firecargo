<?php namespace App\Models;

use DB;
use App\Helpers\Math;
use App\Models\CompanyTrait;
use App\Presenters\PresentableTrait;

/**
 * Warehouse
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse extends Base {

    use CompanyTrait, PresentableTrait;

    protected $presenter = 'App\Presenters\Warehouse';

    protected $table = 'warehouses';

    protected $fillable = [
        'shipper_user_id',
        'consignee_user_id',
        'carrier_id',
        'arrived_at',
        'notes'
    ];

    /**
     * Gets the shipper.
     */
    public function shipper()
    {
        return $this->belongsTo('App\Models\User', 'shipper_user_id');
    }

    /**
     * Gets the consignee.
     */
    public function consignee()
    {
        return $this->belongsTo('App\Models\User', 'consignee_user_id');
    }

    /**
     * Gets the carrier.
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier', 'carrier_id');
    }

    /**
     * Gets the company.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Gets the site.
     */
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * Gets the packages.
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Creates ands assigns the packages to the warehouse.
     *
     * @param  array $packages
     * @param  bool  $detaching
     *   If TRUE, after this operation is complete,
     *   only the packages in the array will be left
     * @return void
     */
    public function syncPackages($packages, $detaching = TRUE)
    {
        $ids = (is_array($packages)) ? array_keys($packages) : [];

        // First we need to delete the packages not specified in the array
        if ($detaching) {
            Package::whereNotIn('id', $ids)->delete();
        }

        // Terminate if there's nothing more to add or update
        if (empty($ids))
            return;

        // Next, we will add or update the remaining packages
        $consignee = $this->consignee;

        foreach ($packages as $id => $data) {
            $package = Package::firstOrCreate(['id' => $id, 'warehouse_id' => $this->id]);
            $data['ship'] = $consignee->autoship_packages;
            $package->update($data);
        }
    }

    /**
     * Overrides parent method to sanitize certain attributes.
     *
     * @see parent::setAttribute()
     */
    public function setAttribute($key, $value)
    {
        switch ($key) {
            case 'arrived_at':
                if (is_string($value)) {
                    $value = date('Y-m-d H:i:s', strtotime($value));
                }
                else if (is_array($value) && isset($value['date'], $value['time'])) {
                    $value = date('Y-m-d H:i:s', strtotime($value['date'] . ' ' . $value['time']));
                }
                else {
                    $value = NULL;
                }
                break;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Calculates the actual weight of the warehouse in pounds.
     *
     * @return float
     */
    public function calculateGrossWeight()
    {
        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['weight'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += $package->weight;
        }

        return $total;
    }

    /**
     * Calculates the volume weight of the warehouse in pounds.
     *
     * @return float
     */
    public function calculateVolumeWeight()
    {
        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['length', 'width', 'height'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += Math::calculateVolumeWeight($package->length, $package->width, $package->height);
        }

        return $total;
    }

    /**
     * Calculates the cubic feet.
     *
     * @return float
     */
    public function calculateCubicFeet()
    {
        $total = 0;

        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['length', 'width', 'height'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += Math::calculateCubicFeet($package->length, $package->width, $package->height);
        }

        return round($total, 3);
    }

    /**
     * Calculates the cubic meter.
     *
     * @return float
     */
    public function calculateCubicMeter()
    {
        $packages = DB::table('packages')
            ->where('warehouse_id', $this->id)
            ->select(['length', 'width', 'height'])
            ->get();

        $total = 0;

        foreach ($packages as $package)
        {
            $total += Math::calculateCubicMeter($package->length, $package->width, $package->height);
        }

        return round($total, 3);
    }

    /**
     * Calculates the charge weight of the warehouse in pounds.
     *
     * @return float
     */
    public function calculateChargeWeight()
    {
        $grossWeight = $this->calculateGrossWeight();
        $volumeWeight = $this->calculateVolumeWeight();
        return ($grossWeight > $volumeWeight) ? $grossWeight : $volumeWeight;
    }

    /**
     * Finds all warehouses with the given criteria.
     *
     * @param  array|null $criteria
     * @param  string     $orderBy
     * @param  string     $order
     * @param  int        $perPage
     * @return array
     */
    public static function search(array $criteria = NULL, $orderBy = 'id', $order = 'desc', $perPage = 15)
    {
        $sortColumns = [
            'id' => 'id',
            'date' => 'arrived_at'
        ];
        $orderBy = array_key_exists($orderBy, $sortColumns) ? $sortColumns[$orderBy] : 'id';
        $order = ($order == 'asc') ? 'asc' : 'desc';

        $warehouses = Warehouse::whereRaw('1')
            ->orderBy('warehouses.' . $orderBy, $order);

        /*if ( ! empty($criteria['status'])) {
            switch ($criteria['status']) {
                case 'pending':
                    $warehouses = $warehouses->whereRaw('warehouses.container_id IS NULL');
                    break;
                case 'processed':
                    $warehouses = $warehouses->whereRaw('warehouses.container_id IS NOT NULL');
                    break;
            }
        }*/

        if ( ! empty($criteria['company_id'])) {
            $warehouses = $warehouses->where('warehouses.company_id', '=', $criteria['company_id']);
        }

        if ( ! empty($criteria['q'])) {
            $q = '%' . $criteria['q'] . '%';

            $warehouses = $warehouses
                ->select('warehouses.*')
                ->leftJoin('users AS consignee', 'warehouses.consignee_user_id', '=', 'consignee.id')
                ->leftJoin('users AS shipper', 'warehouses.shipper_user_id', '=', 'shipper.id')
                //->leftJoin('containers AS container', 'warehouses.container_id', '=', 'container.id')
                ->whereRaw('(
                    warehouses.id LIKE ?
                    OR consignee.id LIKE ?
                    OR consignee.first_name LIKE ?
                    OR consignee.last_name LIKE ?
                    OR shipper.id LIKE ?
                    OR shipper.company_name LIKE ?
                    )', [$q, $q, $q, $q, $q, $q]
                );
        }

        $warehouses = $warehouses->paginate($perPage);
        return $warehouses;
    }
}
