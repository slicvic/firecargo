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
     * @param  string  $size  The possible values are: 'sm'|'md'|'lg'
     * @param  string  $ext   The possible values are: 'png'|'jpg'
     * @param  string  $default
     * @return string|NULL
     */
    public function logoUrl($size = 'sm', $ext = 'png', $default = NULL)
    {
        if ($this->model->has_logo)
        {
            return Upload::resourceUrl('company.logo', "{$size}.{$ext}", $this->model->id);
        }

        return $default;
    }
}
