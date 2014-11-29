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
if(is_file($staticvars['local_root'].'modules/congressos/system/settings.php')):
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
else:
	echo 'You need to build settings file first!';
	exit;
endif;

	$ERROR_MSGS[0] = "";
	$ERROR_MSGS[1] = "Maximum file Size Exceeded.";
	$ERROR_MSGS[2] = "Maximum file Size Exceeded.";
	$ERROR_MSGS[3] = "Parcial File Upload.";
	$ERROR_MSGS[4] = "Missing Upload File.";

	$abs=mysql_escape_string($_POST['abstract']);
	
	if (isset($_FILES['paper'])):
		if ($_FILES['paper']['error']==0):
			$ext=explode(".",$_FILES['paper']['name']);
			$ext=$ext[count($ext)-1];
			if($type_file=='both' and ($ext=='doc' or $ext=='docx' or $ext=='pdf' )):
				$allow=true;
			elseif($type_file=='doc' and ($ext=='doc' or $ext=='docx')):
				$allow=true;
			elseif($type_file=='pdf' and $ext=='pdf'):
				$allow=true;
			else:
				$allow=false;
				$_SESSION['status']='<font class="body_text"> <font color="#FF0000">'.$ps[14].'</font></font>';
				echo '<font class="body_text"> <font color="#FF0000">'.$ps[14].'</font></font>';
			endif;
			if($allow==true):
				include($staticvars['local_root'].'general/pass_generator.php');
				$idc=generate(50,'Yes','Yes','Yes');
				$filename=$idc.'.'.$ext;
				$location=$staticvars['upload'].'/congress/papers/'.$idc.'.'.$ext;
				if (!move_uploaded_file($_FILES['paper']['tmp_name'], $location)):
					$_SESSION['status']='<font class="body_text"> <font color="#FF0000">'.$ps[15].'</font></font>';
					echo '<font class="body_text"> <font color="#FF0000">'.$ps[15].'</font></font>';
				else:
					$absc=$db->getquery("select cod_theme, title, authors, keywords, abstract from congress_abstracts where cod_abstract='".$abs."'");
					$topic=$db->getquery("select reference, name, translations, cod_topic from congress_themes where cod_theme='".$absc[0][0]."'");
				
					$db->setquery("update congress_papers set active='n' where cod_user='".$staticvars['users']['code']."' and cod_abstract='".$abs."'");
					$db->setquery("insert into congress_papers set cod_theme='".$absc[0][0]."', cod_abstract='".$abs."', file='".$filename."', active='s', cod_user='".$staticvars['users']['code']."'");
					
					
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
					if(is_file($staticvars['local_root'].'modules/congresssos/templates/emails/papers/'.$lang.'/paper_submission.html')):
						$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/papers/'.$lang.'/';
						$email->template='paper_submission';
					else:
						$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/papers/en/';
						$email->template='paper_submission';
					endif;
					if(is_file($staticvars['local_root'].'modules/congressos/templates/emails/papers/'.$lang.'/submission.html')):
						$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/papers/'.$lang.'/submission.html');
					else:
						$email->message=file_get_contents($staticvars['local_root'].'modules/congressos/templates/emails/papers/en/submission.html');
					endif;
					$ref=$db->getquery("select cod_paper from congress_papers where file='".$filename."'");
					$idc='p-'.$ref[0][0];
					$email->message=str_replace("{site_name}",$staticvars['name'],$email->message);
					$email->message=str_replace("{reference}",$idc,$email->message);
					$email->message=str_replace("{theme}",$topic_name,$email->message);
					$email->message=str_replace("{title}",$title,$email->message);
					$email->message=str_replace("{authors}",$authors,$email->message);
					$email->message=str_replace("{keywords}",$keywords,$email->message);
					$email->message=str_replace("{abstract}",$abstract,$email->message);
					$email->message=str_replace("{filename}",$filename,$email->message);
					$message=$email->send_email($staticvars);
					echo '<font class="body_text"> <font color="#FF0000">'.$message.'</font></font>';
					$_SESSION['status']='<font class="body_text"> <font color="#FF0000">'.$ps[19].'</font></font>';
					echo '<font class="body_text"> <font color="#FF0000">'.$ERROR_MSGS[$_FILES['file_paper']['error']].'</font></font>';
				endif;
			endif;
		else:
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">'.$ERROR_MSGS[$_FILES['file_paper']['error']].'</font></font>';
			echo '<font class="body_text"> <font color="#FF0000">'.$ERROR_MSGS[$_FILES['file_paper']['error']].'</font></font>';
		endif;
	endif;
?>