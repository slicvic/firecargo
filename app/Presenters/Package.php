<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

/**
 * Package
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Package extends BasePresenter {

    /**
     * Presents the status name.
     *
     * @return string
     */
    public function status()
    {
        return ($this->model->status_id) ? $this->model->status->name : '';
    }

    /**
     * Presents the type name.
     *
     * @return string
     */
    public function type()
    {
        return ($this->model->type_id) ? $this->model->type->name : '';
    }

    /**
     * Presents the dimensions.
     *
     * @return string
     */
    public function dimensions()
    {
        return $this->model->length . 'x' . $this->model->width . 'x' . $this->model->height;
    }

    /**
     * Presents the dimensions.
     *
     * @return string
     */
    public function weight()
    {
        return $this->model->weight . ' Lbs';
    }

    /**
     * Presents a string representation.
     *
     * @return string
     */
    public function toString()
    {
        return sprintf("# %s - %s - %s - %s",
            $this->model->id,
            $this->type(),
            $this->dimensions(),
            $this->weight()
        );
    }
}
