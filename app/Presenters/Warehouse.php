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
        return ($this->model->shipper_user_id) ? $this->model->shipper->present()->companyName() : '';
    }

    /**
     * Presents the shipper name link.
     *
     * @return string
     */
    public function shipperNameLink()
    {
        return '<a href="' . url('accounts/edit/' . $this->model->shipper->id) . '">' . $this->shipperName() . '</a>';
    }


    /**
     * Presents the shipper name link.
     *
     * @return string
     */
    public function consigneeNameLink()
    {
        return '<a href="' . url('accounts/edit/' . $this->model->consignee->id) . '">' . $this->consigneeName() . '</a>';
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
     * Presents the container.
     *
     * @return string
     */
    public function container()
    {
        return ($this->model->container_id) ? $this->model->container->tracking_number : 'N/A';
    }

    /**
     * Presents the container link.
     *
     * @return string
     */
    public function containerLink()
    {
        return ($this->model->container_id) ? '<a href="' . url('containers/edit/' . $this->model->container_id) . '">' . $this->container() . '</a>' : 'N/A';
    }
}
