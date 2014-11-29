<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
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
    <td colspan="2"><span class="header_text_1">Cartazes </span><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/cartazes/images/cartaz.gif';?>" width="57" height="57" border="0" /></td>
    <td><br />
    <img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=terms_management.php');?>">Adicionar Cartaz </a><br />
    <img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=terms_management.php&edit=edit');?>">Editar Cartaz </a><br />
	<img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=terms_management.php&edit=publish');?>">Publicar Cartaz </a><br /></td>
  </tr>
</table>

