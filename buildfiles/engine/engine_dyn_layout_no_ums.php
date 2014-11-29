<?php
/*
File revision date: 19-Nov-2008
*/
// engine - dynamic layout
if ($self_skin<>'default'):
	include($self_skin);
else:
	// atencao ao cod_skin! - verificar quando nao esta definida nenhuma skin!
	$cells_layout=$db->getquery("select cell, cod_module from skin_layout where cod_skin='".$cod_skin[0][0]."' order by cell ASC, priority ASC");
	$max_cells=$cells_layout[count($cells_layout)-1][0];
	
	for($x=0;$x<=$max_cells+1;$x++):
		$l_titulo[$x]='';// titulo
		$l_module[$x]='';//module
		$l_cod_module[$x]='';// cod_module
		$index[$x]=0;// cod_module
	endfor;
	
	// menu
	$l_titulo[0][0]='';
	$l_module[0][0]=$staticvars['local_root'].'layout/menu/menu.php';
	$l_cod_module[0][0]='';
	for($x=0;$x<count($cells_layout);$x++):
		$cell=$cells_layout[$x][0];
		$module=$db->getquery("select cod_module, link,name,display_name from module published='s' and cod_module=".$cells_layout[$x][1]);
		if ($module[0][0]<>''):
			$l_titulo[$cell+1][$index[$cell+1]]='';
			$l_module[$cell+1][$index[$cell+1]]=$staticvars['local_root'].'modules/'.$module[0][1];
			$l_cod_module[$cell+1][$index[$cell+1]]=$module[0][0];
			$index[$cell+1]=$index[$cell+1]+1;
		endif;
	endfor;

	if($task<>''):
		$l_titulo[1]=array();
		$module=$db->getquery("select cod_module, link,name,display_name,cod_user_type from module where published='s' and cod_module=".$task);
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
	// layout template to load
	include($staticvars['local_root'].'layout/templates/'.$cod_skin[0][1]);
	unset($l_titulo);
	unset($l_module);
	unset($l_cod_module);
endif;







include_once($staticvars['local_root'].'kernel/engine_funcs.php');
if($cell==-1):// menu
	include($staticvars['local_root'].'layout/menu/menu.php');
elseif ($task==''):
	$layout=$db->getquery('select cod_module, priority from skin_layout where cell='.$cell.' and cod_skin='.$cod_skin[0][0].' order by priority ASC');
	if ($layout[0][0]<>''):
		for ($ii=0; $ii<count($layout);$ii++):
			$module=$db->getquery("select cod_module, link,name,display_name from module where published='s' and cod_module=".$layout[$ii][0]);
			if ($module[0][0]<>''):
				if($module[0][3]<>'' and $module[0][3]<>'N/A'):
					$be_titulo=box_effects($module,$lang);
					$be_link_module=$staticvars['local_root'].'modules/'.$module[0][1];
					$be_cod_module=$layout[$ii][0];
					include($staticvars['local_root'].'layout/box_effects/box_effects.php');
				endif;
			endif;
		endfor;
	endif;
elseif($task<>''): // $task <>''
			$layout=$db->getquery("select cell from skin_layout where cod_module='".$task."' and cod_skin='".$cod_skin[0][0]."'");
			if ($layout[0][0]<>''): // esta configurado no skin layout
				$module_cell=$layout[0][0];			
			else: // nao esta configurado no skin layout
				$module_cell=0;
			endif;
			if ($cell==$module_cell):
				$module=$db->getquery("select link, cod_user_type,name,display_name from module where published='s' and cod_module='".$task."'");
				if ($module[0][0]<>''):
					$be_titulo=box_effects($module,$lang);
					$be_link_module='modules/'.$module[0][0];
					$be_cod_module=$task;
					include($staticvars['local_root'].'layout/box_effects/box_effects.php');
				endif;
			else: // the current loading column is different than the column in the module -> Load all default modules to the current column
				$layout=$db->getquery('select cod_module, priority from skin_layout where cell='.$cell.' and cod_skin='.$cod_skin[0][0].' order by priority ASC');
				if ($layout[0][0]<>''):
					$ii=0;
					while($ii<count($layout)):
						$module=$db->getquery("select cod_module, link,name,display_name from module where (cod_user_type='".$staticvars['users']['user_type']['guest']."' or cod_user_type='".$staticvars['users']['user_type']['default']."') and published='s' and cod_module=".$layout[$ii][0]);
						if ($module[0][0]<>''):
							$be_titulo=box_effects($module,$lang);
							$be_link_module='modules/'.$module[0][1];
							$be_cod_module=$layout[$ii][0];
							include($staticvars['local_root'].'layout/box_effects/box_effects.php');
						endif;
						$ii++;
					endwhile;
				endif; // if ($layout[0][0]<>''):
			endif; // if ($cell==$module_cell):
else: // invalid id request

	include($staticvars['local_root'].'general/error.php');
	load_unauthorized_acess("ERROR(Core 2) - The requested page does not exist! Please Hit the Back Button. Thank You.");
endif; // if ($task==''):

?>