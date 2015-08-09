<?php namespace App\Observers;

use Auth;

use App\Models\Account;
use App\Models\AccountTag;
use App\Models\Address;

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
            $account->email = $user->email;

            if ($account->exists)
            {
                $account->save();
            }
            else
            {
                $user->account()->save($account);
                $account->tags()->attach(AccountTag::CUSTOMER);
            }
        }
    }
}


