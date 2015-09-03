<?php

namespace App\Helpers;

use App\Models\User;
use Mail;

/**
 * welcome
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Email {

    const FROM = 'vmlantigua@gmail.com';

    public static function passwordRecovery(User $user)
    {
        //echo $code;
        //JDJ5JDEwJExabkYuOC5neDNRbXlFUjluc0VhbnVVQ1MwNDVyZ0NNRnFNLkpOa3FzcUJqZDFsMnE5UGJx
    }

    public static function welcome(User $user)
    {
        Mail::send('emails.welcome', [$user], function($message) use($user)
        {
            $message->from(self::FROM);

            $message->to($user->email)->subject('Activate your FireCargo account');
        });
    }
}
