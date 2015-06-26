<?php namespace App\Pdf;

use TCPDF;
use TCPDFBarcode;
use App\Models\Warehouse as WarehouseModel;

/**
 * WarehousesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Warehouse {

    /**
     * Generates a warehouse receipt.
     *
     * @param  int $warehouseId
     * @return PDF
     */
    public static function getReceipt($warehouseId)
    {
        $warehouse = WarehouseModel::find($warehouseId);
        $packages = $warehouse->packages();

        $barcode = new TCPDFBarcode($warehouseId, 'C128');
        $barcodeBase64 = base64_encode($barcode->getBarcodePngData(2, 30));

        $pdf = new TCPDF('P', 'mm', 'A4', TRUE, 'UTF-8', FALSE);
        // White out the top header border
        $pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));
        $pdf->SetFont('helvetica', '', 10);
        $pdf->AddPage();

        $html = view('pdf/warehouse/receipt', [
            'warehouse' => $warehouse,
            'packages' => $packages,
            'barcodeBase64' => $barcodeBase64
        ])->render();

        $pdf->writeHTML($html, TRUE, FALSE, TRUE, FALSE, '');

        return $pdf->Output('warehouse-receipt-' . $warehouseId . '.pdf', 'I');
    }

    /**
     * Generates a warehouse shipping label.
     *
     * @param  int $warehouseId
     * @return PDF
     */
    public static function getLabel($warehouseId)
    {
        $warehouse = WarehouseModel::find($warehouseId);
        $packages = $warehouse->packages();

        $barcode = new TCPDFBarcode($warehouseId, 'C128');
        $barcodeBase64 = base64_encode($barcode->getBarcodePngData(2, 30));

        $pdf = new TCPDF('P', 'mm', 'A4', TRUE, 'UTF-8', FALSE);
        // White out the top header border
        $pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));
        $pdf->SetFont('helvetica', '', 10);

         $stickerNumber = 1;

        foreach ($warehouse->packages() as $package)
        {
            $pdf->AddPage();

            $html = view('pdf/warehouse/label', [
                'warehouse' => $warehouse,
                'packages' => $packages,
                'barcodeBase64' => $barcodeBase64,
                'stickerNumber' => $stickerNumber
            ])->render();

            $pdf->writeHTML($html, TRUE, FALSE, TRUE, FALSE, '');

            $stickerNumber++;
        }

        return $pdf->Output('warehouse-label-' . $warehouseId . '.pdf', 'I');
    }
}

