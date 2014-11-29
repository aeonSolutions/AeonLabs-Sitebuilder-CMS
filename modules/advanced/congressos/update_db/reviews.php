<?php
/*
File revision date: 09-set-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(is_file($staticvars['local_root'].'modules/congressos/system/settings.php')):
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
else:
	echo 'You need to build settings file first!';
	exit;
endif;
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
if(is_file($staticvars['local_root'].'modules/congressos/system/settings.php')):
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
else:
	echo 'You need to build settings file first!';
	exit;
endif;
include($staticvars['local_root']."modules/congressos/system/pdf/html2fpdf.php");
include($staticvars['local_root']."kernel/reload_credentials.php");
if(isset($_POST['submit_revpaper'])):// paper review
	include($staticvars['local_root'].'modules/congressos/update_db/review_paper_options.php');
	$cod_abs=mysql_escape_string($_POST['cod_abs']);
	$cod_paper=mysql_escape_string($_POST['cod_paper']);
	
	$gaoe=array(" "," "," "," ");	
	if(isset($_POST['ga_oe'])):
		$originality=$ga_originality[0];
		$gaoe[0]='checked="checked"';
	elseif(isset($_POST['ga_og'])):
		$originality=$ga_originality[1];
		$gaoe[1]='checked="checked"';
	elseif(isset($_POST['ga_of'])):
		$originality=$ga_originality[2];
		$gaoe[2]='checked="checked"';
	else:
		$originality=$ga_originality[3];
		$gaoe[3]='checked="checked"';
	endif;
	
	$gatq=array(" "," "," "," ");	
	if(isset($_POST['ga_tqe'])):
		$tech_quality=$ga_technical[0];
		$gatq[0]='checked="checked"';
	elseif(isset($_POST['ga_tqg'])):
		$tech_quality=$ga_technical[1];
		$gatq[1]='checked="checked"';
	elseif(isset($_POST['ga_tqf'])):
		$tech_quality=$ga_technical[2];
		$gatq[2]='checked="checked"';
	else:
		$tech_quality=$ga_technical[3];
		$gatq[3]='checked="checked"';
	endif;
	
	$gaif=array(" "," "," "," ");	
	if(isset($_POST['ga_ife'])):
		$importance=$ga_importance[0];
		$gaif[0]='checked="checked"';
	elseif(isset($_POST['ga_ifg'])):
		$importance=$ga_importance[1];
		$gaif[1]='checked="checked"';
	elseif(isset($_POST['ga_iff'])):
		$importance=$ga_importance[2];
		$gaif[2]='checked="checked"';
	else:
		$importance=$ga_importance[3];
		$gaif[3]='checked="checked"';
	endif;
	
	$gacp=array(" "," "," "," ");
	if(isset($_POST['ga_cpe'])):
		$clarity=$ga_clarity[0];
		$gacp[0]='checked="checked"';
	elseif(isset($_POST['ga_cpg'])):
		$clarity=$ga_clarity[1];
		$gacp[1]='checked="checked"';
	elseif(isset($_POST['ga_cpf'])):
		$clarity=$ga_clarity[2];
		$gacp[2]='checked="checked"';
	else:
		$clarity=$ga_clarity[3];
		$gacp[3]='checked="checked"';
	endif;
	
	$taz=array(" "," ");
	if(isset($_POST['ta'])):
		$title =  $rev_title[0];
		$taz[0]='checked="checked"';
	else:
		$title =  $rev_title[1];
		$taz[1]='checked="checked"';
	endif;
	
	$lag=array(" "," ");
	if(isset($_POST['lg'])):
		$language =  $rev_lang[0];
		$lag[0]='checked="checked"';
	else:
		$language = $rev_lang[1];
		$lag[1]='checked="checked"';
	endif;
	
	$absc=array(" "," "," "," ");
	if(isset($_POST['aca'])):
		$abstract=$rev_abs[0];
		$absc[0]='checked="checked"';
	elseif(isset($_POST['asr'])):
		$abstract=$rev_abs[1];
		$absc[1]='checked="checked"';
	elseif(isset($_POST['asc'])):
		$abstract=$rev_abs[2];
		$absc[2]='checked="checked"';
	else:
		$abstract=$rev_abs[3];
		$absc[3]='checked="checked"';
	endif;
	$pres=array(" "," "," "," "," ");
	if(isset($_POST['pg'])):
		$presentation=$presentation[0];
		$pres[0]='checked="checked"';
	elseif(isset($_POST['ptb'])):
		$presentation=$presentation[1];
		$pres[1]='checked="checked"';
	elseif(isset($_POST['ptl'])):
		$presentation=$presentation[2];
		$pres[2]='checked="checked"';
	elseif(isset($_POST['pc'])):
		$presentation=$presentation[3];
		$pres[3]='checked="checked"';
	else:
		$presentation=$presentation[4];
		$pres[4]='checked="checked"';
	endif;
	$ils=array(" "," "," "," ");
	if(isset($_POST['ig'])):
		$illustrations=$illustrations[0];
		$ils[0]='checked="checked"';
	elseif(isset($_POST['ie'])):
		$illustrations=$illustrations[1];
		$ils[1]='checked="checked"';
	elseif(isset($_POST['iq'])):
		$illustrations=$illustrations[2];
		$ils[2]='checked="checked"';
	else:
		$illustrations=$illustrations[3].mysql_escape_string($_POST['iff_txt']);
		$ils[3]='checked="checked"';
	endif;
	$tabs=array(" "," "," ");
	if(isset($_POST['tg'])):
		$tables=$rev_tables[0];
		$tabs[0]='checked="checked"';
	elseif(isset($_POST['ts'])):
		$tables=$rev_tables[1];
		$tabs[1]='checked="checked"';
	else:
		$tables=$rev_tables[2].mysql_escape_string($_POST['tt_txt']);
		$tabs[2]='checked="checked"';
	endif;
	
	$afus=array(" "," "," "," ");
	if(isset($_POST['afu_c'])):
		$afu=$afu[0];
		$afus[0]='checked="checked"';
	elseif(isset($_POST['afu_n'])):
		$afu=$afu[1];
		$afus[1]='checked="checked"';
	elseif(isset($_POST['afu_s'])):
		$afu=$afu[2];
		$afus[2]='checked="checked"';
	else:
		$afu=$afu[3];
		$afus[3]='checked="checked"';
	endif;
	$rev_ref2=array(" "," "," "," ");
	if(isset($_POST['ra'])):
		$references=$rev_ref[0];
		$rev_ref2[0]='checked="checked"';
	elseif(isset($_POST['rin'])):
		$references=$rev_ref[1];
		$rev_ref2[1]='checked="checked"';
	elseif(isset($_POST['ri'])):
		$references=$rev_ref[2];
		$rev_ref2[2]='checked="checked"';
	else:
		$references=$rev_ref[3];
		$rev_ref2[3]='checked="checked"';
	endif;
	
	$gaess=array(" "," "," "," ");
	if(isset($_POST['gae'])):
		$grading=$grading[0];
		$gaess[0]='checked="checked"';
	elseif(isset($_POST['gag'])):
		$grading=$grading[1];
		$gaess[1]='checked="checked"';
	elseif(isset($_POST['gaw'])):
		$grading=$grading[2];
		$gaess[2]='checked="checked"';
	else:
		$grading=$grading[3].mysql_escape_string($_POST['ga_txt']);
		$gaess[3]='checked="checked"';
	endif;
	$reca=array(" "," "," "," ");
	if(isset($_POST['reca'])):
		$accepted='y';
		$recomendation=$recomend[0];
		$reca[0]='checked="checked"';
	elseif(isset($_POST['recam'])):
		$accepted='y';
		$recomendation=$recomend[1];
		$reca[1]='checked="checked"';
	elseif(isset($_POST['recama'])):
		$accepted='n';
		$recomendation=$recomend[2];
		$reca[2]='checked="checked"';
	else:
		$accepted='n';
		$recomendation=$recomend[3];
		$reca[3]='checked="checked"';
	endif;
	$stw='';
	$stn='';
	if(isset($_POST['stw'])):
		$stw='checked="checked"';
		$subject_topic= $subject_topic[0];
	else:
		$subject_topic= $subject_topic[1];
		$stn='checked="checked"';
	endif;
	$signature=mysql_escape_string($_POST['signature']);
	$comment_authors=mysql_escape_string($_POST['comment_author']);
	$comment_editors=mysql_escape_string($_POST['comment_editor']);
	
	$db->setquery("insert into congress_revision_paper set cod_abs='".$cod_abs."', cod_paper='".$cod_paper."', cod_revisor='".$staticvars['users']['code']."',revision_data=NOW(),
	accepted='".$accepted."', subject_topic='".$subject_topic."', originality='".$originality."', tech_quality='".$tech_quality."', clarity='".$clarity."',
	importance='".$importance."', title='".$title."', language='".$language."', abstract='".$abstract."', presentation='".$presentation."', illustrations='".$illustrations."',
	tbl='".$tables."', afu='".$afu."', ref='".$references."', grading='".$grading."', recomendation='".$recomendation."', signature='".$signature."',
	comment_authors='".$comment_authors."', comment_editors='".$comment_editors."' ");

	$db->setquery("update congress_papers set revised='y', revision_data=NOW() where cod_paper='".$cod_paper."'");

	// build pdf
	$pfiles=$db->getquery("select file,data from congress_papers where cod_paper='".$cod_paper."'");
	$reviewer=$db->getquery("select nome from users where cod_user='".$staticvars['users']['code']."'");
	$abs=$db->getquery("select authors, title from congress_abstracts where cod_abstract='".$cod_abs."'");
	$pfile=explode(".",$pfiles[0][0]);
	$pfile=$pfile[0];
	if(is_file($staticvars['local_root'].'modules/congressos/templates/pdf/'.$lang.'/review_paper.html')):
		$contents=file_get_contents($staticvars['local_root'].'modules/congressos/templates/pdf/'.$lang.'/review_paper.html');
	else:
		$contents=file_get_contents($staticvars['local_root'].'modules/congressos/templates/pdf/en/review_paper.html');
	endif;
	$contents=str_replace("{page_title}",$staticvars["meta"]["page_title"],$contents);
	$contents=str_replace("{cod_paper}",$cod_paper,$contents);
	$contents=str_replace("{authors}",$abs[0][0],$contents);
	$contents=str_replace("{date_sent}",$pfiles[0][1],$contents);
	$contents=str_replace("{title}",$abs[0][1],$contents);
	$contents=str_replace("{reviewer}",$reviewer[0][0],$contents);
	$contents=str_replace("{signature}",$signature,$contents);
	$contents=str_replace("{site_name}",$staticvars['name'],$contents);
	
	$contents=str_replace("{gaess1}",$gaess[0],$contents);
	$contents=str_replace("{gaess2}",$gaess[1],$contents);
	$contents=str_replace("{gaess3}",$gaess[2],$contents);
	$contents=str_replace("{gaess4}",$gaess[3],$contents);
	
	
	$contents=str_replace("{taz1}",$taz[0],$contents);
	$contents=str_replace("{taz2}",$taz[1],$contents);
	
	$contents=str_replace("{lag1}",$lag[0],$contents);
	$contents=str_replace("{lag2}",$lag[1],$contents);
	
	$contents=str_replace("{ref1}",$rev_ref2[0],$contents);
	$contents=str_replace("{ref2}",$rev_ref2[1],$contents);
	$contents=str_replace("{ref3}",$rev_ref2[2],$contents);
	$contents=str_replace("{ref4}",$rev_ref2[3],$contents);
	
	$contents=str_replace("{gacp1}",$gacp[0],$contents);
	$contents=str_replace("{gacp2}",$gacp[1],$contents);
	$contents=str_replace("{gacp3}",$gacp[2],$contents);
	$contents=str_replace("{gacp4}",$gacp[3],$contents);
	
	$contents=str_replace("{gaif1}",$gaif[0],$contents);
	$contents=str_replace("{gaif2}",$gaif[1],$contents);
	$contents=str_replace("{gaif3}",$gaif[2],$contents);
	$contents=str_replace("{gaif4}",$gaif[3],$contents);
	
	$contents=str_replace("{gatq1}",$gatq[0],$contents);
	$contents=str_replace("{gatq2}",$gatq[1],$contents);
	$contents=str_replace("{gatq3}",$gatq[2],$contents);
	$contents=str_replace("{gatq4}",$gatq[3],$contents);
	
	$contents=str_replace("{gaoe1}",$gaoe[0],$contents);
	$contents=str_replace("{gaoe2}",$gaoe[1],$contents);
	$contents=str_replace("{gaoe3}",$gaoe[2],$contents);
	$contents=str_replace("{gaoe4}",$gaoe[3],$contents);
	
	$contents=str_replace("{reca1}",$rev_ref2[0],$contents);
	$contents=str_replace("{reca2}",$rev_ref2[1],$contents);
	$contents=str_replace("{reca3}",$rev_ref2[2],$contents);
	$contents=str_replace("{reca4}",$rev_ref2[3],$contents);
	
	$contents=str_replace("{absc1}",$absc[0],$contents);
	$contents=str_replace("{absc2}",$absc[1],$contents);
	$contents=str_replace("{absc3}",$absc[2],$contents);
	$contents=str_replace("{absc4}",$absc[3],$contents);
	
	$contents=str_replace("{gae_txt}",$_POST['ga_txt'],$contents);
	$contents=str_replace("{pres1}",$pres[0],$contents);
	$contents=str_replace("{pres2}",$pres[1],$contents);
	$contents=str_replace("{pres3}",$pres[2],$contents);
	$contents=str_replace("{pres4}",$pres[3],$contents);
	$contents=str_replace("{pres5}",$pres[4],$contents);
	
	$contents=str_replace("{ils1}",$ils[0],$contents);
	$contents=str_replace("{ils2}",$ils[1],$contents);
	$contents=str_replace("{ils3}",$ils[2],$contents);
	$contents=str_replace("{ils4}",$ils[3],$contents);
	
	$contents=str_replace("{ils_txt}",$_POST['iff_txt'],$contents);
	$contents=str_replace("{gae_txt}",$_POST['ga_txt'],$contents);
	
	$contents=str_replace("{afus1}",$afus[0],$contents);
	$contents=str_replace("{afus2}",$afus[1],$contents);
	$contents=str_replace("{afus3}",$afus[2],$contents);
	$contents=str_replace("{afus4}",$afus[3],$contents);
	
	$contents=str_replace("{tabs1}",$tabs[0],$contents);
	$contents=str_replace("{tabs2}",$tabs[1],$contents);
	$contents=str_replace("{tabs3}",$tabs[2],$contents);
	$contents=str_replace("{tabs_txt}",$_POST['tt_txt'],$contents);
	$contents=str_replace("{stw}",$stw,$contents);
	$contents=str_replace("{stn}",$stn,$contents);
	$contents=str_replace("{today_date}",date('Y/m/d'),$contents);
	$contents=str_replace("{comment_auhtors}",$comment_authors,$contents);
	$contents=str_replace("{comment_editors}",$comment_editors,$contents);
	$contents=str_replace("{footer}",$cl[17].'&nbsp;'.$staticvars['name'].' - '.$staticvars['site_path'],$contents);
	$pdf=new HTML2FPDF();
	$contents=explode("{split_page}",$contents);
	for($i=0;$i<count($contents);$i++):
		$pdf->AddPage();
		$pdf->WriteHTML($contents[$i]);
	endfor;
	$pdf->Output($staticvars['upload']."/congress/papers/reviews/".$pfile.'.pdf');

//send email to author
	$usr=$db->getquery("select cod_user, title, authors, keywords,abstract  from congress_abstracts where cod_abstract='".$cod_abs."'");
	$topic=$db->getquery("select reference, name, translations, cod_topic from congress_themes where cod_theme='".$absc[0][0]."'");
	$idc=$topic[0][0].'-'.$cod_abs;

	if (isset($_GET['lang'])):
		$lang=$_GET['lang']; 
		if ($lang<>'pt' and $lang<>'en'):
			$lang=$staticvars['language']['main'];
		endif;
	else:
		$lang=$staticvars['language']['main'];
	endif;
	if($topic[0][2]<>''):// there are translations
		$pipes=explode("||",$topic[0][2]);
		$display_name='';
		for($l=0; $l<count($pipes);$l++):
			$names=explode("=",$pipes[$l]);
			if ($lang==$names[0]):
				$display_name=$names[1];
			endif;
		endfor;
		if ($display_name==''):
			$display_name=" - - ";
		endif;
	else:
		$display_name=$topic[0][2];
	endif;
	$theme=$display_name;
	if($topic[0][3]<>0): // subtema
		$st=$db->getquery("select name, translations from congress_themes where cod_theme='".$topic[0][3]."'");
		if($st[0][1]<>''):// there are translations
			$pipes=explode("||",$st[0][1]);
			$display_name='';
			for($l=0; $l<count($pipes);$l++):
				$names=explode("=",$pipes[$l]);
				if ($lang==$names[0]):
					$display_name=$names[1];
				endif;
			endfor;
			if ($display_name==''):
				$display_name=" - - ";
			endif;
		else:
			$display_name=$st[0][0];
		endif;
		$topic_name=$display_name;
	endif;
	
	$title=$absc[0][1];
	$authors=$absc[0][2];
	$keywords=$absc[0][3];
	$abstract=$absc[0][4];
	$email_subject=$ps[16]." ".$staticvars['name'];
	$user_email=$db->getquery("select email from users where cod_user='".$usr[0][0]."'");

	include_once('email/email_engine.php');
	$email = new email_engine_class;
	$email->to=$user_email[0][0].';'.$secretariat_email;
	$email->from=$secretariat_email;
	$email->return_path=$secretariat_email;
	$email->subject=$ar[2].' - '.$staticvars['name'];
	$email->preview=false;
	/* valid tags:
	{title} - title of webpage;
	{site_name} -> $staticvars['name'];
	{reference} - reference code;
	*/
	if(is_file($staticvars['local_root'].'modules/congresssos/templates/emails/papers/'.$lang.'/paper_revision.html')):
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/papers/'.$lang.'/';
		$email->template='paper_revision';
	else:
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/papers/en/';
		$email->template='paper_revision';
	endif;
	if(is_file($staticvars['local_root'].'modules/congressos/templates/emails/papers/'.$lang.'/revision.html')):
		$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/papers/'.$lang.'/revision.html');
	else:
		$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/papers/en/revision.html');
	endif;
	$email->message=str_replace("{site_name}",$staticvars['name'],$email->message);
	$email->message=str_replace("{reference}",$idc,$email->message);
	$email->message=str_replace("{theme}",$topic_name,$email->message);
	$email->message=str_replace("{title}",$usr[0][1],$email->message);
	$email->message=str_replace("{authors}",$usr[0][2],$email->message);
	$email->message=str_replace("{keywords}",$usr[0][3],$email->message);
	$email->message=str_replace("{abstract}",$usr[0][4],$email->message);
	$email->message=str_replace("{remarks}",$comment_authors,$email->message);
	$email->message=str_replace("{result}",$recomendation,$email->message);
	echo $message.'<br>';

	$_SESSION['success']='<font class="body_text"> <font color="#FF0000">'.$as[17].'</font></font>';
	echo '<font class="body_text"> <font color="#FF0000">'.$as[17].'</font></font>';
endif;

if(isset($_POST['submit_revabs'])):// abstract review
	$obs=mysql_escape_string($_POST['obs']);
	$cod=mysql_escape_string($_POST['abs_code']);
	if($_POST['aceitar']):
		$veritas='y';
		$result=$ar[0];
	else:
		$veritas='n';
		$result=$ar[1];
	endif;
	$db->setquery("update congress_abstracts set revised='s', revision_data=NOW() where cod_abstract='".$cod."' ");
	$db->setquery("insert into congress_revision_abs set cod_abs='".$cod."', comments='".$obs."', revision_data=NOW(), accepted='".$veritas."'");

	$usr=$db->getquery("select cod_user, title, authors, keywords,abstract,idc,cod_theme  from congress_abstracts where cod_abstract='".$cod."'");
	$user_email=$db->getquery("select email from users where cod_user='".$usr[0][0]."'");
	$topic=$db->getquery("select reference, name, translations, cod_topic from congress_themes where cod_theme='".$usr[0][6]."'");
	$idc=$topic[0][0].'-'.$cod;
	//send email to author
	include_once('email/email_engine.php');
	$email = new email_engine_class;
	$email->to=$user_email[0][0];
	$email->from=$secretariat_email;
	$email->return_path=$secretariat_email;
	$email->subject=$ar[2].' - '.$staticvars['name'];
	$email->preview=false;
	/* valid tags:
	{title} - title of webpage;
	{site_name} -> $staticvars['name'];
	{reference} - reference code;
	*/
	if(is_file($staticvars['local_root'].'modules/congresssos/templates/emails/abstracts/'.$lang.'/abstract_revision.html')):
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/abstracts/'.$lang.'/';
		$email->template='abstract_revision';
	else:
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/abstracts/en/';
		$email->template='abstract_revision';
	endif;
	if(is_file($staticvars['local_root'].'modules/congressos/templates/emails/abstracts/'.$lang.'/revision.html')):
		$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/abstracts/'.$lang.'/revision.html');
	else:
		$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/abstracts/en/revision.html');
	endif;
	$email->message=str_replace("{site_name}",$staticvars['name'],$email->message);
	$email->message=str_replace("{reference}",$idc,$email->message);
	$email->message=str_replace("{theme}",$topic_name,$email->message);
	$email->message=str_replace("{title}",$usr[0][1],$email->message);
	$email->message=str_replace("{authors}",$usr[0][2],$email->message);
	$email->message=str_replace("{keywords}",$usr[0][3],$email->message);
	$email->message=str_replace("{abstract}",$usr[0][4],$email->message);
	$email->message=str_replace("{remarks}",$obs,$email->message);
	$email->message=str_replace("{result}",$result,$email->message);
	$message=$email->send_email($staticvars);

	if(is_file($staticvars['local_root'].'modules/congressos/templates/pdf/'.$lang.'/review_abstract.html')):
		$contents=file_get_contents($staticvars['local_root'].'modules/congressos/templates/pdf/'.$lang.'/review_abstract.html');
	else:
		$contents=file_get_contents($staticvars['local_root'].'modules/congressos/templates/pdf/en/review_abstract.html');
	endif;
	$contents=str_replace("{title}",$usr[0][1],$contents);
	$contents=str_replace("{cl6}",$cl[6],$contents);
	$contents=str_replace("{cl2}",$cl[2],$contents);
	$contents=str_replace("{re0}",$re[0],$contents);
	$contents=str_replace("{theme}",$topic_name,$contents);
	$contents=str_replace("{authors}",$usr[0][2],$contents);
	$contents=str_replace("{cl1}",$cl[1],$contents);
	$contents=str_replace("{abstract}",$usr[0][4],$contents);
	$contents=str_replace("{cl12}",$cl[12],$contents);
	$contents=str_replace("{keywords}",$usr[0][3],$contents);
	$contents=str_replace("{cl25}",$cl[25],$contents);
	$contents=str_replace("{cl24}",$cl[24],$contents);
	$contents=str_replace("{idc}",$idc,$contents);
	$contents=str_replace("{ar2}",$ar[2],$contents);
	$contents=str_replace("{remarks}",$obs,$contents);
	$contents=str_replace("{rev_result}",$result,$contents);
	$contents=str_replace("{footer}",$cl[17].'&nbsp;'.$staticvars['name'].' - '.$staticvars['site_path'],$contents);
	
	$pdf=new HTML2FPDF();
	$pdf->AddPage();
	$pdf->WriteHTML($contents);
	$pdf->Output($staticvars['upload']."/congress/abstracts/reviews/".$usr[0][5].'.pdf');
	
	
	$_SESSION['success']='<font class="body_text"> <font color="#FF0000">'.$as[17].'</font></font>';
	echo '<font class="body_text"> <font color="#FF0000">'.$as[17].'</font></font>';
endif;
?>