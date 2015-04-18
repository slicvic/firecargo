<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

abstract class BaseSiteSpecific extends Base {

    /**
     * Finds a record by the ID and site ID and throws exception
     * if the record is not found.
     *
     * @param   int    $id
     * @param   int    $siteId
     * @return  []
     */
    public static function findOrFailByIdAndSiteId($id, $siteId)
    {
        return self::where('id', '=', $id)
            ->where('site_id', '=', $siteId)
            ->firstOrFail();
    }

    /**
     * Finds a record by the ID and site ID.
     *
     * @param   int    $id
     * @param   int    $siteId
     * @return  []
     */
    public static function findByIdAndSiteId($id, $siteId)
    {
        return self::where('id', '=', $id)
            ->where('site_id', '=', $siteId)
            ->first();
    }

    /**
     * Finds all records by the site ID.
     *
     * @param  array  $siteId
     * @param  string $orderBy
     * @param  string $order
     * @param  array  $columns
     * @return Model[]
     */
    public static function allBySiteId(array $siteId, $orderBy = 'id', $order = 'desc', $columns = ['*'])
    {
        return self::whereIn('site_id', $siteId)
            ->where('deleted', '<>', 1)
            ->get($columns);
    }

    /**
     * Finds all records by the current site ID.
     *
     * @param  string $orderBy
     * @param  string $order
     * @param  array  $columns
     * @return Model[]
     */
    public static function allByCurrentSiteId($orderBy = 'id', $order = 'desc', $columns = ['*'])
    {
        return self::allBySiteId([0, Auth::user()->site_id], $orderBy, $order, $columns);
    }
}
