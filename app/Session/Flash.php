<?php namespace App\Session;

use Session;

/**
 * Flash
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Flash {

    /**
     * Levels of messages that can be emitted.
     */
    const SUCCESS = 'success';
    const INFO    = 'info';
    const WARNING = 'warning';
    const ERROR   = 'error';

    /**
     * The session key we're storing the messages in.
     *
     * @var string
     */
    private $sessionKey = 'flash_message';

    /**
     * Emits a success message.
     *
     * @param  string  $message
     * @return void
     */
    public function success($message)
    {
        $this->set(self::SUCCESS, $message);
    }

    /**
     * Emits an info message.
     *
     * @param  string  $message
     * @return void
     */
    public function info($message)
    {
        $this->set(self::INFO, $message);
    }

    /**
     * Emits a warning message.
     *
     * @param  string  $message
     * @return void
     */
    public function warning($message)
    {
        $this->set(self::WARNING, $message);
    }

    /**
     * Emits an error message.
     *
     * @param  string|array|Validator|MessageBag  $message
     * @return void
     */
    public function error($message)
    {
        if ($message instanceof \Illuminate\Validation\Validator)
        {
            $message = $message->messages()->all(':message');
        }
        elseif ($message instanceof \Illuminate\Support\MessageBag)
        {
            $message = $message->all(':message');
        }

        $this->set(self::ERROR, $message);
    }

    /**
     * Retrieves a message.
     *
     * @return array|NULL
     */
    public function get()
    {
        return Session::pull($this->sessionKey, NULL);
    }

    /**
     * Retrieves a message and renders it as an HTML view.
     *
     * @return string|NULL
     */
    public function getHtml()
    {
        $value = $this->get();

        if ($value === NULL)
        {
            return NULL;
        }

        return self::view($value['message'], $value['level']);
    }

    /**
     * Stores a message in the session.
     *
     * @param   string        $level    success|info|warning|error
     * @param   string|array  $message
     * @return  string
     */
    private function set($level, $message)
    {
        Session::flash($this->sessionKey, ['level' => $level, 'message' => $message]);
    }

    /**
     * Builds the HTML view for a message.
     *
     * @param  string  $level  success|info|warning|error
     * @param  string|array|ValidationException|Validator|MessageBag  $message
     * @return string
     */
    public static function view($message, $level = 'error')
    {
        switch ($level)
        {
            case self::SUCCESS:
            case self::INFO:
            case self::WARNING:

                if ( ! is_string($message))
                {
                    $message = NULL;
                }

                break;

            case self::ERROR:

                if (is_string($message) || is_array($message))
                {
                    // Do nothing
                }
                elseif ($message instanceof \Illuminate\Validation\Validator)
                {
                    $message = $message->messages()->all(':message');
                }
                elseif ($message instanceof \Illuminate\Support\MessageBag)
                {
                    $message = $message->all(':message');
                }
                elseif ($message instanceof \App\Exceptions\ValidationException)
                {
                    $message = $message->errors()->all(':message');
                }
                else
                {
                    $message = NULL;
                }

                break;

            default:

                return NULL;
        }

        return view('flash_messages.' . $level, ['message' => $message])
            ->render();
    }
}
