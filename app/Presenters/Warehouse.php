<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;

/**
 * Warehouse
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse extends BasePresenter {

    /**
     * Presents the human readable arrival date and time.
     *
     * @param  $withTime
     * @return string
     */
    public function arrivalDate($withTime = TRUE)
    {
        $dateFormat = 'n/j/Y';

        if ($withTime) {
            return date($dateFormat . ' g:i A', strtotime($this->model->arrived_at));
        }

        return date($dateFormat, strtotime($this->model->arrived_at));
    }

    /**
     * Presents the carrier.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->carrier_id) ? $this->model->carrier->name : '';
    }

    /**
     * Presents the consignee.
     *
     * @return string
     */
    public function consignee()
    {
        return ($this->model->consignee_user_id) ? $this->model->consignee->present()->fullname() : '';
    }

    /**
     * Presents the shipper name.
     *
     * @return string
     */
    public function shipper()
    {
        return ($this->model->shipper_user_id) ? $this->model->shipper->present()->company() : '';
    }

    /**
     * Presents the shipper name link.
     *
     * @return string
     */
    public function shipperLink()
    {
        return '<a href="' . url('accounts/edit/' . $this->model->shipper_user_id) . '">' . $this->shipper() . '</a>';
    }

    /**
     * Presents the shipper name link.
     *
     * @return string
     */
    public function consigneeLink()
    {
        return '<a href="' . url('accounts/edit/' . $this->model->consignee_user_id) . '">' . $this->consignee() . '</a>';
    }

    /**
     * Presents the volume weight.
     *
     * @return string
     */
    public function volumeWeight()
    {
        return round($this->model->calculateVolumeWeight()) . ' Lbs';
    }

    /**
     * Presents the gross weight.
     *
     * @return string
     */
    public function grossWeight()
    {
        return round($this->model->calculateGrossWeight()) . ' Lbs';
    }

    /**
     * Presents the charge weight.
     *
     * @return string
     */
    public function chargeWeight()
    {
        return round($this->model->calculateChargeWeight()) . ' Lbs';
    }
}
