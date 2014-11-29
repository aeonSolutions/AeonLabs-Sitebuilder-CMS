<?php
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
if (isset($_GET['file'])):
	$fil=@$_GET['file'];
endif;
?>
<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="disp" maxlength="255"  value="<?=$fil;?>" size="40" disabled="disabled"><br />
			<input type="hidden" name="add_skin_name" value="<?=$fil;?>"  ></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang;?>/adicionar.gif"></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="10" colspan="2">
		<?php
		put_files($globvars);
		?>		</td>
	  </tr>
	  </table>
	  </form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top" align="center">&nbsp;</td>
    <td valign="top" align="center">&nbsp;</td>
    <td valign="top" align="center">&nbsp;</td>
  </tr>
</table>
<?php