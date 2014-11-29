<?php
/*
File revision date: 14-abr-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

if($mod=='' or $skin==''):
	$link=session_setup($globvars,$globvars['site_path'].'/index.php');
	header("Location: ".$link);
	exit;
endif;
if(isset($_POST['skin'])):
	$skin=mysql_escape_string(@$_POST['skin']);
else:
	$skin=mysql_escape_string(@$_GET['skin']);
endif;
if ($layout=='dynamic'):
	$query=$db->getquery("select cod_skin, ficheiro from skin where cod_skin='".$skin."'");				
else:
	$query[0][0]=1;
	$query[0][1]=$layout_name;
	$skin=1;
endif;
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><br>        </td>
    <td width="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<font class="header_text_1">Skin:&nbsp;<?=$query[0][1];?><br />
	Editting Cell n&ordm;<?=$mod;?></font>	</td>
  </tr>
  <tr>
    <td height="14" colspan="2" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">
	<font class="header_text_1">&nbsp;Editar</font>
	</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	  <form class="form" method="post" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?');?>"  enctype="multipart/form-data">
		<table height="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
		$query=$db->getquery("select cod_module from skin_layout where cod_skin='".$skin."' and cell='".$mod."' order by priority ASC");
		if ($query[0][0]==''):
			?>
			  <tr>
				<td align="left">
				<font class="header_text_1">No modules added at this time</font>
				</td>
			  </tr>
			  <?php
		else:
			$query_module=$db->getquery("select cod_module, name, link from module order by link");
			// a query tem que ser sempre nesta forma senao da erro! : select cod_module, name, link from module
			$option=build_drop_modules($query_module,$task);
			$selected=0;
			for($i=0;$i<count($query);$i++):
				?>
				<tr>
				<td align="center">
				<?php
				$selected=0;
				for($k=0;$k<count($option);$k++):
					if ($option[$k][0]==$query[$i][0]):
						$selected=$k;
					endif;
				endfor;
				?>
				<font class="Body_text">Position 
				n&ordm;<?=$i+1;?>&nbsp;&nbsp;</font>
				<select size="1" name="drop_<?php echo $i;?>" class="form_input">
					<?php
					for ($k=0 ; $k<count($option); $k++):
						 if ($option[$k][0]=='optgroup'):
						 ?>
						<optgroup disabled label="<?=$option[$k][1];?>"></optgroup>
						 <?php
						 else:
						?>
						<option value="<?php echo $option[$k][0];?>" <?php if ($selected==$k){?>selected<?php } ?>>
						<?php echo $option[$k][1]; ?></option>
						<?php
						endif;
					endfor; ?>
				</select>
			</td>
			</tr>
			<tr>
			  <td height="5"></td>
			</tr>
			<?php
			endfor;
			?>
			<tr>
			  <td height="5" align="right">
			  <input type="hidden" value="<?=$mod;?>" name="mod" />
			  <input type="hidden" value="<?=$skin;?>" name="skin" />
			  <input type="hidden" name="max_pos" value="<?=count($query)-1;?>">
			  <input type="submit" value="Save" class="button">
			  </td>
			</tr>
		<?php
		endif;
		?>
		</table>
	  </form>
	</td>
  </tr>
  <tr>
    <td height="14" colspan="2" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">
	<font class="header_text_1">&nbsp;Adicionar</font>
	</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	  <form class="form" method="post" action="<?=session_setup($globvars,$site_path.'/index.php?');?>"  enctype="multipart/form-data">
		<table height="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center">
				<?php
				$query_module=$db->getquery("select cod_module, name, link from module order by link");
				// a query tem que ser sempre nesta forma senao da erro! : select cod_module, name, link from module
				$option=build_drop_modules($query_module,$task);
				$selected=0;
				?>
				<select size="1" name="drop_add" class="form_input">
					<?php
					for ($k=0 ; $k<count($option); $k++):
						 if ($option[$k][0]=='optgroup'):
						 ?>
						<optgroup disabled label="<?=$option[$k][1];?>"></optgroup>
						 <?php
						 else:
						?>
						<option value="<?php echo $option[$k][0];?>" <?php if ($selected==$k){?>selected<?php } ?>>
						<?php echo $option[$k][1]; ?></option>
						<?php
						endif;
					endfor; ?>
				</select>
			</td>
			</tr>
			<tr>
			  <td height="5"></td>
			</tr>
			<tr>
			  <td height="5" align="right">
			  <input type="hidden" value="<?=$mod;?>" name="mod" />
			  <input type="hidden" value="<?=$skin;?>" name="skin" />
			  <input type="submit" class="button" value="Add Module">
			  </td>
			</tr>
		</table>
	  </form>
      
	</td>
  </tr>
  <tr>
    <td height="14" colspan="2" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">
	<font class="header_text_1">&nbsp;Apagar</font>
	</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	  <form class="form" method="post" action="<?=session_setup($globvars,$site_path.'/index.php');?>"  enctype="multipart/form-data">
		<table height="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center">
				<font class="Body_text">Position n&ordm;&nbsp;&nbsp;</font>
				<input type="text" size="10" name="del_pos" class="form_input">&nbsp;&nbsp;
			  </td>
			</tr>
			<tr>
			  <td height="5"></td>
			</tr>
			<tr>
			  <td height="5" align="right">
			  <input type="hidden" value="<?=$mod;?>" name="mod" />
			  <input type="hidden" value="<?=$skin;?>" name="skin" />
			  <input type="checkbox" name="del_all" class="form_input">
				<font class="Body_text">&nbsp;&nbsp;Delete all&nbsp;&nbsp;</font>
			    <input type="submit" value="Delete" class="button">
			  </td>
			</tr>
		</table>
	  </form>
	</td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	  <form class="form"  method="post" action="<?=session_setup($globvars,$site_path.'/index.php?&skin='.$skin);?>"  enctype="multipart/form-data">
		<table height="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td height="5" align="right">
			  <input type="hidden" value="<?=$skin;?>" name="skin" />
			  <input type="submit" value="Go back" class="button">
			  </td>
			</tr>
		</table>
	  </form>
	</td>
  </tr>
</table>

<?php
function build_drop_modules($query,$task){
// a query tem que ser sempre nesta forma senao da erro! 
//       : select cod_module, name, link from module order by link
	$option[0][0]='none';
	$option[0][1]='------------------------------------';
	$t[0]='';
	$t[1]='';
	$k=1;
	if ($query[0][0]==''):
		return $option;
	endif;
	for ($i=1;$i<=count($query);$i++):
		$last_t=$t;
		$t=explode("/",$query[$i-1][2]);
		if ($t[0]<>$last_t[0]):
			$option[$k][0]='optgroup';
			$option[$k][1]=$t[0];
			$k++;
		endif;
		$option[$k][0]=$query[$i-1][0];;
		$option[$k][1]='&nbsp;&nbsp;&nbsp;&nbsp;'.$query[$i-1][1].' @ '.$t[1];
		$k++;
	endfor;

return $option;
};
?>
