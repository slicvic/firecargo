<?php namespace App\Presenters;

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
     * Presents the carrier name.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->exists) ? $this->model->carrier->name : '';
    }

    /**
     * Presents the customer name.
     *
     * @return string
     */
    public function customer()
    {
        return ($this->model->exists) ? $this->model->customer->name : '';
    }

    /**
     * Presents the shipper name.
     *
     * @return string
     */
    public function shipper()
    {
        return ($this->model->exists) ? $this->model->shipper->name : '';
    }

    /**
     * Presents a link to the shipper account page.
     *
     * @return html
     */
    public function shipperLink()
    {
        return Html::linkWithIcon(
            "/shippers/edit/{$this->model->shipper_account_id}",
            $this->model->shipper->name
        );
    }

    /**
     * Presents a link to the customer account page.
     *
     * @return html
     */
    public function customerLink()
    {
        return Html::linkWithIcon(
            "/customers/edit/{$this->model->customer_account_id}",
            $this->model->customer->name
        );
    }

    /**
     * Presents the status as a CSS class.
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
     * Presents the total volume weight.
     *
     * @return string
     */
    public function volumeWeight()
    {
        return round($this->model->calculateVolumeWeight()) . ' Lbs';
    }

    /**
     * Presents the total gross weight.
     *
     * @return string
     */
    public function grossWeight()
    {
        return round($this->model->calculateGrossWeight()) . ' Lbs';
    }

    /**
     * Presents the total charge weight.
     *
     * @return string
     */
    public function chargeWeight()
    {
        return round($this->model->calculateChargeWeight()) . ' Lbs';
    }

    /**
     * Presents the monetary value in dollar format.
     *
     * @return string
     */
    public function totalValue()
    {
        return ($this->model->exists) ? (new Currency($this->model->calculateTotalValue()))->asDollar() : '';
    }
}
