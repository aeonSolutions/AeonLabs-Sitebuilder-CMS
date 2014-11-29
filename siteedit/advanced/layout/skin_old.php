<?php
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
$code=mysql_escape_string(@$_GET['ut']);
if (isset($_POST['ut'])):
	$code=mysql_escape_string($_POST['ut']);
else:
	$code=mysql_escape_string(@$_GET['ut']);
endif;
if(isset($_POST['skin_name']) or isset($_POST['add_skin_name']) or isset($_POST['skin_code']) or isset($_POST['del_skin']) or isset($_FILES['add_template'])):
	include($globvars['site']['directory'].'kernel/staticvars.php');
	include($globvars['local_root'].'update_db/skin_setup.php');
endif;
include($globvars['site']['directory'].'kernel/settings/layout.php');
?>
<link rel="StyleSheet" href="<?=$site_path;?>/core/java/dtree.css" type="text/css" />
<TABLE width="100%" height="550" border="0" cellPadding="0" cellSpacing="0">
  <TBODY>
  <TR>
    <TD valign="top">
      <DIV class="main-box">
      	<DIV class="main-box-title">Configura&ccedil;&atilde;o da Skin do Site</DIV>
		<DIV class="main-box-data">
			<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
			  <tr valign="top">
			    <td align="center">
				<br>
					<form method="post" action="<?=session_setup($globvars,'index.php?id='.$task);?>" enctype="multipart/form-data">
					<select size="1" name="ut" class="form_input" <? if($layout=='static') echo ' disabled="disabled"';?>>
						<?php
						if ($layout=='dynamic'):	
							$query=$db->getquery("select cod_skin, ficheiro from skin");
							$selected=0;
							$option[0][0]='';
							$option[0][1]='-----------------';
							if($query[0][0]<>''):
								for ($i=0;$i<count($query);$i++):
									$option[$i+1][0]=$query[$i][0];
									$option[$i+1][1]=$query[$i][1];
									if ($query[$i][0]==$user):
										$selected=$i;
									endif;
								endfor;
							endif;
						else:
							$selected=0;
							$option[0][0]=$layout_name;
							$option[0][1]=$layout_name;
						endif;
						for ($i=0 ; $i<count($option); $i++):
							?>
							<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
							<?=$option[$i][1];?></option>
							<?php
						endfor; ?>
					</select>&nbsp;&nbsp; 
					<input class="form_submit" value=" view " type="submit" <? if($layout=='static') echo ' disabled="disabled"';?> name="user_input">
					</form>
				<hr class="gradient">
				<div class="dtree">
					<a href="<?=session_setup($globvars,$site_path.'/index.php?type=add&id='.$task);?>" >Install New Skin </a> |
					<a href="<?=session_setup($globvars,$site_path.'/index.php?type=template&id='.$task);?>" >Add Template to the templates directory</a>
					
				</div>
				<hr class="gradient">
				</td>
			  </tr>
			  <tr>
			    <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
		      </tr>
			  <tr valign="top">
			    <td>
				<?php
				if ($code<>'' and $layout=='dynamic'):
					$query=$db->getquery("select ficheiro, cod_skin, active from skin where cod_skin='".$code."'");
					if ($query[0][0]<>''):
						edit_field($code,$globvars);
					endif;
				else:
					if (isset($_GET['type'])):
						if($_GET['type']=='add'):
							add_field($globvars);
						elseif($_GET['type']=='template'):
							add_template($globvars);
						else:
							no_code($globvars);
						endif;
					else:
						no_code($globvars);
					endif;
				endif;
				  ?>
				</td>
			  </tr>
			  <?php
				if (isset($_GET['type'])):
					if($_GET['type']=='view'):
					?>
				  <tr>
					<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
				  </tr>
				  <tr valign="top">
					<td class="body_text">
					CSS:<br />
						<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
						  <tr>
							<td height="400">
							  <IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="100%" src="<?=session_setup($globvars,$site_path.'/layout/view.php?where=skin&file='.$_GET['file']);?>" scrolling="auto"></IFRAME>
							</td>
						  </tr>
						</table>
					</td>
				  </tr>
				  <tr>
					<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
				  </tr>
			  <?php
				endif;
			endif;
		  ?>
			</table>
		
		</DIV>
	  </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<?php
function no_code($globvars){
?>
<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center">
	<font class="body_text">Seleccione uma op&ccedil;&atilde;o na DropBox acima de modo a poder visualizar os detalhes</font>
	</td>
  </tr>
  <tr>
    <td align="center">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left">
				<?php
					put_files($globvars);
				?>
			</td>
		  </tr>
		</table>
	</td>
  </tr>
</table>
<?php
};

function add_template($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
?>
<form method="post" enctype="multipart/form-data" name="add_template" action="<?=session_setup($globvars,$site_path.'/index.php?id='.$task);?>">
<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" class="body_text"><p>Para poder adicionar um template, compacte num ficheiro ZIP</p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$site_path;?>/images/template_example1.gif" width="294" height="66" /></td>
  </tr>
  <tr>
    <td align="left" class="body_text"><p>&nbsp;</p>
      <p>o ficheiro template  com as imagens e outros ficheiros adicionais (CSS por ex.) num direct&oacute;rio com o nome do template (sem a extens&atilde;o)</p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$site_path;?>/images/template_example2.gif" width="315" height="123" /></td>
  </tr>
  <tr>
    <td align="left" class="body_text">
      <p>&nbsp;</p>
      <p>por &uacute;ltimo n&atilde;o se esque&ccedil;a de incluir o ficheiro de imagem Preview.jpg no directorio </p></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  <tr>
    <td class="body_text"><strong>Template a adicionar (ZIP)</strong> </td>
  </tr>
  <tr>
    <td><label>
      <input type="file" name="add_template" accesskey="1" size="50" />
    </label></td>
  </tr>
  <tr>
    <td height="15" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><input name="add_template" type="image" src="<?=$site_path.'/images/buttons/'.$lang.'/adicionar.gif';?>" /></td>
  </tr>
</table>

</form>
<?php
};
function edit_field($mod,$globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;

$query_a=$db->getquery("select ficheiro, cod_skin, active, default_cell, num_cells from skin where cod_skin='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
	exit;
endif;
if($query_a[0][2]=='s'):
	$pub='Sim';
	$name='unpublish';
	$value='nao_publicar';
else:
	$name='publish';
	$value='publicar';
	$pub='N&atilde;o';
endif;
$file=explode(".",$query_a[0][0]);
$dir=glob($globvars['local_root'].'layouts/templates/*.*');
for($i=0;$i<count($dir);$i++):
	$dir_x=explode("/",$dir[$i]);
	$dir_x=explode(".",$dir_x[count($dir_x)-1]);
	if($dir_x[0]==$file[0]):
	$file=$file[0].'.'.$dir_x[1];
	break;
	endif;
endfor;
?>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<form method="post" action="<?=session_setup($globvars,$site_path.'/index.php?id='.$task.'&mod='.$mod);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código da Skin: <?=$query_a[0][1];?>,&nbsp;Skin activa: <?=$pub;?></strong></font>		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="skin_name" value="<?=$query_a[0][0];?>" maxlength="255" size="40">		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/gravar.gif';?>">		</td>
	  </tr>
	  </table>
	  </form>    </td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="skin_code" value="<?=$name;?>">
			<input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/'.$value.'.gif';?>" type="image">
		</form>	</td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="del_skin" value="<?=$query_a[0][1];?>">
			<input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/';?>apagar.gif" type="image">
		</form>    </td>
  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
</table>
<br />
<iframe src="<?=session_setup($globvars,$globvars['site_path'].'/layout/view.php?where=skin&file='.$file);?>" name="target_iframe" width="100%" height="600" align="center" scrolling="Auto" frameborder="0" id="target_iframe"></iframe>
<?php	
};

function add_field($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
if (isset($_GET['file'])):
	$fil=@$_GET['file'];
else:
	$fil='';
endif;
?>
	<form method="post" action="<?=session_setup($globvars,$site_path.'/index.php?id='.$task);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_skin_name" maxlength="255"  value="<?=$fil;?>" size="40">		</td>
	  </tr>
	  
	  
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$site_path.'/images/buttons/'.$lang.'/adicionar.gif';?>">		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="10" colspan="2">
		<?php
		put_files($local_root);
		?>		</td>
	  </tr>
	  </table>
</form>

<?php
};

function put_files($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
echo '<br><br><font class="body_text">Templates existentes:</font><br><br>';
$dir_files = array_merge(glob($globvars['local_root']."layouts/templates/*.htm"),glob($globvars['local_root']."layouts/templates/*.html"),glob($globvars['local_root']."layouts/templates/*.php")) ;
$j=1;
if ($dir_files[count($dir_files)-1]==''):
	$nums=count($dir_files)-1;
else:
	$nums=count($dir_files);
endif;
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">'.chr(13).'<tr>';
for($i=0; $i < $nums; $i++):
	$fl=explode("/",$dir_files[$i]);
	$name=explode(".",$fl[count($fl)-1]);
	$location=explode(".",$fl[count($fl)-1]);
	if(!is_file($globvars['local_root'].'layouts/templates/'.$location[0].'/preview.jpg')):
		$location=$globvars['site_path'].'/images/no_preview.jpg';
	else:
		$location=$globvars['site_path'].'/layouts/templates/'.$location[0].'/preview.jpg';	
	endif;
	include($globvars['site']['directory'].'kernel/settings/layout.php');
	if ($layout=='dynamic'):
		$query=$db->getquery("select cod_skin, ficheiro, active from skin where ficheiro='".$name[0].".php'");
	else:
		$query[0][0]='12';
		$query[0][1]='12';
		if($layout_name==$name[0]):
			$query[0][2]='s';
		else:
			$query[0][0]='';
			$query[0][2]='n';
		endif;
	endif;
	$sr='';
	
	if ($query[0][0]<>''): //file found on the db
		$sr= '<img src="'.$globvars['site_path'].'/images/check_mark.gif">'.chr(13);
		if ($query[0][2]=='s'):
			$sr .= '<font class="body_text">&nbsp;[Activado]</font>&nbsp;&nbsp;';
		else:
			$sr .= '<font class="body_text">&nbsp;[Inactivo]</font>&nbsp;&nbsp;';
		endif;
		$sr .= '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id=5&type=skin&file='.$fl[count($fl)-1]).'" target="_self">Editar</a>]<br>'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;".chr(13);
	else:
		$sr= '<img src="'.$globvars['site_path'].'/images/cross_mark.gif">'.chr(13);
		$sr .= '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id=5&type=skin&file='.$fl[count($fl)-1]).'" target="_self">Editar</a>]<br><a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=add&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">'.$fl[count($fl)-1]. "</a>&nbsp;(". filesize($dir_files[$i]) . " bytes)</font><br>".chr(13);
	endif;
	echo '<td height="180" valign="top" align="center"><img src="'.$location.'" border="1"><br><br>'.$sr.'</td>';
	$j++;
	if ($j>3):
		$j=1;
		echo '</tr>'.chr(13).'<tr>';
	endif;
endfor;
if ($j<4):
	for ($i=$j;$i<4;$i++):
		echo '<td valign="top" align="center"></td>';
	endfor;
endif;
echo '</table><br><br>';
echo '<img src="'.$globvars['site_path'].'/images/check_mark.gif"><font class="body_text">Ficheiro instalado</font>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<img src="'.$globvars['site_path'].'/images/cross_mark.gif"><font class="body_text">Ficheiro n&atilde;o instalado</font>';

};
?>