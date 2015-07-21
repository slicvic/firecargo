<?php namespace App\Presenters;

use App\Presenters\BasePresenter;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends BasePresenter {

    /**
     * Presents the company address.
     *
     * @return string
     */
    public function address()
    {
        return ($address = $this->model->address) ? $address->toString() : NULL;
    }
}
