<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Helpers\Currency;

/**
 * Shipment
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Shipment extends BasePresenter {

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
     * Presents the creator's name and timestamp.
     *
     * @return string
     */
    public function createdAt()
    {
        $dt = date('m/d/y g:i A', strtotime($this->model->created_at));

        return $dt . ' by ' . $this->model->creator->present()->fullname();
    }

    /**
     * Presents the updater's name and timestamp.
     *
     * @return string
     */
    public function updatedAt()
    {
        $dt = date('m/d/y g:i A', strtotime($this->model->updated_at));

        return $dt . ' by ' . $this->model->updater->present()->fullname();
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
     * Presents the total monetary value in dollar format.
     *
     * @return string
     */
    public function totalValue()
    {
        return ($this->model->exists) ? (new Currency($this->model->calculateTotalValue()))->asDollar() : '';
    }
}
