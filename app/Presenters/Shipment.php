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
     * Presents the shipment carrier's name.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->carrier_id) ? $this->model->carrier->present()->name() : NULL;
    }

    /**
     * Presents the created timestamp and creator name.
     *
     * @return string
     */
    public function createdAt()
    {
        $creator = ($this->model->creator_user_id) ? $this->model->creator->present()->fullname() : NULL;
        $date = date('m/d/y g:i A', strtotime($this->model->created_at));

        if ( ! $creator)
        {
            return $date;
        }

        return $date . ' by ' . $creator;
    }

    /**
     * Presents the updated timestamp and updater name.
     *
     * @return string
     */
    public function updatedAt()
    {
        $updater = ($this->model->updater_user_id) ? $this->model->updater->present()->fullname() : NULL;
        $date = date('m/d/y g:i A', strtotime($this->model->created_at));

        if ( ! $updater)
        {
            return $date;
        }

        return $date . ' by ' . $updater;
    }


    /**
     * Presents the shipment departed date.
     *
     * @return string
     */
    public function departedAt()
    {
        $format = 'm/d/Y';

        return $this->model->exists ? date($format, strtotime($this->model->departed_at)) : date($format);
    }

    /**
     * Presents the shipment total value.
     *
     * @return string
     */
    public function totalValue()
    {
        return ($this->model->exists) ? Currency::formatDollar($this->model->calculateTotalValue()) : NULL;
    }
}
