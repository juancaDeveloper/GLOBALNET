<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');
class Pdf extends Dompdf
{
    public function createPDF($html, $filename='', $stream=TRUE, $paper='A4', $orientation='portrait'){
        $dompdf = new Dompdf();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }
}
