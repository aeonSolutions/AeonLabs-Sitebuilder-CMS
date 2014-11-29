<?php
$file_content="
<?php
// Global variables environment
//"."$"."staticvars['']='';
	//version
	"."$"."staticvars['version']='".$_SESSION['misc']['site_version']."';
	"."$"."staticvars['name']='".$_SESSION['misc']['site_name']."';
	
	//language settings
	"."$"."staticvars['language']['main']='".$_SESSION['language']['main']."';// website main language
	"."$"."staticvars['language']['available']='".$_SESSION['language']['available']."'; // available languages dot comma separated en;es;fr;

	//errors
	"."$"."staticvars['error']['flag']=false; // true if error occur
	"."$"."staticvars['error']['layout']='';// name of the file with the layout to load when error occurs
	"."$"."staticvars['error']['type']='';// type in {exclamation, question, info, prohibited}
	"."$"."staticvars['error']['message']='';

	/*/users
	"."$"."staticvars['users']['user_type']['admin']='';// admin group code
	"."$"."staticvars['users']['user_type']['guest']='';//guest group code
	"."$"."staticvars['users']['user_type']['default']='';//default group code
	"."$"."staticvars['users']['user_type']['auth']='';// authenticated group code
	"."$"."staticvars['users']['user_type']['cm']='';// content management group code
	"."$"."staticvars['users']['sid']=session_id();// session id
	"."$"."staticvars['users']['is_auth']=false;// flag true when user auth occurs
	"."$"."staticvars['users']['name']= isset("."$"."_SESSION['user']) ? "."$"."_SESSION['user'] : 0;// username
	"."$"."staticvars['users']['code']='';// db user code
	"."$"."staticvars['users']['group']='';// user group
	"."$"."staticvars['users']['email']='';// user email
	*/
	// site paths & files
	// returns the current hard drive directory not the root directory
	"."$"."staticvars['local_root']='".$_SESSION['paths']['local_root']."';// local harddrive path
	"."$"."staticvars['site_path']='".$_SESSION['paths']['site_path']."';// url address
	"."$"."staticvars['temp']="."$"."staticvars['local_root'].'tmp';// temp path
	"."$"."staticvars['upload']="."$"."staticvars['local_root'].'".$_SESSION['paths']['upload']."';// uploads path
	"."$"."staticvars['upload_path']="."$"."staticvars['site_path'].'/".$_SESSION['paths']['upload']."';// uploads path
	"."$"."staticvars['files']['max_size']='7';//tamanho maximo do ficheiro em MB

	// meta vars
	"."$"."staticvars['meta']['description']='".$_SESSION['meta']['description']."';
	"."$"."staticvars['meta']['keywords']='".$_SESSION['meta']['keywords']."';
	"."$"."staticvars['meta']['author']='SiteBuilder Version ".$globvars['version']."';
	"."$"."staticvars['meta']['robots']='".$_SESSION['meta']['robots']."';
	"."$"."staticvars['meta']['page_title']='".$_SESSION['misc']['page_title']."';

	// Database configuration settings
	"."$"."db = new database_class;
	"."$"."db->host='".$_SESSION['database']['host']."';
	"."$"."db->user='".$_SESSION['database']['user']."';
	"."$"."db->password='".$_SESSION['database']['password']."';
	"."$"."db->name='".$_SESSION['database']['name']."';
	"."$"."db->type='".$_SESSION['database']['type']."'; /* possible database types: mssql, mysql */

	//SMTP
	"."$"."staticvars['smtp']['enable']=".$_SESSION['smtp']['enable'].";
	"."$"."staticvars['smtp']['host']='".$_SESSION['smtp']['host']."';
	"."$"."staticvars['smtp']['user']='".$_SESSION['smtp']['user']."';
	"."$"."staticvars['smtp']['password']='".$_SESSION['smtp']['password']."';
	"."$"."staticvars['smtp']['admin_mail']='".$_SESSION['smtp']['admin_mail']."';
	
	//Cookies
	"."$"."staticvars['cookies']['enable']=".$_SESSION['cookies']['enable'].";
	"."$"."staticvars['cookies']['id']='".$_SESSION['cookies']['id']."';
	"."$"."staticvars['cookies']['expire']='".$_SESSION['cookies']['expire']."';
	"."$"."staticvars['cookies']['path']='".$_SESSION['cookies']['path']."';

?>";