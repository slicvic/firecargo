<?php namespace App\Models;

/**
 * WarehouseStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehouseStatus extends Base {

    /**
     * @var int
     */
    const STATUS_NEW      = 1;
    const STATUS_PENDING  = 2;
    const STATUS_COMPLETE = 3;

    /**
     * @var string
     */
    protected $table = 'warehouse_statuses';
}
