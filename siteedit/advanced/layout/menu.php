<?php
/*
File revision date: 23-Ago-2006
*/
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
if(isset($_POST['menu_nome']) or isset($_POST['add_menu_nome']) or isset($_POST['menu_code']) or isset($_POST['del_menu'])):
	include($globvars['site']['directory'].'kernel/staticvars.php');
	include($globvars['local_root'].'update_db/menu_layout_setup.php');
endif;
include($globvars['site']['directory'].'kernel/settings/menu.php');
if($menu_type=='disabled'):
	$txt='<img src="'.$globvars['site_path'].'/images/info.png" alt="info" /><font class="body_text">You have selected a static menu.</font>';
else:
	$txt='<a href="'.session_setup($globvars,$globvars['site_path'].'/index.php?type=add&id='.$task).'" >Add </a>';
endif;
?>
<link rel="StyleSheet" href="<?=$globvars['site_path'];?>/core/java/dtree.css" type="text/css" />
			<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0" height="340">
			  <tr valign="top">
			    <td align="center">
				<br>
					<form method="post" action="<?=session_setup($globvars,'index.php?id='.$task);?>" enctype="multipart/form-data">
					<select size="1" name="ut" class="form_input" <? if($menu_type=='disabled') echo ' disabled="disabled"';?>>
						<?php
						if ($menu_type<>'disabled'):	
							$query=$db->getquery("select cod_menu_layout, ficheiro from menu_layout");
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
					<input class="form_submit" value=" view " type="submit" <? if($menu_type=='disabled') echo ' disabled="disabled"';?> name="user_input">
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
				if ($code<>'' and $menu_type<>'disabled'):
					$query=$db->getquery("select cod_menu_layout, ficheiro, active from menu_layout where cod_menu_layout='".$code."'");
					if ($query[0][0]<>''):
						edit_field($code,$globvars);
					endif;
				else:
					if (isset($_GET['type'])):
						if($_GET['type']=='add'):
							add_field($globvars);
						elseif($menu_type<>'disabled'):
							no_code($globvars);
						endif;
					elseif($menu_type<>'disabled'):
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
					Skin Menu:<br />
						<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
						  <tr>
							<td height="400">
							  <IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="100%" src="<?=session_setup($globvars,$globvars['site_path'].'/layout/view.php?where=menu&file='.$_GET['file']);?>" scrolling="auto"></IFRAME>
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

function edit_field($mod,$globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;

$query_a=$db->getquery("select ficheiro, cod_menu_layout, active, nome from menu_layout where cod_menu_layout='".$mod."'");
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
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form method="post" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código do Menu: <?=$query_a[0][1];?>,&nbsp;Menu  activo: <?=$pub;?></strong></font>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="menu_nome" value="<?=$query_a[0][3];?>" maxlength="255" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="15" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="menu_ficheiro" value="<?=$query_a[0][0];?>" maxlength="255" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/gravar.gif';?>">
		</td>
	  </tr>
	  </table>
	  </form>
    </td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="menu_code" value="<?=$name;?>">
			<input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/'.$value.'.gif';?>" type="image">
		</form>
	</td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="del_menu" value="<?=$query_a[0][1];?>">
			<input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/';?>apagar.gif" type="image">
		</form>
    </td>
  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="center" colspan="2" height="400">
		  <IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="100%" src="<?=session_setup($globvars,$globvars['site_path'].'/layouts/view.php?where=menu&file='.$query_a[0][0]);?>" scrolling="auto"></IFRAME>
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
			<input type="text" name="add_menu_nome" maxlength="255" value="<?=$nam;?>" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_menu_ficheiro" maxlength="255" value="<?=$fil;?>" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/adicionar.gif';?>">
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
echo '<br><br><font class="body_text">Ficheiros existentes no directório de Skins do Menu:</font><br><br>';
$dir_files = glob($globvars['local_root']."layouts/menu/layouts/*.php");
for($i=0; $i < count($dir_files); $i++):
	$fl=explode("/",$dir_files[$i]);
	$query=$db->getquery("select cod_menu_layout, ficheiro, active from menu_layout where ficheiro='".$fl[count($fl)-1]."'");
	if ($query[0][0]<>''): //file found on the db
		echo '<img src="'.$globvars['site_path'].'/images/check_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;";
		if ($query[0][2]=='s'):
			echo '<font class="body_text">&nbsp;[Activado]</font><br>';
		else:
			echo '<font class="body_text">&nbsp;[Inactivo]</font><br>';
		endif;
	else:
		echo '<img src="'.$globvars['site_path'].'/images/cross_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=add&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">'.$fl[count($fl)-1]. "</a>&nbsp;(". filesize($dir_files[$i]) . " bytes)</font><br>";
	endif;
endfor;
echo '<br><br>';
echo '<img src="'.$globvars['site_path'].'/images/check_mark.gif"><font class="body_text">Ficheiro instalado</font>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<img src="'.$globvars['site_path'].'/images/cross_mark.gif"><font class="body_text">Ficheiro n&atilde;o instalado</font>';

};
?>
