
<table style="background-color:#FFFDF0;border-color:#7598BF;border-style:solid;border-width:1px;color:#003366;width:100%;margin-bottom:10PX;">
	<tbody>
	<tr style="font-weight:bolder; font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
	<td height="10" colspan="2" valign="top" bgcolor="#7598BF" align="left">
		<?php 
		if (!isset($box_setup)):
			echo $be_titulo;
		endif;
		 ?>
	</td>
	</tr>
	<tr>
	<td height="100%" valign="top" align="center">
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
