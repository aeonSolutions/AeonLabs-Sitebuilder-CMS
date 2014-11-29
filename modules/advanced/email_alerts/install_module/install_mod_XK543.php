<?php
include($staticvars['local_root'].'kernel/staticvars.php');
$linker=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql';
   exit;
endif;
$result=mysql_select_db($db->name);
$result=mysql_query("select * from alerts_users");
if (mysql_error()): // table not found
	$result=mysql_query("CREATE TABLE `alerts_users` (
  `cod_alerts_users` bigint(20) NOT NULL auto_increment,
  `cod_alerts` bigint(20) NOT NULL,
  `cod_user` bigint(20) NOT NULL,
  PRIMARY KEY  (`cod_alerts_users`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
endif;
$result=mysql_query("select * from alerts");
if (mysql_error()): // table not found
	mysql_query("CREATE TABLE `alerts` (
  `cod_alerts` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text  NOT NULL,
  `active` varchar(1) NOT NULL default 's',
  `linked_to` varchar(255)  NOT NULL default 'no_link',
  `info` varchar(255)  NOT NULL
) ENGINE=MyISAM");
endif;
$result=mysql_query("select * from items");
if (!mysql_error()): // items table found
	mysql_query("INSERT INTO `alerts` VALUES (1, 'vara&ccedil;&otilde;es novas de Software', 'sempre que é adicionada uma nova vara&ccedil;&atilde;o de software no directório ser-lhe-&aacute; enviado um email de aviso.', 's', 'items', 'software')");
	mysql_query("INSERT INTO `alerts` VALUES (2, 'vara&ccedil;&otilde;es novas de Documentos', 'sempre que é adicionada uma nova vara&ccedil;&atilde;o de documentos no directório ser-lhe-&aacute; enviado um email de aviso', 's', 'items', 'documents')");
endif;
mysql_close($linker);

?>