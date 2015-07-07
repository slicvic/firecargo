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
        'name',
        'is_default'
    ];

    /**
     * Resets the default status by company ID.
     *
     * @param  int  $siteId
     * @return int
     */
    public static function unsetDefaultByCompanyId($companyId)
    {
        return PackageStatus::where('company_id', $companyId)
            ->update(['is_default' => 0]);
    }
}
