<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Content Management';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (CMS Panel)';
	exit;
endif;
$local_file = __FILE__ ;
$local_file = ''.substr( $local_file, 0, strpos( $local_file, "panel.php" ) ) ;
if (is_file($local_file.'version.php')):
	include($local_file.'version.php');
else:
	$module_version='0.0';
endif;
?>
<table border="0" cellspacing="0">
  <tr>
    <td colspan="2"><span class="header_text_1">Gestor de Inqu&eacute;ritos </span><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td width="57"><img src="<?=$staticvars['site_path'].'/modules/polls/images/panel_base.jpg';?>" width="57" height="57" border="0" /></td>
    <td width="124" valign="top"><br />
    <img src="<?=$staticvars['site_path'];?>/modules/polls/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=polls_maintenance.php');?>">Gest&atilde;o</a><br /></td>
  </tr>
</table>

