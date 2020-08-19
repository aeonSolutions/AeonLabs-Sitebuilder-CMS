<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$linker):
   echo 'Could not connect to mysql';
   exit;
endif;

$result=mysql_select_db($db->name);

$result=mysql_query("select * from congress_revision_paper");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_revision_paper` (
`cod_revision` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_abs` INT NOT NULL ,
`cod_paper` INT NOT NULL ,
`cod_revisor` INT NOT NULL ,
`revision_data` TIMESTAMP NOT NULL ,
`accepted` VARCHAR( 1 ) NOT NULL ,
`subject_topic` VARCHAR( 255 ) NOT NULL ,
`originality` VARCHAR( 255 ) NOT NULL ,
`tech_quality` VARCHAR( 255 ) NOT NULL ,
`clarity` VARCHAR( 255 ) NOT NULL ,
`importance` VARCHAR( 255 ) NOT NULL ,
`title` VARCHAR( 255 ) NOT NULL ,
`language` VARCHAR( 255 ) NOT NULL ,
`abstract` VARCHAR( 255 ) NOT NULL ,
`presentation` VARCHAR( 255 ) NOT NULL ,
`illustrations` VARCHAR( 255 ) NOT NULL ,
`tables` VARCHAR( 255 ) NOT NULL ,
`afu` VARCHAR( 255 ) NOT NULL ,
`references` VARCHAR( 255 ) NOT NULL ,
`grading` VARCHAR( 255 ) NOT NULL ,
`recomendation` VARCHAR( 255 ) NOT NULL ,
`signature` VARCHAR( 255 ) NOT NULL ,
`comment_authors` TEXT NOT NULL ,
`comment_editors` TEXT NOT NULL
) ENGINE = MYISAM");

endif;

$result=mysql_query("select * from congress_revision_abs");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_revision_abs` (
  `cod_abs` int(11) NOT NULL,
  `comments` text collate latin1_general_ci NOT NULL,
  `revision_data` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `nome` varchar(200) collate latin1_general_ci NOT NULL,
  `accepted` varchar(1) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci");

endif;

$result=mysql_select_db($db->name);
$result=mysql_query("select * from congress_users");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_users` (
`cod_user` INT NOT NULL ,
`title` VARCHAR( 10 ) NOT NULL ,
`nome` VARCHAR( 200 ) NOT NULL ,
`affiliation` VARCHAR( 200 ) NOT NULL ,
`address1` VARCHAR( 200 ) NOT NULL ,
`address2` VARCHAR( 200 ) NOT NULL ,
`city` VARCHAR( 90 ) NOT NULL ,
`country` VARCHAR( 50 ) NOT NULL ,
`postal` VARCHAR( 10 ) NOT NULL ,
`phone` VARCHAR( 20 ) NOT NULL ,
`fax` VARCHAR( 20 ) NOT NULL
) ENGINE = MYISAM");

endif;
$result=mysql_query("select * from congress_abstracts");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_abstracts` (
`cod_abstract` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_user` INT NOT NULL ,
`cod_theme` SMALLINT NOT NULL ,
`file` VARCHAR( 255 ) NOT NULL ,
`title` VARCHAR( 255 ) NOT NULL ,
`keywords` TEXT NOT NULL ,
`authors` TEXT NOT NULL ,
`abstract` TEXT NOT NULL ,
`data` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`revised` VARCHAR( 1 ) NOT NULL DEFAULT 'n',
`revision_data` TIMESTAMP NOT NULL ,
 `sub_abstract` INT NOT NULL DEFAULT '0',
 `active` VARCHAR( 1 ) NOT NULL
) ENGINE = MYISAM");

endif;
$result=mysql_query("select * from congress_papers");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_papers` (
`cod_paper` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_user` INT NOT NULL ,
`cod_abstract` INT NOT NULL ,
`cod_theme` SMALLINT NOT NULL ,
`file` VARCHAR( 255 ) NOT NULL ,
`data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`revised` VARCHAR( 1 ) NOT NULL DEFAULT 'n',
`revision_data` TIMESTAMP NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL
) ENGINE = MYISAM");

endif;
$result=mysql_query("select * from congress_category");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_category` (
  `cod_category` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(100) collate latin1_general_ci NOT NULL,
  `translations` varchar(255) collate latin1_general_ci NOT NULL,
  `priority` tinyint(4) NOT NULL
) ENGINE=MyISAM");

endif;
$result=mysql_query("select * from congress_dl_category");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_dl_category` (
`cod_category` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`titulo` VARCHAR( 255 ) NOT NULL ,
`descricao` TEXT NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL
) ENGINE = MYISAM");

endif;
$result=mysql_query("select * from congress_download");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_download` (
`cod_download` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_category` SMALLINT NOT NULL ,
`ficheiro` VARCHAR( 255 ) NOT NULL ,
`nome` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM");

endif;
$result=mysql_query("select * from congress_menu");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_menu` (
`cod_menu` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 200 ) NOT NULL ,
`priority` SMALLINT NOT NULL ,
`cod_category` SMALLINT NOT NULL ,
`cod_module` SMALLINT NOT NULL
) ENGINE = MYISAM");

endif;

$result=mysql_query("select * from congress_themes");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_themes` (
`cod_theme` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_topic` SMALLINT NOT NULL ,
`name` VARCHAR( 255 ) NOT NULL ,
`reference` VARCHAR( 40 ) NOT NULL ,
`translations` TEXT NOT NULL
) ENGINE = MYISAM");

endif;

$result=mysql_query("select * from congress_revisor");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `congress_revisor` (
`cod_revisor` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_user` SMALLINT NOT NULL ,
`cod_theme` SMALLINT NOT NULL
) ENGINE = MYISAM");

endif;

mysql_close($linker);

// create user groups
$db->setquery("insert into user_type set name='revisor', cod_user_group='".$auth_code."'");
$db->setquery("insert into user_type set name='secretariado', cod_user_group='".$auth_code."'");
$db->setquery("insert into user_type set name='gestorcongresso', cod_user_group='".$auth_code."'");

// create direcories needed
if (!is_dir($staticvars['upload'].'/congress')):
	@mkdir($staticvars['upload'].'/congress', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/congress/abstracts')):
	@mkdir($staticvars['upload'].'/congress/abstracts', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/congress/abstracts/reviews')):
	@mkdir($staticvars['upload'].'/congress/abstracts/reviews', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/congress/papers')):
	@mkdir($staticvars['upload'].'/congress/papers', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/congress/papers/reviews')):
	@mkdir($staticvars['upload'].'/congress/papers/reviews', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/congress/downloads')):
	@mkdir($staticvars['upload'].'/congress/downloads', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/congress/system/logo')):
	@mkdir($staticvars['upload'].'/congress/system/logo', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/congress/system/logo/original')):
	@mkdir($staticvars['upload'].'/congress/system/logo/original', 0755, true);
endif;

?>