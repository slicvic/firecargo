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
class Package extends BaseSearchable {

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
        'customer_account_id',
        'length',
        'width',
        'height',
        'weight',
        'description',
        'invoice_number',
        'invoice_value',
        'tracking_number',
        'hold'
    ];

    /**
     * A list of sortable fields.
     *
     * {@inheritdoc}
     */
    protected static $sortable = [
        'id',
        'warehouse_id',
        'type_id',
        'shipment_id',
        'customer_account_id',
        'invoice_value',
        'tracking_number',
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

        Package::observe(new PackageObserver);
    }

    /**
     * Gets the package's warehouse.
     *
     * @return Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    /**
     * Gets the package's owner.
     *
     * @return Warehouse
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Account', 'customer_account_id');
    }

    /**
     * Gets the package's type.
     *
     * @return PackageType
     */
    public function type()
    {
        return $this->belongsTo('App\Models\PackageType', 'type_id');
    }

    /**
     * Gets the package's shipment.
     *
     * @return Shipment
     */
    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
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
     * Finds unprocessed packages.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeUnprocessed($query)
    {
        return $query
            ->whereNull('shipment_id')
            ->where('hold', FALSE);
    }

    /**
     * Finds packages on hold.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOnHold($query)
    {
        return $query
            ->whereNull('shipment_id')
            ->where('hold', TRUE);
    }

    /**
     * Finds shipped packages.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeShipped($query)
    {
        return $query->whereNotNull('shipment_id');
    }

    /**
     * Checks if the package has been assigned to a shipment or not.
     *
     * @return bool
     */
    public function isShipped()
    {
        return (bool) $this->shipment_id;
    }

    /**
     * Checks if the package is on hold or not.
     *
     * @return bool
     */
    public function isOnHold()
    {
        return (bool) $this->hold;
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
     * Calculates the cubic feet of the package.
     *
     * @return float
     */
    public function calculateCubicFeet()
    {
        return Math::calculateCubicFeet($this->length, $this->width, $this->height);
    }

    /**
     * Calculates the cubic meter of the package.
     *
     * @return float
     */
    public function calculateCubicMeter()
    {
        return Math::calculateCubicMeter($this->length, $this->width, $this->height);
    }

    /**
     * Finds all packages with the given criteria.
     *
     * {@inheritdoc}
     */
    public static function search(array $criteria = [], $orderBy = 'id', $order = 'desc', $perPage = 15)
    {
        $query = Package::query()
            ->orderBy('packages.' . self::sanitizeOrderBy($orderBy), self::sanitizeOrder($order))
            ->with('type', 'customer', 'shipment');

        if ( ! empty($criteria['company_id']))
        {
            $query->where('packages.company_id', $criteria['company_id']);
        }

        if ( ! empty($criteria['customer_account_id']))
        {
            $query->where('packages.customer_account_id', $criteria['customer_account_id']);
        }

        if ( ! empty($criteria['status']))
        {
            switch ($criteria['status'])
            {
                case 'unprocessed':
                    $query->unprocessed();
                    break;
                case 'hold':
                    $query->onHold();
                    break;
                case 'shipped':
                    $query->shipped();
                    break;
            }
        }

        if (isset($criteria['search']) && strlen($criteria['search']) > 2)
        {
            $searchTerm = '%' . $criteria['search'] . '%';

            $query
                ->join('accounts AS customers', 'packages.customer_account_id', '=', 'customers.id')
                ->leftJoin('shipments', 'packages.shipment_id', '=', 'shipments.id')
                ->groupBy('packages.id')
                ->whereRaw('(
                    packages.warehouse_id LIKE ?
                    OR packages.customer_account_id LIKE ?
                    OR packages.description LIKE ?
                    OR packages.tracking_number LIKE ?
                    OR packages.invoice_number LIKE ?
                    OR packages.invoice_value LIKE ?
                    OR customers.name LIKE ?
                    OR customers.firstname LIKE ?
                    OR customers.lastname LIKE ?
                    OR shipments.reference_number LIKE ?
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
                ]);
        }

        return $query->paginate($perPage);
    }
}
