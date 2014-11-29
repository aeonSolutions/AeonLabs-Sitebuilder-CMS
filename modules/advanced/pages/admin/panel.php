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
    <td colspan="2"><span class="header_text_1">Integrated WebPage FileSystem</span><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/iwfs/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td>
    <?php
	if ($staticvars['users']['user_type']['admin']==$staticvars['users']['group']):
		?>
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=general.php');?>">Config. Geral</a><br />
        <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=general.php');?>">Ver C&oacute;digos did</a><br />
	<?php
    endif;
	?>
	<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=edit.php');?>">Gest&atilde;o de P&aacute;ginas </a><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=add.php');?>">Adicionar P&aacute;gina </a></td>
  </tr>
</table>

