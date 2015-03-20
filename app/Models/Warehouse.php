<?php namespace App\Models;

class Warehouse extends BaseModel {

    protected $table = 'warehouses';

    public function consignee()
    {
        return $this->belongsTo('App\Models\User', 'consignee_user_id');
    }

    public function shipper()
    {
        return $this->belongsTo('App\Models\User', 'shipper_user_id');
    }

    public function carrier()
    {
        return $this->belongsTo('App\Models\ShippingCarrier', 'carrier_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\WarehouseItem');
    }
}
