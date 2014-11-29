<?php
/*
File revision date: 8-dez-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
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
    <td colspan="2"><span class="header_text_1">Publicidade </span><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td width="57"><img src="<?=$staticvars['site_path'].'/modules/advertising/images/panel.jpg';?>" width="57" height="57" border="0" /></td>
    <td align="left" valign="top"><br />
		<img src="<?=$staticvars['site_path'];?>/modules/advertising/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=edit.php');?>"> Gest&atilde;o</a></td>
  </tr>
</table>

