<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

abstract class BaseRestrictedAccess extends Model {

    public static function all($columns = ['*'])
    {
        $class = get_called_class();

        return $class::whereIn('site_id', [1, Auth::user()->site_id])
            ->get($columns);
    }

    public static function findOrFailByIdAndSiteId($id, $siteId)
    {
        $class = get_called_class();

        return $class::where('id', '=', $id)
            ->where('site_id', '=', $siteId)
            ->firstOrFail();
    }
}
