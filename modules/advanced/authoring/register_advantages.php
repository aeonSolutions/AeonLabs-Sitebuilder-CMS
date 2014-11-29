<?php
$reg=return_id('new_register.php');
$top=return_id('wtos_main.php');
?>
<p><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/my_content.png" alt="vantagens do registo" width="250" height="87"></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p align="justify">Ao registar-se permite-lhe aceder a um conjunto de funcionalidades e servi&ccedil;os exclusivos de entre os quais se destacam:</p>
      <ul>
        <li>Descarregar em formato Acrobat Reader os artigos e documentos publicados no site nomeadamente regulamenta&ccedil;&atilde;o e normas;</li>
        <li>Aceder a publica&ccedil;&otilde;es premium e grava-las no seu computador;</li>
        <li>Aceder livremente ao direct&oacute;rio com a possibilidade de fazer download de todos os seus conte&uacute;dos;</li>
        <li>Ser o primeiro a receber as novidades e em primeira m&atilde;o a atrav&eacute;s do servi&ccedil;o personalizavel de avisos;</li>
      </ul>
      <p><br />
      Isto tudo sem preocupa&ccedil;&otilde;es e &agrave; dist&acirc;ncia de um click com a garantia que os seus dados pessois ser&atilde;o sempre tratados com descri&ccedil;&atilde;o de acordo com a nossa <a href="<?=session($staticvars,'index.php?id='.$top.'&navigate=TOP');?>">pol&iacute;tica de privacidade</a>.</p>
      <p align="justify">&nbsp;</p>
      <p align="justify">&nbsp;</p>
      <p align="justify">&nbsp;</p>
      <form class="form" name="form1" method="post" action="<?=session($staticvars,'index.php?id='.$reg);?>">
        <div align="right">
          <input type="submit" name="registo" id="registo" class="button" value="Efectuar Registo">
        </div>
    </form>      <p></p></td>
    <td width="165" valign="top"><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/eng_project.gif" alt="engenheiro" width="159" height="239"></td>
  </tr>
</table>
