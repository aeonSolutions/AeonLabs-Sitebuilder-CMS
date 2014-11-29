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
if ($tipos=='linkexterno'):
	include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p3_links.php');
elseif ($tipos=='webpage'):
	include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p3_webpages.php');
elseif($tipos=='audio' or $tipos=='video' or $tipos=='image' or $tipos=='zip' or $tipos=='docs' ): // documents , audio, video, image, zip
	include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p3_files.php');
else:
	//not supposed to
	echo 'Error processing files.(add contents P3)';
endif;
?>