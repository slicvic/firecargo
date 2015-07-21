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
        if ( ! Auth::user()->isAdmin() && $user->isAdmin())
        {
            // ONLY ADMINS CAN ASSIGN "ADMIN" ROLE
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
        if ($user->isClient())
        {
            // Create or update user account
            $account = $user->account ?: new Account;
            $account->firstname = $user->firstname;
            $account->lastname = $user->lastname;
            $account->email = $user->email;
            $account->type_id = AccountType::CLIENT;
            $account->name = "{$account->firstname} {$account->lastname}";
            $account->user()->associate($user);
            $account->save();
        }
    }
}


