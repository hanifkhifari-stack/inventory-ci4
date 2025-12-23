<?php

require_once APPPATH . 'ThirdParty/tcpdf/tcpdf.php';

if (!function_exists('qr_barang')) {
    function qr_barang($text)
    {
        $pdf = new TCPDF();
        $style = [
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => [0, 0, 0],
            'bgcolor' => false,
            'module_width' => 1,
            'module_height' => 1,
        ];

        // Buat QR ke memory
        $pdf->AddPage();
        $pdf->write2DBarcode($text, 'QRCODE,H', 10, 10, 30, 30, $style, 'N');

        // Ambil output image
        return $pdf->Output('', 'S');
    }
}
