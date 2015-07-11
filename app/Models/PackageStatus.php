<?php namespace App\Models;

use App\Models\CompanyTrait;

/**
 * PackageStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatus extends Base {

    use CompanyTrait;

    protected $table = 'package_statuses';

    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'company_id',
        'name',
        'is_default'
    ];

    /**
     * Resets the default status by company ID.
     *
     * @param  int  $companyId
     * @return int
     */
    public static function unsetDefaultByCompanyId($companyId)
    {
        return PackageStatus::where('company_id', $companyId)
            ->update(['is_default' => 0]);
    }
}
