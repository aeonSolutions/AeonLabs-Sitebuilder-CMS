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
    <td colspan="2"><span class="header_text_1">Forum </span></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/forum/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td><p><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=category.php');?>">Categorias</a><br />
        <span class="text"><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=forums.php');?>">Forums</a></span></p>
    </td>
  </tr>
</table>
