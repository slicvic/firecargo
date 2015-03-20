<?php namespace App\Models;

class Warehouse extends BaseModel {
    protected $table = 'warehouses';

    public function consignee()
    {
        return $this->belongsTo('User', 'consignee_user_id');
    }

    public function shipper()
    {
        return $this->belongsTo('User', 'shipper_user_id');
    }

    public function deliverer()
    {
        return $this->belongsTo('WarehouseDeliverer', 'deliverer_id');
    }

    public function items()
    {
        return $this->hasMany('WarehouseItem');
    }
}
