<?php namespace App\Models;

/**
 * PackageStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatus extends BaseSiteSpecific {

    protected $table = 'package_statuses';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name',
        'deleted',
        'color',
        'is_default'
    ];

    /**
     * Resets the default status by site ID.
     *
     * @param  int  $siteId
     * @return int
     */
    public static function unsetDefaultBySiteId($siteId)
    {
        return PackageStatus::where('site_id', $siteId)
            ->update(['is_default' => 0]);
    }
}
