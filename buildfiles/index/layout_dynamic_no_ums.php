<?php
/*
File revision date: 14-abr-2008
*/
// Dynamic Layout
$module='default';

if($task==-1):
	$task='';
endif;
if ($task<>''):
	$query=$db->getquery("select name, link, published, cod_user_type,self_skin, cod_skin from module where cod_module=".$task);
	if ($query[0][0]<>''):
		if ($query[0][4]=='yes'): // modulo com self skin
				include($local_root.'modules/'.$query[0][1]);
		else: // modulo sem self skin
			if ($query[0][5]=='' or $query[0][5]==0):
				$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where active='s'");
			else:
				$cod_skin=$db->getquery("select cod_skin,ficheiro from skin where cod_skin='".$query[0][5]."'");
			endif;	
			if ($cod_skin[0][0]==''  or $cod_skin[0][0]==0):
				$cod_skin[0][1]='default.php';
			endif;
			include($staticvars['local_root'].'layout/templates/'.$cod_skin[0][1]);
		endif;
	else: // module not found in DB
		$task='';
	endif;//$query[0][0]<>''
endif;

if ($task==''):
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
	include($staticvars['local_root'].'layout/templates/'.$cod_skin[0][1]);
endif;
