<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from livros");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `livros` (
`cod_livro` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`imagem` VARCHAR( 255 ) NOT NULL ,
`preco` INT NOT NULL ,
`titulo` VARCHAR( 255 ) NOT NULL ,
`descricao` TEXT NOT NULL ,
`editora` VARCHAR( 255 ) NOT NULL ,
`editora_link` VARCHAR( 255 ) NOT NULL ,
`link_compra` VARCHAR( 255 ) NOT NULL ,
`active` VARCHAR( 2 ) NOT NULL DEFAULT '?',
`email` VARCHAR( 255 ) NOT NULL 
) ENGINE = MYISAM ");
endif;
mysql_close($linker);
// create direcories needed
if (!is_dir($staticvars['upload'].'/books')):
	mkdir($staticvars['upload'].'/books');
endif;
if (!is_dir($staticvars['upload'].'/books/images')):
	mkdir($staticvars['upload'].'/books/images');
endif;
?>