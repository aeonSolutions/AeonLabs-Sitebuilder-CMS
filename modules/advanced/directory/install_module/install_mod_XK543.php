<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from items");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `items` (
  `cod_item` bigint(20) NOT NULL auto_increment,
  `cod_user` bigint(20) NOT NULL default '0',
  `cod_category` bigint(20) NOT NULL default '0',
  `cod_items_types` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL default '',
  `descricao` text NOT NULL,
  `content` text NOT NULL,
  `active` char(1) NOT NULL default '?',
  `data` timestamp(14) NOT NULL,
  `downloads` bigint(5) NOT NULL default '0',
  `downloads_today` bigint(5) NOT NULL default '0',
  `today` smallint(6) NOT NULL default '0',
  `tipo` varchar(9) NOT NULL default 'software',
  `votacao` double NOT NULL default '3',
  `num_votos` double NOT NULL default '0',
  `imagem` varchar(255) NOT NULL default 'no_img.jpg',
  `visible_to` int(11) NOT NULL default '3',
  PRIMARY KEY  (`cod_item`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
endif;
$result=mysql_query("select * from items_types");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `items_types` (
	`cod_items_types` INT NOT NULL auto_increment,
	`nome` VARCHAR( 255 ) NOT NULL ,
	`tipos` VARCHAR( 255 ) NOT NULL ,
	`extensions_allowed` VARCHAR( 255 ) NOT NULL DEFAULT 'none',
	`actions` VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY ( `cod_items_types` ) 
	) ENGINE = MYISAM ;
	");
endif;
$result=mysql_query("select * from category");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `category` (
  `cod_category` int(11) NOT NULL auto_increment,
  `cod_user_type` smallint(6) NOT NULL default '0',
  `display_name` char(255) NOT NULL,
  `cod_sub_cat` int(11) NOT NULL default '0',
  `active` char(1) NOT NULL default 's',
  `visitors` bigint(20) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`cod_category`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
endif;        
$result=mysql_query("select * from items_comments");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `items_comments` (
  `cod_comment` bigint(20) NOT NULL auto_increment,
  `cod_item` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `data` date NOT NULL default '0000-00-00',
  `cod_user` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`cod_comment`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
endif;
mysql_close($linker);
// create direcories needed
if (!is_dir($staticvars['upload'].'/items')):
	mkdir($staticvars['upload'].'/items', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/items/images')):
	mkdir($staticvars['upload'].'/items/images', 0755, true);
endif;
?>