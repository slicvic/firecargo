<?php namespace App\Models;

use App\Models\SiteTrait;

/**
 * Courier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Courier extends Base {

    use SiteTrait;

    protected $table = 'couriers';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name',
    ];
}
