<?php
/*
File revision date: 25-Nov-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found(box effects)';
	exit;
endif;
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
if(@$_GET['type']=='addall' or isset($_POST['add_box_nome'])):
	include($local_root.'general/staticvars.php');
	include($local_root.'update_db/box_setup.php');
endif;
include($local_root.'kernel/settings/layout.php');
if($box_fx=='installed'):
	$txt='<a href="'.session_setup($globvars,$site_path.'/index.php?type=add&id='.$task).'" >Adicionar </a> |<a href="'.session_setup($globvars,$site_path.'/index.php?type=addall&id='.$task).'" >Adicionar TODOS </a>';
	$boxfx=$db->getquery("select box_code from box_effects");
	if (count($boxfx)==1):
		$db->setquery("insert into box_effects set nome='default', link='default.php'");
	endif;
else:
	$txt='<img src="'.$site_path.'/images/info.png" alt="info" /><font class="body_text">The Layout type you selected dosn\'t allow Box-Fx effects <br />To change, go back to step nº2.</font>';
endif;
?>
<link rel="StyleSheet" href="<?=$site_path;?>/core/java/dtree.css" type="text/css" />
			<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
			  <tr valign="top">
			    <td align="center">
				<br>
				<hr class="gradient">
				<div class="dtree"><?=$txt;?></div>
				<hr class="gradient">
				</td>
			  </tr>
			  <tr>
			    <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
		      </tr>
			  <tr valign="top">
			    <td>
				<?php
				if($box_fx=='installed'):
					if ($code<>''):
						$query=$db->getquery("select link, box_code, active, nome from box_effects where box_code='".$code."'");
						if ($query[0][0]<>''):
							edit_field($code,$local_root);
						endif;
					else:
						if (isset($_GET['type']) and !isset($_POST['add_box_nome'])):
							if($_GET['type']=='add'):
								add_field($local_root);
							else:
								no_code($local_root);
							endif;
						else:
							no_code($local_root);
						endif;
					endif;
				endif;
				$address=strip_address($local_root,"step",$_SERVER['REQUEST_URI']);
				?>
					<div align="right"><form action="<?=$address;?>" enctype="multipart/form-data" method="post">
					<input name="continue" type="submit" class="form_submit" id="continue" value="Continue Wiz"></form></div>
				</td>
			  </tr>
			  <?php
				$box_setup=true;
				if (isset($_GET['type'])):
					if($_GET['type']=='view'):
					?>
				  <tr>
					<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
				  </tr>
				  <tr valign="top">
					<td class="body_text">
					Efeito Box-FX:<br />
						<table border="0" cellspacing="0" cellpadding="0" align="center" width="200">
						  <tr>
							<td align="left">
								<?php	include($absolute_path.'/layout/box_effects/fx/'.$_GET['file']);;?>
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
<?php
function no_code($local_root){
include($local_root.'general/staticvars.php');
?>
<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center">
	<font class="body_text">Seleccione um dos efeitos de modo a poder visualizar os detalhes<br />
	<?php
	if(isset($_POST['add_box_nome'])):
		$address=strip_address($local_root,"step",$_SERVER['REQUEST_URI']);
		$address=strip_address($local_root,"file",$address);
		$step=$_GET['step']+1;
		$address=$address.'&step='.$step;
	?>
		<img src="<?=$site_path;?>/core/images/button_ok.png" alt="ok" /><br />O efeito foi instalado com sucesso. <br />
		Clique <a href="<?=$address;?>">aqui</a> para continuar ou escolha outro efeito para instalar. <?php
	endif;
	?>	</font>
	</td>
  </tr>
  <tr>
    <td align="center">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left">
				<?php
					put_files($local_root);
				?>
			</td>
		  </tr>
		</table>
	</td>
  </tr>
</table>
<?php
};


function add_field($local_root){
include($local_root.'general/staticvars.php');
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
	<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>"  enctype="multipart/form-data">
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
		  <input name="add_sub_menu" type="image" src="<?=$site_path.'/images/buttons/'.$lang;?>/adicionar.gif">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="10" colspan="2">
		<?php
		put_files($local_root);
		?>
		</td>
	  </tr>
	  </table>
	  </form>

<?php
};

function put_files($local_root){
include($local_root.'general/staticvars.php');
$task=@$_GET['id'];
echo '<br><br><font class="body_text">Ficheiros existentes no directório de Efeitos Box-Fx:</font><br><br>';
$dir_files = glob($local_root."layout/box_effects/fx/*.php");
for($i=0; $i < count($dir_files); $i++):
	$fl=explode("/",$dir_files[$i]);
	$query=$db->getquery("select box_code, link,active from box_effects where link='".$fl[count($fl)-1]."'");
	if ($query[0][0]<>''): //file found on the db
		echo '<img src="'.$site_path.'/images/check_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&step=3&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;";
		if ($query[0][2]=='s'):
			echo '<font class="body_text">&nbsp;[Activado]</font><br>';
		else:
			echo '<font class="body_text">&nbsp;[Inactivo]</font><br>';
		endif;
	else:
		echo '<img src="'.$site_path.'/images/cross_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&step=3&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=add&step=3&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">'.$fl[count($fl)-1]. "</a>&nbsp;(". filesize($dir_files[$i]) . " bytes)</font><br>";
	endif;
endfor;
echo '<br><br>';
echo '<img src="'.$site_path.'/images/check_mark.gif"><font class="body_text">Ficheiro instalado</font>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<img src="'.$site_path.'/images/cross_mark.gif"><font class="body_text">Ficheiro n&atilde;o instalado</font>';

};
?>
