<?php
$task=@$_GET['id'];
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
@session_start();
include('../../../kernel/staticvars.php');
@include_once('../../../general/SID.php');
$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
if ($admin_code[0][0]<>''):
	$admin_code=$admin_code[0][0];
else:
	$admin_code=-1;
endif;
if (isset($_SESSION['user'])):
	$auth_user=$db->getquery("select cod_user_type from users where nick='".mysql_escape_string($_SESSION['user'])."'");
	if ($auth_user[0][0]<>''):
		$auth_user=$auth_user[0][0];
	else:
		$auth_user=-2;
	endif;
else:
	$auth_user=-2;
endif;
if ($auth_user<>$admin_code): // not administrator
	echo 'Error 1';
	exit;
endif;
$link=session($staticvars,'index.php?id='.$task);
if (isset($_POST['lock'])):
	$db->setquery("update forum_topic set locked='s' where cod_topic='".mysql_escape_string($_POST['cod_topic'])."'");
	$view=@$_GET['view'];
	$link=session($staticvars,'../../../index.php?id='.$task.'&view='.$view);
elseif(isset($_POST['unlock'])):
	$db->setquery("update forum_topic set locked='n' where cod_topic='".mysql_escape_string($_POST['cod_topic'])."'");
	$view=@$_GET['view'];
	$link=session($staticvars,'../../../index.php?id='.$task.'&view='.$view);
elseif(isset($_POST['apagar'])):
	$forum=$db->getquery("select cod_forum,reply_to from forum_topic where cod_topic='".mysql_escape_string($_POST['cod_topic'])."'");
	$db->setquery("delete from forum_topic where cod_topic='".mysql_escape_string($_POST['cod_topic'])."'");
	$db->setquery("delete from forum_topic where reply_to='".mysql_escape_string($_POST['cod_topic'])."'");
	if($forum[0][1]=='0'):
		$code=mysql_escape_string($_POST['cod_topic']);
	else:
		$code=$forum[0][1];
	endif;
	$verify=$db->getquery("select cod_forum from forum_topic where cod_topic='".$code."'");
	if ($verify[0][0]<>''):
		$topic=@$_GET['topic'];
		$link=session($staticvars,'../../../index.php?id='.$task.'&topic='.$topic);
	else:
		$link=session($staticvars,'../../../index.php?id='.$task.'&view='.$forum[0][0]);
	endif;
endif;

header("Location:".$link);
?>


