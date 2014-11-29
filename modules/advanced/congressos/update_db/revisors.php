<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['del_topic'])):
	$theme=mysql_escape_string($_POST['theme']);
	$ucode=mysql_escape_string($_POST['cod_user']);
	$db->setquery("delete from congress_revisor where cod_revisor='".$ucode."' and cod_theme='".$theme."'");
	echo '<font class="body_text"> <font color="#FF0000">Tema retirado da area de revisao do utilizador</font></font>';
	$_SESSION['message']= '<font class="body_text"> <font color="#FF0000">Tema retirado da area de revisao do utilizador</font></font>';
endif;
if(isset($_POST['select_theme'])):
	$ucode=mysql_escape_string($_POST['cod_user']);
	$theme=mysql_escape_string($_POST['theme']);
	if($theme<>''):
		$db->setquery("insert into congress_revisor set cod_user='".$ucode."', cod_theme='".$theme."'");
		echo '<font class="body_text"> <font color="#FF0000">Tema adicionado a area de revisao do utilizador</font></font>';
		$_SESSION['message']= '<font class="body_text"> <font color="#FF0000">Tema adicionado a area de revisao do utilizador</font></font>';
	else:
		echo '<font class="body_text"> <font color="#FF0000">Nao é possível adicionar mais temas ao utilizador</font></font>';
		 $_SESSION['message']='<font class="body_text"> <font color="#FF0000">Nao é possível adicionar mais temas ao utilizador</font></font>';
	endif;
endif;
?>