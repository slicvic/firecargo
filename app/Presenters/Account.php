<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\AccountType;
use Html;

/**
 * Account
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Account extends BasePresenter {

    /**
     * Presents the address as a string.
     *
     * @return string
     */
    public function address()
    {
        return ($this->model->address) ? $this->model->address->toString() : '';
    }

    /**
     * Presents the account type as a bootstrap badge.
     *
     * @return html
     */
    public function type()
    {
        switch ($this->model->type_id)
        {
            case AccountType::CLIENT:
                $cssClass = 'primary';
                break;
            default:
                $cssClass = 'default';
        }

        return sprintf('<div class="badge badge-%s">%s</div>', $cssClass, $this->model->type->name);
    }
}
