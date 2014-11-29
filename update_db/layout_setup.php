<?php
/*
File revision date: 14-abr-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;


$skin=@mysql_escape_string($_POST['skin']);
$mod=@mysql_escape_string($_POST['mod']);
if (isset($_POST['del_full'])):// delete all the layout for the current skin
		$db->setquery("delete from skin_layout where cod_skin='".$skin."'");
		echo '<font class="body_text"> <font color="#FF0000">Layout eliminado por completo</font></font>';
elseif (isset($_POST['max_pos'])):// edit current modules in the cell
	$query=$db->getquery("select cod_layout from skin_layout where cod_skin='".$skin."' and cell='".$mod."' order by priority ASC");
	for($i=0;$i<=$_POST['max_pos'];$i++):
		$db->setquery("update skin_layout set cod_module='".$_POST['drop_'.$i]."', priority='".($i+1)."' where cod_layout='".$query[$i][0]."'");
	endfor;
	echo '<font class="body_text"> <font color="#FF0000">Nova configura&ccedil;&atilde;o de modulos gravada com sucesso.</font></font>';
elseif(isset($_POST['drop_add'])): // add new module to the end of the cell
	$query=$db->getquery("select priority from skin_layout where cod_skin='".$skin."' and cell='".$mod."' order by priority DESC");
 	$db->setquery("insert into skin_layout set cod_module='".$_POST['drop_add']."', priority='".($query[0][0]+1)."',
	 cod_skin='".$skin."', cell='".$mod."'");	
	echo '<font class="body_text"> <font color="#FF0000">Novo modulo adicionado com sucesso ao skin LayOut.</font></font>';
elseif(isset($_POST['del_pos'])): // delete modules in cell
	if (isset($_POST['del_all'])):
		$db->setquery("delete from skin_layout where cod_skin='".$skin."' and cell='".$mod."'");
		echo '<font class="body_text"> <font color="#FF0000">Todos os modulos foram apagados.</font></font>';
	else:
		$query=$db->getquery("select cod_layout from skin_layout where cod_skin='".$skin."' and cell='".$mod."' order by priority ASC");
		$db->setquery("delete from skin_layout where cod_layout='".$query[($_POST['del_pos']-1)][0]."'");
		//reorganizing the priority field
		$query=$db->getquery("select cod_layout from skin_layout where cod_skin='".$skin."' and cell='".$mod."' order by priority ASC");
		for($i=0;$i<count($query);$i++):
			$db->setquery("update skin_layout set priority='".($i+1)."' where cod_layout='".$query[$i][0]."'");
		endfor;
	echo '<font class="body_text"> <font color="#FF0000">Modulo apagado com sucesso.</font></font>';		
	endif;
endif;
?>
