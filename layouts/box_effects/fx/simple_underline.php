
<table style=" border-bottom-color:#7598BF; border-bottom-width:1px; border-bottom-style:solid;" width="100%">
	<tbody>
	<tr>
	<td height="100%" valign="top" align="left">
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
