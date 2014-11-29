<?php
/*
File revision date: 24-set-2008
*/

$cat=mysql_escape_string(@$_GET['mod']);
if (isset($_POST['estado'])): // activar 
	if ($_POST['cat_code']=='Activar'):
		$db->setquery("update iwfs_advanced_categorias set active='s' where cod_categoria='".$cat."'");
		echo '<font class="body_text"> <font color="#FF0000">Categoria publicada</font></font>';
	elseif($_POST['cat_code']=='Desactivar'): // desactivar
		$db->setquery("update iwfs_advanced_categorias set active='n' where cod_categoria='".$cat."'");
		echo '<font class="body_text"> <font color="#FF0000">Categoria desactivada</font></font>';
	endif;
	unset($_POST['cat_code']);
elseif (isset($_POST['apagar'])): // apagar 
	$db->setquery("update iwfs_advanced_categorias set cod_sub_cat='0' where cod_sub_cat='".$cat."'");
	$db->setquery("delete from iwfs_advanced_categorias where cod_categoria='".$cat."'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria apagada</font></font>';
	unset($_POST['del_cat']);
elseif (isset($_POST['cat_name']))://editar
		$db->setquery("update iwfs_advanced_categorias set descricao='".mysql_escape_string($_POST['cat_name'])."',
		nome='".mysql_escape_string($_POST['cat_name'])."' where cod_categoria='".$cat."'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria editada com sucesso</font></font>';
	unset($_POST['cat_name']);
elseif (isset($_POST['add_cat_name']))://adicionar
		$db->setquery("insert into iwfs_advanced_categorias set descricao='".mysql_escape_string($_POST['add_cat_name'])."',
		  cod_sub_cat='".mysql_escape_String($_POST['cod_sub_cat'])."', nome='".mysql_escape_string($_POST['add_cat_name'])."', active='s'");
	echo '<font class="body_text"> <font color="#FF0000">Categoria adicionada</font></font>';
	unset($_POST['add_cat_name']);
endif;
echo '<br>';
?>