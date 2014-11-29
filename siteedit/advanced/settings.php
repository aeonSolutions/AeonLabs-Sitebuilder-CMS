<?php
/*
File revision date: 12-Abr-2008
*/
if ( !defined('ON_SiTe')):
	echo 'not for direct access';
	exit;
endif;
$write_file=false;

//SMTP POST
if(isset($_POST['save_smtp'])):
	$staticvars['smtp']['enable']=$_POST['enable'];
	$staticvars['smtp']['host']=$_POST['host'];
	$staticvars['smtp']['user']=$_POST['user'];
	$staticvars['smtp']['password']=$_POST['password'];
	$staticvars['smtp']['admin_mail']=$_POST['admin_mail'];
	include($globvars['local_root'].'buildfiles/staticvars/build_edit.php');
	$write_file=true;
endif;

//Cookies Post
if(isset($_POST['save_cookies'])):
	$staticvars['cookies']['enable']=$_POST['enable'];
	$staticvars['cookies']['id']=$_POST['id'];
	$staticvars['cookies']['expire']=$_POST['expire'];
	$staticvars['cookies']['path']=$_POST['path'];
	include($globvars['local_root'].'buildfiles/staticvars/build_edit.php');
	$write_file=true;
endif;

//Language POST
if(isset($_POST['save_lang'])):
	$staticvars['language']['main']=$_POST['main'];
	$staticvars['language']['available']=$_POST['available'];
	include($globvars['local_root'].'buildfiles/staticvars/build_edit.php');
	$write_file=true;
endif;

//Database POST
if(isset($_POST['save_db'])):
	$db->type=$_POST['db_type'];
	$db->name=$_POST['name'];
	$db->host=$_POST['host'];
	$db->user=$_POST['username'];
	$db->password=$_POST['password'];
	include($globvars['local_root'].'buildfiles/staticvars/build_edit.php');
	$write_file=true;
endif;


//Meta tags POST
if(isset($_POST['save_meta'])):
	$staticvars['meta']['keywords']=$_POST['meta_keywords'];
	$staticvars['meta']['description']=$_POST['meta_description'];
	$staticvars['meta']['robots']='nofollow, index';

	$filename=$globvars['site']['directory'].'robots.txt';
	$file_content=$_POST['meta_robots'];
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
	include($globvars['local_root'].'buildfiles/staticvars/build_edit.php');
	$write_file=true;

endif;

//Misc Defs POST
if(isset($_POST['save_misc'])):
	$staticvars['meta']['page_title']=$_POST['page_title'];
	$staticvars['name']=$_POST['site_name'];
	$staticvars['version']=$_POST['site_version'];
	$filename=$globvars['local_root'].'tmp/misc.tmp';
	include($globvars['local_root'].'buildfiles/staticvars/build_edit.php');
	$write_file=true;
endif;

//paths POST
if(isset($_POST['save_paths'])):
	
	$loca_root=$_POST['local_root'];
	if ($loca_root[strlen($loca_root)-1]=='/' or $loca_root[strlen($loca_root)-1]=='\\'):
		$loca_root=substr($loca_root,0,strlen($loca_root)-1);
	endif;

	$tmp=$_POST['local_root'];
	$tmp=$tmp[strlen($tmp)-1]<>'/' ? $tmp.'/' : $tmp;
	$tmp=stripslashes($tmp); 
	if ($staticvars['local_root']<>$tmp):
		$staticvars['site_path']=$_POST['site_path'];
		$staticvars['local_root']=$tmp;
		if (copyr($globvars['site']['directory'],$tmp,$globvars)):
			delr($globvars['site']['directory']);
		endif;
	else:
		$old_addr=explode("://",$staticvars['site_path']);
		$new_addr=explode("://",$_POST['site_path']);
		if($old_addr<>$new_addr):
	        $dir=glob($globvars['site']['directory']."layout/templates/*",GLOB_ONLYDIR);
			if ($dir[0]<>''):
				for($i=0;$i<count($dir);$i++):
					$dirX=explode("/",$dir[$i]);
					$filename=explode(".",$dirX[count($dirX)-1]);
					$dir_name=$filename[0];
					$code=file_get_contents($globvars['site']['directory'].'layout/templates/'.$dir_name.'.php');
					$code=str_replace($old_addr,$new_addr,$code);
					$filename=$globvars['site']['directory'].'layout/templates/'.$dir_name.'.php';
					if (file_exists($filename)):
						unlink($filename);
					endif;
					if (!$handle = fopen($filename, 'a')):
						echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
						exit;
					endif;
					if (fwrite($handle, $code) === FALSE):
						echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
						exit;
					endif;
					fclose($handle);	
					// update css file
					if (strpos("-".$code,"<link")):
						// retrieve css file name
						$init=strpos($code,"<link");
						$final=strpos($code,"/>",$init);
						$filename=substr($code,$init,$final-$init);
						$filename=explode("href",$filename);
						$filename=explode('"',$filename[1]);
						$filename=explode("/",$filename[1]);
						$css_file=$filename[count($filename)-1];
						if ($css_file=='default.css' and strpos("-".$code,"<link",$final)):
							// retrieve css file name
							$init=strpos($code,"<link",$final);
							$final=strpos($code,"/>",$init);
							$filename=substr($code,$init,$final-$init);
							$filename=explode("href",$filename);
							$filename=explode('"',$filename[1]);
							$filename=explode("/",$filename[1]);
							$css_file=$filename[count($filename)-1];
						endif;
						if ($css_file<>'default.css'):					
							$code_css=file_get_contents($globvars['site']['directory']."layout/templates/".$dir_name."/".$css_file);
							$code_css=str_replace($old_addr,$new_addr,$code_css);
							$filename=$globvars['site']['directory']."layout/templates/".$dir_name."/".$css_file;
							if (file_exists($filename)):
								unlink($filename);
							endif;
							if (!$handle = fopen($filename, 'a')):
								echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
								exit;
							endif;
							if (fwrite($handle, $code_css) === FALSE):
								echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
								exit;
							endif;
							fclose($handle);	
						endif;
					endif;
				endfor;
			endif;			
			$staticvars['site_path']=$_POST['site_path'];
		else:
			$staticvars['site_path']=$_POST['site_path'];
		endif;
		$staticvars['upload']=$_POST['upload'];	
		$tmp2=stripslashes($_POST['upload']);
		if ($staticvars['upload']<>$tmp2):
			if (copyr($staticvars['upload'],$tmp2,$globvars)):
				delr($staticvars['upload']);
			endif;
		endif;
	endif;
	$write_file=true;

	$file_content="
	<?PHP
	// New site status file
	"."$"."globvars['site']['sid']='".$globvars['site']['sid']."';
	"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
	"."$"."globvars['site']['name']='".$globvars['site']['name']."';
	"."$"."globvars['site']['directory']='".$tmp."';
	?>";
	$filename=$globvars['local_root'].'core/editsite.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
	include($globvars['local_root'].'buildfiles/staticvars/build_edit.php');
endif;

if($write_file):
	$filename=$globvars['site']['directory'].'kernel/staticvars.php';
	@unlink($filename);
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
	if ($staticvars['smtp']['enable']==false):
		delr($globvars['site']['directory'].'general/email');
	else:
		copyr($globvars['local_root'].'copyfiles/advanced/general/email',$globvars['site']['directory'].'general/email',$globvars);
	endif;
	echo '<font class="body_text"> <font color="#FF0000">Settings saved!</font></font>';
endif;
//load vars into session env
include($globvars['site']['directory'].'kernel/staticvars.php');

if (isset($_GET['gen'])):
	$staticvars['cookies']['id']=md5( uniqid( rand () ) );
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

if (isset($_GET['set'])):
	if(is_numeric($_GET['set'])):
		if ($_GET['set']>=0 and $_GET['set']<=7):
			$set=$_GET['set'];
		endif;
	endif;
endif;
?>
<h2><img src="<?=$globvars['site_path'];?>/images/design.gif" alt="settings" width="32" height="32">
  Define site properties<br>
</h2>
<hr size="1" color="#666666" />
<p></p><p></p>  <p></p>  
<?php
include($globvars['local_root'].'siteedit/advanced/settings/'.$load[$set]);
?>

