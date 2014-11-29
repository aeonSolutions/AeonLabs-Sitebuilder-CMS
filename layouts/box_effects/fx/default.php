<?php 
if (!isset($box_setup)):
	include($be_link_module);
else:
	include($local_root.'layout/box_effects/empty.php');
	unset($box_setup);
endif;
 ?>
