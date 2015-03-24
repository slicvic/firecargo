<?php namespace App\Models;

class Warehouse extends BaseModel {

    protected $table = 'warehouses';

    public static $rules = [
        'site_id' => 'required',
    ];

    protected $fillable = [
        'site_id',
    ];

    public function shipper()
    {
        return $this->belongsTo('App\Models\User', 'shipper_user_id');
    }

    public function consignee()
    {
        return $this->belongsTo('App\Models\User', 'consignee_user_id');
    }

    public function deliveredBy()
    {
        return $this->belongsTo('App\Models\Courier', 'delivered_by_courier_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
