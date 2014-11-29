<?php
/*
File revision date: 14-abr-2008
*/
// check if are there any post vars -> if so , let them do their work first!
if (isset($_POST) and $task<>'' and $task<>'error' and isset($_GET['update'])):
	$query=$db->getquery("select link from module where cod_module=".$task);
	if ($query[0][0]<>'' and count($_POST)>0):
		include($staticvars['local_root'].'modules/'.$query[0][0]);
	endif;
endif;
?>