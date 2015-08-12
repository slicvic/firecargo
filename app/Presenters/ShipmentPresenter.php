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
     * Present the carrier name.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->exists) ? $this->model->carrier->name : '';
    }

    /**
     * Present the departure date.
     *
     * @return string
     */
    public function departedAt()
    {
        $format = 'm/d/Y';

        return $this->model->exists ? date($format, strtotime($this->model->departed_at)) : date($format);
    }

    /**
     * Present the total value of the shipment.
     *
     * @return string
     */
    public function value()
    {
        return ($this->model->exists) ? (new Currency($this->model->calculateTotalValue()))->asDollar() : '';
    }
}
