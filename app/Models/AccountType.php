<?php namespace App\Models;

/**
 * AccountType
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountType extends Base {

    /**
     * @var int
     */
    const REGISTERED_CLIENT = 1;
    const CLIENT            = 2;
    const CONSIGNEE         = 3;
    const SHIPPER           = 4;

    /**
     * @var string
     */
    protected $table = 'account_types';

    /**
     * Retrieves all account types with the exception of "Registered Client".
     *
     * @return AccountType[]
     */
    public static function allExceptRegisteredClient()
    {
        return self::where('id', '<>', self::REGISTERED_CLIENT)->get();
    }
}
