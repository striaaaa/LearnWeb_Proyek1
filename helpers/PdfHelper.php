<?php

// require_once __DIR__ . '/dompdf/vendor/autoload.php';

// use Dompdf\Dompdf;
// use Dompdf\Options;

// class PdfHelper
// {
//     public static function generatePdf($html, $filename = "materi.pdf")
//     {
//         $options = new Options();
//         $options->set("isRemoteEnabled", true);
//         $options->set("isHtml5ParserEnabled", true);

//         $dompdf = new Dompdf($options);
//         $dompdf->loadHtml($html);
//         $dompdf->setPaper("A4", "portrait");

//         $dompdf->render();
//         $dompdf->stream($filename, ["Attachment" => true]); // download langsung
//     }



// Path menuju dompdf/autoload.inc.php
// require_once __DIR__ . '/../dompdf/autoload.inc.php';
require_once __DIR__ . '/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfHelper
{
    public static function generatePdf($html, $filename = "materi.pdf")
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        $dompdf->stream($filename, [
            "Attachment" => true
        ]);
    }
    public static function  generateCertificatePDF($html, $filename='default.pdf')
    {
        // Buffer html
        // ob_start();
        // include "certificate_format.php";  
        // $html = ob_get_clean();

        // // Render PDF
        // $dompdf = new Dompdf();
        // $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'landscape');
        // $dompdf->render();
        // $dompdf->stream("sertifikat-$Coursetitle-$user_name.pdf", ["Attachment" => true]);
         $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // AUTO DOWNLOAD
        $dompdf->stream($filename, ["Attachment" => true]);
    }
}
