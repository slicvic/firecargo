<?php namespace App\Models;

class ShippingCarrier extends BaseModel {

    protected $table = 'shipping_carriers';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'name'
    ];
}
