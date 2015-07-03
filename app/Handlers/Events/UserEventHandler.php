<?php namespace App\Handlers\Events;

use App\Events\UserLoggedIn;
use App\Events\UserRegistered;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Auth;
use App\Helpers\Mailer;

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
     * Handle user login events.
     */
    public function onUserLogin(UserLoggedIn $event)
    {
        Auth::login($event->user);
        $event->user->logins += 1;
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->save();
    }

    /**
     * Handle user signup events.
     */
    public function onUserRegister(UserRegistered $event)
    {
        Auth::login($event->user);
        Mailer::sendWelcome($event->user);
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
