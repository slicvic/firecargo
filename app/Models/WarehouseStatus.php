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
    const UNPROCESSED = 1;
    const PENDING     = 2;
    const COMPLETE    = 3;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'warehouse_statuses';
}
