<?php
session_id('943f7a5dc10e0430c990937bb04426d8');
session_start();
define('ON_SiTe', true);

// Static Varibales
$staticvars['language']['main']='pt';

$local_root = __FILE__ ;
$staticvars['local_root']=''.substr( $local_root, 0, strpos( $local_root, "index.php" ) ) ;
include($staticvars['local_root'].'kernel/staticvars.php');

// end of Staticvars
if (isset($_GET['lang'])):
	$staticvars['language']['current']=$_GET['lang'];
	if ($staticvars['language']['current']==''):
		$staticvars['language']['current']=$staticvars['language']['main'];
	endif; 
else:
	$staticvars['language']['current']=$staticvars['language']['main'];
endif;


include($staticvars['local_root'].'kernel/functions.php');

if (isset($_GET['id'])):
	$staticvars['module']['location']='modules/'.$_GET['id']."/main.php";
	$staticvars['module']['id']= $_GET['id'];
else:
	$staticvars['module']['location']='modules/mainpage/main.php';
	$staticvars['module']['id']='mainpage';
endif;
if(!is_file($staticvars['local_root'].$staticvars['module']['location']) ):
	$staticvars['module']['location']='kernel/errors/not_found.php';
endif;

include($staticvars['local_root'].'layout/'.$staticvars['layout']['file']);
?>

