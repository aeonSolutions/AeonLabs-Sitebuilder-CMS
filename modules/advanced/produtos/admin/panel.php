<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
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
    <td colspan="4"><span class="header_text_1">Produtos </span><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td width="57"><img src="<?=$staticvars['site_path'].'/modules/produtos/images/panel.jpg';?>" width="57" height="57" border="0" /></td>
    <td width="95" align="left" valign="top"><strong>Gestão</strong><br />
      <img src="<?=$staticvars['site_path'];?>/modules/produtos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=iva_management.php');?>">I.V.A. </a><br />
		<img src="<?=$staticvars['site_path'];?>/modules/produtos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=descontos_management.php');?>"> Descontos </a><br />
    <img src="<?=$staticvars['site_path'];?>/modules/produtos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=category_management.php');?>"> Categorias</a><br /></td>
    <td width="9" align="left" valign="top">&nbsp;</td>
<td width="69" align="left" valign="top"><strong>Produtos</strong><br />
        <img src="<?=$staticvars['site_path'];?>/modules/produtos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=produtos_management.php');?>">Adicionar</a><br />
        <img src="<?=$staticvars['site_path'];?>/modules/produtos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=produtos_management.php&edit=edit');?>">Editar</a><br />
        <img src="<?=$staticvars['site_path'];?>/modules/produtos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=produtos_management.php&edit=publish');?>">Publicar</a><br />
    </td>
  </tr>
</table>

