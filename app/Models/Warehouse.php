<?php namespace App\Models;

use DB;
use App\Helpers\Math;
use App\Models\CompanyTrait;
use App\Models\WarehouseStatus;
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
        'status_id',
        'consignee_user_id',
        'carrier_id',
        'arrived_at',
        'notes'
    ];

    /**
     * Gets the shipper relation.
     *
     * @return User
     */
    public function shipper()
    {
        return $this->belongsTo('App\Models\User', 'shipper_user_id');
    }

    /**
     * Gets the consignee relation.
     *
     * @return User
     */
    public function consignee()
    {
        return $this->belongsTo('App\Models\User', 'consignee_user_id');
    }

    /**
     * Gets the carrier relation.
     *
     * @return Carrier
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier', 'carrier_id');
    }

    /**
     * Gets the company relation.
     *
     * @return Company
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Gets the packages relation.
     *
     * @return Package[]
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Creates/updates the given packages and attaches them to the warehouse.
     *
     * WARNING: After this operation is complete only the packages in the array
     * will remain in the warehouse.
     *
     * @param  array  $packages
     * @param  bool   $detaching
     * @return void
     */
    public function syncPackages(array $packages, $detaching = TRUE)
    {
        $packageIds = array_keys($packages);

        // First lets detach those packages not in $packageIds
        if ($detaching)
        {
            Package::whereNotIn('id', $packageIds)
                ->where('warehouse_id', '=', $this->id)
                ->update(['warehouse_id' => NULL]);
        }

        // Next, we will create or update the given packages
        if (count($packages))
        {
            foreach ($packages as $id => $data)
            {
                $package = Package::firstOrNew(['id' => $id]);
                $package->fill($data);
                $package->warehouse_id = $this->id;
                $package->company_id = $this->company_id;
                $package->ship = ($package->shipment_id) ? $package->ship : $this->consignee->autoship_setting;
                $package->save();
            }
        }
    }

    /**
     * Creates/updates the given packages and attaches them to the warehouse.
     *
     * @param  array  $packages
     * @return void
     */
    public function createOrUpdatePackages(array $packages)
    {
        foreach ($packages as $id => $data)
        {
            $package = Package::firstOrNew(['id' => $id]);
            $package->fill($data);
            $package->warehouse_id = $this->id;
            $package->company_id = $this->company_id;
            $package->ship = ($package->shipment_id) ? $package->ship : $this->consignee->autoship_setting;
            $package->save();
        }
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
     * Calculates the total cost of the warehouse.
     *
     * @return float
     */
    public function calculateTotalValue()
    {
        return DB::table('packages')->where('warehouse_id', '=', $this->id)
            ->sum('invoice_amount');
    }

    /**
     * Finds all warehouses with the given criteria.
     *
     * @param  array|null  $criteria
     * @param  string      $orderBy
     * @param  string      $order
     * @param  int         $perPage
     * @return array
     */
    public static function search(array $criteria = NULL, $orderBy = 'id', $order = 'desc', $perPage = 15)
    {
        // Define valid sort columns
        $sortColumns = [
            'id' => 'id',
            'arrived' => 'arrived_at',
            'created' => 'created_at',
            'updated' => 'updated_at',
        ];

        // Define valid status filters
        $statuses = [
            'pending' => WarehouseStatus::STATUS_PENDING,
            'complete' => WarehouseStatus::STATUS_COMPLETE,
            'new' => WarehouseStatus::STATUS_NEW
        ];

        // Determine sort order
        $orderBy = array_key_exists($orderBy, $sortColumns) ? $sortColumns[$orderBy] : $sortColumns['id'];
        $order = ($order == 'asc') ? 'asc' : 'desc';

        $warehouses = Warehouse::whereRaw('1')
            ->orderBy('warehouses.' . $orderBy, $order);

        // Filter by status
        if ( ! empty($criteria['status']) && array_key_exists($criteria['status'], $statuses))
        {
            $warehouses = $warehouses->where('warehouses.status_id', '=', $statuses[$criteria['status']]);
        }

        // Filter by company id
        if ( ! empty($criteria['company_id']))
        {
            $warehouses = $warehouses->where('warehouses.company_id', '=', $criteria['company_id']);
        }

        // Full text search
        if ( ! empty($criteria['q']))
        {
            $q = '%' . $criteria['q'] . '%';

            $warehouses = $warehouses
                ->select('warehouses.*')
                ->leftJoin('users AS consignee', 'warehouses.consignee_user_id', '=', 'consignee.id')
                ->leftJoin('users AS shipper', 'warehouses.shipper_user_id', '=', 'shipper.id')
                ->whereRaw('(
                    warehouses.id LIKE ?
                    OR consignee.id LIKE ?
                    OR consignee.full_name LIKE ?
                    OR shipper.id LIKE ?
                    OR shipper.company_name LIKE ?
                    )', [$q, $q, $q, $q, $q]
                );
        }

        $warehouses = $warehouses->paginate($perPage);

        return $warehouses;
    }
}
