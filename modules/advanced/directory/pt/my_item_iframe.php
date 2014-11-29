<?php
$mod=mysql_escape_string(@$_GET['mod']);

if ($mod==''):
	no_code();
else:
	$query=$db->getquery("select cod_category, titulo, descricao, imagem, data, downloads from items where cod_item='".$mod."'");
	if ($query[0][0]<>''):
		list_module_details($mod,$staticvars['local_root']);
	else:
		no_code();
	endif;
endif;

function list_module_details($code,$local){
include($local.'/kernel/staticvars.php');

$task=@$_GET['id'];
$query=$db->getquery("select cod_category, titulo, descricao, imagem, content, data, downloads from items where cod_item='".$code."'");
$cat_name=$db->getquery("select name from category where cod_category='".$query[0][0]."'");
if ($query[0][3]=='no_img.jpg'):
	$imagem=$staticvars['site_path'].'/modules/directory/images/no_img.jpg';
else:
	$imagem=$upload_path.'/items/images/'.$query[0][3];
endif;
include_once($local.'/general/return_module_id.php');
$browse_id=return_id('ds_my_items.php');
$link=session($staticvars,$staticvars['site_path'].'/index.php?id='.$browse_id.'&code='.$code);
$link_file=$upload_path.'/items/'.$query[0][4];
?>
<table border="0" cellspacing="0" cellpadding="0" width="400" align="center">
  
  <tr>
    <td>
	<font class="header_text_1">Titulo:&nbsp;</font>
	<font class="body_text"><?=$query[0][1];?></font></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Descrição:<br>
	&nbsp;</font>
	<font class="body_text"><?=$query[0][2];?></font></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Inserido na categoria:&nbsp;</font>
	<font class="body_text"><?=$cat_name[0][0];?></font></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Ficheiro Associado:&nbsp;</font>
	<font class="body_text"><a href="<?=$link_file;?>"><?=$query[0][4];?></a></font></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Data de submissão:&nbsp;</font>
	<font class="body_text"><?=$query[0][5];?></font></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">nº de downloads:&nbsp;</font>
	<font class="body_text"><?=$query[0][6];?></font></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Imagem associada:<br>
	&nbsp;</font>
	<div align="center"><img align="middle" src="<?=$imagem;?>"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">
	<table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
			<form method="POST" action="<?=$link;?>" target="_parent">
				<input name="editar" src="<?=$staticvars['site_path'].'/images/buttons/pt/editar.gif';?>" type="image">
			</form>
			</td>
        <td><form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" target="_parent">
          <input type="hidden" name="del" value="<?=$code;?>" />
          <input name="apagar" src="<?=$staticvars['site_path'].'/images/buttons/pt/apagar.gif';?>" type="image" />
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php
};

function no_code(){
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<font class="body_text">Seleccione um módulo na árvore de módulos abaixo de modo a poder visualizar os detalhes</font>
	</td>
  </tr>
</table>
<?php
};
?>
