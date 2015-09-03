<?php

namespace App\Services\Pdf;

use TCPDF;
use TCPDFBarcode;

use App\Models\Warehouse;

/**
 * WarehousePdfService
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehousePdfService {

    /**
     * Generate a warehouse receipt.
     *
     * @param  Warehouse  $warehouse
     * @return PDF
     */
    public function makeReceipt(Warehouse $warehouse)
    {
        // Create barcode
        $barcode = new TCPDFBarcode($warehouse->id, 'C128');
        $barcodeBase64 = base64_encode($barcode->getBarcodePngData(2, 30));

        // Create PDF
        $pdf = new TCPDF('P', 'mm', 'A4', TRUE, 'UTF-8', FALSE);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetAutoPageBreak(FALSE);
        // White out the header border
        $pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));

        $pdf->AddPage();

        $html = view('admin/pdfs/warehouse/receipt', [
            'warehouse' => $warehouse,
            'barcodeBase64' => $barcodeBase64
        ])->render();

        $pdf->writeHTML($html, TRUE, FALSE, TRUE, FALSE, '');

        return $pdf->Output('warehouse-receipt-' . $warehouse->id . '.pdf', 'I');
    }

    /**
     * Generate a warehouse shipping label.
     *
     * @param  Warehouse  $warehouse
     * @return PDF
     */
    public function makeLabel(Warehouse $warehouse)
    {
        // Retrieve packages
        $packages = $warehouse->packages;
        $totalPackages = count($packages);

        // Create barcode
        $barcode = new TCPDFBarcode($warehouse->id, 'C128');
        $barcodeBase64 = base64_encode($barcode->getBarcodePngData(2, 30));

        $pdf = new TCPDF('P', 'mm', 'A6', TRUE, 'UTF-8', FALSE);
        $pdf->SetFont('helvetica', '', 8.5);
        $pdf->SetAutoPageBreak(FALSE);
        // White out the header border
        $pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));

        $html = view('admin/pdfs/warehouse/label', [
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

