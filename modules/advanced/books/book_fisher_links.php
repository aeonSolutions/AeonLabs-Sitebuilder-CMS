<?php
$termo=return_id('dic_propose.php');
?>
<table width="100%" border="0">
  <tr>
    <td class="header_text_1" align="center"> Conhece algum termo que n&atilde;o esteja neste dicion&aacute;rio?<br />
      <a href="<?=session($staticvars,'index.php?id='.$termo);?>"><img border="0" src="<?=$staticvars['site_path'];?>/modules/dictionary/images/colaboradores.gif" alt="Sugerir uma palavra" width="187" height="155" /><br />
      </a>
      
      Adicionar ao dicionário</td>
  </tr>
 </table>


