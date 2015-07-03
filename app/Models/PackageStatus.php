<?php namespace App\Models;

use App\Models\SiteTrait;

/**
 * PackageStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatus extends Base {

    use SiteTrait;

    protected $table = 'package_statuses';

    public static $rules = [
        'site_id' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'site_id',
        'name',
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
