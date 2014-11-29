<?php
/*
File revision date: 2-Out-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$css=@$_GET['mod'];
if (isset($_POST['cat_code'])): // activar / desactivar categorias
	if ($_POST['cat_code']=='publish'):
		$db->setquery("update forum_cats set active='s' where cod_cat='".$css."'");
		echo '<font class="body_text"> <font color="#FF0000">Categoria varada</font></font>';
	elseif($_POST['cat_code']=='unpublish'):
		$db->setquery("update forum_cats set active='n' where cod_cat='".$css."'");
		echo '<font class="body_text"> <font color="#FF0000">Categoria desactivada</font></font>';
	endif;
elseif (isset($_POST['cat_del'])): // apagar categorias
	$db->setquery("delete from forum_cats where cod_cat='".$css."'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria apagada</font></font>';
elseif (isset($_POST['cat_titulo']))://editar categoria
	$db->setquery("update forum_cats set titulo='".mysql_escape_string($_POST['cat_titulo'])."' where cod_cat='".$css."'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria editada</font></font>';
elseif (isset($_POST['add_cat_titulo']))://adicionar skin
	$query="insert into forum_cats set titulo='".mysql_escape_string($_POST['add_cat_titulo'])."'";
	if(!isset($_POST['add_cat_active'])):
		$query=$query." , active='n'";
	endif;
	$db->setquery($query);
	echo '<font class="body_text"> <font color="#FF0000">Categoria adicionada</font></font>';
endif;
