<?php
/*
File revision date: 26-Mar-2007
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if(isset($_FILES['add_template'])):
	include($staticvars['local_root'].'modules/iwfs/update_db/web_management.php');
endif;
?>
<h3><img src="<?=$staticvars['site_path'].'/modules/iwfs';?>/images/adcionar.gif" /> Adcionar  P&aacute;ginas Web  </h3><br />
<form class="form" method="post" enctype="multipart/form-data" name="add_template" action="<?=$_SERVER['REQUEST_URI'];?>">
<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" class="body_text"><p>Para poder adicionar uma p&aacute;gina web, compacte num ficheiro ZIP todos os ficheiros correspondentes &agrave; p&aacute;gina web que quer colocar (imagens, CSS, etc). </p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$staticvars['site_path'];?>/modules/iwfs/images/template_example1.gif" width="294" height="66" /></td>
  </tr>
  <tr>
    <td align="left" class="body_text"><p>&nbsp;</p>
      <p> Lembre-se tamb&eacute;m que no c&oacute;digo html de cada p&aacute;gina as tags das imagens ou qualquer outro ficheiro devem estar com caminhos relativos, por ex.: images/bg.gif. Caso se trate de endere&ccedil;os externos inicie a tg por &quot;http://&quot; .<br />
      </p>      </td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$staticvars['site_path'];?>/modules/iwfs/images/template_example2.gif" width="315" height="123" /></td>
  </tr>
  
  <tr>
    <td height="15"><br />
      O nome do ficheiro compactado ser&aacute; o nome do direct&oacute;rio onde a p&aacute;gina ficar&aacute; alojada no servidor. Caso j&aacute; exista esse nome no servidor, os ficheiros ser&atilde;o substituidos. </td>
  </tr>
  <tr>
    <td class="body_text"><strong>P&aacute;gina Web  a adicionar (ZIP)</strong> </td>
  </tr>
  <tr>
    <td><label>
      <input type="file" name="add_template" accesskey="1" size="50" />
    </label></td>
  </tr>
  <tr>
    <td height="15" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><input name="add_template" type="submit"  value="Adicionar" class="button" /></td>
  </tr>
</table>

</form>
