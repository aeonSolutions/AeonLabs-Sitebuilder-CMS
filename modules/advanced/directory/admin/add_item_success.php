<?php
/*
File revision date: 2-Out-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (add item sucess)';
	exit;
endif;
if ($enable_publish):
	$txt='O seu arquivo foi submetido com sucesso na categoria '.$type_name.' e encontra-se de momento em analise. Caso seja aprovado, ser-lhe-&aacute; enviado um email. Obrigado por ter participado!';
else:
	$txt='O seu arquivo foi submetido com sucesso na categoria '.$type_name.'. Obrigado por ter participado!';
endif;
?>
<table border="0" align="left" width="100%">
	<tr>
	 <td>
	   <table border="0">
		 <tr>
		   <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" width="23" height="23" /></td>
		   <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" alt="o" width="23" height="23" /></td>
		   <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_completed.jpg" width="23" height="23" /></td>
		  </tr>
		</table>		</td>
	</tr>
	<tr>
	<td ><div class="bxthdr">3 - Adicionar <?=$type_name;?></div></td>
	</tr>
  <tr>
	<td class="header_text_1"><?=$txt;?></td>
  </tr>
  <tr>
	<td height="15"></td>
  </tr>
</table>
