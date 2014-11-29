<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from formacao_curso");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `formacao_curso` (
`cod_curso` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_categoria` INT NOT NULL ,
`objectivos` TEXT NOT NULL ,
`conteudos` TEXT NOT NULL ,
`regalias` TEXT NOT NULL ,
`duracao` INT NOT NULL ,
`horario` TEXT NOT NULL ,
`titulo` VARCHAR( 255 ) NOT NULL ,
`local` VARCHAR( 255 ) NOT NULL ,
`data_inicio` DATE NOT NULL ,
`destinatarios` TEXT NOT NULL ,
`curso_code` VARCHAR( 50 ) NOT NULL ,
`descricao` TEXT NOT NULL ,
`habilitacoes` VARCHAR( 50 ) NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL ,
`idade` SMALLINT NOT NULL 
) ENGINE = MYISAM");
endif;
$result=mysql_query("select * from formacao_categorias");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `formacao_categorias` (
`cod_categoria` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`nome` VARCHAR( 255 ) NOT NULL ,
`descricao` VARCHAR( 255 ) NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?',
`cod_sub_cat` SMALLINT NOT NULL ,
) ENGINE = MYISAM ");
endif;
mysql_close($linker);
?>