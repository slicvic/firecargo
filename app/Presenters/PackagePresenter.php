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
     * Presents a link to its client's account page.
     *
     * @return html
     */
    public function clientLink()
    {
        return Html::linkWithIcon(
            "/clients/edit/{$this->model->client_account_id}",
            $this->model->client->name
        );
    }

    /**
     * Presents a link to its warehouse's page.
     *
     * @return html
     */
    public function warehouseLink()
    {
        return Html::linkWithIcon(
            "/warehouses/show/{$this->model->warehouse_id}",
            $this->model->warehouse_id
        );
    }

    /**
     * Presents a link to its shipment's page.
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

        $title = sprintf('%s (Reference: %s, Date: %s)',
            $shipment->id,
            $shipment->reference_number,
            $shipment->present()->departedAt()
        );

        return Html::linkWithIcon("/shipments/show/{$shipment->id}", $title);
    }

    /**
     * Determines the color status CSS class.
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
     * Presents the total invoice amount.
     *
     * @return string
     */
    public function invoiceValue()
    {
        return ($this->model->exists) ? (new Currency($this->model->invoice_value))->asDollar() : '';
    }
}
