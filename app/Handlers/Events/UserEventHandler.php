<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Auth;

use App\Events\UserLoggedInEvent;
use App\Events\UserRegisteredEvent;
use App\Helpers\Email;

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
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen('App\Events\UserLoggedInEvent', 'App\Handlers\Events\UserEventHandler@onUserLogin');
        $events->listen('App\Events\UserRegisteredEvent', 'App\Handlers\Events\UserEventHandler@onUserRegister');
    }

    /**
     * Handles user login events.
     */
    public function onUserLogin(UserLoggedInEvent $event)
    {
        Auth::login($event->user);

        $event->user->logins += 1;
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->save();
    }

    /**
     * Handles user register events.
     */
    public function onUserRegister(UserRegisteredEvent $event)
    {
        Auth::login($event->user);

        Email::welcome($event->user);
    }
}
