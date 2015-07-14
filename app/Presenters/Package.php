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
        return ($this->model->exists) ? $this->model->status->name : '';
    }

    /**
     * Presents the type name.
     *
     * @return string
     */
    public function type()
    {
        return ($this->model->exists) ? $this->model->type->name : '';
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
     * Presents the warehouse link.
     *
     * @return string
     */
    public function warehouseLink()
    {
        return sprintf('<a target="_blank" href="/warehouses/show/%s">%s</a> <i class="fa fa-link"></i>', $this->model->warehouse_id, $this->model->warehouse_id);
    }

    /**
     * Presents the cargo link.
     *
     * @return string
     */
    public function cargoLink()
    {
        return ($this->model->cargo_id)
            ? sprintf('<a target="_blank" href="/cargos/show/%s">%s (%s)</a> <i class="fa fa-link"></i>', $this->model->cargo_id, $this->model->cargo->name, $this->model->cargo->reference_number) :
            'N/A';
    }

    /**
     * Presents the color status.
     *
     * @return string
     */
    public function colorStatus()
    {
        return ($this->model->cargo_id) ? 'success' : 'danger';
    }

    /**
     * Presents a string representation.
     *
     * @return string
     */
    public function toString()
    {
        return sprintf('# %s - %s - %s - %s',
            $this->model->id,
            $this->type(),
            $this->dimensions(),
            $this->weight()
        );
    }
}
