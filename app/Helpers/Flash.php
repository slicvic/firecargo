<?php namespace App\Helpers;

use Session;
use Illuminate\Validation\Validator;

/**
 * Flash Message Helper.
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Flash {

    private static $sessionKey = 'flash_message';

    /**
     * Sets success message.
     *
     * @param  string $message
     * @return void
     */
    public static function success($message)
    {
        self::set(['level' => 'success', 'message' => $message]);
    }

    /**
     * Sets info message.
     *
     * @param  string $message
     * @return void
     */
    public static function info($message)
    {
        self::set(['level' => 'info', 'message' => $message]);
    }

    /**
     * Sets error message.
     *
     * @param  string|array|\Illuminate\Validation\Validator $message
     * @return void
     */
    public static function error($message)
    {
        if ($message instanceof Validator)
        {
            // Convert MessageBag to array
            $messages = $message->messages()->getMessages();
            $message = [];

            foreach ($messages as $errors)
            {
                foreach ($errors as $error)
                {
                    $message[] = $error;
                }
            }

        }

        self::set(['level' => 'error', 'message' => $message]);
    }

    /**
     * Gets plain message.
     *
     * @return array|NULL
     */
    public static function get()
    {
        return Session::pull(self::$sessionKey, NULL);
    }

    /**
     * Gets HTML message.
     *
     * @return string|NULL
     */
    public static function html()
    {
        $value = self::get();

        if ( ! is_array($value))
            return '';

        switch($value['level']) {
            case 'error':
                return view('flash_messages.error', ['message' => $value['message']]);
            default:
                return view('flash_messages.success', ['message' => $value['message']]);
        }
    }

    /**
     * Sets message.
     *
     * @param   mixed   $message
     * @return  string
     */
    private static function set($message)
    {
        Session::flash(self::$sessionKey, $message);
    }
}
