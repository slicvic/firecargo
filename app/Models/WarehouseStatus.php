<?php namespace App\Models;

class WarehouseStatus extends BaseModel {

    protected $table = 'warehouse_statuses';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'name',
        'order'
    ];
}
