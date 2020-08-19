<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
//Start settings POST
if (isset($_POST['start'])):
	$_SESSION['smtp']['enable']=array();	
	$_SESSION['cookies']['enable']=array();
	unset($_SESSION['cookies']);
	unset($_SESSION['smtp']);	
	$_SESSION['settings']['start']=true;
	if(is_file($globvars['local_root'].'tmp/smtp.tmp')):
		unlink($globvars['local_root'].'tmp/smtp.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/cookies.tmp')):
		unlink($globvars['local_root'].'tmp/cookies.tmp');
	endif;
	if(isset($_POST['cookie'])):
		$_SESSION['cookies']['enable']=true;
	else:
		$_SESSION['cookies']['enable']=0;
		$filename=$globvars['local_root'].'tmp/cookies.tmp';
		$file_content="
		<?PHP
		// Cookies
		".'$'."_SESSION['cookies']['enable']=0;
		".'$'."_SESSION['cookies']['id']='';
		".'$'."_SESSION['cookies']['expire']='';
		".'$'."_SESSION['cookies']['path']='';
		?>";
		$handle = fopen($filename, 'a');
		if(fwrite($handle, $file_content)==false):
			$globvars['warnings']='Unable to write file:'.$filename;
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit;
			endif;
		endif;
		fclose($handle);
	endif;
	if(isset($_POST['smtp'])):
		$_SESSION['smtp']['enable']=true;
	else:	
		$_SESSION['smtp']['enable']=0;
		$filename=$globvars['local_root'].'tmp/smtp.tmp';
		$file_content="
		<?PHP
		// SMTP Settings
		".'$'."_SESSION['smtp']['enable']=0;
		".'$'."_SESSION['smtp']['host']='';
		".'$'."_SESSION['smtp']['user']='';
		".'$'."_SESSION['smtp']['password']='';
		".'$'."_SESSION['smtp']['admin_mail']='';
		?>";
		if(is_file($filename)):
			unlink($filename);
		endif;
		$handle = fopen($filename, 'a');
		if(fwrite($handle, $file_content)==false):
			$globvars['warnings']='Unable to write file:'.$filename;
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit;
			endif;
		endif;
		fclose($handle);
    	if (is_dir($globvars,$globvars['site']['directory'].'email')):
			if(delr($globvars,$globvars['site']['directory'].'email', $globvars)==false):
				$globvars['warnings']='Unable to delete file/directory:'.$globvars['site']['directory'].'email';
				add_error($globvars['warnings'],__LINE__,__FILE__);
				$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
				$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
				if($globvars['error']['critical']):
					$_SESSION['cerr']=true;
					header("Location: ".$_SERVER['REQUEST_URI']);
					exit;
				endif;
			endif;
		endif;
	endif;

elseif(!isset($_POST['start']) and !isset($_SESSION['settings']['start'])):
	@unlink($globvars['local_root'].'tmp/smtp.tmp');
	@unlink($globvars['local_root'].'tmp/cookies.tmp');
	@unlink($globvars['local_root'].'tmp/database.tmp');
	@unlink($globvars['local_root'].'tmp/language.tmp');
	@unlink($globvars['local_root'].'tmp/misc.tmp');
	@unlink($globvars['local_root'].'tmp/paths.tmp');
	@unlink($globvars['local_root'].'tmp/meta_tags.tmp');
	$_SESSION['settings']=array();
endif;


//Language POST
if(isset($_POST['save_lang'])):
	$filename=$globvars['local_root'].'tmp/language.tmp';
	$file_content="
	<?PHP
	// Language Settings
	".'$'."_SESSION['language']['main']='".$_POST['main']."';
	".'$'."_SESSION['language']['available']='".$_POST['available']."';
	?>";
	if (is_file($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
endif;


//Misc Defs POST
if(isset($_POST['save_misc'])):
	$filename=$globvars['local_root'].'tmp/misc.tmp';
	$file_content="
	<?PHP
	// General Settings
	".'$'."_SESSION['misc']['site_name']=".'"'.utf8_encode($_POST['site_name']).'"'.";
	".'$'."_SESSION['misc']['site_version']=".'"'.utf8_encode($_POST['site_version']).'"'.";
	".'$'."_SESSION['misc']['page_title']=".'"'.utf8_encode($_POST['page_title']).'"'.";
	?>";
	if (is_file($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
endif;
//Database POST
if(isset($_POST['save_db'])):
	$cuser= ($_POST['cred_user']<>'') ? $_POST['cred_user'] : "boxvenue_main";
	$cpass= ($_POST['cred_pass']<>'') ? $_POST['cred_pass'] : "migalhas";
	$link=mysql_connect($_POST['host'], $cuser, $cpass);
	if (!$link):
		$globvars['warnings']='Could not connect to Database Server: Bad Root username/password?';
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			sleep(1);
			echo $globvars['warnings'];
			//header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	
/* not valid to boxvenue.net
	if (isset($_POST['db_exists'])):
		$result=mysql_query("DROP DATABASE ".$_POST['db_exists']);
		if (!$result):
			$globvars['warnings']='Could not DELETE exiting DB....';
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
	endif;
*/
	$result=mysql_query("CREATE DATABASE ".$_POST['name']);
	$result=mysql_query("CREATE USER '".$_POST['username']."'@'%' IDENTIFIED BY '".$_POST['password']."'");
	$result=mysql_query("SET PASSWORD FOR '".$_POST['username']."'@'%' = PASSWORD( '".$_POST['password']."' )");
	$result=mysql_query("GRANT USAGE ON * . * TO '".$_POST['username']."'@'%' IDENTIFIED BY '".$_POST['password']."' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0");
	$result=mysql_query("GRANT ALL PRIVILEGES ON `".$_POST['name']."` . * TO '".$_POST['username']."'@'%' WITH GRANT OPTION");
	@mysql_close($link);
	if (!$result):
		$globvars['warnings']='Could not perform DB tasks: CREATE USER / SET PASS / GRANT PRIVILEGES';
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=false; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			sleep(1);
			
			echo 'here';//header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
 
	$_SESSION['database']['type']=$_POST['db_type'];
	$_SESSION['database']['name']=$_POST['name'];
	$_SESSION['database']['host']=$_POST['host'];
	$_SESSION['database']['username']=$_POST['username'];
	$_SESSION['database']['password']=$_POST['password'];

	include($globvars['local_root'].'update_db/install_db.php');
	$filename=$globvars['local_root'].'tmp/database.tmp';
	$file_content="
	<?PHP
	// SMTP Settings
	".'$'."_SESSION['database']['type']='".$_POST['db_type']."';
	".'$'."_SESSION['database']['user']='".$_POST['username']."';
	".'$'."_SESSION['database']['password']='".$_POST['password']."';
	".'$'."_SESSION['database']['host']='".$_POST['host']."';
	".'$'."_SESSION['database']['name']='".$_POST['name']."';
	?>";
	if (is_file($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
endif;

//paths POST
if(isset($_POST['save_paths'])):
// store contents to local tmp file
	if(!isset($_SESSION['error']['continue'])):// first time here
    	$delFile=$globvars['local_root'].'tmp/paths.tmp';
		if (is_file($delFile)):
			unlink($delFile);
		endif;
		$filename=$globvars['local_root'].'tmp/paths.tmp';
		$_SESSION['paths']['site_path']=$_POST['local_root'];
		$_SESSION['paths']['upload']=$_POST['upload'];

		$file_content="
		<?PHP
		// Paths Settings
		".'$'."_SESSION['paths']['site_path']='".$_POST['site_path']."';
		".'$'."_SESSION['paths']['local_root']='".$globvars['local_root']."'tmp';
		".'$'."_SESSION['paths']['upload']='".$_POST['upload']."';
		?>";
		$handle = fopen($filename, 'a');
		if(fwrite($handle, $file_content)==false):
			$globvars['warnings']='Unable to write file:'.$filename;
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit;
			endif;
		endif;
		fclose($handle);
	else:
		include($globvars['local_root'].'tmp/paths.tmp');
	endif;
// create base webapp directory
	$loca_root=$_SESSION['paths']['site_path'];
	if ($loca_root[strlen($loca_root)-1]=='/' or $loca_root[strlen($loca_root)-1]=='\\'):
		$loca_root=substr($loca_root,0,strlen($loca_root)-1);
	endif;
	
	$loca_root=substr($globvars['local_root'],0,strpos($globvars['local_root'],$globvars['directory_name'])).$loca_root;
	echo 'LINE 277:'.$loca_root;
	if(!@mkdir($loca_root, 0755, true) and !isset($_SESSION['error']['continue'], 0755, true)):
		$globvars['warnings']='Unable to create website main directory('.$loca_root.'). Already exists?';
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='question';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
// update status file
	$file_content="
	<?PHP
	// New site status file
	"."$"."globvars['site']['sid']='".$globvars['site']['sid']."';
	"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
	"."$"."globvars['site']['type']='".$globvars['site']['type']."';
	"."$"."globvars['site']['directory']='".$tmp."';
	?>";
	$filename=$globvars['local_root'].'core/status.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);

	copyr($globvars['local_root'].'copyfiles/advanced/kernel',$loca_root.'/kernel',$globvars);
	copyr($globvars['local_root'].'copyfiles/advanced/general',$loca_root.'/general',$globvars);
	if (!is_dir($loca_root.'/layout')):
		@mkdir($loca_root.'/layout', 0755, true);
	endif;
	if (!is_dir($loca_root.'/layout/templates')):
		@mkdir($loca_root.'/layout/templates', 0755, true);
	endif;
	if (!is_dir($loca_root.'/modules')):
		@mkdir($loca_root.'/modules', 0755, true);
	endif;
	if (!is_dir($loca_root.'/layout')):
		@mkdir($loca_root.'/layout', 0755, true);
	endif;
	if (!is_dir($loca_root.'/tmp')):
		@mkdir($loca_root.'/tmp', 0755, true);
	endif;
	if (!is_dir($loca_root.'/sql')):
		@mkdir($loca_root.'/sql', 0755, true);
	endif;
	if (!is_dir($loca_root.'/'.$_SESSION['paths']['upload'])):
		@mkdir($loca_root.'/'.$_SESSION['paths']['upload'], 0755, true);
	endif;		

	$_SESSION['directory']=$loca_root.'/';
endif;


//SMTP POST
if(isset($_POST['save_smtp'])):

	$filename=$globvars['local_root'].'tmp/smtp.tmp';
	$file_content="
	<?PHP
	// SMTP Settings
	".'$'."_SESSION['smtp']['enable']=0;
	".'$'."_SESSION['smtp']['host']='".$_POST['host']."';
	".'$'."_SESSION['smtp']['user']='".$_POST['user']."';
	".'$'."_SESSION['smtp']['password']='".$_POST['password']."';
	".'$'."_SESSION['smtp']['admin_mail']='".$_POST['admin_mail']."';
	?>";
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
	include_once($globvars['local_root'].'core/status.php');
	copyr($globvars['local_root'].'copyfiles/advanced/email',$globvars['site']['directory'].'/email',$globvars);
endif;

//Cookies Post
if(isset($_POST['save_cookies'])):
	$filename=$globvars['local_root'].'tmp/cookies.tmp';
	$file_content="
	<?PHP
	// Cookies
	".'$'."_SESSION['cookies']['enable']=true;
	".'$'."_SESSION['cookies']['id']='".$_POST['id']."';
	".'$'."_SESSION['cookies']['expire']='".$_POST['expire']."';
	".'$'."_SESSION['cookies']['path']='".$_POST['path']."';
	?>";
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
endif;

//Meta tags POST
if(isset($_POST['save_meta'])):
	$filename=$globvars['local_root'].'tmp/meta_tags.tmp';
	$file_content="
	<?PHP
	// Meta Tags
	".'$'."_SESSION['meta']['keywords']='".normalize_chars($_POST['meta_keywords'])."';
	".'$'."_SESSION['meta']['description']='".normalize_chars($_POST['meta_description'])."';
	".'$'."_SESSION['meta']['robots']='nofollow, index';
	?>";
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
	$filename=$_SESSION['directory'].'robots.txt';
	$file_content=$_POST['meta_robots'];
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=false; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
endif;

// Wrapp it up save static vars and reload
if( is_file($globvars['local_root'].'tmp/misc.tmp') and is_file($globvars['local_root'].'tmp/paths.tmp') and is_file($globvars['local_root'].'tmp/meta_tags.tmp') and is_file($globvars['local_root'].'tmp/database.tmp') and is_file($globvars['local_root'].'tmp/language.tmp') and is_file($globvars['local_root'].'tmp/smtp.tmp') and is_file($globvars['local_root'].'tmp/cookies.tmp')):
	include($globvars['local_root'].'tmp/misc.tmp');
	include($globvars['local_root'].'tmp/meta_tags.tmp');
	include($globvars['local_root'].'tmp/paths.tmp');
	include($globvars['local_root'].'tmp/database.tmp');
	include($globvars['local_root'].'tmp/language.tmp');
	include($globvars['local_root'].'tmp/smtp.tmp');
	include($globvars['local_root'].'tmp/database.tmp');
	include($globvars['local_root'].'tmp/cookies.tmp');
	include($globvars['local_root'].'buildfiles/staticvars/build.php');
	$filename=$globvars['site']['directory'].'kernel/staticvars.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			sleep(1);
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
	if ($_SESSION['smtp']['enable']==false):
		delr($globvars,$globvars['site']['directory'].'email');
	else:
		copyr($globvars['local_root'].'copyfiles/advanced/email',$globvars['site']['directory'].'email',$globvars);
	endif;
	header("Location: ".strip_address("set",strip_address("step",$_SERVER['REQUEST_URI'])));
	exit;
endif;

//load vars into session env
if(isset($_SESSION['directory'])):
	if(is_file($_SESSION['directory'].'kernel/staticvars.php')):
		include($_SESSION['directory'].'kernel/staticvars.php');
		//Cookies
		$_SESSION['cookies']['id']=$staticvars['cookies']['id'];
		$_SESSION['cookies']['expire']=$staticvars['cookies']['expire'];
		$_SESSION['cookies']['path']=$staticvars['cookies']['path'];
		//SMTP
		$_SESSION['smtp']['admin_mail']=$staticvars['smtp']['admin_mail'];
		$_SESSION['smtp']['host']=$staticvars['smtp']['host'];
		$_SESSION['smtp']['username']=$staticvars['smtp']['user'];
		$_SESSION['smtp']['password']=$staticvars['smtp']['password'];
		//language
		$_SESSION['language']['main']=$staticvars['language']['main'];
		$_SESSION['language']['available']=$staticvars['language']['available'];
		//database
		$_SESSION['database']['type']=$db->type;
		$_SESSION['database']['name']=$db->name;
		$_SESSION['database']['host']=$db->host;
		$_SESSION['database']['username']=$db->user;
		$_SESSION['database']['password']=$db->password;
		//misc
		$_SESSION['misc']['page_title']=$staticvars['meta']['page_title'];
		$_SESSION['misc']['site_version']=$staticvars['version'];
		$_SESSION['misc']['site_name']=$staticvars['name'];	
		//paths
		$_SESSION['paths']['site_path']=$staticvars['site_path'];
		$_SESSION['paths']['local_root']=$staticvars['local_root'];
		$_SESSION['paths']['upload']=str_replace($staticvars['local_root'],"",$staticvars['upload']);
		
		// Meta tags
		$_SESSION['meta']['keywords']=$staticvars['meta']['keywords'];
		$_SESSION['meta']['description']=$staticvars['meta']['description'];
		$_SESSION['meta']['robots']=$staticvars['meta']['robots'];
	endif;
else:
	//Cookies
	$_SESSION['cookies']['id']=md5( uniqid( rand () ) );
	$_SESSION['cookies']['expire']='60*60*24*15';
	$_SESSION['cookies']['path']='/';
	//SMTP
	$_SESSION['smtp']['admin_mail']='contact@boxvenue.net';
	$_SESSION['smtp']['host']='localhost';
	$_SESSION['smtp']['username']='';
	$_SESSION['smtp']['password']='';
	//language
	$_SESSION['language']['main']='pt';
	$_SESSION['language']['available']='pt;en';
	//database
	$_SESSION['database']['type']='mysql';
	$_SESSION['database']['name']='';
	$_SESSION['database']['host']='localhost';
	$_SESSION['database']['username']='';
	$_SESSION['database']['password']='';
	//misc
	$_SESSION['misc']['page_title']='Bem vindo a';
	$_SESSION['misc']['site_version']='1.0';
	$_SESSION['misc']['site_name']='';	
	//paths
	$_SESSION['paths']['site_path']='http://www.';
	$_SESSION['paths']['local_root']=substr(__FILE__,0,strpos(__FILE__,$globvars['directory_name']));
	$_SESSION['paths']['upload']='upload';
	
	// Meta tags
	$_SESSION['meta']['keywords']='';
	$_SESSION['meta']['description']='';
	$_SESSION['meta']['robots']='
User-agent: W3C-checklink
Allow: /

User-agent: MSIECrawler
Allow: /

User-agent: Googlebot-Image
Allow: /

User-agent: psbot
Allow: /

User-agent: NetMechanic
Allow: /

User-agent: ia_archiver
Allow: /

User-agent: sitecheck.internetseer.com
Allow: /

User-agent: LinkWalker
Allow: /

User-agent: FreeFind
Allow: /

User-agent: MondoSearch
Allow: /

User-agent: Spiderline
Allow: /

User-agent: fusionbot
Allow: /

User-agent: WebReaper
Allow: /

User-agent: NPBot
Allow: /

User-agent: *
Disallow: /images/
Disallow: /favicon.ico
	';
	if(is_file($globvars['local_root'].'tmp/misc.tmp')):
		include($globvars['local_root'].'tmp/misc.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/meta_tags.tmp')):
		include($globvars['local_root'].'tmp/meta_tags.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/paths.tmp')):
		include($globvars['local_root'].'tmp/paths.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/database.tmp')):
		include($globvars['local_root'].'tmp/database.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/language.tmp')):
		include($globvars['local_root'].'tmp/language.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/smtp.tmp')):
		include($globvars['local_root'].'tmp/smtp.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/database.tmp')):
		include($globvars['local_root'].'tmp/database.tmp');
	endif;
	if(is_file($globvars['local_root'].'tmp/cookies.tmp')):
		include($globvars['local_root'].'tmp/cookies.tmp');
	endif;
endif;
if (isset($_GET['gen'])):
	$_SESSION['cookies']['id']=md5( uniqid( rand () ) );
endif;

$load[0]='start.php';
$load[1]='misc.php';
$load[2]='paths.php';
$load[3]='meta_tags.php';
$load[4]='db.php';
$load[5]='lang.php';
$load[6]='smtp.php';
$load[7]='cookies.php';
$set=0;  
if(!isset($_SESSION['settings']['start'])):
	$set=0;
elseif(!is_file($globvars['local_root'].'tmp/misc.tmp')):
	$set=1;
elseif(!is_file($globvars['local_root'].'tmp/paths.tmp')):
	$set=2;
elseif(!is_file($globvars['local_root'].'tmp/meta_tags.tmp')):
	$set=3;
elseif(!is_file($globvars['local_root'].'tmp/database.tmp')):
	$set=4;
elseif(!is_file($globvars['local_root'].'tmp/language.tmp')):
	$set=5;
elseif(!is_file($globvars['local_root'].'tmp/smtp.tmp') and $_SESSION['smtp']['enable']==true):
	$set=6;
elseif(!is_file($globvars['local_root'].'tmp/cookies.tmp') and $_SESSION['cookies']['enable']==true):
	$set=7;
else:
	if (isset($_GET['set'])):
		$set=8;
	endif;
endif;

if (isset($_GET['set'])):
	if(is_numeric($_GET['set'])):
		if ($_GET['set']>=0 and $_GET['set']<=7):
			if ($_GET['set']<$set):
				$set=$_GET['set'];
			endif;
		endif;
	endif;
endif;
if (isset($_SESSION['smtp']['enable'])):
	if($_SESSION['smtp']['enable']==false and $_SESSION['cookies']['enable']==false and $set>5):
		header("Location: ".strip_address("set",strip_address("step",$_SERVER['REQUEST_URI'])));
		exit;
	elseif($_SESSION['smtp']['enable']==true and $_SESSION['cookies']['enable']==false and $set>6):
		header("Location: ".strip_address("set",strip_address("step",$_SERVER['REQUEST_URI'])));
		exit;
	elseif($_SESSION['smtp']['enable']==false and $set==6 and $_SESSION['cookies']['enable']==true):
		$set=7;
	endif;
endif;
$comp='style="border-bottom: #009900 solid 2px"';
$to_do='style="border-bottom:#FF0000 solid 2px"';
?>
<h2><img src="<?=$globvars['site_path'];?>/images/design.gif" alt="settings" width="32" height="32">
  Define site properties<br>
</h2>
<hr size="1" color="#666666" />
<table border="0" align="right">
  <tr>
    <td width="20" <?=$set<=0?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=0');?>"><img src="<?=$globvars['site_path'];?>/images/set_start.gif" alt="Start" width="20" height="20" border="0"></a></td>
    <td width="20" <?=$set<=1?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=1');?>"><img src="<?=$globvars['site_path'];?>/images/set_misc.gif" alt="General Settings" width="20" height="20" border="0"></a></td>
    <td width="20" <?=$set<=2?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=2');?>"><img src="<?=$globvars['site_path'];?>/images/paths.gif" alt="Paths" width="20" height="20" border="0"></a></td>
    <td width="20" <?=$set<=3?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=3');?>"><img src="<?=$globvars['site_path'];?>/images/meta_tags.gif" alt="Meta tags" width="20" height="20" border="0"></a></td>
    <td width="20" <?=$set<=4?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=4');?>"><img src="<?=$globvars['site_path'];?>/images/db.gif" alt="Database" width="20" height="20" border="0"></a></td>
    <td width="20" <?=$set<=5?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=5');?>"><img src="<?=$globvars['site_path'];?>/images/set_lang.gif" alt="Language Settings" width="20" height="20" border="0"></a></td>
    <td width="20" <?=$set<=6?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=6');?>"><img src="<?=$globvars['site_path'];?>/images/set_email.gif" alt="Email Settings" width="20" height="20" border="0"></a></td>
    <td width="20" <?=$set<=7?$to_do:$comp;?>><a href="<?=session_setup($globvars,'index.php?set=7');?>"><img src="<?=$globvars['site_path'];?>/images/cookies.gif" alt="cookies" width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td colspan="8" align="right">
    <?php
    if (isset($_GET['step'])):
		echo '<a href="'.strip_address("step",strip_address("set",$_SERVER['REQUEST_URI'])).'">Continue Wizard</a>';
	endif;
	?></td>
  </tr>
</table>
<p></p><p></p>  <p></p>  
<?php

include($globvars['local_root'].'wizard/advanced/settings/'.$load[$set]);
?>

