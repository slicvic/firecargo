<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Role;
use Html;

/**
 * User
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class User extends BasePresenter {

    /**
     * Presents the user fullname.
     *
     * @return string
     */
    public function fullname()
    {
        return "{$this->model->firstname} {$this->model->lastname}";
    }

    /**
     * Presents the user role.
     *
     * @return HTML string
     */
    public function role()
    {
        switch ($this->model->role_id)
        {
            case Role::SUPER_ADMIN:
                $cssClass = 'danger';
                break;
            case Role::SUPER_AGENT:
                $cssClass = 'warning';
                break;
            default:
                $cssClass = 'primary';
                break;
        }

        return sprintf('<div class="badge badge-%s">%s</div>', $cssClass, $this->model->role->name);
    }
}
