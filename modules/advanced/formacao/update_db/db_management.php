<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found(formacao managment)';
	exit;
endif;
$bc=mysql_escape_string(@$_GET['cod']);
$message='';

if (isset($_POST['publish_product'])):// publicar
	$db->setquery("update formacao_curso set active='s' where cod_curso='".$bc."'");
	
	$_SESSION['update']='curso publicado';
elseif(isset($_POST['unpublish_product'])): // retirar de publicaçao
	$db->setquery("update formacao_curso set active='n' where cod_curso='".$bc."'");
	$_SESSION['update']='curso retirado de publicação';
elseif (isset($_POST['del_product'])): // apagar
	$db->setquery("delete from formacao_curso where cod_curso='".$bc."'");
		$_SESSION['update']='curso apagado';
elseif (isset($_POST['edit_product']) and $message=='')://editar box
	if(isset($_POST['active'])):
		$active=" ,active='s'";
	else:
		$active="";
	endif;
	if($_POST['titulo']<>'' and $_POST['descricao']<>'' and $_POST['objectivos']<>'' and $_POST['conteudos']<>'' and $_POST['destinatarios']<>'' and $_POST['idade']<>''
	 and $_POST['duracao']<>'' and $_POST['categoria']<>'0' and $_POST['horario']<>'' and $_POST['data_inicio']<>'' and $_POST['regalias']<>''):
		$db->setquery("update formacao_curso set titulo='".mysql_escape_string($_POST['titulo'])."', descricao='".mysql_escape_string($_POST['descricao'])."',
		conteudos='".mysql_escape_string($_POST['conteudos'])."', regalias='".mysql_escape_string($_POST['regalias'])."',
		local='".mysql_escape_string($_POST['local'])."', habilitacoes='".mysql_escape_string($_POST['habilitacoes'])."',
		objectivos='".mysql_escape_string($_POST['objectivos'])."', 
		destinatarios='".mysql_escape_string($_POST['destinatarios'])."', idade='".mysql_escape_string($_POST['idade'])."',
		cod_categoria='".mysql_escape_string($_POST['categoria'])."', data_inicio='".mysql_escape_string($_POST['data_inicio'])."',
		horario='".mysql_escape_string($_POST['horario'])."', duracao='".mysql_escape_string($_POST['duracao'])."' ".$active." where cod_curso='".$bc."'");
		$_SESSION['update']='curso editado com sucesso';
	else:
		$_SESSION['update']='Falta preencher campos obrigatórios';
	endif;
elseif (isset($_POST['add_product']) and $message=='')://inserir box
	if(isset($_POST['active'])):
		$active=", active='s'";
	else:
		$active="";
	endif;
	if($_POST['titulo']<>'' and $_POST['descricao']<>'' and $_POST['objectivos']<>'' and $_POST['conteudos']<>'' and $_POST['destinatarios']<>'' and $_POST['idade']<>''
	 and $_POST['duracao']<>'' and $_POST['categoria']<>'0' and $_POST['horario']<>'' and $_POST['data_inicio']<>'' and $_POST['regalias']<>''):
		$db->setquery("insert into formacao_curso set titulo='".mysql_escape_string($_POST['titulo'])."', descricao='".mysql_escape_string($_POST['descricao'])."',
		conteudos='".mysql_escape_string($_POST['conteudos'])."', regalias='".mysql_escape_string($_POST['regalias'])."',
		local='".mysql_escape_string($_POST['local'])."', habilitacoes='".mysql_escape_string($_POST['habilitacoes'])."',
		objectivos='".mysql_escape_string($_POST['objectivos'])."', 
		destinatarios='".mysql_escape_string($_POST['destinatarios'])."', idade='".mysql_escape_string($_POST['idade'])."',
		cod_categoria='".mysql_escape_string($_POST['categoria'])."', data_inicio='".mysql_escape_string($_POST['data_inicio'])."',
		horario='".mysql_escape_string($_POST['horario'])."', duracao='".mysql_escape_string($_POST['duracao'])."'".$active);
		$_SESSION['update']='curso adicionado com sucesso';
	else:
		$_SESSION['update']='Falta preencher campos obrigatórios';
	endif;
endif;
if ($message<>''):
	$_SESSION['update']='formacao_curso:'.$message;
endif;
?>