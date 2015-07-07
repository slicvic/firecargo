<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

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
        return $this->model->first_name . ' ' . $this->model->last_name;
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
     * Presents the roles as an array.
     *
     * @return array
     */
    public function rolesAsArray()
    {
        $roles = [];
        foreach ($this->model->roles as $role) {
            $roles[$role->id] = $role->name;
        }
        return $roles;
    }
}
