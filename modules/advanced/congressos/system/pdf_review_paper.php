<?php
/*
File revision date: 09-set-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

if(is_file($staticvars['local_root'].'modules/congressos/templates/pdf/'.$lang.'/review_paper.html')):
	$contents->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/pdf/'.$lang.'/review_paper.html');
else:
	$contents=file_get_contents($staticvars['local_root'].'modules/congressos/templates/pdf/en/review_paper.html');
endif;
include($staticvars['local_root']."modules/congressos/system/pdf/html2fpdf.php");
$contents=str_replace("{page_title}",$staticvars["meta"]["page_title"],$contents);
$contents=str_replace("{cod_paper}",$cod_paper,$contents);
$contents=str_replace("{authors}",$abs[0][2],$contents);
$contents=str_replace("{date_sent}",$paper[0][1],$contents);
$contents=str_replace("{title}",$abs[0][1],$contents);
$contents=str_replace("{reviewer}",$reviewer[0][0],$contents);
$contents=str_replace("{signature}",$,$contents);
$contents=str_replace("{today_date}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);
$contents=str_replace("{}",$,$contents);

$contents=explode("{split_page}",$contents);
$pdf=new HTML2FPDF();
for():
	$pdf->AddPage();
	$pdf->WriteHTML($contents);

$pdf->Output("");
?>