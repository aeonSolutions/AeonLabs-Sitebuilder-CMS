<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(!include($staticvars['local_root'].'modules/publicacoes/system/settings.php')):
	$main_type=1;
else:
	include_once($staticvars['local_root'].'modules/publicacoes/system/functions.php');
endif;
include_once($staticvars['local_root'].'modules/publicacoes/system/posts_main_'.$main_type.'.php');
?>