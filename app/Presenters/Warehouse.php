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
    public function arrivedAt($withTime = TRUE)
    {
        $dateFormat = 'n/j/Y';

        if ($withTime)
        {
            return date("$dateFormat g:i A", strtotime($this->model->arrived_at));
        }

        return date($dateFormat, strtotime($this->model->arrived_at));
    }

    /**
     * Presents the carrier name.
     *
     * @param  bool  $appendId
     * @return string
     */
    public function carrier($appendId = FALSE)
    {
        return ($this->model->exists) ? $this->model->carrier->present()->name($appendId) : '';
    }

    /**
     * Presents the consignee name.
     *
     * @param  bool  $appendId
     * @return string
     */
    public function consignee($appendId = FALSE)
    {
        return ($this->model->exists) ? $this->model->consignee->present()->company($appendId) : '';
    }

    /**
     * Presents the shipper name.
     *
     * @param  bool  $appendId  Whether or not to append the user's id.
     * @return string
     */
    public function shipper($appendId = FALSE)
    {
        return ($this->model->exists) ? $this->model->shipper->present()->company($appendId) : '';
    }

    /**
     * Presents the shipper name as a link.
     *
     * @return string
     */
    public function shipperLink()
    {
        return sprintf('<a target="_blank" href="/accounts/edit/%s">%s</a> <i class="fa fa-link"></i>', $this->model->shipper_user_id, $this->model->shipper->present()->company());
    }

    /**
     * Presents the shipper name as a link.
     *
     * @return string
     */
    public function consigneeLink()
    {
        return sprintf('<a target="_blank" href="/accounts/edit/%s">%s</a> <i class="fa fa-link"></i>', $this->model->consignee_user_id, $this->model->consignee->present()->company());
    }

    /**
     * Presents the color status.
     *
     * @return string
     */
    public function colorStatus()
    {
        switch ($this->model->determineColorStatus())
        {
            case 'green':
                return 'success';
            case 'yellow':
                return 'warning';
            default:
                return 'danger';
        }
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
