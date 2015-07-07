<?php namespace App\Models;

use App\Models\CompanySpecificTrait;

/**
 * PackageStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatus extends Base {

    use CompanySpecificTrait;

    protected $table = 'package_statuses';

    public static $rules = [
        'company_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'name'
    ];
}
