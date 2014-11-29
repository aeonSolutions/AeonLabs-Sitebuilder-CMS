<?php
/*
File revision date: 27-Nov-2008
*/
//sessions management
ob_start(); 
header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache");
header("Cache-control: private"); //IE 6 Fix for sessions
if (isset($_GET['SID'])): // if i have a SID the user is authenticated on the website
	$sid=@$_GET['SID'];
	session_id($_GET['SID']);
	session_start();
else:
	session_id(md5( uniqid( rand () ) ));
	session_start();
	$sid='Null';
endif;
include_once('general/db_class.php');
include ('kernel/staticvars.php');
$task='';
$task=@$_GET['id'];
if(isset($_COOKIE['cookid'])&& !isset($_COOKIE['cookname'])):// only cookie with SID is set - ecommerce module for instante 
	$sid=$_COOKIE['cookid'];
	session_id($sid);
	session_start();
endif;
$session=is_array($_SESSION['user']);
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid']) and ($session===true)):// cookies are set
	$sid=$_COOKIE['cookid'];
	session_id($sid);
	session_start();
	$staticvars['users']['sid']=session_id();// session id	
	sleep(1);
	$_SESSION['user']=$_COOKIE['cookname'];
endif;
if (isset($_GET['logout'])):
	if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])):
         setcookie("cookname", "", time()-$staticvars['cookies']['expire'], $staticvars['cookies']['path']);
         setcookie("cookid",   "", time()-$staticvars['cookies']['expire'], $staticvars['cookies']['path']);
		 unset($_COOKIE['cookname']);
		 unset($_COOKIE['cookid']);
    endif;
	session_destroy(); 
	$_SESSION = array(); 
	session_id(md5( uniqid( rand () ) ));
	session_start();
endif;
?>
