<?php namespace App\Models;

/**
 * PackageType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageType extends Base {

    protected $table = 'package_types';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'name',
    ];
}
