<?php
?>
<table border="0" cellspacing="0">
  <tr>
    <td colspan="2"><strong>NewsLetters</strong></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/newsletters/images/panel.gif';?>" width="57" height="57" border="0" /></td>
    <td><p><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=management.php');?>">Criar nova</a><br />
        <span class="text"><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=management.php&edit');?>">Editar</a></span><br />
        <span class="text"><a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=statistics.php');?>">Estatísticas</a></span></p>
    </td>
  </tr>
</table>
