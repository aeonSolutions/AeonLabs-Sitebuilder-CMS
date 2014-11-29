<?php
$bc=@$_GET['mod'];
if (isset($_POST['box_code'])): // activar / desactivar box effects
	if ($_POST['box_code']=='publish'):
		$db->setquery("update box_effects set active='n'");
		$db->setquery("update box_effects set active='s' where box_code='".$bc."'");
		echo '<font class="body_text"> <font color="#FF0000">Box-Fx publicado</font></font>';
	elseif($_POST['box_code']=='unpublish'):
		$db->setquery("update box_effects set active='n' where box_code='".$bc."'");
		echo '<font class="body_text"> <font color="#FF0000">Box-Fx desactivado</font></font>';
	endif;
elseif (isset($_POST['del_box'])): // apagar  box
	$db->setquery("delete from box_effects where box_code='".$bc."'");
		echo '<font class="body_text"> <font color="#FF0000">Box-Fx apagado</font></font>';
elseif (isset($_POST['box_link']))://editar box
	$db->setquery("update box_effects set nome='".mysql_escape_string($_POST['box_nome'])."',
	 link='".mysql_escape_string($_POST['box_link'])."' where box_code='".$bc."'");
	echo '<font class="body_text"> <font color="#FF0000">Box-Fx editado com sucesso</font></font>';
	if (isset($_POST['default_fx'])):
		$db->setquery("update module set box_code='".$bc."'");
	endif;
elseif (isset($_POST['add_box_link']))://inserir box
	$db->setquery("insert into box_effects set nome='".mysql_escape_string($_POST['add_box_nome'])."',
	 link='".mysql_escape_string($_POST['add_box_link'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Box-Fx adicionado</font></font>';
elseif (isset($_GET['type'])):
	if ($_GET['type']=='addall'):
		$dir=glob($globvars['local_root']."/layout/box_effects/fx/*.php");
		if ($dir[0]<>''):
			for($i=0;$i<count($dir);$i++):
				$dirX=explode("/",$dir[$i]);
				$db->setquery("insert into box_effects set nome='".$dirX[count($dirX)-1]."', link='".$dirX[count($dirX)-1]."'");
			endfor;
			echo '<font class="body_text"> <font color="#FF0000">Adicionados todos os efeitos Box-Fx</font></font>';
		endif;
	endif;
endif;
?>