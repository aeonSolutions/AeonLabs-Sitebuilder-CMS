<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!isset($local_root)):
	echo 'Error: Security Not Found (db backup)';
	exit;
endif;
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found(db backup)';
	exit;
endif;

if (isset($_POST['backup'])):
	include('update_db/db_backup.php');
	unset($_POST['backup']);
	@session_start();
	?>
	<script language="javascript">
		window.alert("efectuado o Backup da Base de Dados!");
	</script>
	<?php
endif;
include($local_root.'general/staticvars.php'); 
?>
<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
  <TBODY>
  <TR>
    <TD>
      <DIV class="main-box">
      	<DIV class="main-box-title">Backup da Base de Dados</DIV>
		<DIV class="main-box-data">
			<TABLE width="100%" height="400" border="0" cellPadding="0" cellSpacing="0">
			  <tr>
			    <td align="center">
				  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td><div align="center"><img src="<?php echo $site_path.'/images/menus.gif'; ?>" border="0" ></div></td>
					</tr>
					<tr>
					  <td><div align="center">Backup da Base de Dados </div></td>
					</tr>
				  </table>
				</td>
			  </tr>
			  <tr>
				<td height="100" colspan="3" valign="bottom"><div align="center"></div></td>
			  </tr>
		  <tr>
		    <td height="5" colspan="3" valign="bottom">
				<form method="post" enctype="multipart/form-data" action="<?=session_setup($globvars,'index.php?id='.$task);?>">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="center">
					<input type="hidden" name="backup" value="do backup">
					<input type="image" src="<?=$site_path;?>/images/buttons/pt/backup.gif">
					</td>
				  </tr>
				</table>
				</form>
			</td>
		  </tr>
		</table>
		</DIV>
	  </DIV>
      </TD>
    </TR>
	</TBODY>
</TABLE>
