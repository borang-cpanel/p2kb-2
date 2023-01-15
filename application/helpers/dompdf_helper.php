<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
	$path = FCPATH.'/css/';
	$dompdf->set_base_path(realpath($path));
	$dompdf->set_paper("A4", "portrait");
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
?>