<?php
$file_content="
<?php
// Global variables environment
//"."$"."staticvars['']='';
	//version
	"."$"."staticvars['version']='".$staticvars['version']."';
	"."$"."staticvars['name']='".$staticvars['name']."';
	
	//language settings
	"."$"."staticvars['language']['main']='".$staticvars['language']['main']."';// website main language
	"."$"."staticvars['language']['available']='".$staticvars['language']['available']."'; // available languages dot comma separated en;es;fr;

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
	"."$"."staticvars['local_root']='".$staticvars['local_root']."';// local harddrive path
	"."$"."staticvars['site_path']='".$staticvars['site_path']."';// url address
	"."$"."staticvars['temp']="."$"."staticvars['local_root'].'tmp';// temp path
	"."$"."staticvars['upload']='".$staticvars['upload']."';// uploads path
	"."$"."staticvars['upload_path']='".$staticvars['upload_path']."';// uploads path
	"."$"."staticvars['files']['max_size']='7';//tamanho maximo do ficheiro em MB

	// meta vars
	"."$"."staticvars['meta']['description']='".$staticvars['meta']['description']."';
	"."$"."staticvars['meta']['keywords']='".$staticvars['meta']['keywords']."';
	"."$"."staticvars['meta']['author']='SiteBuilder Version ".$globvars['version']."';
	"."$"."staticvars['meta']['robots']='".$staticvars['meta']['robots']."';
	"."$"."staticvars['meta']['page_title']='".$staticvars['meta']['page_title']."';

	// Database configuration settings
	"."$"."db = new database_class;
	"."$"."db->host='".$db->host."';
	"."$"."db->user='".$db->user."';
	"."$"."db->password='".$db->password."';
	"."$"."db->name='".$db->name."';
	"."$"."db->type='".$db->type."'; /* possible database types: mssql, mysql */

	//SMTP
	"."$"."staticvars['smtp']['enable']=".$staticvars['smtp']['enable'].";
	"."$"."staticvars['smtp']['host']='".$staticvars['smtp']['host']."';
	"."$"."staticvars['smtp']['user']='".$staticvars['smtp']['user']."';
	"."$"."staticvars['smtp']['password']='".$staticvars['smtp']['password']."';
	"."$"."staticvars['smtp']['admin_mail']='".$staticvars['smtp']['admin_mail']."';
	
	//Cookies
	"."$"."staticvars['cookies']['enable']=".$staticvars['cookies']['enable'].";
	"."$"."staticvars['cookies']['id']='".$staticvars['cookies']['id']."';
	"."$"."staticvars['cookies']['expire']='".$staticvars['cookies']['expire']."';
	"."$"."staticvars['cookies']['path']='".$staticvars['cookies']['path']."';

?>";