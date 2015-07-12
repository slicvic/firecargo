<?php namespace App\Presenters;

use App\Presenters\PresenterException;

/**
 * PresentableTrait
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
trait PresentableTrait {

    protected $presenterInstance;

    public function present()
    {
        if ( ! $this->presenter || ! class_exists($this->presenter))
        {
            throw new PresenterException('Please set the Presenter path to your Presenter in your Model.');
        }

        if ( ! $this->presenterInstance)
        {
            $this->presenterInstance =  new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}
