<?php namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\Math;
use App\Presenters\PresentableTrait;
use App\Observers\PackageObserver;

/**
 * Package
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Package extends Base {

    use PresentableTrait, SoftDeletes, CompanyTrait;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * The presenter path.
     *
     * @var string
     */
    protected $presenter = 'App\Presenters\PackagePresenter';

    /**
     * Soft delete timestamp.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'type_id',
        'shipment_id',
        'warehouse_id',
        'client_account_id',
        'length',
        'width',
        'height',
        'weight',
        'description',
        'invoice_number',
        'invoice_amount',
        'tracking_number',
        'ship'
    ];

    /**
     * Registers model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        Package::observe(new PackageObserver);
    }

    /**
     * Gets the warehouse.
     *
     * @return Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    /**
     * Gets the client.
     *
     * @return Warehouse
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Account', 'client_account_id');
    }

    /**
     * Gets the package type.
     *
     * @return PackageType
     */
    public function type()
    {
        return $this->belongsTo('App\Models\PackageType', 'type_id');
    }

    /**
     * Gets the shipment.
     *
     * @return Shipment
     */
    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
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
     * Checks if the package has been assigned to a shipment or not.
     * @return bool
     */
    public function wasShipped()
    {
        return (bool) $this->shipment_id;
    }

    /**
     * Calculates the volume weight of the package in pounds.
     *
     * @param  int  $precision
     * @return float
     */
    public function calculateVolumeWeight()
    {
        return Math::calculateVolumeWeight($this->length, $this->width, $this->height);
    }

    /**
     * Calculates the package cubic feet.
     *
     * @return float
     */
    public function calculateCubicFeet()
    {
        return Math::calculateCubicFeet($this->length, $this->width, $this->height);
    }

    /**
     * Calculates the package cubic meter.
     *
     * @return float
     */
    public function calculateCubicMeter()
    {
        return Math::calculateCubicMeter($this->length, $this->width, $this->height);
    }

    /**
     * Counts the total packages shipped by the given company id.
     *
     * @param  int  $companyId
     * @return int
     */
    public static function countShippedByCompanyId($companyId = NULL)
    {
        $query = Package::whereNotNull('shipment_id');

        if ($companyId)
        {
            $query->where('company_id', $companyId);
        }

        return $query->count();
    }

    /**
     * Counts the total packages pending shipment by the given company id.
     *
     * @param  int  $companyId
     * @return int
     */
    public static function countPendingShipmentByCompanyId($companyId = NULL)
    {
        $query = Package::whereNull('shipment_id');

        if ($companyId)
        {
            $query->where('company_id', $companyId);
        }

        return $query->count();
    }

    /**
     * Finds all packages eligible for shipment by the given company id.
     *
     * @param  int  $companyId
     * @return array
     */
    public static function allPendingShipmentByCompanyId($companyId)
    {
        $packages = Package::where([
            'shipment_id' => NULL,
            'ship' => TRUE,
            'company_id' => $companyId
        ])
        ->with('type', 'client')
        ->orderBy('warehouse_id', 'DESC')
        ->orderBy('id', 'ASC')
        ->get();

        return $packages;
    }

    /**
     * Finds a package by its id and client account id.
     *
     * @param  int  $id                The package id
     * @param  int  $clientAccountId   The client's account id
     * @return Package
     */
    public static function findOrFailByIdAndClientAccountId($id, $clientAccountId)
    {
        return Package::query()
            ->join('warehouses', 'packages.warehouse_id', '=', 'warehouses.id')
            ->where(['packages.id' => $id, 'warehouses.client_account_id' => $clientAccountId])
            ->firstOrFail();
    }

    public static function search(array $criteria = NULL)
    {
        $query = Package::query()
            ->select('packages.*')
            ->join('warehouses', 'packages.warehouse_id', '=', 'warehouses.id')
            ->with('type', 'warehouse');

        if ( ! empty($criteria['client_account_id']))
        {
            $query->where('warehouses.client_account_id', $criteria['client_account_id']);
        }

        return $query->get();
    }
}
