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

    /**
     * Presents the address as an array.
     *
     * @return array
     */
    public function addressAsArray()
    {
        $address = [];

        if ($this->model->address1) {
            $address[] = $this->model->address1;
        }

        if ($this->model->address2) {
            $address[] = $this->model->address2;
        }

        if ($this->model->city && $this->model->state) {
            $line3 = $this->model->city . ', ' . $this->model->state;
        }
        else {
            $line3 = $this->model->city . $this->model->state;
        }

        if ($this->model->postal_code) {
            $line3 .= ' ' . $this->model->postal_code;
        }

        $address[] = trim($line3);

        if ($this->model->country_id) {
            $address[] = $this->model->country->name;
        }

        return $address;
    }

    /**
     * Presents the address as a string.
     *
     * @param  string $lineSeparator
     * @return string
     */
    public function addressAsString($lineSeparator = '<br>')
    {
        return implode($lineSeparator, $this->addressAsArray());
    }
}
