<?php

namespace App\Session;

use Illuminate\Session\Store;

/**
 * FlashNotifier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class FlashNotifier {

    /**
     * The session store instance.
     *
     * @var Store
     */
    protected $session;

    /**
     * The session key to the flash.
     *
     * @var string
     */
    private $sessionKey = 'flash_message';

    /**
     * The base view path.
     *
     * @var string
     */
    protected $view = 'shared.flash_message';

    /**
     * Constructor.
     *
     * @param Store  $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash a success message.
     *
     * @param  string  $message
     * @return void
     */
    public function success($message)
    {
        $this->message($message, 'success');
    }

    /**
     * Flash an error message.
     *
     * @param  mixed  $message
     * @return void
     */
    public function error($message)
    {
        $this->message($message, 'error');
    }

    /**
     * Flash a general message.
     *
     * @param  mixed  $message
     * @param  string $level    success|error
     * @return void
     */
    public function message($message, $level = 'success')
    {
        $data['level'] = $level;
        $data['message'] = FlashMessageNormalizer::normalize($message);

        $this->session->flash($this->sessionKey, $data);
    }

    /**
     * Display the flash message.
     *
     * @param  string  $style  bootstrap|toastr
     * @return string
     */
    public function render($style = 'bootstrap')
    {
        if ( ! $this->session->has($this->sessionKey))
        {
            return '';
        }

        $data = $this->session->get($this->sessionKey);

        return view("{$this->view}.{$style}", $data)->render();
    }
}
