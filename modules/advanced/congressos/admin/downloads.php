<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$cod_cat='';
$cod_cat= isset($_GET['cat']) ? $_GET['cat'] : '';
if($cod_cat==''):
	$cod_cat= isset($_POST['cat']) ? $_POST['cat'] : '';
endif;
if($cod_cat<>''):
	$cats=$db->getquery("select cod_category, titulo, descricao, active from congress_dl_category where cod_category='".$cod_cat."'");
	if($cats[0][0]<>''):
		if($cats[0][3]=='s'):
			$name='unpublish_cat';
			$val='Desactivar';
		else:
			$name='publish_cat';
			$val='Activar';
		endif;
		$extra='<input type="hidden" value="'.$cod_cat.'" name="cat" /><input class="button" type="submit" name="'.$name.'" id="'.$name.'" value="'.$val.'" />&nbsp;<input class="button" type="submit" name="del_cat" id="del_cat" value="Apagar" />';
	else:
		$cod_cat='';
	endif;
else:
	$cats[0][0]='';
	$cats[0][1]='';
	$cats[0][2]='';
endif;
if(isset($_POST['add_cat']) or isset($_POST['del_cat']) or isset($_POST['send_file']) or isset($_POST['del_file']) or isset($_POST['publish_cat']) or isset($_POST['unpublish_cat'])):
	include($staticvars['local_root'].'modules/congressos/update_db/downloads.php');
	//header("Location: ".strip_address("cat",$_SERVER['REQUEST_URI']).'&cat='.$cod_cat);
endif;

if(isset($_SESSION['status'])):
	echo $_SESSION['status'];
	$_SESSION['status']=array();
	unset($_SESSION['status']);
endif;
?>
<h3><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/adcionar.gif" />&nbsp;Downloads</h3><br />
<form action="<?=strip_address("cat",$_SERVER['REQUEST_URI']);?>" method="post" enctype="application/x-www-form-urlencoded">
    <h2>Escolher categoria</h2>
    <p>
  <select name="cat" class="text">
    <option>Nova Categoria</option>
    <?php
		$cat=$db->getquery("select cod_category, titulo, descricao, active from congress_dl_category");
		if($cat[0][0]<>''):
			for($i=0;$i<count($cat);$i++):
				$sel=($cat[$i][0]==$cod_cat)? 'selected="selected"' : '';
				echo '<option value="'.$cat[$i][0].'" '.$sel.'>'.$cat[$i][1].'</option>';
			endfor;
		endif;
        ?>
  </select>
      &nbsp;<input class="button" type="submit" name="ver_cat" id="ver_cat" value="Ok" />
    </p>
</form>
<hr size="1" />
<form action="" method="post" enctype="application/x-www-form-urlencoded">
  <h2>Categoria</h2>
  <h2> T&iacute;tulo<br />
    <input class="text" name="titulo" type="text" id="titulo" size="60" value="<?=$cats[0][1];?>" />
  </h2>
<p>Descri&ccedil;&atilde;o<br />
  <textarea class="text" name="descricao" cols="60" rows="8" id="descricao"><?=$cats[0][2];?></textarea>
</p>
<div align="right">
  <?=$extra;?>&nbsp;<input type="submit" class="button" name="add_cat" id="add_cat" value="Gravar" />
</div>
</form>
<hr size="1" />
<?php
if($cod_cat<>''):
	$dw=$db->getquery("select cod_download, ficheiro, nome from congress_download where cod_category='".$cats[0][0]."'");
	if($dw[0][0]<>''):
		echo '<form action="" method="post" enctype="application/x-www-form-urlencoded">';
		for($j=0;$j<count($dw);$j++):
			echo '<input class="text" type="checkbox" name="dw'.$dw[$j][0].'" />&nbsp;'.$dw[$j][2].'<br>';
		endfor;
		echo '<div align="right"><input class="button" type="submit" name="del_file" id="del_file" value="Apagar" /></div>';
		echo '</form><hr size="1" />';
	else:
		echo 'esta categoria nao tem ficheiros associados para donwload';
	endif;
	?>
<form action="" method="post" enctype="multipart/form-data">
  <h2>Adicionar Ficheiro &agrave; categoria seleccionada  </h2>
  <p> Nome<br />
    <input name="filename" class="text" type="text" id="filename" size="60" />
  </p>
    <p>Ficheiro<br />
      <input name="ficheiro" type="file" id="ficheiro" size="50" maxlength="255" />
    </p>
    <div align="right">
      <input type="hidden" value="<?=$cod_cat;?>" name="cat" /><input type="submit" name="send_file" id="send_file" class="button" value="Enviar" />
    </div>
    </form>
	<?php
endif;
?>
<hr size="1" />

