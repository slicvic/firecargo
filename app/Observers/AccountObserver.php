<?php

namespace App\Observers;

use Auth;
use DB;

use App\Models\Package;
use App\Models\AccountTag;

/**
 * AccountObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountObserver {

    /**
     * After delete event.
     *
     * @param  Account  $account
     * @return void
     */
    public function deleting($account)
    {
        if ($account->user_id)
        {
            // Preserve integrity
            return FALSE;
        }
    }

    /**
     * After delete event.
     *
     * @param  Account  $account
     * @return void
     */
    public function deleted($account)
    {
        // Delete relationships
        $account->shippingAddress()->delete();
        $account->billingAddress()->delete();
        $account->tags()->detach();
    }

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
            // Update the customer packages hold status

            Package::where('customer_account_id', $account->id)
                ->whereNull('shipment_id')
                ->update(['hold' => ($account->autoship ? FALSE : TRUE)]);
        }
    }
}


