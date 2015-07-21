<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;
use App\Models\AccountType;
use App\Helpers\Html;

/**
 * Account
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Account extends BasePresenter {

    /**
     * Presents the name.
     *
     * @param  bool  $showId  Whether to show the id along with the name.
     * @return string
     */
    public function name($showId = FALSE)
    {
        return ($showId) ? "{$this->model->name} ({$this->model->id})" : $this->model->name;
    }

    /**
     * Presents the address.
     *
     * @return string
     */
    public function address()
    {
        return ($this->model->address) ? $this->model->address->toString() : '';
    }

    /**
     * Presents the role.
     *
     * @return HTML string
     */
    public function type()
    {
        switch ($this->model->type_id)
        {
            case AccountType::REGISTERED_CLIENT:
                $cssClass = 'primary';
                break;
            case AccountType::CLIENT:
                $cssClass = 'success';
                break;
            default:
                $cssClass = 'default';
        }

        return sprintf('<div class="badge badge-%s">%s</div>', $cssClass, $this->model->type->name);
    }
}
