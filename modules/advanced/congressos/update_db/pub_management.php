<?php
/*
File revision date: 24-set-2008
*/

$ERROR_MSGS[0] = "";
$ERROR_MSGS[1] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[2] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[3] = "O upload do ficheiro não foi efectuado na totalidade.";
$ERROR_MSGS[4] = "Não foi feito o upload do arquivo.";

if(isset($_POST['categoria'])):
	$cat=mysql_escape_string($_POST['categoria']);
else:
	$cat=mysql_escape_string($_GET['cat']);
endif;
if(isset($_POST['art'])):
	$art=mysql_escape_string($_POST['art']);
else:
	$art=mysql_escape_string($_GET['art']);
endif;
$query=$db->getquery("select nome from iwfs_advanced_categorias where cod_categoria='".$cat."'");

if(isset($_POST['del_pages'])):// apagar ficheiro a uma publicacao
	$query3=$db->getquery("select cod_ficheiro, ficheiro from iwfs_advanced_ficheiros where cod_congresso='".mysql_escape_string($art)."'");
	if($query3[0][0]<>''):
		echo '<font class="body_text"> <font color="#FF0000">Ficheiros a apagar:</font></font>';
		for($i=0;$i<count($query3);$i++):
			if(isset($_POST['cf_'.$query3[$i][0]])):
				$db->setquery("delete from iwfs_advanced_ficheiros where cod_ficheiro='".$query3[$i][0]."'");
				unlink($staticvars['upload'].'/iwfs_advanced/'.$query3[$i][1]);
				echo '<font class="body_text"> <font color="#FF0000">'.$query3[$i][1].'</font></font>';
			endif;
		endfor;
	endif;
elseif(isset($_POST['save'])):
	$db->setquery("update iwfs_advanced set texto='".stripslashes(normalize_chars($_POST['elm1']))."' where cod_congresso='".mysql_escape_string($_GET['edititem'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Publicação gravada.</font></font>';
elseif (isset($_POST['apagar'])): // apagar 
	$db->setquery("delete from iwfs_advanced where cod_congresso='".mysql_escape_string($_POST['edititem'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Publicação apagada</font></font>';
	unset($_POST['del_cat']);
elseif ($query[0][0]<>''):
	if(isset($_POST['activar'])):
		$active='s';
	else:
		$active='n';
	endif;
	if (isset($_POST['edit']))://editar
			$db->setquery("update iwfs_advanced set short_description='".mysql_escape_string($_POST['descricao'])."',
			title='".mysql_escape_string($_POST['titulo'])."', active='".$active."', cod_user='".$_SESSION['user']."' where cod_congresso='".$art."'");
		echo '<font class="body_text"> <font color="#FF0000">Publicação editada com sucesso</font></font>';
		unset($_POST['cat_name']);
	elseif (isset($_POST['add_new']))://adicionar
			$db->setquery("insert into iwfs_advanced set short_description='".normalize_chars(mysql_escape_string($_POST['descricao']))."',
			  cod_categoria='".mysql_escape_string($_POST['categoria'])."', title='".normalize_chars(mysql_escape_string($_POST['titulo']))."', active='".$active."',
			  cod_user='".$staticvars['users']['code']."', lida='0', data_publicacao=NOW()");
		echo '<font class="body_text"> <font color="#FF0000">Publicação adicionada</font></font>';
		$new_item=$db->getquery("select cod_congresso from iwfs_advanced where title='".mysql_escape_string($_POST['titulo'])."' and short_description='".mysql_escape_string($_POST['descricao'])."'");
		$new_item=$new_item[0][0];
	endif;
	if(isset($_POST['add_file'])):// adicionar ficheiro a uma publicacao
		if (isset($_FILES['ficheiro'])):
			if (stristr($_FILES['ficheiro']['type'],"pdf")):
					$name=normalize($_FILES['ficheiro']['name']);
					$tmp=explode(".",$name);
					$tmp[0].=generate('5','No','Yes','No');
					$tmp1[1]=$tmp[0].'.'.$tmp[1];
					$location=$staticvars['upload'].'/iwfs_advanced/'.$tmp1[1];
					if (!move_uploaded_file($_FILES['ficheiro']['tmp_name'], $location)):
						echo '<font class="body_text"> <font color="#FF0000">Erro no Upload. Por favor tente de novo.</font></font>';
					else:
						$db->setquery("insert into iwfs_advanced_ficheiros set descricao='".mysql_escape_string($_POST['descricao'])."', ficheiro='".$tmp1[1]."', active='s', cod_congresso='".$art."'");
						echo '<font class="body_text"> <font color="#FF0000">Ficheiro Adicionado com sucesso.</font></font>';
					endif;
			else:
				echo '<font class="body_text"> <font color="#FF0000">Apenas Ficheiro do tipo Acrobat Reader</font></font>';
			endif;
		endif;
	endif;
else:
	echo '<font class="body_text"> <font color="#FF0000">Erro na Categoria</font></font>';
endif;

?>