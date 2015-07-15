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
        return ($this->model->role_id) ? '<div class="badge badge-warning">' . $this->model->role->name . '</div>' : '';
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
