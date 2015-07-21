<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;
use App\Models\WarehouseStatus;
use App\Helpers\Currency;
use Html;

/**
 * Warehouse
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse extends BasePresenter {

    /**
     * Presents the warehouse date.
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
     * Presents the warehouse carrier name.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->exists) ? $this->model->carrier->present()->name() : '';
    }

    /**
     * Presents the warehouse consignee name.
     *
     * @return string
     */
    public function consignee()
    {
        return ($this->model->exists) ? $this->model->consignee->present()->name() : '';
    }

    /**
     * Presents the warehouse shipper name.
     *
     * @return string
     */
    public function shipper()
    {
        return ($this->model->exists) ? $this->model->shipper->present()->name() : '';
    }

    /**
     * Presents the warehouse shipper name as a link.
     *
     * @return string
     */
    public function shipperLink()
    {
        return Html::link(
            "/accounts/edit/{$this->model->shipper_account_id}",
            $this->model->shipper->present()->name(),
            [],
            TRUE
        );
    }

    /**
     * Presents the warehouse consignee name as a link.
     *
     * @return string
     */
    public function consigneeLink()
    {
        return Html::link(
            "/accounts/edit/{$this->model->consignee_account_id}",
            $this->model->consignee->present()->name(),
            [],
            TRUE
        );
    }

    /**
     * Presents the warehouse color status.
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
     * Presents the warehouse volume weight.
     *
     * @return string
     */
    public function volumeWeight()
    {
        return round($this->model->calculateVolumeWeight()) . ' Lbs';
    }

    /**
     * Presents the warehouse gross weight.
     *
     * @return string
     */
    public function grossWeight()
    {
        return round($this->model->calculateGrossWeight()) . ' Lbs';
    }

    /**
     * Presents the warehouse charge weight.
     *
     * @return string
     */
    public function chargeWeight()
    {
        return round($this->model->calculateChargeWeight()) . ' Lbs';
    }

    /**
     * Presents the warehouse total value.
     *
     * @return string
     */
    public function totalValue()
    {
        return ($this->model->exists) ? Currency::formatDollar($this->model->calculateTotalValue()) : '';
    }
}
