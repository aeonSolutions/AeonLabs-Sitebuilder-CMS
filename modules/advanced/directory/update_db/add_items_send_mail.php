<?php

/*
File revision date: 22-Out-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
// send mail
include_once($absolute_path."/classes/email_engine.php");
$email = new email_engine_class;
$user=$db->getquery("select nick, email, cod_user from users where nick='".$_SESSION['user']."'");
$email->to=$user[0][1];
$email->from=$staticvars['site_path'];
$email->return_path=$admin_mail;

$link=$staticvars['site_path'].'/index.php?id='.return_id('login.php').'&active='.$user[0][2];
$email->subject='Email: varaчуo de conteњdos no site:'.$site_name;
$email->preview=false;
$email->template='publish_contents';
$email->message='A colocaчуo do arquivo que submeteu no directѓrio '.$site_name;
if($enable_publish):
	$email->message.=' encontra-se de momento em fase de anсlise. Por favor aguarde 1-2 dias atщ que a nossa equipa autorize a varaчуo.Obrigado.';
else:
	$email->message.=' foi publicado com sucesso.';
	
endif;

$email->send_email($staticvars['local_root']);

?>