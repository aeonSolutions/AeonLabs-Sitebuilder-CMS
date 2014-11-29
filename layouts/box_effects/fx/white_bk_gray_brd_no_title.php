<table style=" margin-bottom:10px;border-color:#5D5A53;border-style:solid;border-width:1px;width:100%;">
	<tbody>
	<tr>
	<td height="100%" valign="top" bgcolor="#FFFFFF" align="center">
		<?php 
		if (!isset($box_setup)):
			include($be_link_module);
		else:
			include($local_root.'layout/box_effects/empty.php');
			unset($box_setup);
		endif;
		 ?>
	</td>
	</tr>
	</tbody>
</table>


