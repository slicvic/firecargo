<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\AccountType;
use Html;

/**
 * AccountPresenter
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountPresenter extends BasePresenter {

    /**
     * Presents the address as a string.
     *
     * @return string
     */
    public function address()
    {
        return ($this->model->address) ? $this->model->address->toString() : '';
    }
}
