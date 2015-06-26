<?php namespace App\Models;

/**
 * Package
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Package extends Base {

    /**
     * Divisor use to calculate volume weight.
     * For pounds use 166, otherwise 366 for kilos.
     */
    const VOLUME_WEIGHT_DIVISOR = 166;

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
        'deleted',
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
    public function calculateVolumeWeight($precision = 2)
    {
        $weight = ($this->length * $this->width * $this->height) / self::VOLUME_WEIGHT_DIVISOR;

        return round($weight, $precision);
    }

    /**
     * Calculates the cubic feet.
     *
     * @return float
     */
    public function calculateCubicFeet()
    {

        return ($this->length * $this->width * $this->height) * 0.00057870;
    }

    /**
     * Calculates the cubic meter.
     *
     * @return float
     */
    public function calculateCubicMeter()
    {
        return $this->calculateCubicFeet() / 35.315;
    }
}
