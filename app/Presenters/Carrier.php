<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends BasePresenter {

    /**
     * Presents the carrier name.
     *
     * @return string
     */
    public function name()
    {
        return $this->model->name;
    }
}
