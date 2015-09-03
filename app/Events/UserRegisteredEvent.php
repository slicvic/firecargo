<?php

namespace App\Events;

use App\Events\Event;
use App\Models\User;

/**
 * UserRegisteredEvent
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserRegisteredEvent extends Event {

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
