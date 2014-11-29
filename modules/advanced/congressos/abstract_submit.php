<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['submit_btn']) or isset($_POST['edit_abs'])):
	include($staticvars['local_root'].'modules/congressos/update_db/abstracts.php');
	session_write_close();
	sleep(1);
	header("Location: ".$_SERVER['REQUEST_URI']);
endif;

if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
if(isset($_SESSION['paper'])):
	echo '<font color="red">'.$_SESSION['paper'].'</font>';
	unset($_SESSION['paper']);
endif;
if(isset($_GET['success'])):
	include($staticvars['local_root'].'modules/congressos/system/abstract_success.php');
elseif(is_file($staticvars['local_root'].'modules/congressos/system/settings.php')):
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
	$tmp=explode("/",$sa);
	$sa_ano=$tmp[2];
	$sa_mes=$tmp[1];
	$sa_dia=$tmp[0];
	$tmp=explode("/",$na);
	$na_ano=$tmp[2];
	$na_mes=$tmp[1];
	$na_dia=$tmp[0];
	$tmp=explode("/",$sp);
	$sp_ano=$tmp[2];
	$sp_mes=$tmp[1];
	$sp_dia=$tmp[0];
	$tmp=explode("/",$np);
	$np_ano=$tmp[2];
	$np_mes=$tmp[1];
	$np_dia=$tmp[0];
	$tmp=explode("/",$rp);
	$rp_ano=$tmp[2];
	$rp_mes=$tmp[1];
	$rp_dia=$tmp[0];
	$sa=mktime(0,0,0,$sa_mes,$sa_dia,$sa_ano);
	$current=time();
	$ps=mktime(0,0,0,$sp_mes,$sp_dia,$sp_ano);
	if($current<=$sa or $ovr_abs==true):
		include($staticvars['local_root'].'modules/congressos/system/abstract_submit.php');
	elseif($current>$sa):
		include($staticvars['local_root'].'modules/congressos/system/abstract_expired.php');
	endif;
else:
 	include($staticvars['local_root'].'modules/congressos/system/abstract_expired.php');
endif;
?>
