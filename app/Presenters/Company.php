<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends BasePresenter {

    /**
     * Presents the address.
     *
     * @return string
     */
    public function address()
    {
        return ($this->model->address) ? $this->model->address->toString() : '';
    }
}
