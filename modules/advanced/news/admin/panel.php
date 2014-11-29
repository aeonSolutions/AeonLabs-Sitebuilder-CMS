<?php
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
    <td colspan="2"><strong>Informa&ccedil;&otilde;es / Not&iacute;cias</strong><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/news/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td>
    <?php
if ($staticvars['users']['user_type']['admin']==$staticvars['users']['group']):
		?>
		<img src="<?=$staticvars['site_path'];?>/modules/news/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=general.php');?>">Config. Geral </a><br />
        <?php
		endif;
		?>
	<img src="<?=$staticvars['site_path'];?>/modules/news/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=create_news.php');?>">Novo Post informativo </a><br />
    <img src="<?=$staticvars['site_path'];?>/modules/news/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=edit_news.php');?>">Editar Posts de Informa&ccedil;&otilde;es </a><br /></td>
  </tr>
</table>

