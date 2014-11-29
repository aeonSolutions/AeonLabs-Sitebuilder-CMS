<?php
/*
File revision date: 11-ago-2007
*/

if (is_file($globvars['site']['directory'].'kernel/settings/ums.php') and is_file($globvars['site']['directory'].'kernel/settings/layout.php')):
	include($globvars['site']['directory'].'kernel/settings/ums.php');
	include($globvars['site']['directory'].'kernel/settings/layout.php');
	$sessions=file_get_contents($globvars['local_root'].'buildfiles/index/sessions.php');
	$variables=file_get_contents($globvars['local_root'].'buildfiles/index/variables.php');
	if($ug_type=='dynamic'):
		$ums=file_get_contents($globvars['local_root'].'buildfiles/index/ums.php');
	else:
		$ums=file_get_contents($globvars['local_root'].'buildfiles/index/ums_disabled.php');
	endif;
	$postvars=file_get_contents($globvars['local_root'].'buildfiles/index/postvars.php');
	$funcs=file_get_contents($globvars['local_root'].'buildfiles/index/functions_features.php');
	copy($globvars['local_root'].'buildfiles/engine/engine_funcs.php',$globvars['site']['directory'].'kernel/engine_funcs.php');
	if($ug_type=='dynamic'):
	else:
	endif;
	if($layout=='dynamic'):
		if($ug_type=='dynamic'):
			$layout_file=file_get_contents($globvars['local_root'].'buildfiles/index/layout_dynamic.php');
			$engine_file=file_get_contents($globvars['local_root'].'buildfiles/engine/engine_dyn_layout.php');
		else:
			$engine_file=file_get_contents($globvars['local_root'].'buildfiles/engine/engine_dyn_layout_no_ums.php');
			$layout_file=file_get_contents($globvars['local_root'].'buildfiles/index/layout_dynamic_no_ums.php');
		endif;
	else:
		if($ug_type=='dynamic'):
			$layout_file=file_get_contents($globvars['local_root'].'buildfiles/index/layout_disabled.php');
			$engine_file=file_get_contents($globvars['local_root'].'buildfiles/engine/engine_static_layout.php');
		else:
			$engine_file=file_get_contents($globvars['local_root'].'buildfiles/engine/engine_static_layout_no_ums.php');
			$layout_file=file_get_contents($globvars['local_root'].'buildfiles/index/layout_disabled.php');
		endif;
	endif;
	$finish=file_get_contents($globvars['local_root'].'buildfiles/index/finish.php');
	$new_index=$sessions.$variables.$funcs.$postvars.$ums.$layout_file.$engine_file.$finish;
	// build index file
	$filename=$globvars['site']['directory'].'index.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $new_index);
	fclose($handle);
	echo '<font class="body_text"> <font color="#FF0000">Success. Index file was created succesfully.</font></font><br />';
else:
	echo 'You must complete the wizard first.';
endif;
?>