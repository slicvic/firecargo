<?php namespace App\Models;

/**
 * WarehouseStatus
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehouseStatus extends Base {

    const STATUS_NEW      = 1;
    const STATUS_PENDING  = 2;
    const STATUS_COMPLETE = 3;

    protected $table = 'warehouse_statuses';
}
