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
     * Retrieves the message.
     *
     * @return array|NULL
     */
    public function get()
    {
        return Session::pull($this->sessionKey, NULL);
    }

    /**
     * Renders the message as bootstrap alert.
     *
     * @return string|NULL
     */
    public function getClassic()
    {
        $value = $this->get();

        if ($value === NULL)
        {
            return NULL;
        }

        return self::view("classic.{$value['level']}", $value['message']);
    }

    /**
     * Renders the message as a toastr.
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
     * Makes the HTML view for the message.
     *
     * @param  string  $view
     * @param  mixed   $message
     * @return string
     */
    public function view($view, $message)
    {
        return view("flash_messages.{$view}", [
            'message' => is_string($message) ? $message : self::tidyMessage($message)
        ])->render();
    }

    /**
     * Stores the message in the session.
     *
     * @param   string        $level    success|info|warning|error
     * @param   string|array  $message
     * @return  string
     */
    private function set($level, $message)
    {
        Session::flash($this->sessionKey, ['level' => $level, 'message' => self::tidyMessage($message)]);
    }

    /**
     * Normalizes the message before storing in session.
     *
     * @param  string|array|ValidationException|Validator|MessageBag  $message
     * @return string
     */
    public static function tidyMessage($message)
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
