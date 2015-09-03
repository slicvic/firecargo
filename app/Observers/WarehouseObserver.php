<?php

namespace App\Observers;

use Auth;

/**
 * WarehouseObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehouseObserver {

    /**
     * Before save event.
     *
     * @param  Warehouse  $warehouse
     * @return void
     */
    public function saving($warehouse)
    {
        if ($warehouse->exists)
        {
            $warehouse->updater_user_id = Auth::user()->id;
        }
        else
        {
            $warehouse->creator_user_id = Auth::user()->id;
        }
    }
}


