<?php namespace App\Models;

use Auth;

trait CompanyTrait {

    /**
     * Finds a record by the id and current user's company id and
     * throws exception if the record is not found.
     *
     * @param   int  $id
     * @return  array
     */
    public static function findOrFailByIdAndCurrentUserCompanyId($id)
    {
        return self::where('id', '=', $id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->firstOrFail();
    }

    /**
     * Finds a record by the id and the company id.
     *
     * @param   int  $id
     * @param   int  $companyId
     * @return  array
     */
    public static function findByIdAndCompanyId($id, $companyId)
    {
        return self::where('id', '=', $id)
            ->where('company_id', '=', $companyId)
            ->first();
    }

    /**
     * Finds a record by the id and the current user's company id.
     *
     * @param   int  $id
     * @return  array
     */
    public static function findByIdAndCurrentUserCompanyId($id)
    {
        return self::findByIdAndCompanyId($id, Auth::user()->company_id);
    }

    /**
     * Finds all records by the company id.
     *
     * @param  array   $companyId
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
     * Finds all records by the current user's company id.
     *
     * @param  string  $perPage
     * @param  string  $orderBy
     * @param  string  $order
     * @param  array   $columns
     * @return Model[]
     */
    public static function allByCurrentUserCompanyId($orderBy = 'id', $order = 'DESC', $columns = ['*'])
    {
        return self::allByCompanyId([NULL, Auth::user()->company_id], $orderBy, $order, $columns);
    }

    /**
     * Updates a record by the id and the current user's company id.
     *
     * @param  int    $id
     * @param  array  $attributes
     * @return bool|null
     */
    public static function updateWhereIdAndCurrentUserCompanyId($id, $attributes)
    {
        return self::where(['id' => $id, 'company_id' => Auth::user()->company_id])->update($attributes);
    }

    /**
     * Deletes a record by the id and the current user's company id.
     *
     * @param int $id
     * @return bool|null
     */
    public static function deleteByIdAndCurrentUserCompanyId($id)
    {
        return self::where(['id' => $id, 'company_id' => Auth::user()->company_id])->delete();
    }
}
