<?php namespace App\Models;

class Package extends Base {

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
     * ----------------------------------------------------
     * Relationships
     * ----------------------------------------------------
     */

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

    /**
     * ----------------------------------------------------
     * /Relationships
     * ----------------------------------------------------
     */

    /**
     * Calculates the volume of the package.
     *
     * @return float
     */
    public function calculateVolume()
    {
        $volume = ($this->length * $this->width * $this->height);
        return $volume;
    }
}
