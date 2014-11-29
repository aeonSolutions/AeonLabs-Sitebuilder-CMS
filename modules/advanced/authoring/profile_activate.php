<?php
/*
File revision date: 10-Fev-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
include($staticvars['local_root'].'kernel/staticvars.php');
$cod_user=@$_GET['active'];
$qw=$db->getquery("select nick, cod_user_type, active from users where cod_user='".mysql_escape_string($cod_user)."'");
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
if ($qw[0][0]<>''):
	if ($qw[0][2]=='s'): //utilizador ja se encontra activado
		?>
		<table width="100%" height="500"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="40"><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/warning.png"/></td>
				<td width="100%"><font class="header_text_1"><?=$pa[0];?></font>
				<br /><font class="body_text"><?=$pa[1];?></font></td>
				<td >&nbsp;</td>
			  </tr>
			  <tr height="100%">
				<td colspan="3" valign="bottom">&nbsp;</td>
			  </tr>
		</table>
		<?php
	else:// utilizador por activar 
		$db->setquery("update users set active='s' where cod_user='".mysql_escape_string($cod_user)."'");
		$SessionID = md5( uniqid( rand () ) );
		$qws=$db->getquery("select session_id from sessions where cod_user='".mysql_escape_string($cod_user)."'");
		if($qws[0][0]<>''): 
			$db->setquery("update sessions set data=NOW(), session_id='".$SessionID."' where cod_user='".mysql_escape_string($cod_user)."'");				
		else:
			$db->setquery("insert into sessions set cod_user='".mysql_escape_string($cod_user)."', data=NOW(), session_id='".$SessionID."'");
		endif;
		@session_destroy();
		session_id($SessionID);
		session_start();
		$_SESSION['user'] = $qw[0][0];
		// fazer formulario de preenchimento de resto de dados de acordo com o tipo de utilizador que foi registado.
		?>
		<table width="100%" height="500"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td ><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/button_ok.png" width="48" height="48" /></td>
				<td width="100%"><font class="header text_1"><?=$pa[0];?></font>
				<br /><font class="body_text"><?=$pa[2];?></font></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr height="100%">
				<td colspan="3" valign="bottom"></td>
			  </tr>
		</table>
		<?php
	endif;
else:
		?>
		<table width="100%" height="500"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td ><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/button_ok.png" width="48" height="48" /></td>
				<td width="100%"><font class="header text_1"><?=$pa[0];?></font>
				<br />
				<font class="body_text"><?=$pa[3];?></font></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr height="100%">
				<td colspan="3" valign="bottom"></td>
			  </tr>
		</table>
		<?php

endif;
?>