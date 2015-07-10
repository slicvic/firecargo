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
     * @param  bool $prependId  Whether or not to prepend the carrier's id.
     * @return string
     */
    public function name($prependId = FALSE)
    {
        return ($prependId) ? "{$this->model->id}  - {$this->model->name}" : $this->model->name;
    }
}
