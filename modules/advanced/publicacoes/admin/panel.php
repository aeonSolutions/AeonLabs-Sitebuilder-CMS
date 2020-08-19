<?php
if ( !defined('ON_SiTe')):
	echo 'not for direct access';
	exit;
endif;
if (include($staticvars['local_root'].'modules/advanced/publicacoes/admin/version.php')):
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
    <td colspan="2"><h3>Publica&ccedil;&otilde;es Online<font style="font-size:10px; color:#666666;">(Ver. <?=$module_version;?> - latest:<?=$server_version;?> )</font></h3></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/publicacoes/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td>
    <?php
if ($staticvars['users']['user_type']['admin']==$staticvars['users']['type']):
		?>
		<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=general.php');?>">Config. Geral </a><br />
        <?php
		endif;
		?>
	<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=category_management.php');?>">Gestão de Categorias</a><br />
	<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=pubs_management.php');?>">Gest&atilde;o de Publica&ccedil;&otilde;es</a><br />
	<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=files_management.php');?>">Gest&atilde;o de Arquivos</a><br />
    </td>
  </tr>
</table>

