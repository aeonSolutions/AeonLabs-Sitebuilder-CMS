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
?>
<table border="0" cellspacing="0">
  <tr>
    <td colspan="2"><span class="header_text_1">Dicion&aacute;rio </span></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/dictionary/images/book.gif';?>" width="57" height="57" border="0" /></td>
    <td><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=terms_management.php');?>">Adicionar Termo </a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=terms_management.php&edit=edit');?>">Editar Termos </a><br />
<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=terms_management.php&edit=publish');?>">Publicar Termos </a><br /></td>
  </tr>
</table>

