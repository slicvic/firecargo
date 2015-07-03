<?php namespace App\Models;

use App\Models\SiteTrait;

/**
 * PackageType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageType extends Base {

    use SiteTrait;

    protected $table = 'package_types';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name',
    ];
}
