<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends BasePresenter {

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
