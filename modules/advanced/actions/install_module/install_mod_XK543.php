<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from stats_referral");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `stats_referral` (
  `cod_ref` bigint(20) NOT NULL auto_increment,
  `link` varchar(255) NOT NULL default '',
  `contador` double NOT NULL default '0',
  `total` double NOT NULL default '0',
  `dia` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`cod_ref`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ");
endif;
   
mysql_close($linker);
?>