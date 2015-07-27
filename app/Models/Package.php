<?php namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\Math;
use App\Presenters\PresentableTrait;

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
        'type_id',
        'status_id',
        'shipment_id',
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
     * Gets the warehouse.
     *
     * @return Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
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
     * Gets the package status.
     *
     * @return PackageStatus
     */
    public function status()
    {
        return $this->belongsTo('App\Models\PackageStatus', 'status_id');
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
     * Retrieves all packages eligible for shipment by the given company id.
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
        ->orderBy('id', 'asc')
        ->get();

        return $packages;
    }

    public static function findOrFailByIdAndConsigneeAccountId($id, $consigneeAccountId)
    {
        return Package::query()
                ->join('warehouses', 'packages.warehouse_id', '=', 'warehouses.id')
                ->where(['packages.id' => $id, 'warehouses.consignee_account_id' => $consigneeAccountId])
                ->firstOrFail();
    }

    public static function search(array $criteria = NULL)
    {
        $query = Package::query()
            ->select('packages.*')
            ->join('warehouses', 'packages.warehouse_id', '=', 'warehouses.id')
            ->with('type', 'status', 'warehouse');

        if ( ! empty($criteria['consignee_account_id']))
        {
            $query = $query->where('warehouses.consignee_account_id', '=', $criteria['consignee_account_id']);
        }

        return $query->get();
    }
}
