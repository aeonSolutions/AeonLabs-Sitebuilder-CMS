<?php
/*
File revision date: 10-abr-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

$profile_id=return_id('profile_edit.php');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/authoring/language/pt.php');
else:
	include($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php');
endif;

?>
<h4>&nbsp;<?=$pi[0];?>, <?=$_SESSION['user'];?></h4>
<hr size="1" />
<a href="<?=session($staticvars,'index.php?id='.$profile_id);?>"><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/login.gif" title="<?=$pi[1];?>" border="0" height="25"></a>&nbsp;
	<a  href="<?=$staticvars['site_path'].'/index.php?logout=-1';?>"><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/log.gif" title="<?=$pi[2];?>" border="0" height="25"></a>&nbsp;    
<hr size="1" />
<?php
// add profiles from other modules
	$dir_mods=glob($staticvars['local_root'].'modules/*',GLOB_ONLYDIR);
	$query=$db->getquery('select link,cod_module from module');
	if ($dir_mods[0]<>''):
		for($ii=0; $ii<count($dir_mods); $ii++):
			if(is_file($dir_mods[$ii].'/system/profile_info.php') ):
				include($dir_mods[$ii].'/system/profile_info.php');
			endif;
		endfor;
	endif;
?>
