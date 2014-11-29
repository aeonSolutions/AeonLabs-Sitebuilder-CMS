<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
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
if(is_file($staticvars['local_root'].'modules/congressos/system/topics.php')):
	include($staticvars['local_root'].'modules/congressos/system/topics.php');
else:
	echo 'You need to build topics file first!';
	exit;
endif;
if(is_file($staticvars['local_root'].'modules/congressos/system/settings.php')):
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
else:
	echo 'You need to build settings file first!';
	exit;
endif;
if($_POST['title']==''):
	$_SESSION['goback']=true;
endif;
if($_POST['topic']==''):
	$_SESSION['goback']=true;
endif;
if($_POST['authors']==''):
	$_SESSION['goback']=true;
endif;
if($_POST['keywords']==''):
	$_SESSION['goback']=true;
endif;
if($_POST['abstract']==''):
	$_SESSION['goback']=true;
endif;
if($_SESSION['goback']==true):
	$_SESSION['congress']=$as[12];
else:
	$title=mysql_escape_string($_POST['title']);
	$topic=mysql_escape_string($_POST['topic']);
	$keywords=mysql_escape_string($_POST['keywords']);
	$abstract=str_replace("'","&#8217",stripslashes(normalize_chars($_POST['abstract'])));
	$authors=mysql_escape_string($_POST['authors']);
	if(isset($_POST['edit_abs'])):
		$rev=$db->getquery("select revised,idc from congress_abstracts where cod_abstract='".mysql_escape_string($_POST['code'])."'");
		$idc=$rev[0][1];
		if($rev[0][0]=='y'):
			$clause=" ,sub_abstract='".mysql_escape_string($_POST['code'])."', idc='".$idc."'";
			$str='insert into ';
			$email_subject=$as[16]." ".$staticvars['name'];			
		else:
			$str='update ';
			$clause=" where cod_abstract='".mysql_escape_string($_POST['code'])."'";
			$email_subject=$as[14]." ".$staticvars['name'];
		endif;
	else:
		include($staticvars['local_root'].'general/pass_generator.php');
		$idc=generate(50,'Yes','Yes','Yes');
		$clause=" ,idc='".$idc."'";
		$str='insert into ';
		$email_subject=$as[15]." ".$staticvars['name'];
	endif;
	include($staticvars['local_root'].'kernel/reload_credentials.php');
	$db->setquery($str."congress_abstracts set cod_user='".$staticvars['users']['code']."', title='".$title."',
				  keywords='".$keywords."', authors='".$authors."', abstract='".$abstract."', cod_theme='".$topic."'".$clause);
	$topic=$db->getquery("select reference, name, translations, cod_topic from congress_themes where cod_theme='".$topic."'");
	$addr=$db->getquery("select affiliation, address1, address2, postal, city, country from congress_users where cod_user='".$staticvars['users']['code']."'");
	$address=$addr[0][0].','.$addr[0][1].' '.$addr[0][2].', '.$addr[0][3].' '.$addr[0][4].', '.$addr[0][5];
	$file_content=file_get_contents($staticvars['local_root'].'modules/congressos/templates/rtf/abstract.rtf');
	$file_content=str_replace("titletext",$title,$file_content);
	$file_content=str_replace("authors",$authors,$file_content);
	$file_content=str_replace("abstract_text",$abstract,$file_content);
	$file_content=str_replace("keywords_text",$keywords,$file_content);
	$file_content=str_replace("address",$address,$file_content);
	
	$filename=$staticvars['upload'].'\\congress\\abstracts\\'.$idc.'.rtf';
	@unlink($filename);
	if (!$handle = fopen($filename, 'a')):
		echo '<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
	endif;
	if (fwrite($handle, $file_content) === FALSE):
		echo '<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
	endif;
	fclose($handle);

	$db->setquery("update congress_abstracts set file='".$idc.".rtf' where idc='".$idc."'");

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
	//send email to author
	include_once('email/email_engine.php');
	$email = new email_engine_class;
	if($forwarding=='on'):
		$email->to=$staticvars['users']['email'].';'.$secretariat_email;
	else:
		$email->to=$staticvars['users']['email'];
	endif;
	$email->from=$secretariat_email;
	$email->return_path=$secretariat_email;
	$email->subject=$email_subject;
	$email->preview=false;
	/* valid tags:
	{title} - title of webpage;
	{site_name} -> $staticvars['name'];
	{reference} - reference code;
	*/
	if(is_file($staticvars['local_root'].'modules/congresssos/templates/emails/abstracts/'.$lang.'/abstract_submission.html')):
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/abstracts/'.$lang.'/';
		$email->template='abstract_submission';
	else:
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/abstracts/en/';
		$email->template='abstract_submission';
	endif;
	if(is_file($staticvars['local_root'].'modules/congressos/templates/emails/abstracts/'.$lang.'/submission.html')):
		$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/abstracts/'.$lang.'/submission.html');
	else:
		$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/abstracts/en/submission.html');
	endif;
	$idc=$db->getquery("select cod_abstract from congress_abstracts where idc='".$idc."'");
	$idc=$topic[0][0].'-'.$idc[0][0];
	$email->message=str_replace("{site_name}",$staticvars['name'],$email->message);
	$email->message=str_replace("{reference}",$idc,$email->message);
	$email->message=str_replace("{theme}",$topic_name,$email->message);
	$email->message=str_replace("{title}",$title,$email->message);
	$email->message=str_replace("{authors}",$authors,$email->message);
	$email->message=str_replace("{keywords}",$keywords,$email->message);
	$email->message=str_replace("{abstract}",$abstract,$email->message);
	$message=$email->send_email($staticvars);
	$_SESSION['success']=$message;
endif;

?>