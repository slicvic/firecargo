<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
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
     * Presents the arrival date.
     *
     * @return string
     */
    public function arrivedAt($showTime = TRUE)
    {
        return date('n/j/Y g:i A', strtotime($this->model->arrived_at));
    }

    /**
     * Presents the creator's name and timestamp.
     *
     * @return string
     */
    public function createdAt()
    {
        $dt = date('m/d/y g:i A', strtotime($this->model->created_at));

        return $dt . ' by ' . $this->model->creator->present()->fullname();
    }

    /**
     * Presents the updater's name and timestamp.
     *
     * @return string
     */
    public function updatedAt()
    {
        $dt = date('m/d/y g:i A', strtotime($this->model->updated_at));

        return $dt . ' by ' . $this->model->updater->present()->fullname();
    }

    /**
     * Presents the carrier's name.
     *
     * @return string
     */
    public function carrier()
    {
        return ($this->model->exists) ? $this->model->carrier->name : '';
    }

    /**
     * Presents the consignee's name.
     *
     * @return string
     */
    public function consignee()
    {
        return ($this->model->exists) ? $this->model->consignee->name : '';
    }

    /**
     * Presents the shipper's name.
     *
     * @return string
     */
    public function shipper()
    {
        return ($this->model->exists) ? $this->model->shipper->name : '';
    }

    /**
     * Presents a link to the shipper's account page.
     *
     * @return html
     */
    public function shipperLink()
    {
        return Html::linkWithIcon(
            "/accounts/edit/{$this->model->shipper_account_id}", 
            $this->model->shipper->name);
    }

    /**
     * Presents a link to the consignee's account page.
     *
     * @return html
     */
    public function consigneeLink()
    {
        return Html::linkWithIcon(
            "/accounts/edit/{$this->model->consignee_account_id}", 
            $this->model->consignee->name);
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
            case WarehouseStatus::STATUS_PENDING:
                return 'warning';
            case WarehouseStatus::STATUS_COMPLETE:
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
     * Presents the total monetary value in dollar format.
     *
     * @return string
     */
    public function totalValue()
    {
        return ($this->model->exists) ? (new Currency($this->model->calculateTotalValue()))->asDollar() : '';
    }
}
