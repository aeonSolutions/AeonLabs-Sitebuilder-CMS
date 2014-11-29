<?
include($staticvars['local_root'].'modules/software/language/'.$lang.'.php');
?>
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr height="34">
		<td width="37"><img src="<?=$header_root;?>layout/template/gmc/icon.gif"></td>
		<td  class="header"><?=$txt_1;?></td>
	  </tr>
	</table>

<br />
<br />
<?php
if (is_array($software)):
	for($i=0;$i<count($software);$i++):
		if($software[$i][3]<>''):
			$download='&nbsp;&nbsp;<a href="'.$header_root.'modules/software/downloads/'.$software[$i][3].'">[ Download ]</a>';
		else:
			$download='';
		endif;
		if ($software[$i][1]<>''):
			echo '<strong>'.$software[$i][0].'</strong>'.$download.'<br /><div align="center"><img src="'.$header_root.'modules/software/images/'.$software[$i][1].'" border="0"></div><br /><div align="justify" class="text_font">'.$software[$i][2].'</div>';
		else:
			echo '<strong>'.$software[$i][0].'</strong>'.$download.'<br /><div align="justify" class="text_font">'.$software[$i][2].'</div>';
		endif;
		if ($i>0 or count($software)>1):
			echo '<hr size="1">';
		endif;
	endfor;
endif;
?>