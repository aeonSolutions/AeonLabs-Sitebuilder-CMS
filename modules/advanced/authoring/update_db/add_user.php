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
$type=@$_GET['type'];
$task=@$_GET['id'];
@$_SESSION['non']=@$_POST['name'];
@$_SESSION['e-mail']=@$_POST['email'];
@$_SESSION['new_user']=@$_POST['user_name'];
@$_SESSION['pass']=@$_POST['pass1'];
//fields Verification

// todos os campos estao correctamente preeenchidos - fixe: adicionar a BD!
$_SESSION['goback']=false;

//verificaçao do codigo de verificacao
if ($_POST['txtstr']<>$_POST['security_name']):
	$_SESSION['goback']=true;
	// O código de segurança que introduziu não coincide com o código da imagem.
	$_SESSION['erro_sec_code']=$nusr[0];
	echo '<font class="body_text"> <font color="#FF0000">'.$nusr[0].'</font></font>';
endif;
// verificaçao da password
if ($_POST['pass1']<>$_POST['pass2'] or $_POST['pass1']=='' or $_POST['pass2']==''):
	$_SESSION['goback']=true;
	$_SESSION['erro_pass']=$nusr[1];
	echo '<font class="body_text"> <font color="#FF0000">'.$nusr[1].'</font></font>';
endif;											
//verificaçao do nome de utilizador
if($_POST['user_name']==''):
	@$_SESSION['new_user']='';
	$_SESSION['goback']=true;
	//nome de utilizador invalido.
	$_SESSION['erro_user']=$nusr[5];
endif;
$qw=$db->getquery("select nick from users where nick='".mysql_escape_string($_POST['user_name'])."'");
if ($qw[0][0]<>''):
	@$_SESSION['new_user']='';
	$_SESSION['goback']=true;
	//Já existe um utilizador com o nome de utilizador que escolheu.
	$_SESSION['erro_user']=$nusr[2];
	echo '<font class="body_text"> <font color="#FF0000">'.$nusr[2].'</font></font>';
endif;
//verificaçao do email
$qw2=$db->getquery("select email from users where email='".mysql_escape_string($_POST['email'])."'");
if ($qw2[0][0]<>''):
	@$_SESSION['new_user']='';
	$_SESSION['goback']=true;
	$_SESSION['erro_email']=$nusr[3];
	echo '<font class="body_text"> <font color="#FF0000">'.$nusr[3].'</font></font>';
endif;
$not_found=checkEmail(mysql_escape_string($_POST['email']));
if(!$not_found):
	@$_SESSION['new_user']='';
	$_SESSION['goback']=true;
	$_SESSION['erro_email']=$nusr[4];
	echo '<font class="body_text"> <font color="#FF0000">'.$nusr[4].'</font></font>';
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
	// add profiles from other modules
	sleep(1);
	// atencao ao cod user type!!
	$db->setquery("insert into users set active='?', email='".mysql_escape_string($_POST['email'])."',
	 nome='".mysql_escape_string($_POST['name'])."', nick='".mysql_escape_string($_POST['user_name'])."',
	  password=password('".mysql_escape_string($_POST['pass1'])."'), data=now(), cod_skin='4', cod_css='1', cod_user_type='".$staticvars['users']['user_type']['auth']."' ");
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

	if ($staticvars['cookies']['enable']==1):
		if(!isset($_COOKIE['cookid'])):
			setcookie("cookid",   session_id(),   time()+$staticvars['cookies']['expire'], $staticvars['cookies']['path']);
		endif;
	else:
		echo 'Cookies are disabled by default.';
	endif;

	//send email to author
	include_once('email/email_engine.php');
	$email = new email_engine_class;
	$email->to=$_POST['email'];
	$email->from=$staticvars['smtp']['admin_mail'];
	$email->return_path=$staticvars['smtp']['admin_mail'];
	$email->subject="Registo / Registration ".$staticvars['name'];
	$email->preview=false;

	/* valid tags:
	{title} - title of webpage;
	{site_name} -> $staticvars['name'];
	{reference} - reference code;
	*/
	if(is_file($staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/add_user.html')):
		$email->template_location=$staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/';
		$email->template='add_user';
	else:
		$email->template_location=$staticvars['local_root'].'modules/authoring/templates/emails/en/';
		$email->template='add_user';
	endif;
	if(is_file($staticvars['local_root'].'modules/authoring/templates/emails/contents/'.$lang.'/submission.html')):
		$email->message=file_get_contents($staticvars['local_root'].'modules/authoring/templates/emails/contents/'.$lang.'/add_user.html');
	else:
		$email->message=file_get_contents($staticvars['local_root'].'modules/authoring/templates/emails/contents/en/add_user.html');
	endif;
	$cod_user=$db->getquery("select cod_user from users where email='".$_POST['email']."'");
	$link=$staticvars['site_path'].'/index.php?id='.return_id('login.php').'&active='.$cod_user[0][0];

	$email->message=str_replace("{username}",$_POST['user_name'],$email->message);
	$email->message=str_replace("{password}",$_POST['pass1'],$email->message);
	$email->message=str_replace("{link}",$link,$email->message);
	$message=$email->send_email($staticvars);
	echo $message.'->Email to:'.$email->to;
	sleep(2);
	header("referer: add_user");
	header("Location: ".session($staticvars,'index.php?id='.return_id('success_register.php')));
	echo 'should not be here - check form new register';
	exit;
endif;

?>



