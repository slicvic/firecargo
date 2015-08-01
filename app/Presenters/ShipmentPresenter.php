<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Helpers\Currency;

/**
 * ShipmentPresenter
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ShipmentPresenter extends BasePresenter {

    /**
     * Gets the carrier's name.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->exists) ? $this->model->carrier->name : '';
    }

    /**
     * Presents the departure date.
     *
     * @return string
     */
    public function departedAt()
    {
        $format = 'm/d/Y';

        return $this->model->exists ? date($format, strtotime($this->model->departed_at)) : date($format);
    }

    /**
     * Presents the monetary value in dollar format.
     *
     * @return string
     */
    public function totalValue()
    {
        return ($this->model->exists) ? (new Currency($this->model->calculateTotalValue()))->asDollar() : '';
    }
}
