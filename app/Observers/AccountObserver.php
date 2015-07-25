<?php namespace App\Observers;

use App\Models\AccountType;

/**
 * AccountObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountObserver {

    /**
     * Before save event.
     *
     * @param  Account  $account
     * @return void
     */
    public function saving($account)
    {
        if ($account->getOriginal('type_id') == AccountType::CLIENT && $account->getAttribute('type_id') != AccountType::CLIENT)
        {
            // Cannot change "client" account type once its been set.
            $account->type_id = AccountType::CLIENT;
        }
    }
}
