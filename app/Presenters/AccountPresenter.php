<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\AccountTag;
use Html;

/**
 * AccountPresenter
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountPresenter extends BasePresenter {

    /**
     * Presents the address as a string.
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
     * Presents the tags as bootstrap badges.
     *
     * @return string
     */
    public function tags()
    {
        $html = [];

        $tags = $this->model->tags->lists('name', 'id');

        foreach ($tags as $id => $name)
        {
            $html[] = sprintf(
                '<span class="badge badge-%s">%s</span>',
                ($id === AccountTag::CUSTOMER ? 'primary' : 'default'),
                $name
            );
        }

        return implode('<br>', $html);
    }
}
