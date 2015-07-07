<?php namespace App\Models;

use DB;
use App\Helpers\Math;
use App\Models\CompanySpecificTrait;
use App\Presenters\PresentableTrait;

/**
 * Warehouse
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse extends Base {

    use CompanySpecificTrait, PresentableTrait;

    protected $presenter = 'App\Presenters\Warehouse';

    protected $table = 'warehouses';

    public static $rules = [
        'company_id' => 'required',
        'shipper_user_id' => 'required',
        'consignee_user_id' => 'required',
        'courier_id' => 'required',
        'arrived_at' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'shipper_user_id',
        'consignee_user_id',
        'courier_id',
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
     * Gets the courier.
     */
    public function courier()
    {
        return $this->belongsTo('App\Models\Courier', 'courier_id');
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
     * Gets the container.
     */
    public function container()
    {
        return $this->belongsTo('App\Models\Container');
    }

    /**
     * Gets the packages.
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
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
     * Searches warehouses.
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

        if ( ! empty($criteria['status'])) {
            switch ($criteria['status']) {
                case 'pending':
                    $warehouses = $warehouses->whereRaw('warehouses.group_id IS NULL');
                    break;
                case 'processed':
                    $warehouses = $warehouses->whereRaw('warehouses.group_id IS NOT NULL');
                    break;
            }
        }

        if ( ! empty($criteria['company_id'])) {
            $warehouses = $warehouses->where('warehouses.company_id', '=', $criteria['company_id']);
        }

        if ( ! empty($criteria['q'])) {
            $q = '%' . $criteria['q'] . '%';
            $warehouses = $warehouses
                ->join('users AS consignee', 'warehouses.consignee_user_id', '=', 'consignee.id')
                ->join('users AS shipper', 'warehouses.shipper_user_id', '=', 'shipper.id')
                ->join('warehouse_groups AS group', 'warehouses.group_id', '=', 'group.id')
                ->whereRaw('warehouses.id LIKE ? OR group.tracking_number LIKE ? OR consignee.first_name LIKE ? OR consignee.last_name LIKE ? OR shipper.business_name LIKE ?', [$q, $q, $q, $q, $q])
                ->select('warehouses.*');
        }

        $warehouses = $warehouses->paginate($perPage);
        return $warehouses;
    }
}
