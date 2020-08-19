<?php
/*
File revision date: 15-jul-2008
*/
$menu=@$_GET['mod'];

if (isset($_POST['menu_code'])): // activar / desactivar menus
	if ($_POST['menu_code']=='publish'):
		$db->setquery("update menu_layout set active='n'");
		$db->setquery("update menu_layout set active='s' where cod_menu_layout='".$menu."'");
		echo '<font class="body_text"> <font color="#FF0000">Skin Menu publicado</font></font>';
	elseif($_POST['menu_code']=='unpublish'):
		$db->setquery("update menu_layout set active='n' where cod_menu_layout='".$menu."'");
		echo '<font class="body_text"> <font color="#FF0000">Skin Menu desactivado</font></font>';
	endif;
elseif (isset($_POST['del_menu'])): // apagar menus
	$menu_name=$db->getquery("select ficheiro from menu_layout where cod_menu_layout='".$menu."'");
	$name=explode(".",$menu_name[0][0]);
	@unlink($staticvars['local_root'].'layout/menu/layouts/'.$menu_name[0][0]);
	if (is_dir($staticvars['local_root'].'layout/menu/layouts/'.$name[0])):
		delr($globvars,$staticvars['local_root'].'layout/menu/layouts/'.$name[0]);
		delr($globvars,$staticvars['local_root'].'layout/menu/layouts/'.$name[0]);		
	endif;
	$db->setquery("delete from menu_layout where cod_menu_layout='".$menu."'");
	echo '<font class="body_text"> <font color="#FF0000">Skin Menu apagado</font></font>';
elseif (isset($_POST['menu_ficheiro']))://editar menu
	$db->setquery("update menu_layout set ficheiro='".mysql_escape_string($_POST['menu_ficheiro'])."', nome='".mysql_escape_string($_POST['menu_nome'])."'
	 where cod_menu_layout='".$menu."'");
	echo '<font class="body_text"> <font color="#FF0000">Skin Menu editado com sucesso</font></font>';
elseif (isset($_POST['add_menu_nome']))://adicionar menu
	$menu_name=mysql_escape_string($_POST['add_menu_ficheiro']);
	$name=explode(".",$menu_name);
	copy($globvars['local_root'].'layouts/menu/layouts/'.$menu_name,$globvars['site']['directory'].'layout/menu/layouts/'.$menu_name);
	if (is_dir($globvars['local_root'].'layouts/menu/layouts/'.$name[0])):
		copyr($globvars['local_root'].'layouts/menu/layouts/'.$name[0],$globvars['site']['directory'].'layout/menu/layouts/'.$name[0],$globvars);
	endif;

	$db->setquery("insert into menu_layout set  ficheiro='".mysql_escape_string($_POST['add_menu_ficheiro'])."',
	nome='".mysql_escape_string($_POST['add_menu_nome'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Skin Menu adicionado</font></font>';
endif;
?>
