<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from users");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `users` (
  `cod_user` int(11) NOT NULL auto_increment,
  `cod_user_type` int(11) NOT NULL default '0',
  `cod_css` int(11) NOT NULL default '0',
  `nome` varchar(200) NOT NULL default '',
  `email` varchar(200) NOT NULL default '',
  `data` timestamp(14) NOT NULL,
  `nick` varchar(25) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `active` char(1) NOT NULL default 'n',
  `cod_skin` int(11) NOT NULL default '0',
  `referral` char(1) NOT NULL default 'n',
  PRIMARY KEY  (`cod_user`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
mysql_query("INSERT INTO `users` ( `cod_user` , `cod_user_type` , `cod_css` , `nome` , `email` , `data` , `nick` , `password` , `active` , `cod_skin` ) VALUES ( NULL , '5', '0', 'gestao', '', NOW( ) , 'gestao', PASSWORD( '12345' ) , '1', '0') ");

endif;
$result=mysql_query("select * from user_type");
if (mysql_error()): // table not found
	mysql_query("CREATE TABLE `user_type` (
	  `cod_user_type` int(11) NOT NULL auto_increment,
	  `name` varchar(30) NOT NULL default '',
	  `cod_user_group` bigint(20) NOT NULL default '0',
	  PRIMARY KEY  (`cod_user_type`)
	) ENGINE=MyISAM AUTO_INCREMENT=2");
	mysql_query("INSERT INTO `user_type` VALUES (1, 'Administrators', 1)");
	mysql_query("INSERT INTO `user_type` VALUES (2, 'Guests', 2)");
	mysql_query("INSERT INTO `user_type` VALUES (3, 'Default', 3)");
	mysql_query("INSERT INTO `user_type` VALUES (4, 'Authenticated Users', 4)");
	mysql_query("INSERT INTO `user_type` VALUES (5, 'Content Management', 5)");
endif;
$result=mysql_query("select * from sessions");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `sessions` (
	  `session_id` varchar(32) NOT NULL default '',
	  `cod_user` bigint(20) NOT NULL default '0',
	  `data` timestamp NOT NULL) ENGINE=MyISAM");
endif;
mysql_close($linker);
?>