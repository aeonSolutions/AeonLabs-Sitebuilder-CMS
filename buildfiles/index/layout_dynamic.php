<?php
/*
File revision date: 14-abr-2008
*/
// Dynamic Layout

$self_skin='default';
if($task==-1):
	$task='';
endif;
if ($task<>''):
	$module=$db->getquery("select link, cod_user_type,name,display_name,self_skin, cod_skin from module where published='s' and cod_module='".$task."'");
	if ($module[0][0]<>''):
		if ($module[0][4]=='yes'): // modulo com self skin
			if (($module[0][1]==$staticvars['user']['group']) or $module[0][1]==$staticvars['users']['user_type']['admin'] or $module[0][1]==$staticvars['users']['user_type']['default'] or ($staticvars['users']['is_auth']==true and $module[0][1]==$staticvars['users']['user_type']['auth'])): // authorized to view the module
				$self_skin=$staticvars['local_root'].'modules/'.$module[0][0];
			else: // error not authorized to view this page
				include('general/error.php');
				load_unauthorized_acess("ERROR(Index 1) - You are not authorized to view this page! Please Hit the Back Button. Thank You.");
			endif;
		else: // modulo sem self skin
			if ($module[0][5]=='' or $module[0][5]==0):
				$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where active='s'");
			else:
				$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where cod_skin='".$module[0][5]."'");
			endif;	
			if ($cod_skin[0][0]==''  or $cod_skin[0][0]==0):
				$cod_skin[0][1]='default.php';
			endif;
		endif;
	else: // module not found in DB
		$task='';
		$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where active='s'");
		if ($cod_skin[0][0]==''  or $cod_skin[0][0]==0):
			$cod_skin[0][1]='default.php';
		endif;
	endif;//$query[0][0]<>''
else:
	if (isset($_GET['areaid'])):
		$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where cod_skin='".mysql_escape_string($_GET['areaid'])."'");
		if ($cod_skin[0][0]==''):
			$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where active='s'");
		endif;
	else:
		$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where active='s'");	
	endif;
	if ($cod_skin[0][0]==''  or $cod_skin[0][0]==0):
		$cod_skin[0][1]='default.php';
	endif;
endif;
?>