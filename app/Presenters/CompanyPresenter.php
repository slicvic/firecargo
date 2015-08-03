<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Helpers\Upload;

/**
 * CompanyPresenter
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CompanyPresenter extends BasePresenter {

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
     * Presents the logo URL.
     *
     * @param  string  $size  sm|md|lg
     * @return string
     */
    public function logoUrl($size = 'sm')
    {
        if (Upload::resourceExists('company.logo', "{$size}.png", $this->model->id))
        {
            return Upload::resourceUrl('company.logo', "{$size}.png", $this->model->id);
        }

        return asset('assets/admin/img/avatar.png');
    }
}
