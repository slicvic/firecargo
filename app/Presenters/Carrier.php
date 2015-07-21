<?php namespace App\Presenters;

use App\Presenters\BasePresenter;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends BasePresenter {

    /**
     * Presents the carrier name.
     *
     * @return string
     */
    public function name()
    {
        return $this->model->name;
    }
}
