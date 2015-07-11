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
        'name',
        'is_default'
    ];

    /**
     * Resets the default company package status.
     *
     * @param  int  $companyId
     * @param  int  $excludeId
     * @return int
     */
    public static function unsetCompanyDefaultStatus($companyId, $excludeId = NULL)
    {
        $query = PackageStatus::where('company_id', $companyId);

        if ($excludeId) {
            $query->where('id', '<>', $excludeId);
        }

        return $query->update(['is_default' => 0]);
    }
}
