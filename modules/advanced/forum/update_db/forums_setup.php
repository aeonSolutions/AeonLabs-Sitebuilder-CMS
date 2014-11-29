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

if (isset($_POST['forum_code'])): // activar / desactivar forums
	if ($_POST['forum_code']=='publish'):
		$db->setquery("update forum_forum set active='s' where cod_forum='".$css."'");
		echo '<font class="body_text"> <font color="#FF0000">Forum publicado</font></font>';
	elseif($_POST['forum_code']=='unpublish'):
		$db->setquery("update forum_forum set active='n' where cod_forum='".$css."'");
		echo '<font class="body_text"> <font color="#FF0000">Forum desactivado</font></font>';
	endif;
elseif (isset($_POST['forum_del'])): // apagar forums
	$db->setquery("delete from forum_forum where cod_forum='".$css."'");
	echo '<font class="body_text"> <font color="#FF0000">Forum apagado</font></font>';
elseif (isset($_POST['forum_nome']))://editar forums
	$query="update forum_forum set nome='".mysql_escape_string($_POST['forum_nome'])."',
	 descricao='".mysql_escape_string($_POST['forum_descricao'])."', cod_cat='".mysql_escape_string($_POST['forum_cat'])."'";
	if(!isset($_POST['forum_active'])):
		$query=$query." , active='n'";
	endif;
	if(isset($_POST['forum_pruning'])):
		$query=$query." , auto_pruning='s', remove_topics='".mysql_escape_string($_POST['forum_remove'])."',
		 check_topics='".mysql_escape_string($_POST['forum_check'])."'";
	endif;
	$query=$query." where cod_forum='".$css."'";
	$db->setquery($query);
	echo '<font class="body_text"> <font color="#FF0000">Forum editado</font></font>';	
elseif (isset($_POST['add_forum_nome']))://adicionar forums
	$query="insert into forum_forum set nome='".mysql_escape_string($_POST['add_forum_nome'])."',
	 descricao='".mysql_escape_string($_POST['add_forum_descricao'])."', cod_cat='".mysql_escape_string($_POST['add_forum_cat'])."'";
	if(!isset($_POST['add_forum_active'])):
		$query=$query." , active='n'";
	endif;
	if(isset($_POST['add_forum_pruning'])):
		$query=$query." , auto_pruning='s', remove_topics='".mysql_escape_string($_POST['add_forum_remove'])."',
		 check_topics='".mysql_escape_string($_POST['add_forum_check'])."'";
	endif;
	$db->setquery($query);
	echo '<font class="body_text"> <font color="#FF0000">Forum adicionado</font></font>';
endif;
