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
            return date("$dateFormat g:i A", strtotime($this->model->arrived_at));

        return date($dateFormat, strtotime($this->model->arrived_at));
    }

    /**
     * Presents the carrier name.
     *
     * @param  bool $prependId  Whether or not to prepend the carrier's id.
     * @return string
     */
    public function carrier($prependId = FALSE)
    {
        return ($this->model->exists) ? $this->model->carrier->present()->name($prependId) : '';
    }

    /**
     * Presents the consignee name.
     *
     * @param  bool  $prependId  Whether or not to prepend the user's id.
     * @return string
     */
    public function consignee($prependId = FALSE)
    {
        if ( ! $this->model->exists)
            return '';

        $name = $this->model->consignee->present()->fullname() ?: $this->model->consignee->company_name;

        return ($prependId) ? "{$this->model->consignee_user_id} - {$name}" : $name;
    }

    /**
     * Presents the shipper name.
     *
     * @param  bool  $prependId  Whether or not to prepend the user's id.
     * @return string
     */
    public function shipper($prependId = FALSE)
    {
        if ( ! $this->model->exists)
            return '';

        $name = $this->model->shipper->company_name ?: $this->model->shipper->present()->fullname();

        return ($prependId) ? "{$this->model->shipper_user_id} - {$name}" : $name;
    }

    /**
     * Presents the shipper name as a link.
     *
     * @return string
     */
    public function shipperLink()
    {
        return sprintf('<a href="/accounts/edit/%s">%s</a>', $this->model->shipper_user_id, $this->shipper());
    }

    /**
     * Presents the shipper name as a link.
     *
     * @return string
     */
    public function consigneeLink()
    {
        return sprintf('<a href="/accounts/edit/%s">%s</a>', $this->model->consignee_user_id, $this->consignee());
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
