<?php

// TO START A NEW SETUP
// SET the VARIABLE $reset to TRUE
if(is_file($local_root.'general/staticvars.php') and !isset($_GET['reset']) and !isset($_GET['noreset'])):
	$temp=file_get_contents($local_root.'general/staticvars.php');
	$temp1=strpos($temp,"absolute_path");
	$temp2=strpos($temp,'";',$temp1+strlen("absolute_path"));
	$temp=substr($temp,$temp1+strlen("absolute_path")+4,abs($temp2-($temp1+strlen("absolute_path")+4)));
	$local_root = __FILE__ ;
	$local_root = ''.substr( $local_root, 0, strpos( $local_root, "setup" ) ) ;
	if (stripslashes(stripslashes($temp))<>stripslashes(stripslashes($local_root))):// same directory -  new site
		// set errors vars
		$globvars['error']['flag']=true; // true if error occur
		$globvars['error']['type']='question';// type in {exclamation, question, info, prohibited}
		$globvars['error']['message']='<font style="font-family:Georgia, Times, serif; font-size:12px"> New site detected!<br>Do you want to reset vars?   [<a href="index.php?reset=1">Yes</a>] [<a href="index.php?noreset=1">No</a>]</font>';
		include($local_root.'core/layout/'.$globvars['error']['layout']);
		exit;
	endif;
	
endif;

if(isset($_GET['reset']) and is_file($local_root.'general/staticvars.php')):
	$msg='Performing operations:<br></h2>';
	include_once($local_root.'general/recursive_copy.php');
	$temp=file_get_contents($local_root.'general/staticvars.php');
	$upload_dir_name=$temp;
	$temp1=strpos($temp,"absolute_path");
	$temp2=strpos($upload_dir_name,'";',$temp1+strlen("absolute_path"));
	$absolute_path=substr($temp,$temp1+strlen("absolute_path")+4,abs($temp2-($temp1+strlen("absolute_path")+4)));

	$temp11=strpos($upload_dir_name,"upload_dir_name");
	$temp22=strpos($upload_dir_name,'";',$temp11+strlen("upload_dir_name"));
	$upload_dir_name=substr($upload_dir_name,$temp11+strlen("upload_dir_name")+2,abs($temp22-($temp11+strlen("upload_dir_name")+2)));
	$upload_directory = $local_root.$upload_dir_name;
	// all files in uploads directory
	delr($upload_directory);
	@rmdir($upload_directory);
	$msg.='Upload Directory deleted!<br>';
	// all files in kernel/settings
	delr($local_root.'kernel/settings');
	@mkdir($local_root.'kernel/settings');
	@unlink($local_root.'kernel/search_spiders.php');	
	@unlink($local_root.'kernel/error_logging.php');	
	@unlink($local_root.'kernel/stats_management.php');	
	@unlink($local_root.'index.php');	
	@copy($loca_root.'buildfiles/index/index_setup.php',$local_root.'index.php');
	@unlink($local_root.'kernel/engine.php');	
	$msg.='Kernel Settings deleted!<br>';
	// staticvars.php
	@unlink($local_root.'general/staticvars.php');	
	$msg.='Configuration settings reseted!<br>';
	// all files in layout/box_efects
	delr($local_root.'layout/box_effects');
	@rmdir($local_root.'/layout/box_effects');
	// all files in layout/menu
	delr($local_root.'layout/menu');
	@rmdir($local_root.'/layout/menu');
	// all files in layout/templates
	delr($local_root.'layout/templates');
	@rmdir($local_root.'/layout/templates');
	@mkdir($local_root.'/layout/templates');
	$msg.='Layout files deleted!<br>';
	// all files in modules
	delr($local_root.'modules');
	@mkdir($local_root.'modules');
	$msg.='Modules deleted!<br>';
	// all files in tmp 
	delr($local_root.'tmp');
	@mkdir($local_root.'tmp');
	$msg.='Temporary files deleted!<br>';
	// all files in sql 
	delr($local_root.'sql');
	@mkdir($local_root.'sql');
	$msg.='Database backup files deleted!<br><br>';
	$file_content='
	<?PHP
	// WebPage wizard status
	$status=0;
	?>';
	$filename=$local_root.'core/status.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
    $msg.='<font style="font-family:Georgia, Times, serif; font-size:12px">WebSite has Been Reseted. Click <a href="index.php">here</a> to continue</font><br>';
	// set errors vars
	$globvars['error']['flag']=true; // true if error occur
	$globvars['error']['type']='question';// type in {exclamation, question, info, prohibited}
	$globvars['error']['message']=$msg;
	include($local_root.'core/layout/'.$globvars['error']['layout']);
	exit;
endif;

?>