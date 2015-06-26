<?php namespace App\Models;

/**
 * Courier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
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
