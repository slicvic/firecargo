<?php namespace App\Observers;

use Auth;

/**
 * PackageObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackageObserver {

    /**
     * Before save event.
     *
     * @param  Package  $package
     * @return void
     */
    public function saving($package)
    {
        if ($package->exists)
        {
            $package->updater_user_id = Auth::user()->id;
        }
        else
        {
            $package->creator_user_id = Auth::user()->id;
        }
    }
}


