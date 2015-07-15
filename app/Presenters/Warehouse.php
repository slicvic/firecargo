<?php namespace App\Presenters;

use App\Presenters\Base as BasePresenter;
use App\Models\WarehouseStatus;
use App\Helpers\Currency;
use App\Helpers\Html;

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
     * @param  bool  $showId
     * @return string
     */
    public function carrier($showId = FALSE)
    {
        return ($this->model->exists) ? $this->model->carrier->present()->name($showId) : '';
    }

    /**
     * Presents the consignee name.
     *
     * @param  bool  $showId
     * @return string
     */
    public function consignee($showId = FALSE)
    {
        return ($this->model->exists) ? $this->model->consignee->present()->company($showId) : '';
    }

    /**
     * Presents the shipper name.
     *
     * @param  bool  $showId
     * @return string
     */
    public function shipper($showId = FALSE)
    {
        return ($this->model->exists) ? $this->model->shipper->present()->company($showId) : '';
    }

    /**
     * Presents the shipper name as a link.
     *
     * @return string
     */
    public function shipperLink()
    {
        return Html::link('/accounts/edit/' . $this->model->shipper_user_id, $this->model->shipper->present()->company(), ['target' => ''], TRUE);
    }

    /**
     * Presents the shipper name as a link.
     *
     * @return string
     */
    public function consigneeLink()
    {
        return Html::link('/accounts/edit/' . $this->model->consignee_user_id, $this->model->consignee->present()->company(), ['target' => ''], TRUE);
    }

    /**
     * Presents the color status.
     *
     * @return string
     */
    public function colorStatus()
    {
        switch ($this->model->status_id)
        {
            case WarehouseStatus::STATUS_PENDING:
                return 'warning';
            case WarehouseStatus::STATUS_COMPLETE:
                return 'success';
            case WarehouseStatus::STATUS_NEW:
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
