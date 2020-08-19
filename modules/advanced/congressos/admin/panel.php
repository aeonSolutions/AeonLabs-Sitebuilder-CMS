<?php
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;
if (include($staticvars['local_root'].'modules/advanced/congressos/admin/version.php')):
	$server_version=$module_version;
else:
	$server_version='0.0';
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
    <td colspan="2"><h3>Congresso, Confer&ecirc;ncias &amp; WorkShops<font style="font-size:10px; color:#666666;">(Ver. <?=$module_version;?> - latest:<?=$server_version;?> )</font></h3></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/congressos/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=general.php');?>">Config. Geral</a><br />
	  <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=categories.php');?>">Gest&atilde;o de Categorias &amp; Conte&uacute;dos</a><br />
	  <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=themes.php');?>">Temas</a><br />
	  <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=menu.php');?>">Configura&ccedil;&atilde;o do Menu Lateral</a><br />
	  <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=downloads.php');?>">Gest&atilde;o de Downloads</a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=add.php');?>">Adicionar P&aacute;gina </a></td>
  </tr>
</table>

