<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from polls");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `polls` (
`cod_poll` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`questions` TEXT NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?',
`cod_user` SMALLINT NOT NULL ,
`votes` VARCHAR( 50 ) NOT NULL ,
`data` TIMESTAMP NOT NULL 
) ENGINE = MYISAM");
endif;
mysql_close($linker);
?>