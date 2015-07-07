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
        else {
            return date($dateFormat, strtotime($this->model->arrived_at));
        }
    }

    /**
     * Presents the courier name.
     *
     * @return string
     */
    public function courierName()
    {
        return ($this->model->courier_id) ? $this->model->courier->name : '';
    }

    /**
     * Presents the consignee name.
     *
     * @return string
     */
    public function consigneeName()
    {
        return ($this->model->consignee_user_id) ? $this->model->consignee->present()->fullName() : '';
    }

    /**
     * Presents the shipper name.
     *
     * @return string
     */
    public function shipperName()
    {
        return ($this->model->shipper_user_id) ? $this->model->shipper->business_name : '';
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

    /**
     * Presents the group.
     *
     * @return string
     */
    public function group()
    {
        return ($this->model->group_id) ? $this->model->group->tracking_number : 'N/A';
    }
}
