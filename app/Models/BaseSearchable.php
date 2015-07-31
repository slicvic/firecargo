<?php namespace App\Models;

abstract class BaseSearchable extends Base implements ISearchable {

    /**
     * A list of valid sort columns.
     *
     * @var array
     */
    protected static $sortable = [];

    /**
     * Sanitizes the provided sort column name.
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
     * Sanitizes the provided sort order.
     *
     * @param  string  $order
     * @return string
     */
    final protected static function sanitizeOrder($order)
    {
        return ($order === 'asc') ? 'ASC' : 'DESC';
    }
}
