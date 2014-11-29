<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$dbss=$db->getquery("select cod_category, nome from congress_category");
?>
<script type="text/javascript">
var num_dbs=<?=count($dbss).';'.chr(13);?>
var db=new Array(num_dbs);
<?php
for($i=0;$i<count($dbss);$i++):
	echo 'db['.$i.']="'.$dbss[$i][1].'";'.chr(13);
endfor;
$nome='';
$translations='';
$button='insert_cat';
if(isset($_GET['cat'])):
	$cat=$db->getquery("select cod_category, nome, translations from congress_category where cod_category='".mysql_escape_string($_GET['cat'])."'");
	if($cat[0][0]<>''):
		$nome=$cat[0][1];
		$translations=$cat[0][2];
		$button='edit_cat';
echo 'var disable=true;'; 
	endif;
else:
echo 'var disable=false;'; 
endif;

?>
function cleanform ( form )
{
if(disable==false){
	document.getElementById('name_img').innerHTML="<img src='<?=$staticvars['site_path'];?>/modules/congressos/images/check_mark.gif'>";
	document.getElementById('reset_db').innerHTML="";
	for(i=0;i<num_dbs;i++)
		{
		  if (form.nome.value == db[i]) {
			document.getElementById('t_name').style.color="#2b2b2b";
			document.getElementById('name_img').innerHTML="<img width='20' height='20' src='<?=$staticvars['site_path'];?>/modules/congressos/images/reload.gif'>";
			document.getElementById('reset_db').innerHTML="<input type='hidden' name='db_exists' value='"+db[i]+"' />Category exists.<br>If you proceed Category will be reseted.";
			return false;
		  }
		}
  // ** END **
}
}
//-->

</script>
<h3><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/adcionar.gif" /> Adcionar  Categoria de P&aacute;ginas Web  </h3><br />
<form class="form" name="form_db" method="post" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
<h4 id="t_name">Nome da Categoria:<br />
<table border="0">
  <tr>
    <td><input onKeyPress="cleanform(document.form_db)" onMouseMove="cleanform(document.form_db)"  onchange="cleanform(document.form_db)" value="<?=$nome;?>"  class="text" type="text" name="nome" id="nome"></td>
    <td><div id="name_img"></div></td>
  </tr>
</table>
<div id="reset_db" style="font-size:x-small"></div>
  </h4>
<h4>  Tradu&ccedil;&otilde;es:<br />
<input class="text" type="text" value="<?=$translations;?>" name="translations" id="translations" size="60" />
  <br />
</h4>
<div align="right">
<?php
if($button=='edit_cat'):
	echo '<input type="hidden" name="cat" value="'.$cat[0][0].'" />';
	echo '<input type="submit" class="button" name="edit_contents" class="button" value="Editar Conteúdos" />&nbsp;&nbsp;';
	echo '<input type="submit" class="button" name="del_cat" class="button" value="Apagar" />&nbsp;&nbsp;';
endif;
?>
<input onMouseOver="cleanform(document.form_db)" class="button" type="submit" name="<?=$button;?>" id="<?=$button;?>" value="Gravar"></div>
</form>


