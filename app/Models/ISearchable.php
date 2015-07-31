<?php namespace App\Models;

/**
 * ISearchable
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
interface ISearchable {

    /**
     * Finds all models with the given criteria.
     *
     * @param  array|null  $criteria
     * @param  string      $orderBy
     * @param  string      $order
     * @param  int         $perPage
     * @return Model[]
     */
    public static function search(array $criteria = [], $orderBy = 'id', $order = 'desc', $perPage = 15);
}
