<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

if(isset($_POST['add_cat'])):
	$titulo=mysql_escape_string($_POST['titulo']);
	$descricao=mysql_escape_string($_POST['descricao']);
	$db->setquery("insert into congress_dl_category set titulo='".$titulo."', descricao='".$descricao."', active='n'");
	$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria adicionada</font></font>';
elseif(isset($_POST['del_cat'])):
	$cod=mysql_escape_string($_POST['cat']);
	$dw=$db->getquery("select ficheiro from congress_download where cod_category='".$cod."'");
	if($dw[0][0]<>''):
		for($i=0;$i<count($dw);$i++):
			unlink($staticvars['upload'].'/congress/downloads/'.$dw[$i][0]);
		endfor;
	endif;
	$db->setquery("delete from congress_download where cod_category='".$cod."'");
	$db->setquery("delete from congress_dl_category where cod_category='".$cod."'");
	$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria apagada</font></font>';	
elseif(isset($_POST['send_file'])):
	include($staticvars['local_root'].'kernel/file_functions.php');
	$ERROR_MSGS[0] = "";
	$ERROR_MSGS[1] = "Tamanho do ficheiro exede o limite máximo.";
	$ERROR_MSGS[2] = "Tamanho do ficheiro exede o limite máximo.";
	$ERROR_MSGS[3] = "O upload do ficheiro não foi efectuado na totalidade.";
	$ERROR_MSGS[4] = "Não foi feito o upload do arquivo.";
	if (isset($_FILES['ficheiro'])and $_FILES['ficheiro']['error']<>4):
		include_once($staticvars['local_root'].'general/pass_generator.php');
		$cod=mysql_escape_string($_POST['cat']);
		$name=normalize($_FILES['ficheiro']['name']);
		$tmp=explode(".",$name);
		$tmp[0].=generate('5','No','Yes','No');
		$tmp1[1]=$tmp[0].'.'.$tmp[1];
		$location=$staticvars['upload'].'/congress/downloads/'.$tmp1[1];
		if (!@move_uploaded_file($_FILES['ficheiro']['tmp_name'], $location)):
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Erro no Upload. Por favor tente de novo.</font></font>';
		else:
			$db->setquery("insert into congress_download set nome='".mysql_escape_string($_POST['filename'])."', ficheiro='".$tmp1[1]."', cod_category='".$cod."'");
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Ficheiro Adicionado com sucesso.</font></font>';
		endif;
	else:
		$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Erro no Ficheiro</font></font>';
	endif;
elseif(isset($_POST['del_file'])):
	$dw=$db->getquery("select cod_download, ficheiro from congress_download");
	if($dw[0][0]<>''):
		for($i=0;$i<count($dw);$i++):
			if(isset($_POST['dw'.$dw[$i][0]])):
				unlink($staticvars['upload'].'/congress/downloads/'.$dw[$i][1]);
				$db->setquery("delete from congress_download where cod_download='".$dw[$i][0]."'");
			endif;
		endfor;
		$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Ficheiros apagados</font></font>';
	else:
		$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Nao foram encontrados ficheiros</font></font>';
	endif;
elseif(isset($_POST['publish_cat'])):
	$cod=mysql_escape_string($_POST['cat']);
	$db->setquery("update congress_dl_category set active='s' where cod_category='".$cod."'");
	$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria foi activada</font></font>';
elseif(isset($_POST['unpublish_cat'])):
	$cod=mysql_escape_string($_POST['cat']);
	$db->setquery("update congress_dl_category set active='n' where cod_category='".$cod."'");
	$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria afoi desactivada</font></font>';
endif;
?>