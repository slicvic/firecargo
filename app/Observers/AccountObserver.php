<?php namespace App\Observers;

use App\Models\Package;

/**
 * AccountObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountObserver {

    /**
     * After save event.
     *
     * @param  Account  $account
     * @return void
     */
    public function saved($account)
    {
        if ($account->isClient())
        {
            // Update client's packages hold status
            Package::where('client_account_id', $account->id)
                ->whereNull('shipment_id')
                ->update(['hold' => ($account->autoship ? FALSE : TRUE)]);
        }
    }
}


