<?php
/*
File revision date: 1-Set-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
$code=mysql_escape_string(@$_GET['ut']);
if (isset($_POST['ut'])):
	$code=mysql_escape_string($_POST['ut']);
elseif(isset($_GET['ut'])):
	$code=mysql_escape_string(@$_GET['ut']);
else:
	$code=mysql_escape_string(@$_POST['code']);
endif;
if(isset($_POST['add_nome']) or isset($_POST['edit_nome']) or isset($_POST['del'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
	if (isset($_POST['del'])):
		include($staticvars['local_root'].'modules/directory/update_db/content_types_setup.php');
	elseif (isset($_POST['addext'])):
		include($staticvars['local_root'].'modules/directory/update_db/content_types_setup.php');
	else:
		echo '<font class="body_text"><font color="#FF0000">Necessita de ter pelo menos 1 extens&atilde;o escolhida!</font></font>';	
	endif;
	echo '<br>';
endif;
?>
<script language="javascript">
var video_size=4;
var image_size=2;
var audio_size=5;
var zip_size=3;
var modulo_size=3;
var link_externo_size=4;
var web_page_size=3;
var documents_size=3;

var documents=new Array(documents_size);
documents[0]="doc";
documents[1]="xls";
documents[2]="pdf";

var audio=new Array(audio_size);
audio[0]="Mp3";
audio[1]="Wav";
audio[2]="ogg";
audio[3]="wma";
audio[4]="amr";

var video=new Array(video_size);
video[0]="mpeg";
video[1]="wmf";
video[2]="asx";
video[3]="asf";
video[4]="3gp";

var image=new Array(image_size);
image[0]="jpg";
image[1]="gif";

var zip=new Array(zip_size);
zip[0]="zip";
zip[1]="arj";
zip[2]="ace";

var modulo=new Array(modulo_size);
modulo[0]="php";
modulo[1]="html";
modulo[2]="htm";

var link_externo=new Array(link_externo_size);
link_externo[0]="html";
link_externo[1]="htm";
link_externo[2]="php";
link_externo[3]="asp";

var web_page=new Array(web_page_size);
web_page[0]="html";
web_page[1]="htm";
web_page[2]="php";


/*Remove all the options from a dropdown menu list*/
/*Add an option from a dropdown list*/
function reload_fields()
{
var i;
list_ext=document.form_menu.listext;
add_ext=document.form_menu['addext[]'];
add_t=document.form_menu.add_tipo;
for(i=add_ext.length;i>=0;i--)
	{
	list_ext.remove(i);
	}

for(i=5;i>=0;i--)
	{
	add_ext.remove(i);
	}

var position= add_t.options[add_t.selectedIndex].value;

if (position=='audio')
	{
	loader=audio;
	size=audio_size;
	}
if (position=='video')
	{
	loader=audio;
	size=video_size;
	}
if (position=='image')
	{
	loader=image;
	size=image_size;
	}
if (position=='zip')
	{
	loader=zip;
	size=zip_size;
	}
if (position=='modulo')
	{
	loader=modulo;
	size=modulo_size;
	}
if (position=='webpage')
	{
	loader=web_page;
	size=web_page_size;
	}
if (position=='linkexterno')
	{
	loader=link_externo;
	size=link_externo_size;
	}
if (position=='docs')
	{
	loader=documents;
	size=documents_size;
	}

for(i=0;i<size;i++)
	{
		list_ext.options[i]=new Option(loader[i],loader[i]);
	}

}

</script>
<script language="javascript" src="<?=$staticvars['site_path'].'/modules/directory/system/selectbox.js';?>"></script>
<img src="<?=$staticvars['site_path'].'/modules/directory';?>/images/icone_gestao.gif" /><font class="Header_text_4">Gest&atilde;o dos tipos de conte&uacute;dos</font><br />
<br />
<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
  <tr valign="top">
	<td align="center">
	<br>
		<form class="form" method="post" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
		<select size="1" name="ut" class="text">
			<?php
			$query=$db->getquery("select cod_items_types, nome from items_types");
			$selected=0;
			$option[0][0]='';
			$option[0][1]='-----------------';
			if($query[0][0]<>''):
				for ($i=0;$i<count($query);$i++):
					$option[$i+1][0]=$query[$i][0];
					$option[$i+1][1]=$query[$i][1];
					if ($query[$i][0]==$code):
						$selected=$i+1;
					endif;
				endfor;
			endif;
			for ($i=0 ; $i<count($option); $i++):
				?>
				<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
				<?=$option[$i][1];?></option>
				<?php
			endfor; ?>
		</select>&nbsp;&nbsp; 
		<input type="submit" value='ver' class="button" name="user_input">
		</form>
	<hr class="gradient">
		<a class="body_text" href="<?=$_SERVER['REQUEST_URI'].'&type=add';?>" >Adicionar </a>
	<hr class="gradient">
	</td>
  </tr>
  <tr>
	<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$staticvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
  </tr>
  <tr valign="top">
	<td>
	<?php
	if ($code<>''):
		$query=$db->getquery("select cod_items_types, nome from items_types where cod_items_types='".$code."'");
		if ($query[0][0]<>''):
			edit_field($code,$staticvars);
		endif;
	else:
		if (isset($_GET['type'])):
			if($_GET['type']=='add'):
				add_field($staticvars);
			else:
				no_code($staticvars);
			endif;
		else:
			no_code($staticvars);
		endif;
	endif;
	  ?>
	</td>
  </tr>
</table>

<?php
function no_code($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
?>
<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center">
	<font class="body_text">Seleccione uma op&ccedil;&atilde;o na DropBox acima de modo a poder visualizar os detalhes</font>
	</td>
  </tr>
</table>
<?php
};

function edit_field($mod,$staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;

$query_a=$db->getquery("select cod_items_types, nome, tipos, extensions_allowed, actions from items_types where cod_items_types='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
	exit;
endif;

$audio[0]="Mp3";
$audio[1]="Wav";
$audio[2]="ogg";
$audio[3]="wma";
$audio[4]="amr";

$video[0]="mpeg";
$video[1]="wmf";
$video[2]="asx";
$video[3]="asf";
$video[3]="3gp";

$image[0]="jpg";
$image[1]="gif";

$zip[0]="zip";
$zip[1]="arj";
$zip[2]="ace";

$modulo[0]="php";
$modulo[1]="html";
$modulo[2]="htm";

$link_externo[0]="html";
$link_externo[1]="htm";
$link_externo[2]="php";
$link_externo[3]="asp";

$web_page[0]="html";
$web_page[1]="htm";
$web_page[2]="php";

$document[0]="doc";
$document[1]="xls";
$document[2]="pdf";

$tmp=explode(";",$query_a[0][3]);
for($i=0;$i<count($tmp)-1;$i++):
	$selected[$i]=$tmp[$i];
endfor;
if ($query_a[0][2]=='audio'):
	for($i=0;$i<count($audio);$i++):		
		$options[$i]=$audio[$i];
	endfor;
elseif ($query_a[0][2]=='video'):
	for($i=0;$i<count($video);$i++):		
		$options[$i]=$video[$i];
	endfor;
elseif ($query_a[0][2]=='image'):
	for($i=0;$i<count($image);$i++):		
		$options[$i]=$image[$i];
	endfor;
elseif ($query_a[0][2]=='zip'):
	for($i=0;$i<count($zip);$i++):		
		$options[$i]=$zip[$i];
	endfor;
elseif ($query_a[0][2]=='modulo'):
	for($i=0;$i<count($modulo);$i++):		
		$options[$i]=$modulo[$i];
	endfor;
elseif ($query_a[0][2]=='linkexterno'):
	for($i=0;$i<count($link_externo);$i++):		
		$options[$i]=$link_externo[$i];
	endfor;
elseif ($query_a[0][2]=='webpage'):
	for($i=0;$i<count($web_page);$i++):		
		$options[$i]=$web_page[$i];
	endfor;
elseif ($query_a[0][2]=='docs'):
	for($i=0;$i<count($document);$i++):		
		$options[$i]=$document[$i];
	endfor;
endif;
$tmp=implode(";",$options);
$tmp=str_replace($query_a[0][3],"",$tmp);
$options=explode(";",$tmp);

?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form class="form" method="post" action="<?=$_SERVER['REQUEST_URI'].'&mod='.$mod;?>"  name="form_menu">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código: <?=$query_a[0][0];?></strong></font></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
		<td colspan="2">
			<font class="body_text"><strong>Nome</strong></font><br />
			<input type="text" class="text" name="edit_nome" maxlength="255" value="<?=$query_a[0][1];?>" size="40">		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text"><strong>Tipo</strong></font>&nbsp;&nbsp;&nbsp;
		<select size="1" name="add_tipo" class="text" onchange="javascript:reload_fields();">
			<option value="none" <?php if ($query_a[0][2]=='none'){?>selected="selected"<?php } ?>>Seleccionar</option>
			<option value="docs" <?php if ($query_a[0][2]=='docs'){?>selected="selected"<?php } ?>>Documentos</option>
			<option value="audio" <?php if ($query_a[0][2]=='audio'){?>selected="selected"<?php } ?>>Audio</option>
			<option value="video" <?php if ($query_a[0][2]=='video'){?>selected="selected"<?php } ?>>Video</option>
			<option value="image" <?php if ($query_a[0][2]=='image'){?>selected="selected"<?php } ?>>Imagem</option>
			<option value="zip" <?php if ($query_a[0][2]=='zip'){?>selected="selected"<?php } ?>>Fich. Compactado</option>
			<option value="modulo" <?php if ($query_a[0][2]=='modulo'){?>selected="selected"<?php } ?>>Módulo</option>
			<option value="linkexterno" <?php if ($query_a[0][2]=='linkexterno'){?>selected="selected"<?php } ?>>Link externo</option>
			<option value="webpage" <?php if ($query_a[0][2]=='webpage'){?>selected="selected"<?php } ?>>Web Page</option>
		</select>&nbsp;&nbsp;		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2" valign="top"><table cellpadding="5" align="center" border="0">
                <tr>
                  <td width="40" align="center" valign="top" class="body_text">&nbsp;</td>
                  <td class="body_text" valign="top" align="center">Extens&otilde;es dispon&iacute;veis<br />
					<select style="width:70px" class="text" ondblclick="moveSelectedOptions(this.form.listext,this.form['addext[]'],false)" multiple="multiple" size="7" name="listext" width="70">
						<?php
						for ($i=0 ; $i<count($options); $i++):
							?>
							<option value="<?=$option[$i];?>"><?=$options[$i];?></option>
							<?php
						endfor; ?>					
                    </select></td>
                  <td align="middle">
				  <table border="0" align="center" cellspacing="5">
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveSelectedOptions(this.form.listext,this.form['addext[]'],false)" type="button" value="--&gt;" name="right" /></td>
					  </tr>
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveAllOptions(this.form.listext,this.form['addext[]'],false)" type="button" value="Todos --&gt;" name="right" /></td>
					  </tr>
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveSelectedOptions(this.form['addext[]'],this.form.listext,false)" type="button" value="&lt;--" name="left" /></td>
					  </tr>
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveAllOptions(this.form['addext[]'],this.form.listext,false)" type="button" value="&lt;-- Todos" name="left" /></td>
					  </tr>
					</table>				  </td>
                  <td class="body_text" valign="top" align="center">Extens&otilde;es escolhidas<br />
                      <select style="width:70px" class="text" ondblclick="moveSelectedOptions(this.form['addext[]'],this.form.listext,false)" multiple="multiple" size="7" name="addext[]" width="70">
						<?php
						for ($i=0 ; $i<count($selected); $i++):
							?>
							<option value="<?=$selected[$i];?>"><?=$selected[$i];?></option>
							<?php
						endfor; ?>
                  </select></td>
                </tr>
            </table>		</td>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2">
			<font class="body_text"><strong>Actions</strong></font><br />
			<input type="text" name="add_actions" class="text" maxlength="255" value="<?=$query_a[0][4];?>" size="40">		</td>
	  </tr>

	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <INPUT onClick="selectAllOptions(this.form['addext[]'])" type=submit value="Gravar" class="button">
		  <input type="hidden" name="code" value="<?=$query_a[0][0];?>"></td>
	  </tr>
	  </table>
	  </form></td>
    <td valign="bottom" align="left">
		<form class="form" method="POST" action="<?=$_SERVER['REQUEST_URI'].'&mod='.$mod;?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="del" value="<?=$query_a[0][1];?>">
			<INPUT type=submit value="Apagar" class="button">
		</form>    </td>
  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
</table>
<?php	
};

function add_field($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;

?>
	<form class="form" method="post" action="<?=$_SERVER['REQUEST_URI'];?>" name="form_menu">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text"><strong>Nome</strong></font><br />
			<input class="text" type="text" name="add_nome" maxlength="255" value="" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text"><strong>Tipo</strong></font>&nbsp;&nbsp;&nbsp;
		<select size="1" name="add_tipo" class="text" onchange="javascript:reload_fields();">
			<option value="none" selected="selected">Seleccionar</option>
			<option value="docs">Documentos</option>
			<option value="audio">Audio</option>
			<option value="video">Video</option>
			<option value="image">Imagem</option>
			<option value="zip">Fich. Compactado</option>
			<option value="modulo">Módulo</option>
			<option value="linkexterno">Link externo</option>
			<option value="webpage">Web Page</option>
		</select>&nbsp;&nbsp; 
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2" valign="top"><table cellpadding="5" align="center" border="0">
                <tr>
                  <td width="40" align="center" valign="top" class="body_text">&nbsp;</td>
                  <td class="body_text" valign="top" align="center">Extens&otilde;es dispon&iacute;veis<br />
					<select style="width:70px" class="text" ondblclick="moveSelectedOptions(this.form.listext,this.form['addext[]'],false)" multiple="multiple" size="7" name="listext" width="70">
                    </select></td>
                  <td align="middle">
				  <table border="0" align="center" cellspacing="5">
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveSelectedOptions(this.form.listext,this.form['addext[]'],false)" type="button" value="--&gt;" name="right" /></td>
					  </tr>
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveAllOptions(this.form.listext,this.form['addext[]'],false)" type="button" value="Todos --&gt;" name="right" /></td>
					  </tr>
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveSelectedOptions(this.form['addext[]'],this.form.listext,false)" type="button" value="&lt;--" name="left" /></td>
					  </tr>
					  <tr>
						<td align="center" valign="middle"><input class="text" onclick="moveAllOptions(this.form['addext[]'],this.form.listext,false)" type="button" value="&lt;-- Todos" name="left" /></td>
					  </tr>
					</table></td>
                  <td class="body_text" valign="top" align="center">Extens&otilde;es escolhidas<br />
                      <select multiple="multiple" name="addext[]" size="7" class="text" style="width:70px" ondblclick="moveSelectedOptions(this.form['addext[]'],this.form.listext,false)" width="70">
                    </select></td>
                </tr>
            </table>
		</td>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2">
			<font class="body_text"><strong>Actions</strong></font><br />
			<input class="text" type="text" name="add_actions" maxlength="255" value="" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		<INPUT onClick="selectAllOptions(this.form['addext[]'])" type="submit" value="Gravar" class="button">
		</td>
	  </tr>
	  </table>
</form>

<?php
};
?>
