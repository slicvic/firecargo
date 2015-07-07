<?php namespace App\Models;

use Auth;

trait SiteSpecificTrait {
    /**
     * Finds a record by the ID and site ID and throws exception
     * if the record is not found.
     *
     * @param   int  $id
     * @param   int  $siteId
     * @return  []
     */
    public static function findOrFailByIdAndSiteId($id, $siteId)
    {
        return self::where('id', '=', $id)
            ->where('site_id', '=', $siteId)
            ->firstOrFail();
    }

    /**
     * Finds a record by the ID and current site ID and throws exception
     * if the record is not found.
     *
     * @param   int  $id
     * @return  []
     */
    public static function findOrFailByIdAndCurrentSite($id)
    {
        return self::findOrFailByIdAndSiteId($id, Auth::user()->site_id);
    }

    /**
     * Finds a record by the ID and site ID.
     *
     * @param   int  $id
     * @param   int  $siteId
     * @return  []
     */
    public static function findByIdAndSiteId($id, $siteId)
    {
        return self::where('id', '=', $id)
            ->where('site_id', '=', $siteId)
            ->first();
    }

    /**
     * Finds a record by the ID and the current site ID.
     *
     * @param   int  $id
     * @return  []
     */
    public static function findByIdAndCurrentSite($id)
    {
        return self::findByIdAndSiteId($id, Auth::user()->site_id);
    }

    /**
     * Finds all records by the site ID.
     *
     * @param  array   $siteId
     * @param  string  $perPage
     * @param  string  $orderBy
     * @param  string  $order
     * @param  array   $columns
     * @return Model[]
     */
    public static function allBySiteId(array $siteId, $orderBy = 'id', $order = 'DESC', $columns = ['*'])
    {
        $model = self::whereIn('site_id', $siteId)
            ->orderBy($orderBy, $order);

        return $model->get($columns);
    }

    /**
     * Finds all records by the current site ID.
     *
     * @param  string  $perPage
     * @param  string  $orderBy
     * @param  string  $order
     * @param  array   $columns
     * @return Model[]
     */
    public static function allByCurrentSite($orderBy = 'id', $order = 'DESC', $columns = ['*'])
    {
        return self::allBySiteId([Auth::user()->site_id], $orderBy, $order, $columns);
    }
}
