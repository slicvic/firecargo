<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;
use App\Helpers\Currency;
use Html;

/**
 * Package
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Package extends BasePresenter {

    /**
     * Presents the package status.
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
     * Presents the package dimensions.
     *
     * @return string
     */
    public function dimensions()
    {
        return $this->model->length . 'x' . $this->model->width . 'x' . $this->model->height;
    }

    /**
     * Presents the package weight.
     *
     * @return string
     */
    public function weight()
    {
        return $this->model->weight . ' Lbs';
    }

    /**
     * Presents the package warehouse link.
     *
     * @return string
     */
    public function warehouseLink()
    {
        return Html::link("/warehouses/show/{$this->model->warehouse_id}", $this->model->warehouse_id, [], TRUE);
    }

    /**
     * Presents the package shipment link.
     *
     * @return string
     */
    public function shipmentLink()
    {
        if ($this->model->shipment_id)
        {
            return Html::link(
                "/shipments/show/{$this->model->shipment_id}",
                "{$this->model->shipment->carrier->name} ({$this->model->shipment->reference_number})",
                [],
                TRUE
            );

        }

        return 'N/A';
    }

    /**
     * Presents the package color status.
     *
     * @return string
     */
    public function colorStatus()
    {
        return ($this->model->shipment_id) ? 'success' : 'danger';
    }

    /**
     * Presents the package invoice amount.
     *
     * @param  bool  $showSign
     * @return string
     */
    public function invoiceAmount($showSign = TRUE)
    {
        return ($this->model->exists) ? Currency::formatDollar($this->model->invoice_amount, $showSign) : '';
    }
}
