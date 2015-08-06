<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Auth;

use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use App\Helpers\Email;
use App\Models\LogUserVisit;

class UserEventHandler {

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handles user login events.
     */
    public function onUserLogin(UserLoggedIn $event)
    {
        Auth::login($event->user);
        $event->user->logins += 1;
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->save();
    }

    /**
     * Handles user register events.
     */
    public function onUserRegister(UserRegistered $event)
    {
        Auth::login($event->user);
        Email::welcome($event->user);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen('App\Events\UserLoggedIn', 'App\Handlers\Events\UserEventHandler@onUserLogin');
        $events->listen('App\Events\UserRegistered', 'App\Handlers\Events\UserEventHandler@onUserRegister');
    }
}
