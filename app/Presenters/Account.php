<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;
use App\Models\AccountType;
use Html;

/**
 * Account
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Account extends BasePresenter {

    /**
     * Presents the account name.
     *
     * @return string
     */
    public function name()
    {
        return $this->model->name;
    }

    /**
     * Presents the account address.
     *
     * @return string
     */
    public function address()
    {
        return ($this->model->address) ? $this->model->address->toString() : '';
    }

    /**
     * Presents the account type.
     *
     * @return HTML string
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
