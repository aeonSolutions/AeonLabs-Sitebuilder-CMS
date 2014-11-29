<?php
/*
File revision date: 19-Nov-2008
*/
// engine - dynamic layout
if ($self_skin<>'default'):
	include($self_skin);
else:
	// atencao ao cod_skin! - verificar quando nao esta definida nenhuma skin!
	$cells_layout=$db->getquery("select cell, cod_module from skin_layout order by cell ASC, priority ASC");
	if ($cells_layout[0][0]==''):
		echo 'you need to define a page layout first!';
		exit;
	endif;
	$max_cells=$cells_layout[count($cells_layout)-1][0];
	
	for($x=0;$x<=$max_cells+1;$x++):
		$l_titulo[$x]='';// titulo
		$l_module[$x]='';//module
		$l_cod_module[$x]='';// cod_module
		$index[$x]=0;// cod_module
	endfor;
	
	$login_requiered=return_id('login_requiered.php');
	// menu
	$l_titulo[0][0]='';
	$l_module[0][0]=$staticvars['local_root'].'layout/menu/menu.php';
	$l_cod_module[0][0]='';
	for($x=0;$x<count($cells_layout);$x++):
		$cell=$cells_layout[$x][0];
		if ($staticvars['users']['is_auth']):
			$module=$db->getquery("select cod_module,link,name,display_name from module where (cod_user_type='".$staticvars['users']['user_type']['admin']."' or cod_user_type='".$staticvars['users']['group']."' or cod_user_type='".$staticvars['users']['user_type']['default']."' or cod_user_type='".$staticvars['users']['user_type']['auth']."') and published='s' and cod_module=".$cells_layout[$x][1]);
		else:
			$module=$db->getquery("select cod_module, link,name,display_name from module where (cod_user_type='".$staticvars['users']['user_type']['guest']."' or cod_user_type='".$staticvars['users']['user_type']['default']."') and published='s' and cod_module=".$cells_layout[$x][1]);
		endif;
		if ($module[0][0]<>''):
			$l_titulo[$cell+1][$index[$cell+1]]='';
			$l_module[$cell+1][$index[$cell+1]]=$staticvars['local_root'].'modules/'.$module[0][1];
			$l_cod_module[$cell+1][$index[$cell+1]]=$module[0][0];
			$index[$cell+1]=$index[$cell+1]+1;
		endif;
	endfor;

	if($task<>''):
		$l_titulo[1]=array();
		if ($staticvars['users']['is_auth']):
			$module=$db->getquery("select cod_module,link,name,display_name,cod_user_type from module where (cod_user_type='".$staticvars['users']['user_type']['admin']."' or cod_user_type='".$staticvars['users']['group']."' or cod_user_type='".$staticvars['users']['user_type']['default']."' or cod_user_type='".$staticvars['users']['user_type']['auth']."') and published='s' and cod_module=".$task);
		else:
			$module=$db->getquery("select cod_module, link,name,display_name,cod_user_type from module where (cod_user_type='".$staticvars['users']['user_type']['guest']."' or cod_user_type='".$staticvars['users']['user_type']['default']."') and published='s' and cod_module=".$task);
		endif;
		if (get_authorization($module[0][4],$staticvars)==false ):// error not authorized to view this page
			if ($login_requiered==-1):
				include($staticvars['local_root'].'general/error.php');
				load_unauthorized_acess("Está a tentar aceder a uma area reservada. Para poder continuar necessita de se <a href='".session($staticvars,'index.php?id='.$login.'&navto='.$task)."'>autenticar</a>.");
			else:
				$l_titulo[1][0]='';
				$l_module[1][0]=$staticvars['local_root'].'modules/authoring/login_requiered.php';
				$l_cod_module[1][0]=$login_requiered;
			endif;
		else: // credentials ok
			if ($module[0][0]<>''):
				$l_titulo[1][0]='';
				$l_module[1][0]=$staticvars['local_root'].'modules/'.$module[0][1];
				$l_cod_module[1][0]=$task;
				$dirc=explode("/",$module[0][1]);
				if ($task<>'' and is_file($staticvars['local_root'].'modules/'.$dirc[0].'/system/meta_tags.php')):
					include($staticvars['local_root'].'modules/'.$dirc[0].'/system/meta_tags.php');
				endif;
			else:
				include($staticvars['local_root'].'general/error.php');
				load_unauthorized_acess('ERROR(Core 4) - On locating the module to the corresponding id! or you do not have privileges to view.<br>Please Hit the Back Button. Thank You.');
			endif;
		endif;
	endif;
	// layout template to load
	include($staticvars['local_root'].'layout/templates/'.$cod_skin[0][1]);
	unset($l_titulo);
	unset($l_module);
	unset($l_cod_module);
endif;
?>