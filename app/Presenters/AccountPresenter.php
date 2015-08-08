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
     * @param  string  $type   shipping|billing
     * @return string
     */
    public function address($type = 'shipping')
    {
        if ($type === 'shipping')
        {
            return ($address = $this->model->shippingAddress) ? $address->toString() : '';
        }

        return ($address = $this->model->billingAddress) ? $address->toString() : '';
    }
}
