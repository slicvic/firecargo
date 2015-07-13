<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

/**
 * Cargo
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Cargo extends BasePresenter {

    /**
     * Presents the carrier name.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->exists) ? $this->model->carrier->present()->name() : '';
    }

    /**
     * Presents the departed date.
     *
     * @return string
     */
    public function departedAt()
    {
        $format = 'm/d/Y';

        return $this->model->exists ? date($format, strtotime($this->model->departed_at)) : date($format);
    }
}
