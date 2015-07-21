<?php namespace App\Presenters;

use App\Presenters\Presenter as BasePresenter;
use App\Helpers\Currency;
use App\Helpers\Html;

/**
 * Package
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Package extends BasePresenter {

    /**
     * Presents the status name.
     *
     * @return string
     */
    public function status()
    {
        return ($this->model->exists) ? $this->model->status->name : '';
    }

    /**
     * Presents the type name.
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
        return $this->model->length . 'x' . $this->model->width . 'x' . $this->model->height;
    }

    /**
     * Presents the dimensions.
     *
     * @return string
     */
    public function weight()
    {
        return $this->model->weight . ' Lbs';
    }

    /**
     * Presents the warehouse link.
     *
     * @return string
     */
    public function warehouseLink()
    {
        return Html::link('/warehouses/show/' . $this->model->warehouse_id, $this->model->warehouse_id, ['target' => ''], TRUE);
    }

    /**
     * Presents the shipment link.
     *
     * @return string
     */
    public function shipmentLink()
    {
        if ($this->model->shipment_id)
        {
            return Html::link(
                '/shipments/show/' . $this->model->shipment_id,
                $this->model->shipment->carrier->name . ' (' . $this->model->shipment->reference_number . ')',
                ['target' => ''],
                TRUE
            );

        }

        return 'N/A';
    }

    /**
     * Presents the color status.
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
     * @param bool $showSign
     * @return string
     */
    public function invoiceAmount($showSign = TRUE)
    {
        return ($this->model->exists) ? Currency::formatDollar($this->model->invoice_amount, $showSign) : '';
    }
}
