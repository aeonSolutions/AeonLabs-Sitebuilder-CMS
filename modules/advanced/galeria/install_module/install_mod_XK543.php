<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from galeria");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `galeria` (
`cod_galeria` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`titulo` VARCHAR( 255 ) NOT NULL ,
`descricao` TEXT NOT NULL ,
`imagem` VARCHAR( 255 ) NOT NULL ,
`cod_categoria` SMALLINT NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?'
) ENGINE = MYISAM");
endif;
$result=mysql_query("select * from galeria_categorias");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `galeria_categorias` (
`cod_categoria` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`nome` VARCHAR( 255 ) NOT NULL ,
`descricao` VARCHAR( 255 ) NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?'
) ENGINE = MYISAM ");
endif;
mysql_close($linker);
// create direcories needed
if (!is_dir($staticvars['upload'].'/galeria')):
	mkdir($staticvars['upload'].'/galeria');
endif;
if (!is_dir($staticvars['upload'].'/galeria/images')):
	mkdir($staticvars['upload'].'/galeria/images');
endif;
if (!is_dir($staticvars['upload'].'/galeria/images/original')):
	mkdir($staticvars['upload'].'/galeria/images/original');
endif;
?>