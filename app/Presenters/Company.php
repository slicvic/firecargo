<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends BasePresenter {

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

    /**
     * Presents the logo URL.
     *
     * @param  string $size sm|md|lg
     * @return string
     */
    public function logoURL($size = 'sm')
    {
        $path = 'uploads/companies/' . $this->model->id . '/images/logo/' . $size . '.png';

        if (file_exists(public_path() . '/' . $path)) {
            return asset($path) . '?cb=' . time();
        }
        else {
            return asset('assets/admin/img/avatar.png');
        }
    }
}
