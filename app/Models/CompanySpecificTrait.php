<?php namespace App\Models;

use Auth;

trait CompanySpecificTrait {
    /**
     * Finds a record by the ID and company ID and throws exception
     * if the record is not found.
     *
     * @param   int  $id
     * @param   int  $siteId
     * @return  []
     */
    public static function findOrFailByIdAndCompanyId($id, $companyId)
    {
        return self::where('id', '=', $id)
            ->where('company_id', '=', $companyId)
            ->firstOrFail();
    }

    /**
     * Finds a record by the ID and current company ID and throws exception
     * if the record is not found.
     *
     * @param   int  $id
     * @return  []
     */
    public static function findOrFailByIdAndCurrentCompany($id)
    {
        return self::findOrFailByIdAndCompanyId($id, Auth::user()->company_id);
    }

    /**
     * Finds a record by the ID and company ID.
     *
     * @param   int  $id
     * @param   int  $siteId
     * @return  []
     */
    public static function findByIdAndCompanyId($id, $companyId)
    {
        return self::where('id', '=', $id)
            ->where('company_id', '=', $companyId)
            ->first();
    }

    /**
     * Finds a record by the ID and the current company ID.
     *
     * @param   int  $id
     * @return  []
     */
    public static function findByIdAndCurrentCompany($id)
    {
        return self::findByIdAndCompanyId($id, Auth::user()->company_id);
    }

    /**
     * Finds all records by the company ID.
     *
     * @param  array   $siteId
     * @param  string  $perPage
     * @param  string  $orderBy
     * @param  string  $order
     * @param  array   $columns
     * @return Model[]
     */
    public static function allByCompanyId(array $companyId, $orderBy = 'id', $order = 'DESC', $columns = ['*'])
    {
        $model = self::whereIn('company_id', $companyId)
            ->orderBy($orderBy, $order);

        return $model->get($columns);
    }

    /**
     * Finds all records by the current company ID.
     *
     * @param  string  $perPage
     * @param  string  $orderBy
     * @param  string  $order
     * @param  array   $columns
     * @return Model[]
     */
    public static function allByCurrentCompany($orderBy = 'id', $order = 'DESC', $columns = ['*'])
    {
        return self::allByCompanyId([0, Auth::user()->company_id], $orderBy, $order, $columns);
    }
}
