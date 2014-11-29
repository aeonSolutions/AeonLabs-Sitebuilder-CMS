<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
include($staticvars['local_root']."kernel/settings/layout.php");
if (isset($l_titulo[$cell+1][0])):
	for($iwqs=0;$iwqs<count($l_titulo[$cell+1]);$iwqs++):
			include($l_module[$cell+1][$iwqs]);
	endfor;
endif;
?>