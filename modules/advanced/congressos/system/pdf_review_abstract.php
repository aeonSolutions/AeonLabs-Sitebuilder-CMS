<?php
/*
File revision date: 9-jan-2009
*/
include($staticvars['local_root']."modules/congressos/system/pdf/html2fpdf.php");
$html=
$pdf=new HTML2FPDF();
$pdf->AddPage();
$pdf->WriteHTML($html);
$pdf->Output("");
?>