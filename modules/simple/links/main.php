<?
include($staticvars['local_root'].'modules/links/language/'.$lang.'.php');
?>
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr height="34">
		<td width="37"><img src="<?=$header_root;?>layout/template/gmc/icon.gif"></td>
		<td  class="header">Links</td>
	  </tr>
	</table>
<br />
<br />
<?php
if (is_array($links)):
	for($i=0;$i<count($links);$i++):
		echo '<hr size="1"><a href="'.$links[$i][1].'" target="_blank"><strong>'.$links[$i][0].'</strong></a><br /><div align="justify" class="text_font">'.$links[$i][2].'</div><br />';
	endfor;
	echo '<hr size="1">';
endif;
?>