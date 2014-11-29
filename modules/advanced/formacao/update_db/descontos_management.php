<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found(Desconto -produtos)';
	exit;
endif;
$bc=@$_GET['mod'];
if (isset($_POST['del'])): // apagar  iva
	$db->setquery("delete from produtos_desconto where cod_desconto='".$bc."'");
		echo '<font class="body_text"> <font color="#FF0000">Desconto apagado</font></font>';
elseif (isset($_POST['edit']))://editar iva
	$db->setquery("update produtos_desconto set valor='".mysql_escape_string($_POST['desc_valor'])."',
	 descricao='".mysql_escape_string($_POST['desc_descricao'])."' where cod_desconto='".$bc."'");
	echo '<font class="body_text"> <font color="#FF0000">Desconto editado com sucesso</font></font>';
elseif (isset($_POST['add']))://inserir iva
	$db->setquery("insert into produtos_desconto set valor='".mysql_escape_string($_POST['desc_valor'])."',
	 descricao='".mysql_escape_string($_POST['desc_descricao'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Desconto adicionado</font></font>';
endif;
?>