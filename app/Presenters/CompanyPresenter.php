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
     * Present the primary contact name.
     *
     * @return string
     */
    public function contact()
    {
        return "{$this->model->firstname} {$this->model->lastname}";
    }

    /**
     * Present the address as a string.
     *
     * @param  string  $type   shipping|billing
     * @return string
     */
    public function address($type = 'shipping')
    {
        if ($type === 'shipping')
        {
            return ($address = $this->model->shippingAddress) ? $address->toString() : '';
        }

        return ($address = $this->model->billingAddress) ? $address->toString() : '';
    }

    /**
     * Present the logo URL.
     *
     * @param  string  $size  sm|md|lg
     * @param  string  $ext   png|jpg
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
