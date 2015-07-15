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

    protected $presenter = 'App\Presenters\Package';

    protected $table = 'packages';

    protected $dates = ['deleted_at'];

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
     * Gets the warehouse relation.
     *
     * @return Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    /**
     * Gets the package type relation.
     *
     * @return PackageType
     */
    public function type()
    {
        return $this->belongsTo('App\Models\PackageType', 'type_id');
    }

    /**
     * Gets the status relation.
     *
     * @return PackageStatus
     */
    public function status()
    {
        return $this->belongsTo('App\Models\PackageStatus', 'status_id');
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
     * Gets the shipment relation.
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
     * Calculates the cubic feet.
     *
     * @return float
     */
    public function calculateCubicFeet()
    {
        return Math::calculateCubicFeet($this->length, $this->width, $this->height);
    }

    /**
     * Calculates the cubic meter.
     *
     * @return float
     */
    public function calculateCubicMeter()
    {
        return Math::calculateCubicMeter($this->length, $this->width, $this->height);
    }

    /**
     * Retrieves all packages that have not yet been shipped by the
     * current user's company id.
     *
     * @return array
     */
    public static function allPendingShipmentByCurrentUserCompany()
    {
        $packages = Package::where([
            'packages.shipment_id' => NULL,
            'packages.ship' => TRUE,
            'warehouses.company_id' => Auth::user()->company_id
        ])
        ->join('warehouses', 'packages.warehouse_id', '=', 'warehouses.id')
        ->select('packages.*')
        ->orderBy('warehouses.id', 'asc')
        ->get();

        return $packages;
    }
}
