<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$lang=isset($_GET['lang'])?$_GET['lang']:$staticvars['language']['main'];
if(isset($_POST['idioma'])):
	$idioma=isset($_POST['idioma'])?$_POST['idioma']:$lang;
else:
	$idioma=isset($_GET['idioma'])?$_GET['idioma']:$lang;
endif;
?>
<style>
.equal {
	display:table;
	margin:0px auto;
	border-spacing:5px 5px 5px 5px;
	width:100%;
}
.row {
	display:table-row;
}

.row div {
	display:table-cell;
}
.row div.full{
	width:100%;
	border: 1px solid #FFCC00;
	background:#FFFFCC;
	padding:5px;
}
.row div.mright{
	width:100%;
	border: 1px solid #009900;
	background:#CCFF99;
	padding:5px;
}
.inside{
	padding: 10px 0px 0px 30px;
}
</style>
<script language="JavaScript" type="text/javascript">
function update_fields ( form, title, file )
{
form.nome.value=file;
form.titulo.value=title;
form.nome.focus();
  }

</script>
<div class="equal">
	<div class="row">
		<div class="mright">
		<form action="<?=strip_address("contents",$_SERVER['REQUEST_URI']).'&contents';?>" method="post" enctype="multipart/form-data" name="file_edit" class="form">
		<h4>Categoria: <?=$cat[0][1];?><br /><br />
Mudar idioma:
		  <select name="idioma" style="height:20px" size="1" class="text">
		    <?php
			$lang=explode(";",$staticvars['language']['available']);
			for($i=0;$i<count($lang);$i++):
				$sel=($idioma==$lang[$i])? 'selected="selected"' : '';;
				echo '<option value="'.$lang[$i].'" '.$sel.'>'.$lang[$i].'</option>';
			endfor;
			?>
	      </select>
		  &nbsp;<input type="submit" value="Mudar" name="muda_idioma" class="button">
			<input type="hidden" name="cat" value="<?=$cat[0][0];?>">
		</h4>
		</form>        
		</div>
	</div>
</div>
	  <div class="equal">
			<div class="row">
				<div class="full">
		<form action="<?=strip_address("cat",$_SERVER['REQUEST_URI']).'&idioma='.$idioma.'&cat='.$cat[0][0];?>" method="post" enctype="multipart/form-data" name="form_edits" class="form">
				<h4>Conteúdo: <input name="editar_file" type="submit" class="button" value="Editar"></h4>
		</form>
				<?php
				include($staticvars['local_root'].'modules/congressos/contents/'.$cat[0][2].'/'.$idioma.'/main.php');
				?>
				</div>
			 </div>
		</div>
		<?php
?>