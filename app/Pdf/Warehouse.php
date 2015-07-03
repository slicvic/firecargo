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
     * @param  WarehouseModel $warehouse
     * @return PDF
     */
    public static function getReceipt(WarehouseModel $warehouse)
    {
        $barcode = new TCPDFBarcode($warehouse->id, 'C128');
        $barcodeBase64 = base64_encode($barcode->getBarcodePngData(2, 30));

        $pdf = new TCPDF('P', 'mm', 'A4', TRUE, 'UTF-8', FALSE);
        // White out the top header border
        $pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));
        $pdf->SetFont('helvetica', '', 10);
        $pdf->AddPage();

        $html = view('pdfs/warehouse/receipt', [
            'warehouse' => $warehouse,
            'barcodeBase64' => $barcodeBase64
        ])->render();

        $pdf->writeHTML($html, TRUE, FALSE, TRUE, FALSE, '');

        return $pdf->Output('warehouse-receipt-' . $warehouse->id . '.pdf', 'I');
    }

    /**
     * Generates a warehouse shipping label.
     *
     * @param  WarehouseModel $warehouse
     * @return PDF
     */
    public static function getLabel(WarehouseModel $warehouse)
    {
        $packages = $warehouse->packages;
        $totalPackages = count($packages);
        $barcode = new TCPDFBarcode($warehouse->id, 'C128');
        $barcodeBase64 = base64_encode($barcode->getBarcodePngData(2, 30));

        $pdf = new TCPDF('P', 'mm', 'A4', TRUE, 'UTF-8', FALSE);
        // White out the top header border
        $pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));
        $pdf->SetFont('helvetica', '', 10);

        $html = view('pdfs/warehouse/label', [
            'warehouse' => $warehouse,
            'packages' => $packages,
            'totalPackages' => $totalPackages,
            'barcodeBase64' => $barcodeBase64
        ])->render();

        for ($i = 1; $i <= $totalPackages; $i++)
        {
            $pdf->AddPage('P', 'A6');
            $pdf->writeHTML(str_replace('%%STICKER_NUMBER%%', $i, $html), TRUE, FALSE, TRUE, FALSE, '');
        }

        return $pdf->Output('warehouse-label-' . $warehouse->id . '.pdf', 'I');
    }
}

