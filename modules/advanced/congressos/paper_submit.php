<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['submit_btn'])):
	include($staticvars['local_root'].'modules/congressos/update_db/papers.php');
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
if(isset($_SESSION['status'])):
	$_SESSION['status']=array();
	unset($_SESSION['status']);
	echo $_SESSION['status'];
	include($staticvars['local_root'].'modules/congressos/system/paper_success.php');
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
	if($current<$ps and $current>$sa or $ovr_paper==true):
		if(isset($_POST['submit_paper'])  or isset($_POST['submit_btn']) or isset($_SESSION['status'])):// paper submit form
			include($staticvars['local_root'].'modules/congressos/system/paper_submit.php');
		else:
			include($staticvars['local_root'].'modules/congressos/system/paper_submit_entry_page.php');
		endif;
	elseif($current<$sa):
		include($staticvars['local_root'].'modules/congressos/system/paper_not_enabled.php');
	elseif($current>$ps):
		if($ovr_paper==true):
			if(isset($_POST['submit_paper']) or isset($_POST['submit_btn']) or isset($_SESSION['status'])):// paper submit form
				include($staticvars['local_root'].'modules/congressos/system/paper_submit.php');
			else:
				include($staticvars['local_root'].'modules/congressos/system/paper_submit_entry_page.php');
			endif;
		else:
			include($staticvars['local_root'].'modules/congressos/system/paper_expired.php');
		endif;
	endif;
else:
 	include($staticvars['local_root'].'modules/congressos/system/paper_expired.php');
endif;
?>
