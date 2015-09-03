<?php

namespace App\Models;

use Auth;

/**
 * CreatorUpdaterTrait
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
trait CreatorUpdaterTrait {

    /**
     * Get the creator user.
     *
     * @return Carrier
     */
    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_user_id');
    }

    /**
     * Get the last updater user.
     *
     * @return Carrier
     */
    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updater_user_id');
    }
}
