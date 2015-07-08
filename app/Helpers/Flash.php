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

    /**
     * @var string  The message levels.
     */
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';

    /**
     * Sets success message.
     *
     * @param  string $message
     * @return void
     */
    public static function success($message)
    {
        self::set(self::SUCCESS, $message);
    }

    /**
     * Sets info message.
     *
     * @param  string $message
     * @return void
     */
    public static function info($message)
    {
        self::set(self::INFO, $message);
    }

    /**
     * Sets warning message.
     *
     * @param  string $message
     * @return void
     */
    public static function warning($message)
    {
        self::set(self::WARNING, $message);
    }

    /**
     * Sets error message.
     *
     * @param  string|array|\Illuminate\Validation\Validator|\Illuminate\Support\MessageBag $message
     * @return void
     */
    public static function error($message)
    {
        if ($message instanceof Validator) {
            self::set(self::ERROR, $message->messages()->all(':message'));
        }
        elseif ($message instanceof MessageBag) {
            self::set(self::ERROR, $message->all(':message'));
        }
        else {
            self::set(self::ERROR, $message);
        }
    }

    /**
     * Gets the plain message.
     *
     * @return array|NULL
     */
    public static function get()
    {
        foreach ([self::SUCCESS, self::INFO, self::ERROR, self::WARNING] as $level)
        {
            $value = Session::pull($level, NULL);

            if ($value) {
                return ['level' => $level, 'message' => $value];
            }
        }

        return NULL;
    }

    /**
     * Renders the message as an HTML string.
     *
     * @return string|NULL
     */
    public static function getHTML()
    {
        $value = self::get();

        if ($value === NULL)
            return NULL;

        switch($value['level']) {
            case self::ERROR:
                return view('flash_messages.error', ['message' => $value['message']]);
            case self::SUCCESS:
            case self::INFO:
            case self::WARNING:
                return view('flash_messages.success', ['message' => $value['message']]);
        }
    }

    /**
     * Sets message.
     *
     * @param   string  $key
     * @param   mixed   $value
     * @return  string
     */
    private static function set($key, $value)
    {
        Session::flash($key, $value);
    }
}
