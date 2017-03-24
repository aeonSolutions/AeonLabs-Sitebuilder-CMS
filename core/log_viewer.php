<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$_SESSION['cerr']=array();
if(!function_exists('strip_address')):
	include_once($globvars['local_root'].'copyfiles/advanced/kernel/functions.php');
endif;
if(is_file($globvars['local_root'].'tmp/error_log_man.php')):
	if(is_file($globvars['local_root'].'tmp/error_log_man.php')):
		include($globvars['local_root'].'tmp/error_log_man.php');
	endif;
	echo '<div align="right"><a href="'.strip_address("log", $_SERVER['REQUEST_URI']).'">Exit ERROR Log Report</a></div>';
	echo '<br />PARSING LOG FILE:<hr size="1"><br />';
	for($i=0;$i<count($datetime);$i++):
		echo date('H:i:s e (m.y)',$datetime[$i]).'<br />';
		echo 'LINE [ '.$scriptlinenum[$i].' ]   Script:'.$scriptname[$i].'<br />';
		echo chr('\t').$errormsg[$i].'<br />';
		echo '<hr size="1">';
	endfor;
else:
	$globvars['warnings']='Log file entries not found!';
	$globvars['error']['type']='info';// type in {exclamation, question, info, prohibited}
	$_SESSION['cerr']==false;
	sleep(1);
	header("Location: ".strip_address("log", $_SERVER['REQUEST_URI']));
endif;
?>