<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found(I.V.A. setup)';
	exit;
endif;
$bc=@$_GET['mod'];
if (isset($_POST['del'])): // apagar  iva
	$db->setquery("delete from produtos_iva where cod_iva='".$bc."'");
		echo '<font class="body_text"> <font color="#FF0000">I.V.A. apagado</font></font>';
elseif (isset($_POST['edit']))://editar iva
	$db->setquery("update produtos_iva set valor='".mysql_escape_string($_POST['iva_valor'])."',
	 descricao='".mysql_escape_string($_POST['iva_descricao'])."' where cod_iva='".$bc."'");
	echo '<font class="body_text"> <font color="#FF0000">I.V.A. editado com sucesso</font></font>';
elseif (isset($_POST['add']))://inserir iva
	$db->setquery("insert into produtos_iva set valor='".mysql_escape_string($_POST['iva_valor'])."',
	 descricao='".mysql_escape_string($_POST['iva_descricao'])."'");
	echo '<font class="body_text"> <font color="#FF0000">I.V.A. adicionado</font></font>';
endif;
?>