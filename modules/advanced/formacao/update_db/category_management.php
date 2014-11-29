<?php
/*
File revision date: 24-Ago-2006
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

$cat=mysql_escape_string(@$_GET['mod']);
if (isset($_POST['cat_code'])): // activar 
	if ($_POST['cat_code']=='publish'):
		$db->setquery("update formacao_categorias set active='s' where cod_categoria='".$cat."'");
		echo '<font class="body_text"> <font color="#FF0000">Categoria publicada</font></font>';
	elseif($_POST['cat_code']=='unpublish'): // desactivar
		$db->setquery("update formacao_categorias set active='n' where cod_categoria='".$cat."'");
		echo '<font class="body_text"> <font color="#FF0000">Categoria desactivada</font></font>';
	endif;
	unset($_POST['cat_code']);
elseif (isset($_POST['del_cat'])): // apagar 
	$cod_formacao_categorias=$db->getquery("select cod_sub_cat from formacao_categorias where cod_categoria='".$cat."'");
	$cod_formacao_categorias=$cod_formacao_categorias[0][0];
	$db->setquery("delete from formacao_categorias where cod_categoria='".$cat."'");
	$db->setquery("delete from formacao_categorias where cod_sub_cat='".$cat."'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria apagada</font></font>';
	unset($_POST['del_cat']);
elseif (isset($_POST['cat_name']))://editar
		$db->setquery("update formacao_categorias set descricao='".mysql_escape_string($_POST['cat_disp_name'])."',
		nome='".mysql_escape_string($_POST['cat_name'])."' where cod_categoria='".$cat."'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria editada com sucesso</font></font>';
	unset($_POST['cat_name']);
elseif (isset($_POST['add_cat_name']))://adicionar
		$db->setquery("insert into formacao_categorias set descricao='".mysql_escape_string($_POST['add_cat_disp_name'])."',
		  nome='".mysql_escape_string($_POST['add_cat_name'])."', cod_sub_cat='".$cat."'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria adicionada</font></font>';
	unset($_POST['add_cat_name']);
endif;
echo '<br>';
?>