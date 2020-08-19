<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from produtos");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `produtos` (
`cod_produto` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`titulo` VARCHAR( 255 ) NOT NULL ,
`descricao` TEXT NOT NULL ,
`short_descricao` VARCHAR( 255 ) NOT NULL ,
`imagem` VARCHAR( 255 ) NOT NULL ,
`catalogo` VARCHAR( 255 ) NOT NULL ,
`preco` FLOAT NOT NULL ,
`cod_desconto` SMALLINT NOT NULL ,
`cod_iva` SMALLINT NOT NULL ,
`stock` INT NOT NULL ,
`prazo_entrega` INT NOT NULL ,
`ref_produto` VARCHAR( 50 ) NOT NULL ,
`cod_categoria` SMALLINT NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?'
) ENGINE = MYISAM");
endif;
$result=mysql_query("select * from produtos_iva");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `produtos_iva` (
`cod_iva` SMALLINT NOT NULL AUTO_INCREMENT ,
`valor` INT NOT NULL ,
`descricao` VARCHAR( 255 ) NOT NULL ,
UNIQUE (
`cod_iva` 
)
) ENGINE = MYISAM ");
endif;
$result=mysql_query("select * from produtos_desconto");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `produtos_desconto` (
`cod_desconto` SMALLINT NOT NULL AUTO_INCREMENT ,
`valor` VARCHAR( 5 ) NOT NULL ,
`descricao` VARCHAR( 255 ) NOT NULL ,
UNIQUE (
`cod_desconto` 
)
) ENGINE = MYISAM");
endif;
$result=mysql_query("select * from produtos_categorias");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `produtos_categorias` (
`cod_categoria` SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cod_sub_cat` SMALLINT NOT NULL ,
`nome` VARCHAR( 255 ) NOT NULL ,
`descricao` VARCHAR( 255 ) NOT NULL ,
`active` VARCHAR( 1 ) NOT NULL DEFAULT '?'
) ENGINE = MYISAM ");
endif;
mysql_close($linker);
// create direcories needed
if (!is_dir($staticvars['upload'].'/produtos')):
	mkdir($staticvars['upload'].'/produtos', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/produtos/images')):
	mkdir($staticvars['upload'].'/produtos/images', 0755, true);
endif;
if (!is_dir($staticvars['upload'].'/produtos/images/original')):
	mkdir($staticvars['upload'].'/produtos/images/original', 0755, true);
endif;
?>