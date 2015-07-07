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
    public function fullName()
    {
        $fullName = $this->model->first_name . ' ' . $this->model->last_name;

        if ( ! empty(trim($fullName)))
            return $fullName;

        return $this->model->id;
    }

    /**
     * Presents the company name.
     *
     * @return string
     */
    public function companyName()
    {
        if ( ! empty(trim($this->model->company_name)))
            return $this->model->company_name;
        return $this->model->id;
    }

    /**
     * Presents the profile photo URL.
     *
     * @param  string $size sm|md
     * @return string
     */
    public function profilePhotoURL($size = 'sm')
    {
        $path = 'uploads/users/' . $this->model->id . '/images/profile/' . $size . '.png';

        if (file_exists(public_path() . '/' . $path)) {
            return asset($path) . '?cb=' . time();
        }
        else {
            return asset('assets/admin/img/avatar.png');
        }
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
        return Html::arrayToTags($this->model->roles->lists('name'));
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
