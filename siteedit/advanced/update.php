<?php
/*
File revision date: 7-jul-2009
*/
if ( !defined('ON_SiTe')):
	echo 'not for direct access';
	exit;
endif;
if(isset($_GET['update'])):
	$module=$_GET['update'];
	if($module=='editor'):
		delr($globvars['site']['directory'].'editor');
		copyr($globvars['local_root'].'copyfiles/editor',$globvars['site']['directory'].'editor',$globvars);
		echo '<font class="body_text"> <font color="#FF0000">System Update Succeeded! ('.$module.')</font></font>';
	elseif($module=='kernel'):
		@unlink($globvars['local_root'].'tmp/staticvars.php');
		@unlink($globvars['local_root'].'tmp/features.php');
		$s[0]=false;
		$s[1]=false;
		$s[2]=false;
		if(is_file($globvars['site']['directory'].'kernel/stats_management.php')):
			$s[0]=true;
		endif;
		if(is_file($globvars['site']['directory'].'kernel/error_logging.php')):
			$s[1]=true;
		endif;
		if(is_file($globvars['site']['directory'].'kernel/search_spiders.php')):
			$s[2]=true;
		endif;
		copyr($globvars['site']['directory'].'kernel/staticvars.php',$globvars['local_root'].'tmp/staticvars.php',$globvars);
		copyr($globvars['site']['directory'].'kernel/features.php',$globvars['local_root'].'tmp/features.php',$globvars);
		copyr($globvars['site']['directory'].'kernel/settings',$globvars['local_root'].'tmp/settings',$globvars);
		delr($globvars['site']['directory'].'kernel');	
		//make the update		
		copyr($globvars['local_root'].'copyfiles/advanced/kernel',$globvars['site']['directory'].'kernel',$globvars);
		copyr($globvars['local_root'].'tmp/settings',$globvars['site']['directory'].'kernel/settings',$globvars);
		copyr($globvars['local_root'].'tmp/staticvars.php',$globvars['site']['directory'].'kernel/staticvars.php',$globvars);
		copyr($globvars['local_root'].'tmp/features.php',$globvars['site']['directory'].'kernel/features.php',$globvars);
		if($s[0]==true):
			copyr($globvars['local_root'].'copyfiles/advanced/features/stats_management.php',$globvars['site']['directory'].'kernel/stats_management.php',$globvars);			
		endif;
		if($s[1]==true):
			copyr($globvars['local_root'].'copyfiles/advanced/features/error_logging.php',$globvars['site']['directory'].'kernel/error_logging.php',$globvars);			
		endif;
		if($s[2]==true):
			copyr($globvars['local_root'].'copyfiles/advanced/features/search_spiders.php',$globvars['site']['directory'].'kernel/search_spiders.php',$globvars);			
		endif;
		@unlink($globvars['local_root'].'tmp/staticvars.php');
		@unlink($globvars['local_root'].'tmp/features.php');
		echo '<font class="body_text"> <font color="#FF0000">System Update Succeeded! ('.$module.')</font></font>';
	elseif($module=='general'):
		delr($globvars['site']['directory'].'general');
		copyr($globvars['local_root'].'copyfiles/advanced/general',$globvars['site']['directory'].'general',$globvars);
		echo '<font class="body_text"> <font color="#FF0000">System Update Succeeded! ('.$module.')</font></font>';
	elseif($module=='email'):
		delr($globvars['site']['directory'].'email');
		copyr($globvars['local_root'].'copyfiles/advanced/email',$globvars['site']['directory'].'email',$globvars);
		echo '<font class="body_text"> <font color="#FF0000">System Update Succeeded! ('.$module.')</font></font>';
	elseif($module=='index'):
		copyr($globvars['local_root'].'buildfiles/index/version.php',$globvars['site']['directory'].'version.php',$globvars);
		include($globvars['local_root'].'buildfiles/build.php');
		echo '<font class="body_text"> <font color="#FF0000">System Update Succeeded! ('.$module.')</font></font>';
	elseif($module=='layout'):
		if(is_file($globvars['local_root'].'copyfiles/advanced/layout/update/update.php')):
			include($globvars['local_root'].'copyfiles/advanced/layout/update/update.php');
			for($h=0;$h<count($update);$h++):
				delr($globvars['site']['directory'].'layout/'.$update[$h]);
				copyr($globvars['local_root'].'copyfiles/advanced/layout/'.$update[$h],$globvars['site']['directory'].'layout/'.$update[$h],$globvars);
			endfor;
			echo '<font class="body_text"> <font color="#FF0000">System Update Succeeded! ('.$module.')</font></font>';
		else:
			echo '<font class="body_text"> <font color="#FF0000">Update Module Failed! Module not found! ('.$module.')</font></font>';
		endif;
	else:
		if(is_file($globvars['local_root'].'modules/advanced/'.$module.'/update/update.php')):
			include($globvars['local_root'].'modules/advanced/'.$module.'/update/update.php');
			for($h=0;$h<count($update);$h++):
				delr($globvars['site']['directory'].'modules/'.$module.'/'.$update[$h]);
				copyr($globvars['local_root'].'modules/advanced/'.$module.'/'.$update[$h],$globvars['site']['directory'].'modules/'.$module.'/'.$update[$h],$globvars);
			endfor;
			echo '<font class="body_text"> <font color="#FF0000">Update Module Succeeded! ('.$module.')</font></font>';
		else:
			echo '<font class="body_text"> <font color="#FF0000">Update Module Failed! Module not found! ('.$module.')</font></font>';
		endif;
	endif;
endif;
echo '<h3>System files</h3>';
echo '<table align="center" border="0" cellspacing="0" cellpadding="0">';
//kernel files
if(is_file($globvars['local_root'].'copyfiles/advanced/kernel/version.php') ):
	$server_version='0.0';
	include($globvars['local_root'].'copyfiles/advanced/kernel/version.php');
	$server_version=$sys_version;
else:
	$server_version='0.0';
endif;
if(is_file($globvars['site']['directory'].'/kernel/version.php') ):
	$sys_version='0.0';
	include($globvars['site']['directory'].'/kernel/version.php');
else:
	$sys_version='0.0';
endif;
if($server_version>$sys_version):
	$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=kernel">Update</a>';
elseif($server_version=$sys_version):
	$update='<a style="color:green;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=kernel">Update</a>';
else:
	$update='<a style="color:#006699;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=kernel">Update</a>';
endif;
echo '<td align="left">';
echo '<h3>Kernel&nbsp;&nbsp;<font style="font-size:10px; ">'.$update.'</font></h3><blockquote>installed: '.$sys_version.'<br>Available: '.$server_version.'</blockquote>';
echo '</td><td width="10"><div style="height: 100px;border-right: 1px solid black;width: 1px; voice-family: "\"}/*\"";  width: 0px;"></div></td>';
//general files
if(is_file($globvars['local_root'].'copyfiles/advanced/general/version.php') ):
	include($globvars['local_root'].'copyfiles/advanced/general/version.php');
	$server_version=$sys_version;
else:
	$server_version='0.0';
endif;
if(is_file($globvars['site']['directory'].'/general/version.php') ):
	include($globvars['site']['directory'].'/general/version.php');
else:
	$sys_version='0.0';
endif;
if($server_version>$sys_version):
	$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=general">Update</a>';
elseif($server_version=$sys_version):
	$update='<a style="color:green;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=general">Update</a>';
else:
	$update='<a style="color:#006699;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=general">Update</a>';
endif;
echo '<td align="left">';
echo '<h3>General&nbsp;&nbsp;<font style="font-size:10px; ">'.$update.'</font></h3><blockquote>installed: '.$sys_version.'<br>Available: '.$server_version.'</blockquote>';
echo '</td><td width="10"><div style="height: 100px;border-right: 1px solid black;width: 1px; voice-family: "\"}/*\"";  width: 0px;"></div></td>';
//email files
if(is_file($globvars['local_root'].'copyfiles/advanced/email/version.php') ):
	include($globvars['local_root'].'copyfiles/advanced/email/version.php');
	$server_version=$sys_version;
else:
	$server_version='0.0';
endif;
if(is_file($globvars['site']['directory'].'/email/version.php') ):
	include($globvars['site']['directory'].'/email/version.php');
else:
	$sys_version='0.0';
endif;
if($server_version>$sys_version):
	$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=email">Update</a>';
elseif($server_version=$sys_version):
	$update='<a style="color:green;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=email">Update</a>';
else:
	$update='<a style="color:#006699;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=email">Update</a>';
endif;
echo '<td align="left">';
echo '<h3>Email&nbsp;&nbsp;<font style="font-size:10px; ">'.$update.'</font></h3><blockquote>installed: '.$sys_version.'<br>Available: '.$server_version.'</blockquote>';
echo '</td><td width="10"><div style="height: 100px;border-right: 1px solid black;width: 1px; voice-family: "\"}/*\"";  width: 0px;"></div></td>';
//layout files
if(is_file($globvars['local_root'].'copyfiles/advanced/layout/version.php') ):
	include($globvars['local_root'].'copyfiles/advanced/layout/version.php');
	$server_version=$sys_version;
else:
	$server_version='0.0';
endif;
if(is_file($globvars['site']['directory'].'/layout/version.php') ):
	include($globvars['site']['directory'].'/layout/version.php');
else:
	$sys_version='0.0';
endif;
if($server_version>$sys_version):
	$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=layout">Update</a>';
elseif($server_version=$sys_version):
	$update='<a style="color:green;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=layout">Update</a>';
else:
	$update='<a style="color:#006699;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=layout">Update</a>';
endif;
echo '<td align="left">';
echo '<h3>Layout&nbsp;&nbsp;<font style="font-size:10px; ">'.$update.'</font></h3><blockquote>installed: '.$sys_version.'<br>Available: '.$server_version.'</blockquote>';
echo '</td><td width="10"><div style="height: 100px;border-right: 1px solid black;width: 1px; voice-family: "\"}/*\"";  width: 0px;"></div></td>';
//editor files
if(is_file($globvars['local_root'].'copyfiles/editor/version.php') ):
	include($globvars['local_root'].'copyfiles/editor/version.php');
	$server_version=$sys_version;
else:
	$server_version='0.0';
endif;
if(is_file($globvars['site']['directory'].'/editor/version.php') ):
	include($globvars['site']['directory'].'/editor/version.php');
else:
	$sys_version='0.0';
endif;
if($server_version>$sys_version):
	$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=editor">Update</a>';
elseif($server_version=$sys_version):
	$update='<a style="color:green;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=editor">Update</a>';
else:
	$update='<a style="color:#006699;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=editor">Update</a>';
endif;
echo '<td align="left">';
echo '<h3>Editor&nbsp;&nbsp;<font style="font-size:10px; ">'.$update.'</font></h3><blockquote>installed: '.$sys_version.'<br>Available: '.$server_version.'</blockquote>';
echo '</td><td width="10"><div style="height: 100px;border-right: 1px solid black;width: 1px; voice-family: "\"}/*\"";  width: 0px;"></div></td>';
//index file
if(is_file($globvars['local_root'].'buildfiles/index/version.php') ):
	include($globvars['local_root'].'buildfiles/index/version.php');
	$server_version=$sys_version;
else:
	$server_version='0.0';
endif;
if(is_file($globvars['site']['directory'].'/version.php') ):
	include($globvars['site']['directory'].'/version.php');
else:
	$sys_version='0.0';
endif;
$update=false;
if($server_version>$sys_version):
	$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=index">Update</a>';
elseif($server_version=$sys_version):
	$update='<a style="color:green;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=index">Update</a>';
else:
	$update='<a style="color:#006699;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update=index">Update</a>';
endif;
echo '<td align="left">';
echo '<h3>Index&nbsp;&nbsp;<font style="font-size:10px; ">'.$update.'</font></h3><blockquote>installed: '.$sys_version.'<br>Available: '.$server_version.'</blockquote>';
echo '</td><td width="10"><div style="height: 100px;border-right: 1px solid black;width: 1px; voice-family: "\"}/*\"";  width: 0px;"></div></td>';

echo '</table>';
echo '<hr size="1">';
echo '<h3>Modules</h3>';
// search modules
	include($globvars['site']['directory'].'kernel/staticvars.php');
	$dir_mods=glob($globvars['site']['directory'].'modules/*',GLOB_ONLYDIR);
	$query=$db->getquery('select link,cod_module from module');
	if ($dir_mods[0]<>''):
		$rows=1;
		echo '<table align="center" border="0" cellspacing="0" cellpadding="0">';
		for($ii=0; $ii<count($dir_mods); $ii++):
			if($rows==1):
				echo '<tr>';
			endif;
			$tmp=explode("/",$dir_mods[$ii]);
			$module_name=$tmp[count($tmp)-1];
			if(is_file($globvars['local_root'].'modules/advanced/'.$module_name.'/admin/version.php') ):
				include($globvars['local_root'].'modules/advanced/'.$module_name.'/admin/version.php');
				$server_version=$module_version;
			else:
				$server_version='0.0';
			endif;
			if(is_file($dir_mods[$ii].'/admin/version.php') ):
				include($dir_mods[$ii].'/admin/version.php');
			else:
				$module_version='0.0';
			endif;
			$update=false;
			if($server_version<=$module_version):
				$update=false;
				$msg='server version';
			endif;
			if( is_file($globvars['local_root'].'modules/advanced/'.$module_name.'/update/update.php')):
				$update=true;
			else:
				$msg= '<font style="color:#006699;">Unavailable</font>';
			endif;
			if($update==true):
				if($server_version>$module_version):
					$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update='.$module_name.'">Update</a>';
				elseif($server_version=$module_version):
					$update='<a style="color:green;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update='.$module_name.'">Update</a>';
				else:
					$update='<a style="color:red;" href="'.strip_address("update",$_SERVER['REQUEST_URI']).'&update='.$module_name.'">Update</a>';
				endif;
			else:
				$update=$msg;
			endif;
			echo '<td align="left">';
			echo '<h3>'.$module_name.'&nbsp;&nbsp;<font style="font-size:10px; ">'.$update.'</font></h3><blockquote>installed: '.$module_version.'<br>Available: '.$server_version.'</blockquote>';
			echo '</td><td width="10"><div style="height: 100px;border-right: 1px solid black;width: 1px; voice-family: "\"}/*\"";  width: 0px;"></div></td>';
			$rows++;
			if($rows>5):
				echo '</tr>'.chr(13);
				$rows=1;
			endif;
		endfor;
		echo '</table>';
	endif;
?>
