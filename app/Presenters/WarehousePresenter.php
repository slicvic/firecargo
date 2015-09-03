<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\WarehouseStatus;
use App\Helpers\Currency;
use Html;

/**
 * WarehousePresenter
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehousePresenter extends BasePresenter {

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
     * Present the customer name.
     *
     * @return string
     */
    public function customer()
    {
        return ($this->model->exists) ? $this->model->customer->name : '';
    }

    /**
     * Present the shipper name.
     *
     * @return string
     */
    public function shipper()
    {
        return ($this->model->exists) ? $this->model->shipper->name : '';
    }

    /**
     * Present a link to the shipper account page.
     *
     * @return html
     */
    public function shipperLink()
    {
        return Html::linkWithIcon(
            '/account/' . $this->model->shipper_account_id . '/edit',
            $this->model->shipper->name
        );
    }

    /**
     * Present a link to the customer account page.
     *
     * @return html
     */
    public function customerLink()
    {
        return Html::linkWithIcon(
            '/account/' . $this->model->customer_account_id . '/edit',
            $this->model->customer->name
        );
    }

    /**
     * Determine the CSS class for the status.
     *
     * @return string
     */
    public function statusCssClass()
    {
        switch ($this->model->status_id)
        {
            case WarehouseStatus::PENDING:
                return 'warning';
            case WarehouseStatus::COMPLETE:
                return 'success';
            default:
                return 'danger';
        }
    }

    /**
     * Present the total volume weight.
     *
     * @return string
     */
    public function volumeWeight()
    {
        return round($this->model->calculateVolumeWeight()) . ' Lbs';
    }

    /**
     * Present the total gross weight.
     *
     * @return string
     */
    public function grossWeight()
    {
        return round($this->model->calculateGrossWeight()) . ' Lbs';
    }

    /**
     * Present the total charge weight.
     *
     * @return string
     */
    public function chargeWeight()
    {
        return round($this->model->calculateChargeWeight()) . ' Lbs';
    }

    /**
     * Present the total value of the warehouse.
     *
     * @return string
     */
    public function value()
    {
        return ($this->model->exists) ? (new Currency($this->model->calculateTotalValue()))->asDollar() : '';
    }
}
