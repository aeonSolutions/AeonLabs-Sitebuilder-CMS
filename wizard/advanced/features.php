<?php
/*
File revision date: 4-set-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

$txt='';
if (isset($_POST['el'])):
	$txt="include("."$"."staticvars['local_root'].'kernel/error_logging.php');".chr(13);
    if (!is_file($globvars['site']['directory'].'kernel/error_logging.php')):
        copy($globvars['local_root'].'copyfiles/advanced/features/error_logging.php', $globvars['site']['directory'].'kernel/error_logging.php');
    endif;
else:
    if (is_file($globvars['site']['directory'].'kernel/error_logging.php')):
        unlink($globvars['site']['directory'].'kernel/error_logging.php');
    endif;
endif;

include($globvars['site']['directory'].'kernel/staticvars.php');
if (isset($_POST['stats'])):
	$query=$db->getquery("SHOW TABLES LIKE 'usercountertoday'");
	if ($query[0][0]==''):	
		$db->setquery("CREATE TABLE `usercountertoday` (
		  `ip` varchar(15) NOT NULL default '',
		  `day` char(2) NOT NULL default '',
		  UNIQUE KEY `ip` (`ip`)
		) ENGINE=MyISAM");
		
		$db->setquery("CREATE TABLE `usercountertotal` (
		  `day` char(2) NOT NULL default '',
		  `total` varchar(18) NOT NULL default ''
		) ENGINE=MyISAM");
		
		$db->setquery("INSERT INTO `usercountertotal` VALUES ('19', '4')");
		
		$db->setquery("CREATE TABLE `useronline` (
		  `timestamp` int(15) NOT NULL default '0',
		  `ip` varchar(40) NOT NULL default '',
		  `tipo` varchar(100) NOT NULL default '',
		  PRIMARY KEY  (`timestamp`),
		  KEY `ip` (`ip`),
		  KEY `file` (`tipo`)
		) ENGINE=MyISAM");
		
		$db->setquery("INSERT INTO `useronline` VALUES (1112791764, '127.0.0', 'R')");
		$db->setquery("INSERT INTO `useronline` VALUES (1112791763, '127.0.0', 'R')");
		$db->setquery("INSERT INTO `useronline` VALUES (1112791762, '127.0.0', 'R')");
	endif;
    if (!is_file($globvars['site']['directory'].'kernel/stats_management.php')):
        copy($globvars['local_root'].'copyfiles/advanced/features/stats_management.php', $globvars['site']['directory'].'kernel/stats_management.php');
    endif;
	if($txt<>''):
		$txt.="include("."$"."staticvars['local_root'].'kernel/stats_management.php');".chr(13);
	else:
		$txt="include("."$"."staticvars['local_root'].'kernel/stats_management.php');".chr(13);
	endif;
else:
	$query=$db->getquery("SHOW TABLES LIKE 'usercountertoday'");
	if ($query[0][0]<>''):	
    	$db->setquery("drop table usercountertoday, usercountertotal, useronline ");
    endif;
	if (is_file($globvars['site']['directory'].'kernel/stats_management.php')):
        unlink($globvars['site']['directory'].'kernel/stats_management.php');
    endif;
endif;

if (isset($_POST['sp'])):
	$query=$db->getquery("SHOW TABLES LIKE 'search_spiders'");
	if ($query[0][0]==''):	
		$db->setquery("CREATE TABLE `search_spiders` (
		  `id` int(10) NOT NULL auto_increment,
		  `number` int(10) NOT NULL default '0',
		  `keywords` varchar(255) NOT NULL default '',
		  `month` int(2) NOT NULL default '0',
		  `year` int(4) NOT NULL default '0',
		  PRIMARY KEY  (`id`),
		  KEY `keywords_2` (`keywords`)
		) ENGINE=MyISAM AUTO_INCREMENT=1");
	endif;
    if (!is_file($globvars['site']['directory'].'kernel/search_spiders.php')):
        copy($globvars['local_root'].'copyfiles/advanced/features/search_spiders.php', $globvars['site']['directory'].'kernel/search_spiders.php');
    endif;
	if($txt<>''):
		$txt.="include("."$"."staticvars['local_root'].'kernel/search_spiders.php');".chr(13);
	else:
		$txt="include("."$"."staticvars['local_root'].'kernel/search_spiders.php');".chr(13);
	endif;
else:
	$query=$db->getquery("SHOW TABLES LIKE 'search_spiders'");
	if ($query[0][0]<>''):	
	    $db->setquery("drop table 'search_spiders'");
	endif;
	if (is_file($globvars['site']['directory'].'kernel/search_spiders.php')):
        unlink($globvars['site']['directory'].'kernel/search_spiders.php');
    endif;
endif;

if (isset($_POST['save'])):
	$file_content='
	<?PHP
	// WebPage Features
	'.$txt.'
	?>';
	$filename=$globvars['site']['directory'].'kernel/features.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
	echo '<font class="body_text"> <font color="#FF0000">Success. Settings Saved.</font></font><br />';
	include($globvars['local_root'].'buildfiles/build.php');

	header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;
endif;
if(is_file($globvars['site']['directory'].'kernel/search_spiders.php')):
	$chk[0]=' checked="checked"';
else:
	$chk[0]='';
endif;
if(is_file($globvars['site']['directory'].'kernel/stats_management.php')):
	$chk[1]=' checked="checked"';
else:
	$chk[1]='';
endif;
if(is_file($globvars['site']['directory'].'kernel/error_logging.php')):
	$chk[2]=' checked="checked"';
else:
	$chk[2]='';
endif;

?>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="85%">
		<form class="form" method="post" name="general_settings" action=""  enctype="multipart/form-data">
		  <table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
			  <td colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$site_path;?>//images/design.jpg">&nbsp;Features
			    <hr size="1" color="#666666" /></td>
			</tr>
			<tr>
			  <td colspan="2" class="body_text"><p><strong>WebSite Features </strong><br />
				  <br />
				  <input name="sp" type="checkbox" id="sp" value="checkbox" <?=$chk[0];?>/>
				  <font style="font-size:12px"><strong>Search Spiders</strong></font> 
				  <br />
			    <font style="font-size:11px">The Search Spiders feature enables site redirectioning of search robots to a more rich content site page. </font></p>
				<p>
				  <input name="stats" type="checkbox" id="stats" value="checkbox" <?=$chk[1];?>/>
				  <font style="font-size:12px"><strong>WebSite Statistics</strong></font> <br />
				  <font style="font-size:11px">This feature allows you to monitor website statisticas such as the webpage visitors.</font>  </p>
				<p>
				  <input name="el" type="checkbox" id="el" value="checkbox" <?=$chk[2];?>/>
                  <font style="font-size:12px"><strong>Error Logging</strong></font> <br />
                  <font style="font-size:11px">The Error Log feature allow you to save to a text file script error that might occur, without prompting them to the browser. for Debug purposes only. should be deactivated for site performance. </font></p></td>
			</tr>
			
			<tr>
			  <td height="15"></td>
			</tr>
			<tr>
			  <td height="15"></td>
			</tr>
			<tr>
			  <td align="right" valign="bottom">
					<input type="submit" value="Save Settings" class="button" name="save"></td>
			</tr>
		  </table>
	    </form>
	</td>
    <td width="15%" align="left" valign="bottom">	</td>
  </tr>
</table>
