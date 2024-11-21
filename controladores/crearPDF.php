<?php
require "../config/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('defaultFont');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($_GET['factura']);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$dompdf->stream("Factura.pdf",array("Attachment"=>1));