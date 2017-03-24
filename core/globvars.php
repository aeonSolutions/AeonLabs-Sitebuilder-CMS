<?php // Global variables environment
//$globvars['']='';
	//version
	$globvars['version']='5.5';
	$globvars['name']='WS-WaDE';
	//language settings
	$globvars['language']['main']='pt';// website main language
	$globvars['language']['available']='en'; // available languages dot comma separated en;es;fr;
	// wizard information
	$globvars['wizard']['layout']='main.php';// name of the file with the layout to load when on wizard mode
	//layouts
	$globvars['layout']['main']='main.php';// name of the file with the layout to load
	$globvars['layout']['worktype']='worktype.php';// name of the file with the layout to load when choose type of tasks to develop
	$globvars['layout']['error']='main.php';// name of the file with the layout to load when error occurs
	//$globvars['info']=''; // used for display one line info message on the layout
	$globvars['warnings']='Unk Error Found! Check log file if enabled (loaded GB)';// used for display warning messages on the layout
	//module related
	$globvars['module']['id']=-1; // id -1 means no id parsed
	$globvars['module']['location']='core/layout/error/error.php'; // modules location to load
	//errors
	$globvars['error']['critical']=false; // true if critical error occurs
	$globvars['error']['flag']=false; // true if error occur but not critical
	$globvars['error']['type']='';// type in {exclamation, question, info, prohibited}
	$globvars['error']['message']='Unk Error Found! Check log file if enabled (loaded GB)';
	//users
	$globvars['users']['user_type']['admin']='';// admin group code
	$globvars['users']['user_type']['guest']='';//guest group code
	$globvars['users']['user_type']['default']='';//default group code
	$globvars['users']['user_type']['auth']='';// authenticated group code
	$globvars['users']['user_type']['cm']='';// content management group code
	$globvars['users']['sid']=session_id();// session id
	$globvars['users']['is_auth']=false;// flag true when user auth occurs
	$globvars['users']['name']= isset($_SESSION['user']) ? $_SESSION['user'] : 0;// username
	$globvars['users']['code']='';// db user code
	$globvars['users']['group']='';// user group
	// meta vars
	$globvars['meta']['description']='';
	$globvars['meta']['keywords']='';
	$globvars['meta']['author']='';
	$globvars['meta']['robots']='';
	$globvars['meta']['page_title']='';
	
	// site main directory folders paths
	// returns the current hard drive directory not the root directory
	$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"core"));// local harddrive path with the final slash /
	$site_path=$_SERVER['REQUEST_URI'][strlen($_SERVER['REQUEST_URI'])-1]=='/' ? $_SERVER['REQUEST_URI'] : substr( $_SERVER['REQUEST_URI'], 0, strpos( $_SERVER['REQUEST_URI'], "sitebuilder" ));
	if (strpos($site_path,"http://")===false):
		$site_path='http://'.$_SERVER['HTTP_HOST'].$site_path;
	endif;
	if ($site_path[strlen($site_path)-1]=='/'):
		$site_path=substr($site_path,0,strlen($site_path)-1);
	endif;
	//only for localhost addresses
	if (strpos($site_path,"localhost")<>false  and strpos($site_path,"sitebuilder")===false):
		$site_path.='/sitebuilder';
	endif;
	$globvars['site_path']=$site_path;// local harddrive path
	$globvars['temp']=$globvars['local_root'].'/tmp';// local harddrive path

	include_once($globvars['local_root']."copyfiles/advanced/general/db_class.php");

	// Database configuration settings
	$dbs = new database_class;
	$dbs->host="localhost";
	$dbs->user="root";
	$dbs->password="";
	$dbs->name="sitebuilder";
	$dbs->type="mysql"; /* possible database types: mssql, mysql */

	//sitebuilder specific global variables

	$globvars['site']['directory']='';// directory of the working website
	if(is_file($globvars['local_root'].'core/status.php')):
		include($globvars['local_root'].'core/status.php');
	endif;
	if(is_file($globvars['local_root'].'core/editsite.php')):
		include($globvars['local_root'].'core/editsite.php');
	endif;
	if(is_file($globvars['local_root'].'core/server.php')):
		include($globvars['local_root'].'core/server.php');
	endif;
	
	//session global vars
	$_SESSION['error']['continue']=false;
?>