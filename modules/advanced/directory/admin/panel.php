<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (CMS Panel)';
	exit;
endif;
?>
<table border="0" cellspacing="0">
  <tr>
    <td colspan="2"><span class="header_text_1">CMS - Gestor de Conte&uacute;dos </span></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/directory/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=general.php');?>">Config. Geral</a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=content_types.php');?>">Gest&atilde;o de tipos de conte&uacute;dos</a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=ges_cat.php');?>">Gest&atilde;o de Categorias</a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=publish_items.php');?>">Manuten&ccedil;&atilde;o de Conte&uacute;dos </a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=add_item.php');?>">Adicionar Conte&uacute;dos </a></td>
  </tr>
</table>

