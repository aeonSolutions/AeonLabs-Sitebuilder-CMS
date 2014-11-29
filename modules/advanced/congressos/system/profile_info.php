<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$type=$db->getquery("select name from user_type where cod_user_type='".$staticvars['users']['type']."'");
if($type[0][0]=='gestorcongresso' or $staticvars['users']['user_type']['admin']==$staticvars['users']['code']):
	include($staticvars['local_root'].'modules/congressos/system/congress_info_manager.php');
elseif($type[0][0]=='revisor'):
	include($staticvars['local_root'].'modules/congressos/system/congress_info_revisor.php');
elseif($type[0][0]=='secretariado'):
	include($staticvars['local_root'].'modules/congressos/system/congress_info_secretariado.php');
else:
	include($staticvars['local_root'].'modules/congressos/system/congress_info_user.php');
endif;
?>