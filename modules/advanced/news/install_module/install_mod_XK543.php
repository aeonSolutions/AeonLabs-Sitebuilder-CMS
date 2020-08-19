<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from news");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `news` (
  `cod_news` bigint(20) NOT NULL auto_increment,
  `cod_user` bigint(20) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `texto` text NOT NULL,
  `data` timestamp(14) NOT NULL,
  `emoticons` tinyint(4) NOT NULL default '1',
  `image` varchar(255) NOT NULL default '',
  `active` char(1) NOT NULL default 's',
  PRIMARY KEY  (`cod_news`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ");
endif;
mysql_close($linker);
// create direcories needed
if (!is_dir($upload_directory.'/news/images')):
	@mkdir($upload_directory.'/news/images', 0755, true);
endif;
if (!is_dir($upload_directory.'/news')):
	@mkdir($upload_directory.'/news', 0755, true);
endif;
?>