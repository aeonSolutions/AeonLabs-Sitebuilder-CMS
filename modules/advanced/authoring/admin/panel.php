<?php
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;
if (is_file($staticvars['local_root'].'modules/advanced/authoring/admin/version.php')):
	include($staticvars['local_root'].'modules/advanced/authoring/admin/version.php');
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
    <td colspan="2"><h3>Utilizadores<font style="font-size:10px; color:#666666;">(Ver. <?=$module_version;?> - latest:<?=$server_version;?> )</font></h3></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/authoring/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td><p><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=add.php');?>">Adicionar</a><br />
        <span class="text"><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=main.php');?>">Editar</a></span></p>
    </td>
  </tr>
</table>
