<?php namespace App\Models;

/**
 * AccountTag
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountTag extends Base {

    /**
     * The different types of accounts.
     *
     * @var int
     */
    const CUSTOMER = 1;
    const SHIPPER  = 2;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'account_tags';
}
