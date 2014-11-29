<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found(dictionary managment)';
	exit;
endif;
$bc=mysql_escape_string(@$_GET['cod']);
if (isset($_POST['publish'])):
	$db->setquery("update dictionary set active='s' where cod_dic='".$bc."'");
	$_SESSION['update']='Palavra publicada no dicionario';
elseif(isset($_POST['unpublish'])):
	$db->setquery("update dictionary set active='n' where cod_dic='".$bc."'");
	$_SESSION['update']='Palavra retirada de publicação no dicionario';
elseif (isset($_POST['del_term'])): // apagar  box
	$db->setquery("delete from dictionary where cod_dic='".$bc."'");
		$_SESSION['update']='Palavra apagada';
elseif (isset($_POST['edit_term']))://editar box
	$db->setquery("update dictionary set termo='".mysql_escape_string($_POST['termo'])."',
	 definicao='".mysql_escape_string($_POST['definicao'])."' where cod_dic='".$bc."'");
	$_SESSION['update']='Palavra editada com sucesso';
elseif (isset($_POST['add_term']))://inserir box
	$db->setquery("insert into dictionary set termo='".mysql_escape_string($_POST['termo'])."',
	 definicao='".mysql_escape_string($_POST['definicao'])."'");
	$_SESSION['update']='Palavra adicionada com sucesso';
endif;
if (isset($_POST['send_email'])):
	include_once($absolute_path."/classes/email_engine.php");
	$email = new email_engine_class;
	$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$email->to=$user[0][1];
	$email->from='"'.$site_name.'" <'.$admin_mail.'>';
	$email->return_path=$admin_mail;
	$email->subject="publica&ccedil;&atilde;o no dicionário do ".$site_name;
	$email->preview=false;
	$email->template='publish_contents_error';
	if (isset($_POST['publish'])):
		$email->message='A palavra que submeteu ao dicionário foi aceite para publicação  no dicionário.<br>
		Obrigado pela sua colaboração.';
	elseif (isset($_POST['del_term'])):
		$email->message='A palavra que submeteu ao dicionário não foi aceite para publicação.<br>
		Por favor verifique se preencheu adequadamente todos os campos ou se viola os termos de utiliza&ccedil;&atilde;o do site.
		Obrigado.';
	endif;		
	$email->send_email($staticvars['local_root']);
endif;
?>