<?php
/*
File revision date: 8-dez-2008
*/
if ( !defined('ON_SiTe')):
	echo 'not for direct access';
	exit;
endif;
$tmp=glob($staticvars['local_root']."modules/advertising/formats/180x150/*.php");
$file_in_dir='';
if (isset($tmp[0])):
	$file_in_dir=$tmp;
endif;						
$tmp=glob($staticvars['local_root']."modules/advertising/formats/180x150/*.htm");
if (isset($tmp[0])):
	if ($file_in_dir==''):
		$file_in_dir=$tmp;
	else:
		$file_in_dir=array_merge($file_in_dir,$tmp);
	endif;
endif;						
$tmp=glob($staticvars['local_root']."modules/advertising/formats/180x150/*.html");
if (isset($tmp[0])):
	if ($file_in_dir==''):
		$file_in_dir=$tmp;
	else:
		$file_in_dir=array_merge($file_in_dir,$tmp);
	endif;
endif;						
include($file_in_dir[rand(0,count($file_in_dir)-1)]);
?>

