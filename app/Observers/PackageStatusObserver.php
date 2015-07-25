<?php namespace App\Observers;

use Auth;

use App\Models\PackageStatus;

/**
 * PackageStatusObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageStatusObserver {

    /**
     * After save event.
     *
     * @param  PackageStatus  $packageStatus
     * @return void
     */
    public function saved($packageStatus)
    {
        if ( ! $packageStatus->getOriginal('default') && $packageStatus->default)
        {
            // Unset the previous default status
            PackageStatus::where('company_id', $packageStatus->company_id)
                ->where('id', '<>', $packageStatus->id)
                ->update(['default' => FALSE]);
        }
    }
}


