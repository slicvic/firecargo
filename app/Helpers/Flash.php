<?php namespace App\Helpers;

use Session;
use Illuminate\Validation\Validator;
use Illuminate\Support\MessageBag;

/**
 * Flash Message Helper.
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Flash {

    private static $sessionKey = 'cool_flash_message';

    /**
     * @var string  The flash levels.
     */
    const SUCCESS = 'success';
    const INFO    = 'info';
    const WARNING = 'warning';
    const ERROR   = 'error';

    /**
     * Sets a success message.
     *
     * @param  string $message
     * @return void
     */
    public static function success($message)
    {
        self::set(self::SUCCESS, $message);
    }

    /**
     * Sets an info message.
     *
     * @param  string $message
     * @return void
     */
    public static function info($message)
    {
        self::set(self::INFO, $message);
    }

    /**
     * Sets a warning message.
     *
     * @param  string $message
     * @return void
     */
    public static function warning($message)
    {
        self::set(self::WARNING, $message);
    }

    /**
     * Sets an error message.
     *
     * @param  string|array|\Illuminate\Validation\Validator|\Illuminate\Support\MessageBag $message
     * @return void
     */
    public static function error($message)
    {
        if ($message instanceof Validator) {
            $message = $message->messages()->all(':message');
        }
        elseif ($message instanceof MessageBag) {
            $message = $message->all(':message');
        }

        self::set(self::ERROR, $message);
    }

    /**
     * Gets the plain message.
     *
     * @return array|NULL
     */
    public static function get()
    {
        return Session::pull(self::$sessionKey, NULL);
    }

    /**
     * Renders the message as a an HTML view.
     *
     * @return string|NULL
     */
    public static function getView()
    {
        $value = self::get();

        if ($value === NULL)
            return NULL;

        return self::makeView($value['message'], $value['level']);
    }

    /**
     * Makes the view for an HTML message.
     *
     * @param  string $level  success|info|warning|error
     * @param  string|array|\Illuminate\Validation\Validator|\Illuminate\Support\MessageBag $message
     * @return string
     */
    public static function makeView($message, $level = 'error')
    {
        return view('flash_messages.' . $level, ['message' => $message])
            ->render();
    }

    /**
     * Sets a message.
     *
     * @param   string        $level    success|info|warning|error
     * @param   string|array  $message
     * @return  string
     */
    private static function set($level, $message)
    {
        Session::flash(self::$sessionKey, ['level' => $level, 'message' => $message]);
    }
}
