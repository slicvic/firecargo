<?php

namespace App\Session;

/**
 * FlashMessageNormalizer
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class FlashMessageNormalizer {

    /**
     * Turn the message into a proper format before storing it in session.
     *
     * @param  mixed  $message
     * @return string
     */
    public static function normalize($message)
    {
        if (is_string($message))
        {
            return trans($message);
        }
        elseif (is_array($message))
        {
            return '<ul><li>' . implode('</li><li>', $message) . '</li></ul>';
        }
        elseif ($message instanceof \Illuminate\Validation\Validator)
        {
            return '<ul>' . implode('', $message->messages()->all('<li>:message</li>')) . '</ul>';
        }
        elseif ($message instanceof \Illuminate\Support\MessageBag)
        {
            return '<ul>' . implode('', $message->all('<li>:message</li>')) . '</ul>';
        }
        elseif ($message instanceof \App\Exceptions\ValidationException)
        {
            return '<ul>' . implode('', $message->errors()->all('<li>:message</li>')) . '</ul>';
        }

        return '';
    }
}
