<?php
/*
File revision date: 14-Jul-2008
*/
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
if( isset($_POST['add_username']) or isset($_POST['mod_user_name']) or isset($_POST['del_usertype'])):
	include($globvars['site']['directory'].'kernel/staticvars.php');
	include($globvars['local_root'].'update_db/user_groups_setup.php');
endif;
?>
<link rel="StyleSheet" href="<?=$globvars['site_path'];?>/core/java/dtree.css" type="text/css" />
			<TABLE width="100%" border="0" height="100%"cellPadding="0" cellSpacing="0">
			  <tr valign="top">
			    <td align="center">
				<br>
					<form method="post" action="<?=session_setup($globvars,'index.php?id='.$task);?>" enctype="multipart/form-data">
					<select size="1" name="ut" class="form_input">
						<?php
						$query=$db->getquery("select cod_user_type, name from user_type");
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
					<input type="image" src="<?=$globvars['site_path'].'/images/buttons/pt/ver.gif';?>" name="user_input">
					</form>
				<hr class="gradient">
				<div class="dtree">
					<a href="<?=session_setup($globvars,$globvars['site_path'].'/index.php?type=add&id='.$task);?>" >Adicionar</a></div>
				<hr class="gradient">
				</td>
			  </tr>
			  <tr>
			    <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$globvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
		      </tr>
			  <tr valign="top">
			    <td>
				<?php
				if ($code<>''):
					$query=$db->getquery("select name from user_type where cod_user_type='".$code."'");
					if ($query[0][0]<>''):
						edit_field($code,$globvars);
					endif;
				else:
					if (isset($_GET['type'])):
						if($_GET['type']=='add'):
							add_field($globvars);
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
			</table>	

<?php
function no_code($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
?>
	<font class="body_text">Seleccione uma op&ccedil;&atilde;o na DropBox acima de modo a poder visualizar os detalhes</font>
<?php
};

function edit_field($mod,$globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$globvars['language']['main'];
endif;

$query_a=$db->getquery("select name, cod_user_type,cod_user_group from user_type where cod_user_type='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
	exit;
endif;
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form method="post" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>"  enctype="multipart/form-data">
    <input type="hidden" name="add_usertype" value="<?=$query_a[0][1];?>">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código do Grupo: <?=$query_a[0][1];?></strong></font>		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="mod_user_name" value="<?=$query_a[0][0];?>" maxlength="255" size="40" <?php if (val_ut($query_a[0][0])){?> disabled="disabled"<?php } ?>></td>
	  </tr>
	  <tr>
	    <td align="right">
		<font class="body_text">Este grupo &eacute; gerido por </font>
		<select size="1" name="mod_user_groups" class="form_input" <? if (val_ut($query_a[0][0])){ echo 'disabled="disabled"';}?> >
			<?php
			$query=$db->getquery("select cod_user_type, name from user_type");
			$disabled=0;
			for ($i=0;$i<=count($query);$i++):
				$option[$i][0]=$query[$i][0];
				$option[$i][1]=$query[$i][1];
				if ($query[$i][0]==$query_a[0][2]):
					$disabled=$i;
				endif;
			endfor;
			for ($i=0 ; $i<count($option); $i++):
				 if ($disabled==$i):
				 ?>
					<option value="<?php echo $option[$i][0];?>" selected="selected"><?=$option[$i][1]; ?></option>
				 <?php
				 else:
					?>
					<option value="<?php echo $option[$i][0];?>"><?=$option[$i][1]; ?></option>
				<?php
				endif;
			endfor; ?>
		</select>
		</td>
      </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	<?php
	if (val_ut($query_a[0][0])):?>
	  <tr>
		<td height="10" colspan="2" class="body_text"><img src="<?=$globvars['site_path'].'/images/';?>warning.gif" />&nbsp;N&atilde;o é possivel efectuar altera&ccedil;&otilde;es aos grupos de utilizadores pré-definidos</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	<?php
	endif;
	if (!val_ut($query_a[0][0])):?>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang.'/gravar.gif';?>">		</td>
	  </tr>
	<?php
	endif;
	?>
	  </table>
	  </form>
	  </td>
    <td valign="bottom" align="left">
	<?php
	if (!val_ut($query_a[0][0])):?>
		<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="del_usertype" value="<?=$query_a[0][1];?>">
			<input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/pt/';?>apagar.gif" type="image">
		</form>
	<?php
	endif;
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
?>
<form method="post" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_username" maxlength="255" value="" size="40">		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
	    <td align="right">
		<font class="body_text">Este grupo &eacute; gerido por </font>
		<select size="1" name="add_user_groups" class="form_input">
			<?php
			$query=$db->getquery("select cod_user_type, name from user_type");
			$disabled=0;
			for ($i=0;$i<count($query);$i++):
				$option[$i][0]=$query[$i][0];
				$option[$i][1]=$query[$i][1];
				if ($query[$i][1]=='Authenticated Users'):
					$disabled=$i;
				endif;
			endfor;
			for ($i=0 ; $i<count($option); $i++):
				 if ($disabled==$i):
				 ?>
					<option value="<?php echo $option[$i][0];?>" selected="selected"><?=$option[$i][1]; ?></option>
				 <?php
				 else:
					?>
					<option value="<?php echo $option[$i][0];?>"><?=$option[$i][1]; ?></option>
				<?php
				endif;
			endfor; ?>
		</select>
	</td>
      </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/pt/adicionar.gif';?>">		
          </td>
	  </tr>
  </table>
</form>

<?php
};

function val_ut($name){
if ($name=='Administrators' or $name=='Guests' or $name=='Default' or $name=='Authenticated Users'):
	return true;
else:
	return false;
endif;
};
?>
