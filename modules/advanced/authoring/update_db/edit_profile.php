<?php
/*
File revision date: 30-jan-2009
*/
/*
Procedure for adding field to the new user form
 files that must exist:
 	system/new_user_form.php - with the form specific fields for the module - do not include the <form> tags
	update_db/new_user_form.validade.php - for fields validation
	update_db/new_user_form.php - for insertion on corresponding DB
*/

defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/authoring/language/pt.php');
else:
	include($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php');
endif;

// todos os campos estao correctamente preeenchidos - fixe: adicionar a BD!
$_SESSION['goback']=false;

// verificaçao da password
if ($_POST['pass1']<>$_POST['pass2'] and $_POST['pass1']<>''):
	$_SESSION['goback']=true;
	$_SESSION['status']=$nusr[1];
	echo '<font class="body_text"> <font color="#FF0000">'.$nusr[1].'</font></font>';
endif;											
// add profiles from other modules
$dir=glob($staticvars['local_root'].'modules/*',GLOB_ONLYDIR);
$query=$db->getquery('select link,cod_module from module');
if ($dir[0]<>''):
	for($i=0; $i<count($dir); $i++):
		$dirX=explode("/",$dir[$i]);
		$install=true;
		for ($j=0; $j<count($query); $j++):
			$link=explode("/",$query[$j][0]);
			if ($link[0]==$dirX[count($dirX)-1]): // module found on DB	
				$install=false;
				break;
			endif;
		endfor;
		if (!$install):// module found
			if (is_dir($dir[$i].'/system')):
				if(is_file($dir[$i].'/update_db/new_user_form.validate.php') ):
					include($dir[$i].'/update_db/new_user_form.validate.php');
				endif;
			endif;
		endif;
	endfor;
endif;


if ($_SESSION['goback']==false):
	if($_POST['pass1']<>''):
		$user=mysql_escape_string($_POST['cod_user']);
		$pass=mysql_escape_string($_POST['pass1']);
		$db->setquery("update users set password=PASSWORD('".$pass."') where cod_user='".$user."'");
		$_SESSION['status']=$pe[14];
		$user=$db->getquery("select nick, email from users where cod_user='".$user."'");
		include_once('email/email_engine.php');
		$email = new email_engine_class;
	
		if(is_file($staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/change_pass.html')):
			$email->template_location=$staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/';
			$email->template='change_pass';
		else:
			$email->template_location=$staticvars['local_root'].'modules/authoring/templates/emails/en/';
			$email->template='change_pass';
		endif;
		if(is_file($staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/change_pass_msg.html')):
			$email->message=file_get_contents($staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/change_pass_msg.html');
		else:
			$email->message=file_get_contents($staticvars['local_root'].'modules/authoring/templates/emails/en/change_pass_msg.html');
		endif;
		
		$email->message=str_replace("{site_name}",$staticvars['name'],$email->message);
		$email->message=str_replace("{username}",$user[0][0],$email->message);
		$email->message=str_replace("{password}",$pass,$email->message);
		$message=$email->send_email($staticvars);
	endif;

	// add profiles from other modules
	sleep(1);	
	$dir=glob($staticvars['local_root'].'modules/*',GLOB_ONLYDIR);
	$query=$db->getquery('select link,cod_module from module');
	if ($dir[0]<>''):
		for($i=0; $i<count($dir); $i++):
			$dirX=explode("/",$dir[$i]);
			$install=true;
			for ($j=0; $j<count($query); $j++):
				$link=explode("/",$query[$j][0]);
				if ($link[0]==$dirX[count($dirX)-1]): // module found on DB	
					$install=false;
					break;
				endif;
			endfor;
			if (!$install):// module found
				if (is_dir($dir[$i].'/system')):
					if(is_file($dir[$i].'/update_db/new_user_form.php') ):
						include($dir[$i].'/update_db/new_user_form.php');
					endif;
				endif;
			endif;
		endfor;
	endif;
endif;
?>



