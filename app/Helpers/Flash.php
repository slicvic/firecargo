<?php namespace App\Helpers;

use Session;
use App\Helpers\Html;

/**
 * Flash Message Helper.
 */
class Flash {
    private static $session_key = 'flash_message';

    /**
     * Sets success message.
     *
     * @param  string $message
     * @return void
     */
    public static function success($message)
    {
        self::set(['type' => 'success', 'message' => $message]);
    }

    /**
     * Sets info message.
     *
     * @param  string $message
     * @return void
     */
    public static function info($message)
    {
        self::set(['type' => 'info', 'message' => $message]);
    }

    /**
     * Sets error message.
     *
     * @param  string|array|Illuminate\Support\MessageBag $message
     * @return void
     */
    public static function error($message)
    {
        self::set(['type' => 'error', 'message' => $message]);
    }

    /**
     * Gets plain message.
     *
     * @return array|NULL
     */
    public static function get()
    {
        return Session::pull(self::$session_key, NULL);
    }

    /**
     * Gets HTML message.
     *
     * @return string|NULL
     */
    public static function html()
    {
        $value = self::get();

        return ($value) ? Html::getFlash($value['type'], $value['message']) : '';
    }

    /**
     * Sets message.
     *
     * @param   mixed   $message
     * @return  string
     */
    private static function set($message)
    {
        Session::flash(self::$session_key, $message);
    }
}
