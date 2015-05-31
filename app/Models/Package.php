<?php namespace App\Models;

class Package extends Base {

    const VOLUME_WEIGHT_DIVISOR = 166; // Pounds (Kg = 366)

    protected $table = 'packages';

    public static $rules = [
        'warehouse_id' => 'required',
        /*'type_id' => 'required',
        'length' => 'required',
        'width' => 'required',
        'height' => 'required',
        'weight' => 'required',
        'description' => 'required',
        'invoice_number' => 'required',
        'invoice_amount' => 'required',
        'tracking_number' => 'required'*/
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

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\PackageType', 'type_id');
    }

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\PackageStatus');
    }

    /**
     * Calculates the volume weight of the package.
     *
     * @param bool $round  Whether or not to round the result.
     *
     * @return float
     */
    public function calculateVolumeWeight($round = FALSE)
    {
        $weight = ($this->length * $this->width * $this->height) / self::VOLUME_WEIGHT_DIVISOR;

        return ($round) ? round($weight, 2) : $weight;
    }
}
