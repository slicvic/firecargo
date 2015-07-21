<?php namespace App\Models;

/**
 * PackageType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageType extends Base {

    /**
     * @var string
     */
    protected $table = 'package_types';

    /**
     * Rules for validation.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
