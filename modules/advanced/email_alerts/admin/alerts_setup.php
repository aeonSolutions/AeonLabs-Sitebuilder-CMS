<?php
$bc=@$_POST['cod_alerts'];
if (isset($_POST['box_code'])): // activar / desactivar box effects
	if ($_POST['box_code']=='publish'):
		$db->setquery("update alerts set active='n'");
		$db->setquery("update alerts set active='s' where cod_alerts='".$bc."'");
	elseif($_POST['box_code']=='unpublish'):
		$db->setquery("update alerts set active='n' where cod_alerts='".$bc."'");
	endif;
	$message='Estado do aviso actualizado.';
elseif (isset($_POST['del_box'])): // apagar  box
	$db->setquery("delete from alerts where cod_alerts='".$bc."'");
	$message='Aviso apagado.';
elseif (isset($_POST['alert_title']))://editar box
	$db->setquery("update alerts set titulo='".mysql_escape_string($_POST['alert_title'])."',
	 descricao='".mysql_escape_string($_POST['alert_desc'])."' where cod_alerts='".$bc."'");
	$message='Aviso actualizado.';
elseif (isset($_POST['add_alert_title']))://inserir box
	$db->setquery("insert into alerts set titulo='".mysql_escape_string($_POST['add_alert_title'])."',
	 descricao='".mysql_escape_string($_POST['add_alert_desc'])."'");
	$message='Aviso adicionado.';
endif;
