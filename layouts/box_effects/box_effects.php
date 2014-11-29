<?php
//$be_link_module='modules/'.$module[0][0];
//$be_cod_module=$task;
	$box_code=$db->getquery("select box_code from module where cod_module='".$be_cod_module."'");
	if ($box_code[0][0]=='' or $box_code[0][0]==-1):
		include($local_root.'layout/box_effects/fx/default.php');
	else:
		$box_link=$db->getquery("select link from box_effects where box_code='".$box_code[0][0]."'");
		if ($box_link[0][0]<>''):	
			include($local_root.'layout/box_effects/fx/'.$box_link[0][0]);
		else:
			include($local_root.'layout/box_effects/fx/default.php');
		endif;
	endif;
?>