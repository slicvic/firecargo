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
     * @param  bool  $showId  Whether to show the id along with the name.
     * @return string
     */
    public function name($showId = FALSE)
    {
        return ($showId) ? "{$this->model->name} ({$this->model->id})" : $this->model->name;
    }
}
