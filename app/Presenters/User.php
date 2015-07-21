<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;
use App\Models\Role;
use App\Helpers\Html;

/**
 * User
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class User extends BasePresenter {

    /**
     * Presents the fullname.
     *
     * @return string
     */
    public function fullname()
    {
        return "{$this->model->firstname} {$this->model->lastname}";
    }

    /**
     * Presents the role.
     *
     * @return HTML string
     */
    public function role()
    {
        if ( ! $this->model->role_id)
        {
            return '';
        }

        switch ($this->model->role_id)
        {
            case Role::SUPER_ADMIN:
                $cssClass = 'primary';
                break;
            case Role::SUPER_AGENT:
                $cssClass = 'success';
                break;
            case Role::CLIENT:
                $cssClass = 'danger';
                break;
        }

        return sprintf('<div class="badge badge-%s">%s</div>', $cssClass, $this->model->role->name);
    }
}
