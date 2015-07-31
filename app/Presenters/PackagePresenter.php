<?php namespace App\Presenters;

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
     * Presents the package type.
     *
     * @return string
     */
    public function type()
    {
        return ($this->model->exists) ? $this->model->type->name : '';
    }

    /**
     * Presents the dimensions.
     *
     * @return string
     */
    public function dimensions()
    {
        return round($this->model->length) . 'x' . round($this->model->width) . 'x' . round($this->model->height);
    }

    /**
     * Presents the total weight.
     *
     * @return string
     */
    public function weight()
    {
        return $this->model->weight . ' Lbs';
    }

    /**
     * Presents the client's name.
     *
     * @return string
     */
    public function client()
    {
        return $this->model->client->name;
    }

    /**
     * Presents a link to it's client account page.
     *
     * @return html
     */
    public function clientLink()
    {
        return Html::linkWithIcon(
            "/clients/edit/{$this->model->client_account_id}",
            $this->model->client->name);
    }

    /**
     * Presents a link to it's warehouse page.
     *
     * @return html
     */
    public function warehouseLink()
    {
        return Html::linkWithIcon(
            "/warehouses/show/{$this->model->warehouse_id}",
            $this->model->warehouse_id);
    }

    /**
     * Presents a link to it's shipment page.
     *
     * @return html
     */
    public function shipmentLink()
    {
        if ($this->model->inShipment())
        {
           return Html::linkWithIcon(
                "/shipments/show/{$this->model->shipment_id}",
                "{$this->model->shipment->carrier->name} ({$this->model->shipment->reference_number})");
        }

        return 'N/A';
    }

    /**
     * Presents the total invoice amount.
     *
     * @return string
     */
    public function invoiceAmount()
    {
        return ($this->model->exists) ? (new Currency($this->model->invoice_amount))->asDollar() : '';
    }
}
