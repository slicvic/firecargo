<?php namespace App\Models;

/**
 * PackageType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageType extends Base {

    /**
     * The database table name.
     *
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
     * A list of fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
