<?php
/*
File revision date: 13-mar-2008
*/
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from publicacoes");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `publicacoes` (
  `cod_publicacao` bigint(20) NOT NULL auto_increment,
  `cod_user` bigint(20) NOT NULL default '0',
  `cod_categoria` bigint(20) NOT NULL default '0',  
  `title` varchar(100) NOT NULL default '',
  `texto` text NOT NULL,
  `data` timestamp(14) NOT NULL,
  `data_publicacao` timestamp(14) NOT NULL,
  `active` char(1) NOT NULL default 's',
  `short_description` VARCHAR( 255 ) NOT NULL ,
  `votacao` double NOT NULL default '3',
  `num_votos` double NOT NULL default '0',
  `lida` BIGINT NOT NULL ,
  PRIMARY KEY  (`cod_publicacao`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ");
endif;
$result=mysql_query("select * from publicacoes_categorias");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `publicacoes_categorias` (
`cod_categoria` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_sub_cat` SMALLINT NOT NULL ,
`nome` VARCHAR( 255 ) NOT NULL ,
`descricao` VARCHAR( 255 ) NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?'
) ENGINE = MYISAM ");
endif;
$result=mysql_query("select * from publicacoes_ficheiros");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `publicacoes_ficheiros` (
`cod_ficheiro` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_publicacao` SMALLINT NOT NULL ,
`ficheiro` VARCHAR( 255 ) NOT NULL ,
`descricao` VARCHAR( 255 ) NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?'
) ENGINE = MYISAM ");
endif;
$result=mysql_query("select * from publicacoes_comments");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `publicacoes_comments` (
  `cod_comment` bigint(20) NOT NULL auto_increment,
  `cod_publicacao` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `data` date NOT NULL default '0000-00-00',
  `cod_user` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`cod_comment`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
endif;

$result=mysql_query("select * from publicacoes_revisor");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `publicacoes_revisor` (
`cod_revision` MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_publicacao` MEDIUMINT NOT NULL ,
`cod_revisor` MEDIUMINT NOT NULL ,
`data` timestamp(14) NOT NULL,
`observacoes` TEXT NOT NULL
) ENGINE = MYISAM");
endif;

mysql_close($linker);
// create direcories needed

$db->setquery("insert into user_type set name='revisor & cat mng' cod_user_group='".$content_management."'");
$db->setquery("insert into user_type set name='revisor' cod_user_group='".$content_management."'");
$db->setquery("insert into user_type set name='publisher' cod_user_group='".$auth_code."'");

if (!is_dir($staticvars['upload'].'/publicacoes')):
	@mkdir($staticvars['upload'].'/publicacoes', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/publicacoes/images')):
	@mkdir($staticvars['upload'].'/publicacoes/images', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/publicacoes/ficheiros')):
	@mkdir($staticvars['upload'].'/publicacoes/ficheiros', 0755, true);
endif;
?>