<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Helpers\Upload;

/**
 * Company
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Company extends BasePresenter {

    /**
     * Presents the address as a string.
     *
     * @return string
     */
    public function address()
    {
        return ($this->model->address) ? $this->model->address->toString() : '';
    }

    /**
     * Gets the logo URL.
     *
     * @param  string  $size  sm|md|lg
     * @return string
     */
    public function logoUrl($size = 'sm')
    {
        if ($this->model->has_logo)
        {
            return Upload::resourceUrl('company.logo', "{$size}.png", $this->model->id);
        }

        return asset('assets/admin/img/avatar.png');
    }
}
