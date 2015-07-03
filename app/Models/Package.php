<?php namespace App\Models;

use App\Helpers\Math;

/**
 * Package
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Package extends Base {

    protected $table = 'packages';

    public static $rules = [
        'warehouse_id' => 'required'
    ];

    protected $fillable = [
        'warehouse_id',
        'type_id',
        'status_id',
        'length',
        'width',
        'height',
        'weight',
        'description',
        'invoice_number',
        'invoice_amount',
        'tracking_number',
        'roll'
    ];

    /**
     * Gets the warehouse.
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    /**
     * Gets the package type.
     */
    public function type()
    {
        return $this->belongsTo('App\Models\PackageType', 'type_id');
    }

    /**
     * Gets the site.
     */
    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    /**
     * Gets the status.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\PackageStatus');
    }

    /**
     * Calculates the volume weight of the package in pounds.
     *
     * @param  int $precision
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
}
