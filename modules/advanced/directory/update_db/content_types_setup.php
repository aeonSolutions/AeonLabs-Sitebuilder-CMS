<?php
/*
File revision date: 15-Ago-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;

$code=mysql_escape_string(@$_POST['code']);
if (isset($_POST['del'])): // apagar 
	$db->setquery("delete from items_types where cod_items_types='".$code."'");
	echo '<font class="body_text"> <font color="#FF0000">Tipo apagado</font></font>';
elseif (isset($_POST['edit_nome']))://editar
	$values=$_POST['addext'];
	$extensions='';
	foreach ($values as $a):
		$extensions.=$a.';';
	endforeach;
	$db->setquery("update items_types set nome='".mysql_escape_string($_POST['edit_nome'])."', tipos='".mysql_escape_string($_POST['add_tipo'])."',
		extensions_allowed='".$extensions."' where cod_items_types='".$code."'");
	echo '<font class="body_text"> <font color="#FF0000">Tipo editado com sucesso</font></font>';
elseif (isset($_POST['add_nome']))://adicionar
	$values=$_POST['addext'];
	$extensions='';
	foreach ($values as $a):
		$extensions.=$a.';';
	endforeach;
	$db->setquery("insert into items_types set  nome='".mysql_escape_string($_POST['add_nome'])."',
	actions='".mysql_escape_string($_POST['add_actions'])."', tipos='".mysql_escape_string($_POST['add_tipo'])."',
	extensions_allowed='".$extensions."'");
	echo '<font class="body_text"><font color="#FF0000">Tipo adicionado</font></font>';
	unset($_POST['add_nome']);
endif;
?>