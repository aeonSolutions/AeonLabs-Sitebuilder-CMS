<?php
include_once($staticvars['local_root'].'general/return_module_id.php');
$help_news=return_id('email_alert_help.php');
$create_news=return_id('email_alert.php');
?>
<table width="100%" border="0">
  <tr>
    <td class="header_text_1">Avisos</td>
  </tr>
  <tr>
    <td class="body_text">Queres ser avisado das últimas actualiza&ccedil;&otilde;es?</td>
  </tr>
  <tr>
    <td class="body_text"><img src="<?=$staticvars['site_path'];?>/modules/email_alerts/images/salert.gif" alt="Criar notifica&ccedil;&otilde;es" width="16" height="16">
	<a class="body_text" href="<?=session($staticvars,'index.php?id='.$create_news);?>">Criar aviso </a></td>
  </tr>
  <tr>
    <td class="body_text"><img src="<?=$staticvars['site_path'];?>/modules/email_alerts/images/shelp.gif" alt="Ajuda notifica&ccedil;&otilde;es" width="16" height="16">
	<a class="body_text" href="<?=session($staticvars,'index.php?id='.$help_news);?>">O que é isto?</a></td>
  </tr>
</table>



