<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Helpers\Currency;
use Html;

/**
 * PackagePresenter
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackagePresenter extends BasePresenter {

    /**
     * Present the arrival date.
     *
     * @return
     */
    public function arrivalDate()
    {
        return date('m/d/y', strtotime($this->model->created_at));
    }

    /**
     * Present the package type.
     *
     * @return string
     */
    public function type()
    {
        return ($this->model->exists) ? $this->model->type->name : '';
    }

    /**
     * Present the dimensions.
     *
     * @return string
     */
    public function dimensions()
    {
        return round($this->model->length) . 'x' . round($this->model->width) . 'x' . round($this->model->height);
    }

    /**
     * Present the total weight.
     *
     * @return string
     */
    public function weight()
    {
        return $this->model->weight . ' Lbs';
    }

    /**
     * Present the customer name.
     *
     * @return string
     */
    public function customer()
    {
        return $this->model->customer->name;
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
     * Present a link to the warehouse page.
     *
     * @return html
     */
    public function warehouseLink()
    {
        return Html::linkWithIcon(
            '/warehouse/' . $this->model->warehouse_id,
            $this->model->warehouse_id
        );
    }

    /**
     * Present a link to the shipment page.
     *
     * @return html
     */
    public function shipmentLink()
    {
        if ( ! $this->model->isShipped())
        {
            return 'N/A';
        }

        $shipment = $this->model->shipment;

        return Html::linkWithIcon(
            '/shipment/' . $shipment->id,
            $shipment->reference_number
        );
    }

    /**
     * Determine the CSS class for the current status.
     *
     * @return string
     */
    public function statusCssClass()
    {
        if ($this->model->isShipped())
        {
            return 'success';
        }

        if ($this->model->isOnHold())
        {
            return 'warning';
        }

        return 'danger';
    }

    /**
     * Present the status text.
     *
     * @return string
     */
    public function statusText()
    {
        if ($this->model->isShipped())
        {
            return '<span class="label label-primary">Shipped</span>';
        }

        if ($this->model->isOnHold())
        {
            return '<span class="label label-warning">On Hold</span>';
        }

        // @TODO: Add recibido colombia

        return '<span class="label label-success">Received USA</span>';
    }

    /**
     * Present the total value of the package.
     *
     * @param  bool  $showSign
     * @return string
     */
    public function value($showSign = TRUE)
    {
        return ($this->model->exists) ? (new Currency($this->model->invoice_value))->asDollar($showSign) : '';
    }
}
