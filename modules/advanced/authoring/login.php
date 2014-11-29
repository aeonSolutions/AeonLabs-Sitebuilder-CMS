<?php
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if (isset($_POST['user']) and isset($_POST['p_chave'])):
	include($staticvars['local_root'].'modules/authoring/update_db/authoring.php');
endif;

if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/authoring/language/pt.php');
else:
	include($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php');
endif;

if (isset($_GET['active'])):
	include($staticvars['local_root'].'modules/authoring/profile_activate.php');
elseif (isset($_SESSION['user'])):
	?>
	<br />
	<br />
	<br />
	<br />
	<br />
	<div align="center"><b><?=$l[0];?></b></div>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<?php
else:
	$lost_pass=return_id('lost_pass.php');
	if (isset($_GET['id'])):
		$id=$_GET['id'];
	else:
		$id=return_id('login.php');
	endif;
	if(isset($_GET['areaid'])):
		$areaid='&areaid='.$_GET['areaid'];
	else:
		$areaid='';	
	endif;
	 ?>
	<style type="text/css">
	<!--
	.forgot_password {
		border-top-width: 1px;
		border-left-width:1px;
		border-right-width:1px;
		border-bottom-width: 1px;
		border-top-style: solid;
		border-bottom-style: solid;
		border-left-style: solid;
		border-right-style: solid;
		border-top-color: #000099;
		border-bottom-color: #000099;
		border-left-color: #000099;
		background-color: #6666CC;
	}
	-->
	</style>
	<table background="<?=$staticvars['site_path'].'/modules/authoring/images/header.gif';?>" style=" border:#999999 solid 1px; background-repeat:no-repeat; background-position:right;" width="98%" height="141" align="center">
		<tr>
			<td width="20"></td>
			<td width="230" align="left"><b><?=$l[1];?></b></td>
			<td></td>
		</tr>
		<tr>
			<td width="20"></td>
		 <td width="230" align="left"><font class=""><?=$l[2].$site_name;?></font></td>
			<td></td>
		</tr>
		<tr>
			<td width="20"></td>
		 <td width="230" align="center"><font class=""><?=$l[3];?></font></td>
			<td></td>
		</tr>
	</table>
	<br />
	<font color="#FF0000"><?=$m[$message];?></font>
	<br />
    <div align="center">
	<form class="form" action="index.php?id=<?=return_id('login.php');?>&lang=<?=$lang;?>&navto=<?=@$_GET['navto'].$areaid;?>" enctype="multipart/form-data" method="post">
	  <table width="200"  height="25" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td align="center">
			<?=$l[4];?><br />
			<input class="text" type="text" name="user" size="20" maxlength="25">
		  </td>
		</tr>
		<tr>
		  <td align="center"><?=$l[5];?><br />
		  <input class="text" type="password" name="p_chave" size="20" maxlength="25"><br />
			<font class="litle_text"><br />
		  <input class="text" name="autologin" type="checkbox" id="autologin" value="ON" />
			  <?=$l[6];?> 
			  </font>
		  </td>
		</tr>
		<tr>
		  <td align="center">
			<input type="hidden" name="login">
			<input type="submit" class="button" value=" Login ">
		  </td>
		</tr>
	  </table>
	</form>
    </div>
	<br />
	<br />
	<table width="100%">
		<tr>
			<td width="10"></td>
			<td height="20" class="forgot_password">
			<font color="White" face="Courier New, Courier, mono" size="3"><div align="center"><b><?=$l[7];?></b></div></font>
			</td>
			<td width="10"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td height="5" width="10"></td>
			<td height="10"><font class=""><?=$l[8];?><strong><a href="<?=session($staticvars,'index.php?id='.$lost_pass);?>"><?=$l[9];?></a></strong><?=$l[10];?></font></td>
			<td height="5" width="10"></td>
		</tr>
	</table>
	<?php
endif;

?>

