<?php
include($staticvars['local_root'].'kernel/errors/language/'.$staticvars['language']['current'].'.php');
?>
<div id="module-center">
	<div style="FONT-SIZE: 20px; MARGIN-BOTTOM: 3px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="30"><img src="<?=$staticvars['site_path'];?>/kernel/images/not_found.gif" width="30" height="32" /></td>
			<td class="titletext"><?=$error_title;?></td>
		  </tr>
		</table>
	</div>
	  <br>
	  <table width="64%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td>
		  <p class="bodytext"> <?=$error_msg;?></p>
		  </td>
		</tr>
	  </table>
</div>
