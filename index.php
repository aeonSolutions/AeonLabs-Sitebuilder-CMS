<?php /*
File revision date: 8-jun-2014

Variables Map
$globvars['site']['directory']
	website hard drive working directory
$_SESSION['site']
	wizard - for create a new site
	directory name - for edit a site
$_SESSION['type']
	sa - simple website + auth + language
	shtml - simple website
$_SESSION['contents']
		boolean
		for editing contents(modules) loaded into layout	
*/
// Global variables initialization
include(substr(__FILE__,0,strpos(__FILE__,"index.php")).'core/globvars.php');
// login just enterend
if (isset($_POST['password'])):
	include($globvars['local_root'].'core/authoring/authoring.php');
endif;
ob_start();
if (isset($_GET['logout'])):
	$_SESSION = array(); 
	@session_destroy();
	sleep(1);
	session_write_close();
	header('Location:index.php');
	exit;
endif;
$task= isset($_GET['id']) ? $_GET['id'] : '';
if (isset($_GET['SID'])):
	$sid=$_GET['SID'];
	session_id($_GET['SID']);
	// check session timeouts
	$filepath = ini_get('session.save_path').'/sess_'.session_id();    
	if(!file_exists($filepath)) :
		header('Location:index.php');
		echo '<font style="font-family:Georgia, Times, serif; font-size:9px">Your session has expired.</font><br>';
	endif;
else:
	session_id(md5( uniqid( rand () ) ));
	$sid='Null';
endif;
session_cache_expire (5);// 5 min
session_cache_limiter('private');
session_start();
define('ON_SiTe', true);

// check session timeouts
$filepath = ini_get('session.save_path').'/sess_'.session_id();    
if(file_exists($filepath)) :
    $globvars['session']['start_time'] = filemtime ($filepath);
	$globvars['session']['expire']= session_cache_expire ()*60; // secs
endif;

// user authentication verification and var setup
if (isset($_SESSION['user'])):
	include($globvars['local_root'].'core/authoring/config.php');
	if ($sid<>$sbe_session): // tampered SID ->force logout!
		// set errors vars
		$globvars['error']['flag']=true; // true if error occur
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		$globvars['warnings']='ERROR (Idx65) - not authenticated properly!';
		include($local_root.'core/layout/login.php');
		ob_end_flush();
		exit;
	endif;
	$globvars['users']['is_auth']=true;// flag true when user auth occurs
	$globvars['users']['name']= isset($_SESSION['user']) ? $_SESSION['user'] : '';// username
	$globvars['users']['code']=$sbe_user;// db user code
	$globvars['users']['group']=$globvars['users']['user_type']['admin'];// user group
else:
	include($globvars['local_root'].'core/layout/login.php');
	ob_end_flush();
	exit;
endif;
// critial error found when processing Server code
if(isset($_SESSION['cerr'])):
	if($_SESSION['cerr']==true):
		include($globvars['local_root'].'core/log_viewer.php');
		ob_end_flush();
		exit;
	endif;
endif;
// Debugger
$globvars['debugger']['enabled']=true;// Error logging
if(is_file(substr(__FILE__,0,strpos(__FILE__,"core")).'tmp/error_log_man.php')):
	unlink(substr(__FILE__,0,strpos(__FILE__,"core")).'tmp/error_log_man.php');
endif;
$globvars['debugger']['view_files']=false; // for del and copy file functions
if (isset($_GET['bug'])):
	if($_GET['bug']=='free'):
		$globvars['debugger']['enabled']=true;// Error logging
	else:	
		$globvars['debugger']['enabled']=false;// Error logging
		$_SESSION['debugger']=array();
	endif;
endif;
if($globvars['debugger']['enabled']==true or $_SESSION['debugger']==true):
	if(is_file($globvars['local_root'].'tmp/error_log_man.php')):
		unlink($globvars['local_root'].'tmp/error_log_man.php');
	endif;
	if(is_file($globvars['local_root'].'tmp/error_log.log')):
		unlink($globvars['local_root'].'tmp/error_log.log');
	endif;
	include($globvars['local_root'].'core/error_logging.php');
	if(isset($_SESSION['debugger'])):
		$_SESSION['debugger']==array();
	endif;
endif;
if(setlocale(LC_ALL,'pt_PT')):
	$globvars['warnings']="Unable to setlocale to current charset:".setlocale(LC_ALL,'pt_PT');
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=false; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
endif;

// function initialization
include_once($globvars['local_root'].'copyfiles/advanced/general/return_module_id.php');
include_once($globvars['local_root'].'copyfiles/advanced/general/recursive_copy.php');
include_once($globvars['local_root'].'copyfiles/advanced/kernel/functions.php'); 
include_once($globvars['local_root'].'core/functions.php'); 

if(is_file($globvars['local_root'].'core/server.php')):
	include($globvars['local_root'].'core/server.php');
	if($globvars['site']['sid']<>$sid or isset($_GET['clean'])):
		unlink($globvars['local_root'].'core/server.php');
		header("Location: 'index.php?SID=".@$_GET['SID']);
		exit;
	endif;
endif;
// status of current work
if(is_file($globvars['local_root'].'core/status.php')):
	if (isset($_GET['clean'])):
		unlink($globvars['local_root'].'core/status.php');
		sleep(1);
		header("Location: ".strip_address("clean",$_SERVER['REQUEST_URI']));
		exit;
	elseif(isset($_GET['resume'])):
		include($globvars['local_root'].'core/status.php');
		$file_content="<?PHP
		// New site status file
		"."$"."globvars['site']['sid']='".$_GET['SID']."';
		"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
		"."$"."globvars['site']['type']='".$globvars['site']['type']."';
		"."$"."globvars['site']['directory']='".$globvars['site']['directory']."';
		?>";
		$filename=$globvars['local_root'].'core/status.php';
		if (file_exists($filename)):
			unlink($filename);
		endif;
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		header("Location: ".strip_address("resume",$_SERVER['REQUEST_URI']));
		exit;
	elseif($globvars['site']['sid']<>$sid):
		// set errors vars
		$globvars['error']['flag']=true; // true if error occur
		$globvars['error']['type']='question';// type in {exclamation, question, info, prohibited}
		$globvars['error']['message']='<h4>Lastime you were editting the website,<br> '.$globvars['site']['name'].'</h4><br><p>Do you wish to resume? [<a href="'.session_setup($globvars,'index.php?resume').'">Yes</a>] [<a href="'.session_setup($globvars,'index.php?clean').'">No</a>]</p>';
		include($globvars['local_root'].'core/layout/'.$globvars['layout']['error']);
		exit;
	endif;
	include($globvars['local_root'].'core/status.php');
endif;
if(is_file($globvars['local_root'].'core/editsite.php')):
	include($globvars['local_root'].'core/editsite.php');
	if (isset($_GET['clean'])):
		unlink($globvars['local_root'].'core/editsite.php');
		header("Location: ".strip_address("clean",$_SERVER['REQUEST_URI']));
		exit;
	elseif(isset($_GET['resume'])):
		include($globvars['local_root'].'core/editsite.php');
		$file_content="
		<?PHP
		// New site status file
		"."$"."globvars['site']['sid']='".$_GET['SID']."';
		"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
		"."$"."globvars['site']['name']='".$globvars['site']['name']."';
		"."$"."globvars['site']['directory']='".$globvars['site']['directory']."';
		?>";
		$filename=$globvars['local_root'].'core/editsite.php';
		if (file_exists($filename)):
			unlink($filename);
		endif;
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);

	elseif($globvars['site']['sid']<>$sid):
		// set errors vars
		$globvars['error']['flag']=true; // true if error occur
		$globvars['error']['type']='question';// type in {exclamation, question, info, prohibited}
		$globvars['error']['message']='<h4>Lastime you were editting the website,<br> '.$globvars['site']['name'].'</h4><br><p>Do you wish to resume? [<a href="'.session_setup($globvars,'index.php?resume').'">Yes</a>] [<a href="'.session_setup($globvars,'index.php?clean').'">No</a>]</p>';
		include($globvars['local_root'].'core/layout/'.$globvars['layout']['error']);
		exit;
	endif;
endif;
$globvars['info']='';
$worktype=false;// set worktype to develop
if (!isset($globvars['site']['mode'])):
	$globvars['site']['mode']='null';
	if(isset($_GET['log'])):
		// file location id
		$globvars['module']['id']=isset($_GET['id']) ? $_GET['id'] : ''; // id
		$globvars['info']="Session Error Log View";
		$globvars['module']['location']="core/log_viewer.php";
	else:
		// set errors vars
		$globvars['warnings']='Choose the task you wish to perform.';
		$worktype=true;
	endif;
endif;
if($globvars['site']['mode']=='wizard'):// wizard site builder
	if (isset($globvars['site']['type'])):// ready to start
		$globvars['module']['id']='wizard'; // id
		if ($globvars['site']['type']=='sa'):
			$globvars['wizard']['shtml'][0]='wizard/ws_selector.php';
			$globvars['wizard']['shtml'][1]='wizard/simple/sa/settings.php';
			$globvars['wizard']['shtml'][2]='wizard/simple/layout.php';
			$globvars['wizard']['shtml'][3]='wizard/simple/modules.php';
			$globvars['wizard']['shtml'][4]='wizard/finished.php';
			$globvars['wizard']['shtml'][4]='index.php';

			$addr=strip_address("step",$_SERVER['REQUEST_URI']);
			$menu_current=0;
			$menu[0]['text']='WS Selector';
			$menu[1]['text']='Settings';
			$menu[2]['text']='Layout';
			$menu[3]['text']='Modules';
			$menu[4]['text']='Finish';
			$menu[5]['text']='LogOut';

			$menu[0]['link']=$addr.'&step=0';
			$menu[1]['link']=$addr.'&step=1';
			$menu[2]['link']=$addr.'&step=2';
			$menu[3]['link']=$addr.'&step=3';
			$menu[4]['link']=$addr.'&step=4';
			$menu[4]['link']=$addr.'&logout=1';

			$title[0]='<h3>Website Type</h3>';
			$title[1]='<h3>General Configuration</h3>';
			$title[2]='<h3>Layout Design</h3>';
			$title[3]='<h3>Modules</h3>';
			$title[4]='<h3>Congratulations</h3>';

			$step_completed=step_shtml($globvars);

			if(isset($_GET['step'])):
				$step= $_GET['step']<= $step_completed ? $_GET['step'] : $step_completed;
			else:
				$step=$step_completed;
			endif;

			for($i=$step_completed+1;$i<=4;$i++):
				$menu[$i]['link']='#';
			endfor;
			$globvars['module']['location']=$globvars['wizard']['shtml'][$step]; // modules location to load
			$menu_current=0;
		elseif ($globvars['site']['type']=='shtml'):
			$globvars['wizard']['shtml'][0]='wizard/ws_selector.php';
			$globvars['wizard']['shtml'][1]='wizard/simple/shtml/settings.php';
			$globvars['wizard']['shtml'][2]='wizard/simple/layout.php';
			$globvars['wizard']['shtml'][3]='wizard/simple/modules.php';
			$globvars['wizard']['shtml'][4]='wizard/finished.php';

			$addr=strip_address("step",$_SERVER['REQUEST_URI']);
			$menu_current=0;
			$menu['text'][0]='WS Selector';
			$menu['text'][1]='Settings';
			$menu['text'][2]='Layout';
			$menu['text'][3]='Modules';
			$menu['text'][4]='Finish';
			$menu['text'][4]='LogOut';

			$menu['link'][0]=$addr.'&step=0';
			$menu['link'][1]=$addr.'&step=1';
			$menu['link'][2]=$addr.'&step=2';
			$menu['link'][3]=$addr.'&step=3';
			$menu['link'][4]=$addr.'&step=4';
			$menu['link'][4]=$addr.'&logout=1';

			$title[0]='<h3>Website Type</h3>';
			$title[1]='<h3>General Configuration</h3>';
			$title[2]='<h3>Layout Design</h3>';
			$title[3]='<h3>Modules</h3>';
			$title[4]='<h3>Congratulations</h3>';

			$step_completed=step_shtml($globvars);

			if(isset($_GET['step'])):
				$step= $_GET['step']<= $step_completed ? $_GET['step'] : $step_completed;
			else:
				$step=$step_completed;
			endif;

			for($i=$step_completed+1;$i<=4;$i++):
				$menu[$i]['link']='#';
			endfor;
			$globvars['module']['location']=$globvars['wizard']['shtml'][$step]; // modules location to load
			$menu_current=0;
		elseif ($globvars['site']['type']=='advanced'):
			$globvars['wizard']['advanced'][0]='wizard/ws_selector.php';
			$globvars['wizard']['advanced'][1]='wizard/advanced/settings.php';
			$globvars['wizard']['advanced'][2]='wizard/advanced/general_settings.php';
			$globvars['wizard']['advanced'][3]='wizard/advanced/layout.php';
			$globvars['wizard']['advanced'][4]='wizard/advanced/modules.php';
			$globvars['wizard']['advanced'][5]='wizard/advanced/contents.php';
			$globvars['wizard']['advanced'][6]='wizard/advanced/features.php';
			$globvars['wizard']['advanced'][7]='wizard/finished.php';
			$globvars['wizard']['advanced'][8]='index.php';

			$addr=strip_address("step",$_SERVER['REQUEST_URI']);
			$menu_current=0;
			$menu['text'][0]='WS Selector';
			$menu['text'][1]='Startup';
			$menu['text'][2]='Defs';
			$menu['text'][3]='Layout';
			$menu['text'][4]='Modules';
			$menu['text'][5]='Contents';
			$menu['text'][6]='Features';
			$menu['text'][7]='Finish';
			$menu['text'][8]='LogOut';

			$menu['link'][0]=$addr.'&step=0';
			$menu['link'][1]=$addr.'&step=1';
			$menu['link'][2]=$addr.'&step=2';
			$menu['link'][3]=$addr.'&step=3';
			$menu['link'][4]=$addr.'&step=4';
			$menu['link'][5]=$addr.'&step=5';
			$menu['link'][6]=$addr.'&step=6';
			$menu['link'][7]=$addr.'&step=7';
			$menu['link'][8]=$addr.'&logout=1';

			$title[0]='<h3>Website Type</h3>';
			$title[1]='<h3>Site defenitions</h3>';
			$title[2]='<h3>General Configuration</h3>';
			$title[3]='<h3>Layout Design</h3>';
			$title[4]='<h3>Modules</h3>';
			$title[5]='<h3>Contents Loaded</h3>';
			$title[6]='<h3>Features</h3>';
			$title[7]='<h3>Congratulations</h3>';

			 $step_completed=step_advanced($globvars);

			if(isset($_GET['step'])):
				$step= $_GET['step']<= $step_completed ? $_GET['step'] : $step_completed;
			else:
				$step=$step_completed;
			endif;

			for($i=$step_completed+1;$i<=7;$i++):
				$menu[$i]['link']='#';
			endfor;
			$globvars['module']['location']=$globvars['wizard']['advanced'][$step]; // modules location to load
			$menu_current=0;
			echo 'LINE 360:'.$globvars['module']['location'].'<br/>';
		else: // choose between simple or advanced website
			$globvars['warnings']='<h3>Website Type</h3>';
			$globvars['module']['location']='wizard/ws_selector.php';		
		endif;
		$globvars['warnings']=$title[$step];
	else: // choose between simple or advanced website
		$globvars['warnings']='<h3>Website Type</h3>';
		$globvars['module']['location']='wizard/ws_selector.php';
	endif;
elseif($globvars['site']['mode']=='server'): // server management
	$globvars['edit']['module'][0]='server/main.php';
	$globvars['edit']['module'][1]='server/virtualhosts.php';

	$menu_current=0;
	$menu['text'][0]='Services';
	$menu['text'][1]='VHosts';
	$menu['text'][2]='Finish';

	$menu['link'][0]=session_setup($globvars,'index.php?id=0');
	$menu['link'][1]=session_setup($globvars,'index.php?id=1');
	$menu['link'][2]=session_setup($globvars,'index.php?clean=yes');

	$title[0]='<h3>Services</h3>';
	$title[1]='<h3>Virtual Hosts Configuration</h3>';
	$title[2]='<h3>Databases</h3>';
	$title[3]='<h3>Finish</h3>';
else: // edit site
	if (!isset($globvars['site']['mode'])):
		// set errors vars
		$globvars['warnings']='Choose the task you wish to perform.';
		include($globvars['local_root'].'core/layout/'.$globvars['layout']['main']);
		exit;
	endif;
	if ($globvars['site']['mode']=='simple'):
		$addr=strip_address("id",strip_address("logout",strip_address("step",strip_address("file",strip_address("set",$_SERVER['REQUEST_URI'])))));
		$menu_current=0;

		$globvars['edit']['module'][0]='siteedit/simple/main.php';
		$globvars['edit']['module'][1]='wizard/simple/layout.php';
		$globvars['edit']['module'][2]='siteedit/simple/modules.php';
		include($globvars['site']['directory'].'kernel/staticvars.php');
		if (isset($staticvars['language'])):
			$globvars['edit']['module'][3]='siteedit/simple/sa/settings.php';
		else:
			$globvars['edit']['module'][3]='siteedit/simple/shtml/settings.php';
		endif;
		$globvars['edit']['module'][4]='siteedit/filemanager.php';
		$globvars['edit']['module'][5]='siteedit/site_security.php';

		$title[0]='<h3>Main Page</h3>';
		$title[1]='<h3>Layout Design</h3>';
		$title[2]='<h3>Modules</h3>';
		$title[3]='<h3>Site defenitions</h3>';
		$title[4]='<h3>File manager</h3>';
		$title[5]='<h3>Update</h3>';
		$title[6]='<h3>Logout</h3>';

		$menu['text'][0]='Main page';
		$menu['text'][1]='Layout';
		$menu['text'][2]='Modules';
		$menu['text'][3]='StaticVars';
		$menu['text'][4]='Filemanager';
		$menu['text'][5]='Update';
		$menu['text'][6]='Finish';

		$menu['link'][0]=$addr.'&id=0';		
		$menu['link'][1]=$addr.'&id=1';		
		$menu['link'][2]=$addr.'&id=2';		
		$menu['link'][3]=$addr.'&id=3';		
		$menu['link'][4]=$addr.'&id=4';		
		$menu['link'][5]=$addr.'&id=5';		
		$menu['link'][6]=$addr.'&clean';		
	else://advanced
		$menu_current=0;

		$globvars['edit']['module'][0]='siteedit/advanced/main.php';
		$globvars['edit']['module'][1]='siteedit/advanced/layout_menu.php';
		$globvars['edit']['module'][2]='siteedit/advanced/layout/main.php';
		$globvars['edit']['module'][3]='siteedit/advanced/layout/layout_contents.php';
		$globvars['edit']['module'][4]='siteedit/advanced/main.php'; // free slot!
		$globvars['edit']['module'][5]='siteedit/advanced/modules_menu.php';
		$globvars['edit']['module'][6]='siteedit/advanced/modules/modules.php';
		$globvars['edit']['module'][7]='siteedit/advanced/admin_panel/ap_main.php';
		$globvars['edit']['module'][8]='siteedit/advanced/settings.php';
		$globvars['edit']['module'][9]='siteedit/advanced/menus_menu.php';
		$globvars['edit']['module'][10]='siteedit/advanced/features.php';
		$globvars['edit']['module'][11]='siteedit/filemanager.php';
		$globvars['edit']['module'][12]='siteedit/advanced/webservices_menu.php';
		$globvars['edit']['module'][13]='siteedit/advanced/update.php';
		$globvars['edit']['module'][14]='modules/advanced/admin_panel/database/db_bk.php';
		$globvars['edit']['module'][15]='siteedit/advanced/user_groups/user_groups.php';
		$globvars['edit']['module'][16]='siteedit/advanced/user_management/main.php';
		$globvars['edit']['module'][17]='siteedit/advanced/null_index.php';
		$globvars['edit']['module'][18]='siteedit/advanced/rebuild_index.php';
		$globvars['edit']['module'][19]='siteedit/advanced/menu/menu.php';
		$globvars['edit']['module'][20]='siteedit/advanced/layout/menu.php';
		$globvars['edit']['module'][21]='wizard/advanced/general_settings.php';

		$title[0]='<h3>Main Page</h3>';
		$title[1]='<h3>Layout Design</h3>';
		$title[2]='<h3>Layout Design</h3>';
		$title[3]='<h3>Layout Contents</h3>';
		$title[4]='';
		$title[5]='<h3>Modules</h3>';
		$title[6]='<h3>Modules Management</h3>';
		$title[7]='<h3>Modules Configuration</h3>';
		$title[8]='<h3>Site defenitions</h3>';
		$title[9]='<h3>Menus</h3>';
		$title[10]='<h3>Features</h3>';
		$title[11]='<h3>Filemanager</h3>';
		$title[12]='<h3>WebServices</h3>';
		$title[13]='<h3>Update</h3>';
		$title[14]='<h3>Database Backup</h3>';
		$title[15]='<h3>User Groups</h3>';
		$title[16]='<h3>User Management</h3>';
		$title[17]='<h3>Add Null Index</h3>';
		$title[18]='<h3>Build Index</h3>';
		$title[19]='<h3>Menu Management</h3>';
		$title[20]='<h3>Menu Skin Template</h3>';
		$title[21]='<h3>General settings</h3>';

		$menu['text'][0]='Main page';
		$menu['text'][1]='Layout';
		$menu['text'][2]='Modules';
		$menu['text'][3]='StaticVars';
		$menu['text'][4]='Menus';
		$menu['text'][5]='Features';
		$menu['text'][6]='Contents';
		$menu['text'][7]='Filemanager';
		$menu['text'][8]='Update';
		$menu['text'][9]='Settings';
		$menu['text'][10]='Finish';
		$menu['text'][10]='LogOut';

		$menu['link'][0]=session_setup($globvars,'index.php');	
		$menu['link'][1]=session_setup($globvars,'index.php?id=1');
		$menu['link'][2]=session_setup($globvars,'index.php?id=5');		
		$menu['link'][3]=session_setup($globvars,'index.php?id=8');	
		$menu['link'][4]=session_setup($globvars,'index.php?id=9');	
		$menu['link'][5]=session_setup($globvars,'index.php?id=10');	
		$menu['link'][6]=session_setup($globvars,'index.php?id=3');
		$menu['link'][7]=session_setup($globvars,'index.php?id=11');		
		$menu['link'][8]=session_setup($globvars,'index.php?id=13');		
		$menu['link'][9]=session_setup($globvars,'index.php?id=21');	
		$menu['link'][10]=session_setup($globvars,'index.php?clean');	
		$menu['link'][10]=session_setup($globvars,'index.php?logout=1');	
		if(is_file($globvars['local_root'].'core/status.php')):
			include($globvars['site']['directory'].'kernel/staticvars.php');
		endif;
	endif;
endif; // edit site

if ($globvars['site']['directory']=='' and isset($globvars['site']['name']) and is_file($globvars['local_root'].'core/status.php')):
	$globvars['error']['flag']=true; // true if error occur
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
	$globvars['error']['message']='Website local HD path not defined';
	include($globvars['local_root'].'core/layout/'.$globvars['layout']['error']);
	ob_end_flush();
	exit;
endif;
echo 'LINE 521:'.$globvars['module']['location'].'<br/>';
if (isset($_GET['id'])):
	if($_GET['id']=='error' ):
		$globvars['error']['flag']=true; // true if error occur
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		$globvars['error']['message']=$_SESSION['erro'];
		include($globvars['local_root'].'core/layout/'.$globvars['layout']['error']);
		ob_end_flush();
		exit;
	elseif (is_numeric($_GET['id'])):
		// file location id
		$globvars['module']['id']=$_GET['id']; // id
		$globvars['module']['location']=$globvars['edit']['module'][$globvars['module']['id']];
		$globvars['warnings']=$title[$globvars['module']['id']];
		if (!is_file($globvars['local_root'].$globvars['module']['location'])):
			// set errors vars
			$globvars['error']['flag']=true; // true if error occur
			$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
			$globvars['error']['message']='Task not found!<br/> ['.$globvars['module']['location'].']';
			include($globvars['local_root'].'core/layout/'.$globvars['layout']['error']);
			ob_end_flush();
			exit;
		endif;
	else: //unknown error  - redirect to main
		$globvars['warnings']='<h3>Edit Website</h3>';
		$globvars['module']['location']='siteedit/'.$globvars['site']['mode'].'/main.php';
	endif;
else: //unknown error  - redirect to main
	$globvars['warnings']='<h3>Edit Website</h3>';
	// $globvars['module']['location']='siteedit/'.$globvars['site']['mode'].'/main.php';
	echo 'LINE 548:'.$globvars['module']['location'];
endif;


if(isset($_GET['log'])):
	// file location id
	$globvars['module']['id']=isset($_GET['id']) ? $_GET['id'] : 0; // id
	$globvars['info']="Session Error Log View";
	$globvars['module']['location']="core/log_viewer.php";
endif;		
// include globalvars of the site to edit
$globvars['site']['base']= substr($globvars['local_root'],0,strpos($globvars['local_root'],"sitebuilder"));
if (is_file($globvars['site']['directory'].'kernel/staticvars.php')):
	include($globvars['site']['directory'].'kernel/staticvars.php');
endif;
// change info msg if errors detected
if(is_file(substr(__FILE__,0,strpos(__FILE__,"core")).'tmp/error_log_man.php')):
	include_once(substr(__FILE__,0,strpos(__FILE__,"core")).'tmp/error_log_man.php');
	$globvars['info']="Last page were generated ".count($scriptlinenum)." error(s). You should check'em out before continue!";
endif;
// layout
include($globvars['local_root'].'core/layout/'.$globvars['layout']['main']);
ob_end_flush();
exit;


function step_advanced($globvars){
if(isset($globvars['site']['directory'])):
	if(is_file($globvars['site']['directory'].'kernel/staticvars.php')):
		if(is_file($globvars['site']['directory'].'kernel/settings/menu.php') and is_file($globvars['site']['directory'].'kernel/settings/ums.php') ):
			$dir=glob($globvars['site']['directory'].'layout/templates/*', GLOB_ONLYDIR);
			if(isset($dir[0])):
				$dir=array();
				unset($dir);
				$dir=glob($globvars['site']['directory'].'modules/*',GLOB_ONLYDIR);
				if (count($dir)>2): //admin_panel & authoring should be already in modules directory
					if(isset($_SESSION['contents']) or is_file($globvars['site']['directory'].'kernel/features.php')):
						if(is_file($globvars['site']['directory'].'kernel/features.php')):
							$step=7;
						else:// goto features
							$step=6;
						endif;
					else:// goto edit contents
						$step=5;
					endif;	
				else:// goto modules
					$step=4;
				endif;
			else:// goto layout
				$step=3;
			endif;
		else://goto general config
			$step=2;
		endif;
	else:// goto settings
		$step=1;
	endif;
else:// goto settings
	$step=1;
endif;			

return $step;

};

function step_shtml($globvars){
if($globvars['site']['directory']<>''):
	include($globvars['site']['directory'].'kernel/staticvars.php');
	if($staticvars['layout']['file']<>''):
		$dir=glob($globvars['site']['directory'].'modules/*',GLOB_ONLYDIR);
		if (!isset($dir[0]))://goto modules
			$step=3;
		else:// goto finish
			$step=4;
		endif;
	else://goto layout
		$step=2;
	endif;
else:// goto settings
	$step=1;
endif;			

return $step;
};
?>