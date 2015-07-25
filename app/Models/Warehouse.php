<?php namespace App\Models;

use DB;

use App\Helpers\Math;
use App\Presenters\PresentableTrait;
use App\Observers\WarehouseObserver;

/**
 * Warehouse
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse extends Base {

    use CompanyTrait, PresentableTrait;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'warehouses';

    /**
     * The presenter path.
     *
     * @var Presenter
     */
    protected $presenter = 'App\Presenters\Warehouse';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'shipper_account_id',
        'status_id',
        'consignee_account_id',
        'carrier_id',
        'arrived_at',
        'notes'
    ];

    /**
     * Registers model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        Warehouse::observe(new WarehouseObserver);
    }

    /**
     * Gets the shipper.
     *
     * @return Account
     */
    public function shipper()
    {
        return $this->belongsTo('App\Models\Account', 'shipper_account_id');
    }

    /**
     * Gets the consignee.
     *
     * @return Account
     */
    public function consignee()
    {
        return $this->belongsTo('App\Models\Account', 'consignee_account_id');
    }

    /**
     * Gets the creator.
     *
     * @return Carrier
     */
    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_user_id');
    }

    /**
     * Gets the last updater.
     *
     * @return Carrier
     */
    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updater_user_id');
    }

    /**
     * Gets the carrier.
     *
     * @return Carrier
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier', 'carrier_id');
    }

    /**
     * Gets the warehouse packages.
     *
     * @return Package[]
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Creates or updates the given packages and attaches them to the warehouse.
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
            $package->ship = ($package->shipment_id) ? $package->ship : $this->consignee->autoship;
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
     * Calculates the cubic feet of the warehouse.
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
     * Calculates the cubic meter of the warehouse.
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
     * @param  string      $sort
     * @param  string      $order
     * @param  int         $perPage
     * @return array
     */
    public static function search(array $criteria = NULL, $sort = 'id', $order = 'desc', $perPage = 15)
    {
        $validStatusFilters = [
            'new'      => WarehouseStatus::STATUS_NEW,
            'pending'  => WarehouseStatus::STATUS_PENDING,
            'complete' => WarehouseStatus::STATUS_COMPLETE
        ];

        // Verify sort and order

        $validSortColumns = [
            'id',
            'arrived_at',
            'created_at',
            'updated_at'
        ];

        $sort = in_array($sort, $validSortColumns) ? $sort : 'id';

        $order = ($order === 'asc') ? 'asc' : 'desc';

        // Build query

        $query = Warehouse::query()->orderBy('warehouses.' . $sort, $order);

        if (isset($criteria['status']) && array_key_exists($criteria['status'], $validStatusFilters))
        {
            $query = $query->where('warehouses.status_id', '=', $validStatusFilters[$criteria['status']]);
        }

        if (isset($criteria['company_id']))
        {
            $query = $query->where('warehouses.company_id', '=', $criteria['company_id']);
        }

        if (isset($criteria['search']) && strlen($criteria['search']) > 2)
        {
            $search = '%' . $criteria['search'] . '%';

            $query = $query
                ->select('warehouses.*')
                ->leftJoin('accounts AS consignees', 'warehouses.consignee_account_id', '=', 'consignees.id')
                ->leftJoin('accounts AS shippers', 'warehouses.shipper_account_id', '=', 'shippers.id')
                ->leftJoin('carriers', 'warehouses.carrier_id', '=', 'carriers.id')
                ->groupBy('warehouses.id')
                ->whereRaw('(
                    warehouses.id LIKE ?
                    OR consignees.id LIKE ?
                    OR consignees.name LIKE ?
                    OR consignees.firstname LIKE ?
                    OR consignees.lastname LIKE ?
                    OR shippers.id LIKE ?
                    OR shippers.name LIKE ?
                    OR shippers.firstname LIKE ?
                    OR shippers.lastname LIKE ?
                    OR carriers.name LIKE ?
                    )', [
                    $search,
                    $search,
                    $search,
                    $search,
                    $search,
                    $search,
                    $search,
                    $search,
                    $search,
                    $search
                ]);
        }

        $warehouses = $query
            ->with('creator', 'updater', 'shipper', 'consignee', 'carrier', 'company')
            ->paginate($perPage);

        return $warehouses;
    }
}
