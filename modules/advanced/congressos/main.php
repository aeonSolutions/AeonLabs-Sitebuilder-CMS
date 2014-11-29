<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(!include($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$main_type=1;
else:
	include_once($staticvars['local_root'].'modules/congressos/system/functions.php');
endif;
include_once($staticvars['local_root'].'modules/congressos/system/posts_main'.$main_type.'.php');
?>