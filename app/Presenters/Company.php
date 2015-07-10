<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

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
        return ($address = $this->model->address) ? $address->asString() : '';
    }
}
