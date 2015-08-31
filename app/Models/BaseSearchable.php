<?php namespace App\Models;

use App\Contracts\Models\SearchableInterface;

/**
 * BaseSearchable
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class BaseSearchable extends Base implements SearchableInterface {

    /**
     * A list of allowed sort columns.
     *
     * @var array
     */
    protected static $sortable = [
        'id'
    ];

    /**
     * Sanitize the provided sort column.
     *
     * @param  string  $column
     * @param  string  $default
     * @return string
     */
    final protected static function sanitizeOrderBy($column, $default = 'id')
    {
        $column = in_array($column, static::$sortable) ? $column : $default;

        return $column;
    }

    /**
     * Sanitize the provided sort order.
     *
     * @param  string  $order
     * @return string
     */
    final protected static function sanitizeOrder($order)
    {
        return ($order === 'asc') ? 'ASC' : 'DESC';
    }
}
