<?php namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Helpers\Currency;
use Html;

/**
 * Package
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Package extends BasePresenter {

    /**
     * Presents the status.
     *
     * @return string
     */
    public function status()
    {
        return ($this->model->status_id) ? $this->model->status->name : NULL;
    }

    /**
     * Presents the package type.
     *
     * @return string
     */
    public function type()
    {
        return ($this->model->type_id) ? $this->model->type->name : NULL;
    }

    /**
     * Presents the dimensions.
     *
     * @return string
     */
    public function dimensions()
    {
        return $this->model->length . 'x' . $this->model->width . 'x' . $this->model->height;
    }

    /**
     * Presents the weight.
     *
     * @return string
     */
    public function weight()
    {
        return $this->model->weight . ' Lbs';
    }

    /**
     * Presents the link to the warehouse.
     *
     * @return string
     */
    public function warehouseLink()
    {
        return Html::linkWithIcon("/warehouses/show/{$this->model->warehouse_id}", $this->model->warehouse_id);
    }

    /**
     * Presents the link to the shipment.
     *
     * @return string
     */
    public function shipmentLink()
    {
        if ($this->model->shipment_id)
        {
            return Html::linkWithIcon(
                "/shipments/show/{$this->model->shipment_id}",
                "{$this->model->shipment->carrier->name} ({$this->model->shipment->reference_number})"
            );
        }

        return 'N/A';
    }

    /**
     * Presents the shipment status as a color.
     *
     * @return string
     */
    public function colorStatus()
    {
        return ($this->model->shipment_id) ? 'success' : 'danger';
    }

    /**
     * Presents the invoice amount.
     *
     * @param  bool  $showSign
     * @return string
     */
    public function invoiceAmount($showSign = TRUE)
    {
        return ($this->model->exists) ? Currency::formatDollar($this->model->invoice_amount, $showSign) : NULL;
    }
}
