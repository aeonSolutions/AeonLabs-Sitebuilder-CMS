<?php
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$globvars['language']['main'];
endif;
$code=mysql_escape_string(@$_GET['ut']);
if (isset($_POST['ut'])):
	$code=mysql_escape_string($_POST['ut']);
else:
	$code=mysql_escape_string(@$_GET['ut']);
endif;
if(@$_GET['type']=='addall' or isset($_POST['box_nome']) or isset($_POST['add_box_nome']) or isset($_POST['box_code']) or isset($_POST['del_box'])):
	include($globvars['site']['directory'].'kernel/staticvars.php');
	include($globvars['local_root'].'update_db/box_setup.php');
endif;
$box_effects='';
include($globvars['site']['directory'].'kernel/settings/layout.php');
if($box_fx=='installed'):
	$txt='<a href="'.session_setup($globvars,$globvars['site_path'].'/index.php?type=add&id='.$task).'" >Adicionar </a> |<a href="'.session_setup($globvars,$globvars['site_path'].'/index.php?type=addall&id='.$task).'" >Adicionar TODOS </a>';
else:
	$txt='<img src="'.$globvars['site_path'].'/images/info.png" alt="info" /><font class="body_text">The Layout type you selected doesn\'t allow Box-Fx effects.</font>';
endif;
?>
<link rel="StyleSheet" href="<?=$globvars['site_path'];?>/core/java/dtree.css" type="text/css" />
			<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0" height="350">
			  <tr valign="top">
			    <td align="center">
				<br>
					<form method="post" action="<?=session_setup($globvars,'index.php?id='.$task);?>" enctype="multipart/form-data">
					<select size="1" name="ut" class="form_input" <? if($layout=='static') echo ' disabled="disabled"';?>>
						<?php
						if ($box_fx=='installed'):	
							$query=$db->getquery("select box_code, link, nome from box_effects");
							$selected=0;
							$option[0][0]='';
							$option[0][1]='-----------------';
							if($query[0][0]<>''):
								for ($i=0;$i<count($query);$i++):
									$option[$i+1][0]=$query[$i][0];
									$option[$i+1][1]=$query[$i][2];
									if ($query[$i][0]==$user):
										$selected=$i;
									endif;
								endfor;
							endif;
						else:
							$selected=0;
							$option[0][0]='Disabled';
							$option[0][1]='Disabled';
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
				<div class="dtree"><?=$txt;?></div>
				<hr class="gradient">
				</td>
			  </tr>
			  <tr>
			    <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$globvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
		      </tr>
			  <tr valign="top">
			    <td>
				<?php
				if ($code<>'' and $box_fx=='installed'):
					$query=$db->getquery("select link, box_code, active, nome from box_effects where box_code='".$code."'");
					if ($query[0][0]<>''):
						edit_field($code,$globvars);
					endif;
				else:
					if (isset($_GET['type'])):
						if($_GET['type']=='add'):
							add_field($globvars);
						elseif($box_fx='installed'):
							no_code($globvars);
						endif;
					elseif($box_fx='installed'):
						no_code($globvars);
					endif;
				endif;
				  ?>
				</td>
			  </tr>
			  <?php
				$box_setup=true;
				if (isset($_GET['type'])):
					if($_GET['type']=='view'):
					?>
				  <tr>
					<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$globvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
				  </tr>
				  <tr valign="top">
					<td class="body_text">
					Box-FX:<br />
						<table border="0" cellspacing="0" cellpadding="0" align="center" width="200">
						  <tr>
							<td align="left">
								<?php	include($globvars['site']['directory'].'/layout/box_effects/fx/'.$_GET['file']);;?>
							</td>
						  </tr>
						</table>
					</td>
				  </tr>
				  <tr>
					<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$globvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
				  </tr>
			  <?php
				endif;
			endif;
		  ?>
			</table>
<?php
function no_code($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
include($globvars['site']['directory'].'kernel/settings/layout.php');
?>
<table width="100%" height="250" border="0" cellspacing="0" cellpadding="0" align="center">
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
				if($box_effects=='installed'):
					put_files($globvars);
				endif;
				?>
			</td>
		  </tr>
		</table>
	</td>
  </tr>
</table>
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

$query_a=$db->getquery("select link, box_code, active, nome from box_effects where box_code='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
	exit;
endif;
if($query_a[0][2]=='s'):
	$pub='Sim';
	$name='unpublish';
	$value='nao_varar';
else:
	$name='publish';
	$value='varar';
	$pub='N&atilde;o';
endif;
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form method="post" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código da Box FX: <?=$query_a[0][1];?>,&nbsp;Box Fx  activa: <?=$pub;?></strong></font>		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="box_nome" value="<?=$query_a[0][3];?>" maxlength="255" size="40">		</td>
	  </tr>
	  <tr>
		<td height="15" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="box_link" value="<?=$query_a[0][0];?>" maxlength="255" size="40">		</td>
	  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
	    <td align="right"><input type="checkbox" name="default_fx" />
	      &nbsp;Alterar para este Box-FX  em todos os modulos instalados <br /></td>
	    </tr>
	  <tr>
	    <td align="right">&nbsp;</td>
	    </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="submit" value="Gravar">		</td>
	  </tr>
	  </table>
	  </form>
    </td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="box_code" value="<?=$name;?>">
			<input name="apagar" value="<?=$name;?>" type="submit">
		</form>
	</td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="del_box" value="<?=$query_a[0][1];?>">
			<input name="apagar" value="Apagar" type="submit">
		</form>
    </td>
  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">
		  <?php
			$box_setup=true;
		  	include($staticvars['local_root'].'/layout/box_effects/fx/'.$query_a[0][0]);
		  ?>
		</td>
	  </tr>
</table>
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
	$nam=explode(".",$fil);
	$nam=$nam[0];
	$nam=str_replace("_"," ",$nam);
else:
	$fil='';
	$nam='';
endif;
?>
	<form method="post" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_box_nome" maxlength="255" value="<?=$nam;?>" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_box_link" maxlength="255" value="<?=$fil;?>" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="submit" value="Gravar">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="10" colspan="2">
		<?php
		put_files($globvars);
		?>
		</td>
	  </tr>
	  </table>
	  </form>

<?php
};

function put_files($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
echo '<br><br><font class="body_text">Ficheiros existentes no directório de Efeitos Box-Fx:</font><br><br>';
$dir_files = glob($staticvars['local_root']."layout/box_effects/fx/*.php");
for($i=0; $i < count($dir_files); $i++):
	$fl=explode("/",$dir_files[$i]);
	$query=$db->getquery("select box_code, link,active from box_effects where link='".$fl[count($fl)-1]."'");
	if ($query[0][0]<>''): //file found on the db
		echo '<img src="'.$globvars['site_path'].'/images/check_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id=5&type=box_fx&file='.$fl[count($fl)-1]).'" target="_self">Editar</a>]&nbsp;&nbsp;'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;";
		if ($query[0][2]=='s'):
			echo '<font class="body_text">&nbsp;[Activado]</font><br>';
		else:
			echo '<font class="body_text">&nbsp;[Inactivo]</font><br>';
		endif;
	else:
		echo '<img src="'.$globvars['site_path'].'/images/cross_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id=5&type=box_fx&file='.$fl[count($fl)-1]).'" target="_self">Editar</a>]&nbsp;&nbsp;<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=add&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">'.$fl[count($fl)-1]. "</a>&nbsp;(". filesize($dir_files[$i]) . " bytes)</font><br>";
	endif;
endfor;
echo '<br><br>';
echo '<img src="'.$globvars['site_path'].'/images/check_mark.gif"><font class="body_text">Ficheiro instalado</font>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<img src="'.$globvars['site_path'].'/images/cross_mark.gif"><font class="body_text">Ficheiro n&atilde;o instalado</font>';

};
?>
