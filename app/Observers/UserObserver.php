<?php namespace App\Observers;

use Auth;

use App\Models\Account;
use App\Models\AccountType;

/**
 * UserObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserObserver {

    /**
     * Before save event.
     *
     * @param  User  $user
     * @return void
     */
    public function saving($user)
    {
        if (Auth::check() && ! Auth::user()->isAdmin() && $user->isAdmin())
        {
            // Sorry, only admins can create "admin" users.
            return FALSE;
        }
    }

    /**
     * After save event.
     *
     * @param  User  $user
     * @return void
     */
    public function saved($user)
    {
        if ($user->isCustomer())
        {
            // Create or update user's customer account

            $account = $user->account ?: new Account;
            $account->company_id = $user->company_id;
            $account->name = "{$user->firstname} {$user->lastname}";
            $account->firstname = $user->firstname;
            $account->lastname = $user->lastname;
            $account->type_id = AccountType::CUSTOMER;
            $account->email = $user->email;
            $user->account()->save($account);
        }
    }
}


