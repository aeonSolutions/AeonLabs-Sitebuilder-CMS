<?php
if ($globvars['error']['type']=='question'):
	$img=$globvars['site_path'].'/core/layout/error/images/pergunta.jpg';
	$qest='Do you want to coninue? [ Yes ] / [ No ]';
elseif ($globvars['error']['type']=='exclamation'):
	$img=$globvars['site_path'].'/core/layout/error/images/atencao.gif';
	$qest='Do you want to coninue? [ Yes ] / [ No ]';
elseif ($globvars['error']['type']=='prohibited'):
	$img=$globvars['site_path'].'/core/layout/error/images/prohibited.jpg';
	$qest='You are not allowed to continue. Check the error and try again. Thank You.';
else:
	$img=$globvars['site_path'].'/core/layout/error/images/atencao.gif';
	$qest='Do you want to coninue? [ Yes ] / [ No ]';
endif;
?>
<table width="400" border="0" align="center">
  <tr>
    <td width="100" valign="top"><img src=<?=$img;?> width="100"></td>
    <td align="center" valign="middle"><h2><?=$globvars['error']['message'];?></h2></td>
  </tr>
</table>

