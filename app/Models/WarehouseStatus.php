<?php namespace App\Models;

/**
 * WarehouseStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehouseStatus extends Base {

    /**
     * The types of statuses.
     *
     * @var int
     */
    const STATUS_NEW      = 1;
    const STATUS_PENDING  = 2;
    const STATUS_COMPLETE = 3;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'warehouse_statuses';
}
