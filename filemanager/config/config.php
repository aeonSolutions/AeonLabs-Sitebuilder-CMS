<?
	require_once($globvars['local_root']."filemanager/config/accesscontrol.php");
	
	$group = getUserConfiguration();
	if(file_exists($globvars['local_root']."filemanager/config/useraccesscontrol/".$group."/config.php"))
		require_once($globvars['local_root']."filemanager/config/useraccesscontrol/".$group."/config.php");
?>