<?php
/*
File revision date: 1-out-2008
*/
if(isset($_POST['descricao']) or isset($_POST['del_pages'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
	include($staticvars['local_root'].'kernel/file_functions.php');
	include($staticvars['local_root'].'general/pass_generator.php');
	include($staticvars['local_root'].'modules/congressos/update_db/pub_management.php');
endif;

$art=0;
$art= isset($_GET['art']) ? $_GET['art'] : 0;
$art= isset($_POST['art']) ? $_POST['art'] : $art;

$cod_categoria=0;
$cod_categoria= isset($_GET['cat']) ? $_GET['cat'] : 0;
$cod_categoria= (isset($_POST['cat']) and $_POST['cat']<>'') ? $_POST['cat'] : $cod_categoria;

$query=$db->getquery("select cod_categoria, nome, cod_sub_cat from congressos_categorias where cod_categoria='".$cod_categoria."'");
if ($query[0][0]<>''):
	$cat_name='<a href="'.strip_address('cat',$_SERVER['REQUEST_URI'].'&cat=0').'">raiz</a> > <a href="'.strip_address('cat',$_SERVER['REQUEST_URI']).'&cat='.$query[0][0].'">'.$query[0][1].'</a>';
	while($query[0][2]<>0):
		$query=$db->getquery("select cod_categoria, nome, cod_sub_cat from congressos_categorias where cod_categoria='".$query[0][2]."'");
		$cat_name.=' > <a href="'.strip_address('cat',$_SERVER['REQUEST_URI']).'&cat='.$query[0][0].'">'.$query[0][1].'</a>';
	endwhile;
else:
	$cat_name='raiz';
endif;
?>
<form class="form" method="post" action="<?=strip_address("cat",strip_address("art",$_SERVER['REQUEST_URI'])).'&cat='.$cod_categoria.'&art='.$art;?>" enctype="multipart/form-data">
<h3>Categorias</h3>
<hr class="gradient">
Categoria em que se encontra actualmente: <strong><?=$cat_name;?></strong>
<div align="center"><font class="body_text">Ver categorias existentes:&nbsp;</font>
    <select size="1" name="cat" class="text">
      <?php
    $query=$db->getquery("select cod_categoria, nome from congressos_categorias where cod_sub_cat='".mysql_escape_string($cod_categoria)."'");
    $option[0][0]='';
    $option[0][1]='-----------------';
    if($query[0][0]<>''):
        for ($i=0;$i<count($query);$i++):
            $option[$i+1][0]=$query[$i][0];
            $option[$i+1][1]=$query[$i][1];
        endfor;
    endif;
    for ($i=0 ; $i<count($option); $i++):
        ?>
      <option value="<?php echo $option[$i][0];?>" >
      <?=$option[$i][1];?>
      </option>
      <?php
    endfor; ?>
    </select>
  &nbsp;
  <input type="submit" value="Ver" class="button" name="user_input">
    <br />
    <br />
</div>
<br>
<br>
<h3>Publicações</h3>
<hr class="gradient">
<font class="body_text">Publicações existentes nesta categoria:&nbsp;</font>
<select size="1" name="art" class="text">
    <?php
	unset($option);
	$query2=$db->getquery("select cod_congresso, title from congressos where cod_categoria='".mysql_escape_string($cod_categoria)."'");
    $option[0][0]='';
    $option[0][1]='-----------------';
	$selected=0;
    if($query2[0][0]<>''):
        for ($i=0;$i<count($query2);$i++):
            $option[$i+1][0]=$query2[$i][0];
            $option[$i+1][1]=$query2[$i][1];
			if($query2[$i][0]==$art):
				$selected=$i+1;
			endif;
        endfor;
    endif;
    for ($i=0 ; $i<count($option); $i++):
        ?>
    <option value="<?php echo $option[$i][0];?>" <? if($selected==$i){ echo 'selected';}?> ><?=$option[$i][1];?></option>
        <?php
    endfor; ?>
</select>&nbsp;<input type="submit" value="Ver" class="button" name="user_input">
</form>
<br />
<?php
$query4=$db->getquery("select cod_congresso, short_description from congressos where cod_congresso='".mysql_escape_string($art)."'");
if($query4[0][0]<>''):
?>
	<br>
	<h4>Breve descrição</h4>
<div align="justify"><?=$query4[0][1];?></div>
    <br>
    <h4>Ficheiros associados</h4>
    <hr class="gradient">
    <?php
    $query3=$db->getquery("select cod_ficheiro, ficheiro, descricao from congressos_ficheiros where cod_congresso='".mysql_escape_string($art)."'");
    if($query3[0][0]<>''):
        ?>
        <form name="files" class="form" action="<?=strip_address("cat",strip_address("art",$_SERVER['REQUEST_URI'])).'&art='.$art.'&cat='.$cod_categoria;?>" method="post">
        <?php
        for($i=0;$i<count($query3);$i++):
            echo "<input type='checkbox' name='cf_".$query3[$i][0]."' class='button'>&nbsp;<a target='_blank' href='".$staticvars['upload_path']."/congressos/".$query3[$i][1]."' >".$query3[$i][2]."</a><br>";
        endfor;
        ?>
        <br><br>
          Apagar ficheiros seleccionados?&nbsp;<input type="submit" value="Apagar" class="button" name="del_pages">
</form>
        <?php
    else:
        echo 'Esta publicação não tem ficheiros associados.';
    endif;
	?>
    <br><br>
    <h4>Adicionar Ficheiro</h4>
    <hr class="gradient">
    <form action="<?=strip_address("cat",strip_address("art",$_SERVER['REQUEST_URI'])).'&art='.$art.'&cat='.$cod_categoria;?>" method="post" enctype="multipart/form-data" name="files" class="form">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">Descri&ccedil;&atilde;o</td>
        <td><input name="descricao" type="text" class="text" id="descricao" size="50" maxlength="255"></td>
      </tr>
      <tr height="5">
        <td colspan="2" height="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right">Ficheiro</td>
        <td><input name="ficheiro" type="file" accept="application/pdf" class="text" id="ficheiro" size="50" maxlength="255"><br>
    * Apenas Ficheiros Acrobat Reader
    </td>
      </tr>
    </table>
    
      <p align="right">
      <input type="hidden" name="categoria" value="<?=$cod_categoria;?>">
      <input type="hidden" name="art" value="<?=$art;?>">
        <input type="submit" class="button" name="add_file" id="add_file" value="Adicionar">
    </p>
    </form>
<?php
endif;
?>
