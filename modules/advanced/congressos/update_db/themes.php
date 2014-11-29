<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

if (isset($_POST['del_cat'])): // apagar 
	$cat=mysql_escape_string($_POST['cat']);
	$db->setquery("delete from congress_themes where cod_topic='".$cat."'");
	$db->setquery("delete from congress_themes where cod_theme='".$cat."'");
	$db->setquery("delete from congress_revisor where cod_theme='".$theme."'");
	$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Temas e Subtemas apagados.</font></font>';
elseif (isset($_POST['edit_cat']))://editar
		$db->setquery("update congress_themes set translations='".mysql_escape_string($_POST['translations'])."',
		name='".mysql_escape_string($_POST['nome'])."', cod_topic='".mysql_escape_string($_POST['topics'])."' where cod_theme='".$cat."'");
		$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Tema editada com sucesso</font></font>';
elseif (isset($_POST['insert_cat']))://adicionar
	$tema=mysql_escape_string($_POST['tema']);
	$name=mysql_escape_string($_POST['nome']);
	$tmp=explode(" ",$name);
	$ref='';
	for($i=0;$i<count($tmp);$i++):
		$ref.=$tmp[$i][0];
	endfor;
	if($tema<>0): //  theme
		$sub=$db->getquery("select reference from congress_themes where cod_theme='".$tema."'");	
		$ref=$sub[0][0].'.'.$ref;
	endif;
	$_SESSION['status']=("insert into congress_themes set translations='".mysql_escape_string($_POST['translations'])."',
		   name='".mysql_escape_string($_POST['nome'])."', reference='".$ref."', cod_topic='".mysql_escape_string($_POST['topics'])."'");	
	$db->setquery("insert into congress_themes set translations='".mysql_escape_string($_POST['translations'])."',
		   name='".mysql_escape_string($_POST['nome'])."', reference='".$ref."', cod_topic='".mysql_escape_string($_POST['topics'])."'");	
	$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria adicionada</font></font>';
endif;
?>