<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

/**
 * Carrier
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Carrier extends BasePresenter {

    /**
     * Presents the carrier name.
     *
     * @param  bool  $appendId  Whether or not to append the carrier's id.
     * @return string
     */
    public function name($appendId = FALSE)
    {
        return ($appendId) ? "{$this->model->name} ({$this->model->id})" : $this->model->name;
    }
}
