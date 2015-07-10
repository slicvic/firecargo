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
        return trim($this->model->first_name . ' ' . $this->model->last_name);
    }

    /**
     * Presents the company name.
     *
     * @return string
     */
    public function company()
    {
        return $this->model->company_name;
    }

    /**
     * Presents the roles.
     *
     * @return HTML string
     */
    public function roles()
    {
        if ( ! $roles = $this->model->roles)
            return '';

        $html = '<div>';

        foreach ($roles->lists('name') as $role) {
            $html .= '<div class="badge badge-warning btns-xs">' . ucfirst($role) . '</div><br>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Presents the address.
     *
     * @return string
     */
    public function address()
    {
        return ($address = $this->model->address) ? $address->asString() : '';
    }
}
