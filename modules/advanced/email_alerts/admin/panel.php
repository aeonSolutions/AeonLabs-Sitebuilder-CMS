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
    <td colspan="2"><span class="header_text_1">Avisos Email</span></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/email_alerts/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=alerts_management.php&do=new');?>">Adicionar </a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=alerts_management.php&do=edit');?>">Editar </a><br /></td>
  </tr>
</table>

