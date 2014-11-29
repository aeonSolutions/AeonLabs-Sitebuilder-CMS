<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//		Content Management
$auth_type='Content Management';
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
    <td colspan="4"><strong>Galeria</strong><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td width="57"><img src="<?=$staticvars['site_path'].'/modules/galeria/images/panel.jpg';?>" width="57" height="57" border="0" /></td>
    <td width="95" align="left" valign="top"><strong>Gestão</strong><br />
    <img style="background:; padding:0px; border: solid 0px; margin:0px" src="<?=$staticvars['site_path'];?>/modules/galeria/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=category_management.php');?>"> Categorias</a><br /></td>
    <td width="9" align="left" valign="top">&nbsp;</td>
<td width="69" align="left" valign="top"><strong>Galeria</strong><br />
        <img style="background:; padding:0px; border: solid 0px; margin:0px" src="<?=$staticvars['site_path'];?>/modules/galeria/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=galeria_management.php');?>">Adicionar</a><br />
        <img style="background:; padding:0px; border: solid 0px; margin:0px" src="<?=$staticvars['site_path'];?>/modules/galeria/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=galeria_management.php&edit=edit');?>">Editar</a><br />
        <img style="background:; padding:0px; border: solid 0px; margin:0px" src="<?=$staticvars['site_path'];?>/modules/galeria/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=galeria_management.php&edit=publish');?>">Publicar</a><br />
    </td>
  </tr>
</table>

