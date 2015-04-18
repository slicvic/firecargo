<?php namespace App\Models;

class Courier extends BaseSiteSpecific {

    protected $table = 'couriers';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name',
        'deleted'
    ];
}
