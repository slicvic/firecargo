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
     * Emit a success message.
     *
     * @param  string  $message
     * @return void
     */
    public function success($message)
    {
        $this->set(self::SUCCESS, $message);
    }

    /**
     * Emit an info message.
     *
     * @param  string  $message
     * @return void
     */
    public function info($message)
    {
        $this->set(self::INFO, $message);
    }

    /**
     * Emit a warning message.
     *
     * @param  string  $message
     * @return void
     */
    public function warning($message)
    {
        $this->set(self::WARNING, $message);
    }

    /**
     * Emit an error message.
     *
     * @param  mixed  $message
     * @return void
     */
    public function error($message)
    {
        $this->set(self::ERROR, $message);
    }

    /**
     * Retrieve the message.
     *
     * @return array|NULL
     */
    public function get()
    {
        return Session::pull($this->sessionKey, NULL);
    }

    /**
     * Render the message as bootstrap alert.
     *
     * @return string|NULL
     */
    public function getBootstrap()
    {
        $value = $this->get();

        if ($value === NULL)
        {
            return NULL;
        }

        return self::view("bootstrap.{$value['level']}", $value['message']);
    }

    /**
     * Render the message as a toastr.
     *
     * @return string|NULL
     */
    public function getToastr()
    {
        $value = $this->get();

        if ($value === NULL)
        {
            return NULL;
        }

        return self::view("toastr.{$value['level']}", $value['message']);
    }

    /**
     * Build the HTML view for the message.
     *
     * @param  string  $view
     * @param  mixed   $message
     * @return string
     */
    private function view($view, $message)
    {
        return view("shared.flash.{$view}", [
            'message' => self::normalizeMessage($message)
        ])->render();
    }

    /**
     * Store the message in the session.
     *
     * @param   string        $level    success|info|warning|error
     * @param   string|array  $message
     * @return  string
     */
    private function set($level, $message)
    {
        Session::flash($this->sessionKey, ['level' => $level, 'message' => self::normalizeMessage($message)]);
    }

    /**
     * Turn the given message into a normalized representation before storing it in
     * session.
     *
     * @param  string|array|ValidationException|Validator|MessageBag  $message
     * @return string
     */
    public static function normalizeMessage($message)
    {
        if (is_string($message))
        {
            return $message;
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
