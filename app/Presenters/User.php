<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;
use App\Models\Role;
use App\Helpers\Html;

/**
 * User
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class User extends BasePresenter {

    /**
     * Presents the full name.
     *
     * @return string
     */
    public function fullname()
    {
        return $this->model->full_name;
    }

    /**
     * Presents the company name, otherwise the full name.
     *
     * @param  bool  $showId  Whether to show the id along with the name.
     * @return string
     */
    public function company($showId = FALSE)
    {
        $name = $this->model->company_name ?: $this->fullname();

        return ($showId) ? "$name ({$this->model->id})" : $name;
    }

    /**
     * Presents the role.
     *
     * @return HTML string
     */
    public function role()
    {
        switch ($this->model->role_id)
        {
            case Role::ADMIN:
                $cssClass = 'primary';
                break;
            case Role::AGENT:
                $cssClass = 'success';
                break;
            case Role::CLIENT:
                $cssClass = 'danger';
                break;
            default:
                $cssClass = 'default';
        }

        return ($this->model->role_id) ? sprintf('<div class="badge badge-%s">%s</div>', $cssClass, $this->model->role->name) : '';
    }

    /**
     * Presents the address.
     *
     * @return string
     */
    public function address()
    {
        return ($this->model->address) ? $this->model->address->asString() : '';
    }
}
