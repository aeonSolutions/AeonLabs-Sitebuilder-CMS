<?php
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
    <td colspan="2"><span class="header_text_1">Base de Dados </span><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
  </tr>
  <tr>
    <td><img src="<?=$globvars['site_path'].'/siteedit/advanced/admin_panel/images/db_optimize.gif';?>" width="57" height="57" border="0" /></td>
    <td><img src="<?=$globvars['site_path'];?>/siteedit/advanced/admin_panel/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto=-1&load=db_optimization.php');?>">Optimizar</a><br />
    <span class="text"><img src="<?=$globvars['site_path'];?>/siteedit/advanced/admin_panel/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto=-1&load=db_bk.php');?>">Efectuar Backup </a></span></td>
  </tr>
</table>
<?php
if ($credentials['user_type']['admin']==$credentials['user']['cod_user_type']):
	?>
    <br />
    <table border="0" cellspacing="0">
      <tr>
        <td colspan="2"><span class="header_text_1">Língua &amp; tradu&ccedil;&otilde;es</span><font style="font-size:10px; color:#666666;">(versão <?=$module_version;?>)</font></td>
      </tr>
      <tr>
        <td><img src="<?=$globvars['site_path'].'/siteedit/advanced/admin_panel/images/panel_lang.gif';?>" width="57" height="57" border="0" /></td>
        <td><span class="text"><img src="<?=$globvars['site_path'];?>/siteedit/advanced/admin_panel/images/bola.gif" width="12" height="12" border="0" />&nbsp;<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto=-1&load=language_presentation.php');?>">Tipo de selec&ccedil;&atilde;o de lingua</a></span></td>
      </tr>
    </table>
<?php
endif;
?>
    <br />
    <table border="0" cellspacing="0">
      <tr>
        <td colspan="2"><span class="header_text_1">Adicionar Módulos</span></td>
      </tr>
      <tr>
        <td><img src="<?=$globvars['site_path'].'/siteedit/advanced/admin_panel/images/panel_new_mod.gif';?>" width="57" height="57" border="0" /></td>
        <td><span class="text">Quer novas funcionalidades na sua p&aacute;gina web?<br />
        Consulte <a href="http://www.moradadigital.com/" target="_blank"><strong>aqui</strong></a> os m&oacute;dulos dispon&iacute;veis para a sua p&aacute;gina.</span></td>
      </tr>
    </table>
