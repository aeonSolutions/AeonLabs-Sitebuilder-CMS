<?php
// returns the current hard drive directory not the root directory
$path=explode("/",__FILE__);
$local=$path[0];
for ($i=1;$i<count($path)-1;$i++):
	$local=$local.'/'.$path[$i];
endfor;
$local=$local.'/';
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from forum_cats");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `forum_cats` (
  `cod_cat` bigint(20) NOT NULL auto_increment,
  `titulo` varchar(255) NOT NULL default '',
  `active` char(1) NOT NULL default 's',
  PRIMARY KEY  (`cod_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ");
endif;
$result=mysql_query("select * from forum_topic");
if (mysql_error()): // table not found
	mysql_query("CREATE TABLE `forum_topic` (
  `cod_topic` bigint(20) NOT NULL auto_increment,
  `cod_forum` bigint(20) NOT NULL default '0',
  `assunto` varchar(255) NOT NULL default '',
  `mensagem` text NOT NULL,
  `views` double NOT NULL default '0',
  `reply_to` bigint(11) NOT NULL default '0',
  `cod_user` bigint(20) NOT NULL default '0',
  `data` timestamp(14) NOT NULL,
  `emoticons` char(1) NOT NULL default '',
  `num_views` double NOT NULL default '0',
  `locked` char(1) NOT NULL default 'n',
  PRIMARY KEY  (`cod_topic`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
endif;
$result=mysql_query("select * from forum_forum");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `forum_forum` (
  `cod_forum` bigint(20) NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL default '',
  `Descricao` varchar(255) NOT NULL default '',
  `active` char(1) NOT NULL default 's',
  `auto_pruning` char(1) NOT NULL default 's',
  `remove_topics` int(11) NOT NULL default '0',
  `check_topics` int(11) NOT NULL default '0',
  `cod_cat` bigint(20) NOT NULL default '0',
  `num_posts` double NOT NULL default '0',
  PRIMARY KEY  (`cod_forum`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
endif;
mysql_close($linker);
?>