<?php namespace App\Observers;

use Auth;

use App\Models\Package;
use App\Models\AccountTag;

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
        if (Auth::check())
        {
            if ($account->exists)
            {
                $account->updater_user_id = Auth::user()->id;
            }
            else
            {
                $account->creator_user_id = Auth::user()->id;
            }
        }
    }

    /**
     * After save event.
     *
     * @param  Account  $account
     * @return void
     */
    public function saved($account)
    {
        if ($account->tags->contains(AccountTag::CUSTOMER))
        {
            // Update customer's packages hold status

            Package::where('customer_account_id', $account->id)
                ->whereNull('shipment_id')
                ->update(['hold' => ($account->autoship ? FALSE : TRUE)]);
        }
    }
}


