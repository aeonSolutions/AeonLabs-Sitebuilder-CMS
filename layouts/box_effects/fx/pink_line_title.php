<table style="background-color:#f9f9f9;border-color:#FCC1AC;border-style:solid;border-width:1px;color:#003366;width:100%;margin-bottom:10PX;">
	<tbody>
	<tr style="font-weight:bolder; font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
	<td height="10" colspan="2" valign="top" bgcolor="#FCC1AC" align="left">
		<?php 
		if (!isset($box_setup)):
			echo $be_titulo;
		endif;
		 ?>
	</td>
	</tr>
	<tr>
	<td valign="top" align="left">
		<?php 
		if (!isset($box_setup)):
			include($be_link_module);
		else:
			include($local_root.'layout/box_effects/empty.php');
			unset($box_setup);
		endif;
		 ?></td>
	</tr>
	</tbody>
</table>
