<?php
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
	session_start();
else:
	echo 'o session found (layout frame)';
	exit;
endif;
if (isset($_GET['skin'])):
		$skin=$_GET['skin'];	
	else:
	echo 'layout code error (layout frame)';
	exit;
endif;
if (isset($_GET['file'])):
	$layout=$_GET['file'];	
else:
	echo 'file not found (layout frame)';
	exit;
endif;
$local_root=substr(__FILE__,0,strpos(__FILE__,"siteedit"));
$layout_dir=explode("/",$layout);

include($local_root.'core/globvars.php');
include($globvars['local_root'].'copyfiles/advanced/general/recursive_copy.php');
include($globvars['site']['directory'].'kernel/staticvars.php');
include($globvars['local_root'].'core/functions.php');
include($globvars['site']['directory'].'kernel/staticvars.php');
include($globvars['local_root'].'core/functions/layout.php');

delr($globvars['local_root'].'tmp/layout',$globvars);
if(!is_dir($globvars['local_root'].'tmp/layout')):
	mkdir($globvars['local_root'].'tmp/layout');
endif;
copyr($globvars['site']['directory'].'layout/templates/'.$layout_dir[0], $globvars['local_root'].'tmp/layout/'.$layout_dir[0],$globvars);

if(prepare_layout($layout,$globvars,$staticvars)):
	define('ON_SiTe', true);
	$file=$layout_dir[1];	
	include($globvars['local_root'].'tmp/layout/'.$layout_dir[0].'/'.$file);
else:
	$globvars['warnings']='Unable to prepare layout for editting';
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
    if($globvars['error']['critical']):
    	$_SESSION['cerr']=true;
        sleep(1);
        session_write_close();
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
    endif;
endif;
?>