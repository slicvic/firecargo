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
     * Presents the status of the package.
     *
     * @return string
     */
    public function status()
    {
        return ($this->model->exists && $this->model->status) ? $this->model->status->name : '';
    }

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
     * Presents a link to the warehouse page.
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
     * Presents a link to the shipment page.
     *
     * @return html
     */
    public function shipmentLink()
    {
        if ($this->model->wasShipped())
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
