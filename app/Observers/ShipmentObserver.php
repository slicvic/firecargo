<?php namespace App\Observers;

use Auth;

/**
 * ShipmentObserver
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ShipmentObserver {

    /**
     * Before save event.
     *
     * @param  Shipment  $shipment
     * @return void
     */
    public function saving($shipment)
    {
        if ($shipment->exists)
        {
            $shipment->updater_user_id = Auth::user()->id;
        }
        else
        {
            $shipment->creator_user_id = Auth::user()->id;
        }
    }
}


