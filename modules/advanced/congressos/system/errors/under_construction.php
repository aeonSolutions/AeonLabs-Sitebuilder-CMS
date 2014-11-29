<?php
include($staticvars['local_root'].'modules/congressos/system/errors/language/'.$lang.'.php');
?>
<div id="module-center">
	<div style="FONT-SIZE: 20px; MARGIN-BOTTOM: 3px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="30"><img src="<?=$staticvars['site_path'];?>/modules/congressos/images/not_found.gif" width="30" height="32" /></td>
			<td>&nbsp;<?=$construction_title;?></td>
		  </tr>
		</table>
	</div>
	  <br>
	  <table width="64%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td valign="top"><?=$construction_msg;?></td>
	    </tr>
		<tr>
		  <td width="304" height="230" valign="top" style="background:url(<?=$staticvars['site_path'];?>/modules/congressos/images/mouse.jpg); background-repeat:no-repeat">
		  <p>&nbsp;</p>		  </td>
		</tr>
	  </table>
</div>
