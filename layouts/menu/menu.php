<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$query=$db->getquery("select cod_menu_layout, ficheiro from menu_layout where active='s'");

include_once($staticvars['local_root'].'layout/menu/constructor.php');

if($query[0][0]<>''):
	include($staticvars['local_root'].'layout/menu/layouts/'.$query[0][1]);
else:
	include($staticvars['local_root'].'layout/menu/layouts/default.php');
endif;
?>

