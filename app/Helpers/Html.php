<?php namespace App\Helpers;

class Html {
    /**
     * Gets flash message.
     *
     * @param  string $type  [info, success]
     * @param  mixed $message
     * @return string
     */
    public static function getFlash($type, $message)
    {
        switch($type) {
            case 'error':
                return view('flash_messages.error', ['message' => $message]);
            default:
                return view('flash_messages.success', ['message' => $message]);
        }
    }
}
