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
        $fullname = $this->model->first_name . ' ' . $this->model->last_name;

        if ( ! empty(trim($fullname)))
            return $fullname;

        return $this->model->company_name;
    }

    /**
     * Presents the company name.
     *
     * @return string
     */
    public function company()
    {
        if ( ! empty(trim($this->model->company_name)))
            return $this->model->company_name;

        return $this->fullname();
    }

    /**
     * Presents the roles.
     *
     * @return string
     */
    public function roles()
    {
        if ( ! $this->model->roles)
            return '';
        return Html::arrayToBadges($this->model->roles->lists('name'));
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
