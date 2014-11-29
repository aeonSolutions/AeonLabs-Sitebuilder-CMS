<?php
include($local_root.'general/staticvars.php');
$link=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
mysql_select_db($db->name);
mysql_query("drop table setup_sessions, setup_users");
mysql_close($link);
?>