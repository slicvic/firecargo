<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;
use App\Helpers\Currency;

/**
 * Shipment
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Shipment extends BasePresenter {

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

    /**
     * Presents the total value.
     *
     * @return string
     */
    public function totalValue()
    {
        return ($this->model->exists) ? Currency::formatDollar($this->model->calculateTotalValue()) : '';
    }
}
