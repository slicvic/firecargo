<?php

namespace App\Contracts\Models;

/**
 * SearchableInterface
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
interface SearchableInterface {

    /**
     * Find all models with the given criteria.
     *
     * @param  array|null  $criteria
     * @param  string      $orderBy
     * @param  string      $order
     * @param  int         $perPage
     * @return Model[]
     */
    public static function search(array $criteria = [], $orderBy = 'id', $order = 'desc', $perPage = 15);
}
