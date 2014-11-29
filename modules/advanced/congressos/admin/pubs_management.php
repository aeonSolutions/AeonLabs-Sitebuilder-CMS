<?php
/*
File revision date: 21-Set-2008
*/
$cod_categoria= isset($_GET['cat']) ? $_GET['cat'] : 0;
$cod_categoria= isset($_POST['cat']) ? $_POST['cat'] : $cod_categoria;
if(isset($_GET['edititem'])):
	$cod_categoria=$db->getquery('select cod_categoria from congressos where cod_congresso="'.mysql_escape_string($_GET['edititem']).'"');
	if ($cod_categoria[0][0]<>''):
		$cod_categoria=$cod_categoria[0][0];
	else:
		$cod_categoria=0;
	endif;
endif;
if(isset($_POST['editar_contents'])):
	$code=$db->getquery("select texto, title from congressos where cod_congresso='".mysql_escape_string($_GET['edititem'])."'");
	echo "<h2>".$code[0][1]."</h2>";
	$code=$code[0][0];
	include($staticvars['local_root'].'editor/editor.php');
endif;
if(isset($_POST['gravar']) or isset($_POST['apagar']) or isset($_POST['save'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
	include($staticvars['local_root'].'modules/congressos/update_db/pub_management.php');
endif;
if(!isset($_POST['editar_contents'])):
	$query=$db->getquery("select cod_categoria, nome, cod_sub_cat from congressos_categorias where cod_categoria='".$cod_categoria."'");
	if ($query[0][0]<>''):
		$cat_name[0]='<a href="'.strip_address('cat',strip_address("type",strip_address("edititem",$_SERVER['REQUEST_URI']))).'&cat='.$query[0][0].'">'.$query[0][1].'</a>';
		$k=0;
		while($query[0][2]<>0):
			$query=$db->getquery("select cod_categoria, nome, cod_sub_cat from congressos_categorias where cod_categoria='".$query[0][2]."'");
			$k++;
			$cat_name[$k]='<a href="'.strip_address('cat',strip_address("type",strip_address("edititem",$_SERVER['REQUEST_URI']))).'&cat='.$query[0][0].'">'.$query[0][1].'</a>';
		endwhile;
		$k++;
		$cat_name[$k]='<a href="'.strip_address('cat',strip_address("type",strip_address("edititem",$_SERVER['REQUEST_URI']))).'&cat=0'.'">raiz</a>';
		$tmp='';
		for($i=count($cat_name)-1;$i>0;$i--):
			$tmp.=$cat_name[$i].' > ';
		endfor;
		$tmp.=$cat_name[0];
		$cat_name=$tmp;
	else:
		$cat_name='raiz';
	endif;
	?>
<h3><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/icone_gestao.gif" width="24" height="24" />Manuten&ccedil;&atilde;o de Publica&ccedil;&otilde;es</h3>
	<br />
	<br />
			<form class="form" method="post" action="<?=strip_address("type",strip_address("edititem",$_SERVER['REQUEST_URI']));?>" enctype="multipart/form-data">
			  <strong>Categoria em que se encontra actualmente: 
			  <?=$cat_name;?>
			  </strong>
			<hr class="gradient">
			<div align="center"><font class="body_text">Subcategorias:&nbsp;</font>
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
			  <input type="submit" value="Ver" class="button" name="user_input"><br />
              <img src="<?=$staticvars['site_path'];?>/modules/congressos/images/icon_news_litle.gif" width="20" height="16" /><a class="body_text" href="<?=strip_address("type",strip_address("cat",$_SERVER['REQUEST_URI'])).'&type=add&cat='.$cod_categoria;?>" >Nova publica&ccedil;&atilde;o dentro desta categoria</a>
			  <br />
			</div>
			<hr class="gradient">
			</form>
	
	<?php
	if (is_numeric($cod_categoria)):
		if (isset($_GET['type'])):
			if($_GET['type']=='add' and isset($new_item)): // $new_item var is created on update_db/pub_management
				edit($staticvars,$new_item,$cod_categoria);// new post 
			elseif($_GET['type']=='add'):
				edit($staticvars,0,$cod_categoria);// new post 
			else:
				no_code($staticvars,$cod_categoria);
			endif;
		elseif (isset($_GET['edititem']) and !isset($_POST['apagar'])):
			edit($staticvars,mysql_escape_string($_GET['edititem']),$cod_categoria); // edit post
		else:
			no_code($staticvars,$cod_categoria);
		endif;
	else:
		no_code($staticvars,$cod_categoria);
	endif;
endif;//post edit contents


function no_code($staticvars,$cod_categoria){
include($staticvars['local_root'].'kernel/staticvars.php');
include($staticvars['local_root'].'modules/congressos/system/functions.php');
$query=$db->getquery("select cod_congresso, title, short_description from congressos where cod_categoria='".$cod_categoria."'");
if($query[0][0]<>''):// results found
	$posts_per_page=5;
	$total=intval(count($query)/$posts_per_page);// 5 posts per page
	if(isset($_GET['page'])):
		$page= is_numeric($_GET['page'])? $_GET['page'] : 0;
	else:
		$page=0;
	endif;
	$lower=$page*$posts_per_page;
	$uper=($lower+$posts_per_page)>count($query)? count($query)-1 : ($lower+$posts_per_page);
	$page_selection=select_page($page,$total,$_SERVER['REQUEST_URI']);
	echo $page_selection;
	for($i=$lower;$i<=$uper;$i++):
		echo '<h2>'.$query[$i][1].'</h2><p>'.$query[$i][2].'</p>';
		echo '<div align="right"><form class="form" method="post" action="'.strip_address("edititem",strip_address("cat",$_SERVER['REQUEST_URI'])).'&edititem='.$query[$i][0].'">
		  <input type="hidden" name="edititem" id="editar" value="'.$query[0][0].'" />
		  <input class="button" type="submit" name="editar" id="editar" value="Editar" />
		  <input class="button" type="submit" name="apagar" id="apagar" value="Apagar" />
		</form></div><hr size="1" />';
	endfor;
	echo $page_selection;
else:
	echo 'N&atilde;o existem Publica&ccedil;&otilde;es nesta categoria';
endif;
};

function edit($staticvars,$item,$cod_categoria){
include($staticvars['local_root'].'kernel/staticvars.php');
$name_cat=$db->getquery("select nome from congressos_categorias where cod_categoria='".$cod_categoria."'");
if ($item<>0): //edit post
	$details=$db->getquery("select cod_congresso,cod_user,cod_categoria, title,texto,data_publicacao,active,lida, short_description from congressos where cod_congresso='".$item."'");
	echo '<h3>Editar Publicação</h3>';
else:
	echo '<h3>Nova Publicação</h3>';
	$details[0][0]='';
	$details[0][1]='';
	$details[0][2]='';
	$details[0][3]='';
	$details[0][4]='';
	$details[0][5]='';
	$details[0][6]='';
	$details[0][7]='';
	$details[0][8]='';
endif;
$query=$db->getquery("select cod_categoria, nome from congressos_categorias ");
$option[0][0]='0';
$option[0][1]='Raiz';
$selected=0;
if($query[0][0]<>''):
	for ($i=0;$i<count($query);$i++):
		$option[$i+1][0]=$query[$i][0];
		$option[$i+1][1]=$query[$i][1];
		if ($query[$i][0]==$cod_categoria):
			$selected=$i+1;
		endif;
	endfor;
endif;
?>
<script language="javascript">
function switch_dl()
{
  var cur_box = window.document.pub.activar;
  var alter_box = window.document.pub.desactivar;
  var the_switch = "";
  if (cur_box.checked == false) {
		alter_box.checked=true;
  } else {
		alter_box.checked=false;
  }
}
function switch_fl()
{
  var cur_box = window.document.pub.activar;
  var alter_box = window.document.pub.desactivar;
  if (alter_box.checked == false) {
		cur_box.checked=true;
  } else {
		cur_box.checked=false;
  }
}
function abstract_counter() {
var maxlimit=255;
if (document.pub.descricao.value.length > maxlimit) // if too long...trim it!
	document.pub.descricao.value = document.pub.descricao.value.substring(0, maxlimit);
else // otherwise, update 'characters left' counter
	document.getElementById('abs_chr_left').innerHTML = "( " + (maxlimit - document.pub.descricao.value.length) + " chars left)";
}

</script>
<p><br />
<form class="form" id="pub" name="pub" method="post" action="">
  <p><strong>T&iacute;tulo</strong><br /> 
    <input value="<?=$details[0][3];?>" name="titulo" type="text" class="text" id="titulo" size="66" maxlength="100" />
    <br />
    <br />
  <div align="left">
  <strong>Descri&ccedil;&atilde;o Resumida</strong> <font style="font-size:11px;">(Max 255 chars)</font><br />
    <textarea name="descricao" cols="50" rows="4" wrap="virtual" class="text" onKeyDown="abstract_counter();" onKeyUp="abstract_counter();" id="descricao"><?=$details[0][8];?></textarea>
    <br /><div id="abs_chr_left" style="font-size:11px;">( 255 chars left) </div>
    <br />
    <strong>Publicar de Imediato?</strong><br />
    <input onClick="switch_dl();"  class="text" <? if($details[0][6]=='s' or $item==0){ echo ' checked="checked"';};?> type="checkbox" name="activar" id="activar" />&nbsp;Sim 
    <input onClick="switch_fl();" class="text" <? if($details[0][6]<>'s' and $item<>0){ echo ' checked="checked"';};?> type="checkbox" name="desactivar" id="desactivar" />&nbsp;Não
    <br />
<br />
<?php
if ($item<>0):// edit
	?>
    <strong>Mover para a categoria</strong> 
  <select size="1" name="categoria" class="text">
    <?php
    for ($i=0 ; $i<count($option); $i++):
        ?>
    <option <? if($i==$selected){ echo ' selected="selected"';};?> value="<?php echo $option[$i][0];?>" ><?=$option[$i][1];?></option>
      <?php
    endfor; ?>
  </select>
    </p>
  <p align="right">
    <input type="hidden" name="edit" value="edit" /><input type="hidden" name="art" value="<?=$item;?>" />
    <input class="button" type="submit" name="gravar" id="gravar" value="Gravar Alterações" />
  </p>
</form>
    <hr size="1" />
    <form class="form" id="form_edit" name="form_edit" method="post" action="<?=strip_address("edititem",$_SERVER['REQUEST_URI']).'&edititem='.$item;?>">
      <h3>Conte&uacute;do&nbsp;
        <input class="button" type="submit" name="editar_contents" id="editar_contents" value="Editar" />
      </h3>
    </form>
</p>
	<?php
	echo $details[0][4];
else:
	echo 'Esta Publicação será inserida dentro da categoria '.$name_cat[0][0];
	?>
    <input type="hidden" name="categoria" value="<?=$cod_categoria;?>" />
    <input type="hidden" name="add_new" value="add_new" />
  <p align="right">
    <input class="button" type="submit" name="gravar" id="gravar" value="Gravar Alterações" />
</p>
    <hr size="1" />
    <form class="form" id="form_edit" name="form_edit" method="post" action="">
      <h3>Conte&uacute;do&nbsp;
        <input disabled="disabled" class="button" type="submit" name="editar_contents" id="editar_contents" value="Editar" />
      </h3>
      Tem que gravar primeiro as alterações.
    </form>
</p>
    <?php
endif;
};

?>