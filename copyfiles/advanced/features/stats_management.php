<?php

/*
Referral Links management
*/
if ( !eregi(str_replace("http://", "", $staticvars['site_path']),@$_SERVER['HTTP_REFERER']) and (@$_SERVER['HTTP_REFERER']!="")):
	$today=date("d");
	if (isset($_GET['referral'])):
		$ref=$_GET['referral'];	
		$db->setquery("update user_student set downloads='10' where cod_user_student='".mysql_escape_string($ref)."'");
	endif;
	$linker=mysql_connect($db->host, $db->user, $db->password);
	if (!$linker):
	   echo 'Could not connect to mysql';
	   exit;
	endif;
	$result=mysql_select_db($db->name);
	$result=mysql_query("select * from stats_referral");
	if (!mysql_error()): // table not found
		mysql_close($linker);
		$referer=explode("/",$_SERVER['HTTP_REFERER']);
		$referer=$referer[2];
		$ref=$db->getquery("select cod_ref,contador,total,dia from stats_referral where link='".mysql_escape_string($referer)."'");
		if ($ref[0][0]<>''):
			if ($ref[0][3]<>$today):
				$db->setquery("update stats_referral set contador='1',dia='".$today."',
				total='".($ref[0][2]+1)."' where cod_ref='".$ref[0][0]."'");
			else:
				$db->setquery("update stats_referral set contador='".($ref[0][1]+1)."',dia='".$today."',
				total='".($ref[0][2]+1)."' where cod_ref='".$ref[0][0]."'");
			endif;
		else:
			$db->setquery("insert into stats_referral set contador='1', total='1', dia='".$today."',
			 link='".mysql_escape_string($referer)."'");
		endif;
	endif;
endif;
/*
Visitors management
*/
// PHP 5 only -> date_default_timezone_set('Europe/Lisbon');
setlocale(LC_TIME, 'pt_PT');
$today=date("d");
$ip = substr($_SERVER['REMOTE_ADDR'], 0, strrpos($_SERVER['REMOTE_ADDR'],"."));

// Connect to MySQL Database
@mysql_connect($db->host,$db->user,$db->password);
@mysql_select_db($db->name);

// Add this user to database
@mysql_query("insert into usercountertoday set ip='".$ip."', day='".$today."'");

// check date on usercountertotal
$result = mysql_query("select * from usercountertoday"); 
$count = @mysql_num_rows($result);
@mysql_free_result($result);

$result = @mysql_query("select * from usercountertotal"); 
$col = @mysql_fetch_array($result, MYSQL_NUM);
$totalday = $col[0];
$totalsum = $col[1];

if ($totalday != $today):
	mysql_query("delete from usercountertoday where day='$totalday'");
	mysql_query("delete from usercountertotal where day='$totalday'");
	$totalsum += $count;
	@mysql_query("insert into usercountertotal(day,total) values('$today','$totalsum')");
endif;

@mysql_free_result($result);
@mysql_close();
?>