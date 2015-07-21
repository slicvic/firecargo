<?php namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Warehouse;
use App\Models\CompanyTrait;
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
     * @var string
     */
    protected $table = 'packages';

    /**
     * @var array
     */
    protected $presenter = 'App\Presenters\Package';

    /**
     * Soft delete timestamp.
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
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
     * Gets the parent warehouse.
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
     * Gets the parent shipment.
     *
     * @return Shipment
     */
    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
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
     * Retrieves all packages that have not yet been assigned to a shipment.
     *
     * @param  int  $companyId
     * @return array
     */
    public static function allPendingShipmentByCompanyId($companyId)
    {
        $packages = Package::where([
            'packages.shipment_id' => NULL,
            'packages.ship' => TRUE,
            'warehouses.company_id' => $companyId
        ])
        ->join('warehouses', 'packages.warehouse_id', '=', 'warehouses.id')
        ->select('packages.*')
        ->orderBy('warehouses.id', 'asc')
        ->get();

        return $packages;
    }
}
