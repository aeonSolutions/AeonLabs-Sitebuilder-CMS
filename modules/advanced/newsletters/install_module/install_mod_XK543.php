<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from newsletters");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `newsletters` (
	`cod_newsletter` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`content` TEXT NOT NULL ,
	`active` VARCHAR( 1 ) NOT NULL
	) ENGINE = MYISAM ");
endif;
$result=mysql_query("select * from newsletters_users");
if (mysql_error()): // table not found
	mysql_query("CREATE TABLE `newsletters_users` (
	`cod_user` BIGINT NOT NULL DEFAULT '0',
	`email` VARCHAR( 255 ) NOT NULL
	) ENGINE = MYISAM");
endif;
mysql_close($linker);
?>