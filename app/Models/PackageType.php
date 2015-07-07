<?php namespace App\Models;

use App\Models\CompanySpecificTrait;

/**
 * PackageType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageType extends Base {

    use CompanySpecificTrait;

    protected $table = 'package_types';

    public static $rules = [
        'company_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'name',
    ];
}
