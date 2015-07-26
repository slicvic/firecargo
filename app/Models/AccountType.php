<?php namespace App\Models;

/**
 * AccountType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountType extends Base {

    /**
     * The account types.
     *
     * @var int
     */
    const CLIENT    = 1;
    const CONSIGNEE = 2;
    const SHIPPER   = 3;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'account_types';

    /**
     * Retrieves all account types with the exception of "client" type.
     *
     * @return AccountType[]
     */
    public static function allExceptClient()
    {
        return self::where('id', '<>', self::CLIENT)->get();
    }
}
