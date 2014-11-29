<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Content Management';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (Panel News)';
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
    <td colspan="2"><strong>Informa&ccedil;&otilde;es / Not&iacute;cias</strong><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/eventos/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td>
    <?php
	if ($credentials['user_type']['admin']==$credentials['user']['cod_user_type']):
		?>
		<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=general.php');?>">Config. Geral </a><br />
        <?php
		endif;
		?>
	<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=category_management.php');?>">Gestão de Categorias</a><br />
	<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=create_news.php');?>">Novo Evento </a><br />
    <img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=edit_news.php');?>">Editar Eventos </a><br /></td>
  </tr>
</table>

