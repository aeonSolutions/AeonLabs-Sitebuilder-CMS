<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$link=mysql_connect($_SESSION['database']['host'], $_SESSION['database']['username'], $_SESSION['database']['password']);
	if (!$link):
		$globvars['warnings']='Could not connect to Database Server: Bad Root username/password?';
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			sleep(1);
			echo $globvars['warnings'];
			header("Location: ".$_SERVER['REQUEST_URI']);
		endif;
	endif;
if (!mysql_select_db($_SESSION['database']['name'])):
	$globvars['warnings']='Could not select DB <'.$_SESSION['database']['name'].'>';
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=false; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		sleep(1);
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
endif;
if(mysql_query("SHOW TABLES like 'module'")):
	mysql_query("DROP TABLE IF EXISTS module, skin_layout");
endif;
if (mysql_error()):
	$globvars['warnings']='MySQL Err.:'.mysql_error();
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		sleep(1);
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
endif;
mysql_query("CREATE TABLE module (
  `cod_module` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `published` char(1) NOT NULL default '',
  `cod_user_type` int(11) NOT NULL default '4',
  `self_skin` char(3) NOT NULL default 'no',
  `aditional_params` varchar(255) NOT NULL default 'N/A',
  `box_code` bigint(20) NOT NULL default '0',
  `display_name` varchar(255) NOT NULL default '',
  `cod_skin` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`cod_module`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
if (mysql_error()):
	$globvars['warnings']='MySQL Err.:'.mysql_error();
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		sleep(1);
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
endif;

mysql_query("CREATE TABLE skin_layout (
  `cod_layout` int(11) NOT NULL auto_increment,
  `cod_skin` int(11) NOT NULL default '0',
  `cell` tinyint(4) NOT NULL default '0',
  `cod_module` int(11) NOT NULL default '0',
  `priority` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`cod_layout`)
) ENGINE=MyISAM AUTO_INCREMENT=1");
if (mysql_error()):
	$globvars['warnings']='MySQL Err.:'.mysql_error();
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		sleep(1);
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
endif;
mysql_close($link);
?>