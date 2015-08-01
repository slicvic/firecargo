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
class Warehouse extends BaseSearchable implements ISearchable {

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
     * @var string
     */
    protected $presenter = 'App\Presenters\WarehousePresenter';

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'shipper_account_id',
        'status_id',
        'client_account_id',
        'carrier_id',
        'notes'
    ];

    /**
     * A list of sortable fields.
     *
     * {@inheritdoc}
     */
    protected static $sortable = [
        'id',
        'created_at',
        'updated_at'
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
     * Gets the warehouse's shipper account.
     *
     * @return Account
     */
    public function shipper()
    {
        return $this->belongsTo('App\Models\Account', 'shipper_account_id');
    }

    /**
     * Gets the warehouse's client account.
     *
     * @return Account
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Account', 'client_account_id');
    }

    /**
     * Gets the creator user.
     *
     * @return Carrier
     */
    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_user_id');
    }

    /**
     * Gets the last updater user.
     *
     * @return Carrier
     */
    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updater_user_id');
    }

    /**
     * Gets the warehouse's carrier.
     *
     * @return Carrier
     */
    public function carrier()
    {
        return $this->belongsTo('App\Models\Carrier', 'carrier_id');
    }

    /**
     * Gets the warehouse's packages.
     *
     * @return Package[]
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * Finds unprocesed warehouses.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeUnprocessed($query)
    {
        return $query->where('status_id', WarehouseStatus::UNPROCESSED);
    }

    /**
     * Finds pending warehouses.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePending($query)
    {
        return $query->where('status_id', WarehouseStatus::PENDING);
    }

    /**
     * Finds completed warehouses.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeComplete($query)
    {
        return $query->where('status_id', WarehouseStatus::COMPLETE);
    }

    /**
     * Creates or updates the given packages and attaches them to the warehouse.
     *
     * @param  array  $packages
     * @return void
     */
    public function createOrUpdatePackages(array $packages)
    {
        // First lets delete the packages marked for deletion
        $deleteIds = [];

        foreach ($packages as $id => $data)
        {
            if (isset($data['delete']))
            {
                $deleteIds[] = $id;
                unset($packages[$id]);
            }
        }

        if (count($deleteIds))
        {
            Package::whereIn('id', $deleteIds)
                ->where('warehouse_id', $this->id)
                ->delete();
        }

        // Next, we'll update or create the remaining packages
        foreach ($packages as $id => $data)
        {
            unset($data['delete']);

            $package = Package::firstOrNew(['id' => $id]);

            $data['warehouse_id'] = $this->id;
            $data['client_account_id'] = $this->client_account_id;
            $data['hold'] = ($package->shipment_id) ? $package->hold : ($this->client->autoship ? FALSE : TRUE);

            $package->fill($data);
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
        return DB::table('packages')->where('warehouse_id', $this->id)
            ->sum('invoice_value');
    }

    /**
     * Finds all warehouses with the given criteria.
     *
     * {@inheritdoc}
     */
    public static function search(array $criteria = [], $orderBy = 'id', $order = 'desc', $perPage = 15)
    {
        $query = Warehouse::query()
            ->orderBy('warehouses.' . self::sanitizeOrderBy($orderBy), self::sanitizeOrder($order))
            ->with('creator', 'updater', 'shipper', 'client', 'carrier', 'company');

        if ( ! empty($criteria['status_id']))
        {
             $query->where('warehouses.status_id', $criteria['status_id']);
        }

        if ( ! empty($criteria['company_id']))
        {
            $query->where('warehouses.company_id', $criteria['company_id']);
        }

        if (isset($criteria['search']) && strlen($criteria['search']) > 2)
        {
            $searchTerm = '%' . $criteria['search'] . '%';

            $query
                ->join('accounts AS clients', 'warehouses.client_account_id', '=', 'clients.id')
                ->join('accounts AS shippers', 'warehouses.shipper_account_id', '=', 'shippers.id')
                ->join('carriers', 'warehouses.carrier_id', '=', 'carriers.id')
                ->leftJoin('packages', 'warehouses.id', '=', 'packages.warehouse_id')
                ->groupBy('warehouses.id')
                ->whereRaw('(
                    warehouses.id LIKE ?
                    OR clients.id LIKE ?
                    OR clients.name LIKE ?
                    OR clients.firstname LIKE ?
                    OR clients.lastname LIKE ?
                    OR shippers.id LIKE ?
                    OR shippers.name LIKE ?
                    OR shippers.firstname LIKE ?
                    OR shippers.lastname LIKE ?
                    OR carriers.name LIKE ?
                    OR packages.tracking_number LIKE ?
                    )', [
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm,
                    $searchTerm
                ]);
        }

        return $query->paginate($perPage);
    }
}
