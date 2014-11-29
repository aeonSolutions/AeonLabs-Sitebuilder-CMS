<?php
/*
File revision date: 28-Set-2006
*/

// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users

$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;

$query=$db->getquery("select tipos from items_types where cod_items_types='".mysql_escape_string($type)."'");
$tipos=$query[0][0];
if ($tipos=='modulo'):
	include($staticvars['local_root'].'modules/directory/update_db/manage_modules.php');
elseif ($tipos=='linkexterno'):
	include($staticvars['local_root'].'modules/directory/update_db/manage_links.php');
elseif ($tipos=='webpage'):
	include($staticvars['local_root'].'modules/directory/update_db/manage_webpages.php');
else: // documents , audio, video, image, zip
	include($staticvars['local_root'].'modules/directory/update_db/manage_files.php');
endif;
