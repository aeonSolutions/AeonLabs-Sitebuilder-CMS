<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(is_file($staticvars['local_root'].'modules/congressos/system/settings.php')):
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
    if ($cell_space<>0):
		echo '<table width="100%" height="100%" border="0" cellspacing="'.$cell_space.'">'.chr(13).'<tr valign="top">'.chr(13).'<td>';
	endif;
	$lang= isset($_GET['lang']) ? $_GET['lang'] : $staticvars['language']['main'];
	if (isset($_GET['cat'])):
		$cats=$db->getquery("select folder from congress_category where cod_category='".mysql_escape_string($_GET['cat'])."'");
		if (is_file($staticvars['local_root'].'modules/congressos/contents/'.$cats[0][0].'/'.$lang.'/main.php')):
			include($staticvars['local_root'].'modules/congressos/contents/'.$cats[0][0].'/'.$lang.'/main.php');
		else:
			echo 'category no found! Bug?';
			include($staticvars['local_root'].'modules/congressos/system/errors/not_found.php');
		endif;
	elseif (isset($_GET['mnu'])):
		$mnu=mysql_escape_string($_GET['mnu']);
		$module=$db->getquery("select cod_module, name, link from module order by link");
		$menu=$db->getquery("select cod_category, cod_module from congress_menu where cod_menu='".$mnu."'");
		if($menu[0][0]<>''):
			if($menu[0][0]<>0):// categoria
				$cats=$db->getquery("select folder, nome from congress_category where cod_category='".$menu[0][0]."'");
				if (is_file($staticvars['local_root'].'modules/congressos/contents/'.$cats[0][0].'/'.$lang.'/main.php')):
					include($staticvars['local_root'].'modules/congressos/contents/'.$cats[0][0].'/'.$lang.'/main.php');
					if($cats[0][1]=='Abstract Submission'):
						include($staticvars['local_root'].'modules/congressos/contents_extended/abstract_submission/'.$lang.'/extend.php');					
					elseif($cats[0][1]=='Registration'):
						include($staticvars['local_root'].'modules/congressos/contents_extended/registration/'.$lang.'/extend.php');					
					elseif($cats[0][1]=='Paper Submission'):
						include($staticvars['local_root'].'modules/congressos/contents_extended/paper_submission/'.$lang.'/extend.php');					
					endif;
				else:
					echo 'category no found! Bug?';
					include($staticvars['local_root'].'modules/congressos/system/errors/not_found.php');
				endif;
			else:// module
				$cats=$db->getquery("select link, cod_user_type from module where cod_module='".$menu[0][1]."'");
				if (is_file($staticvars['local_root'].'modules/'.$cats[0][0])):
					if (get_authorization($cats[0][1],$staticvars)==false ):// error not authorized to view this page
						include($staticvars['local_root'].'modules/authoring/login_requiered.php');
					else: // credentials ok
						include($staticvars['local_root'].'modules/'.$cats[0][0]);
					endif;
				else:
					echo 'category no found! Bug?';
					include($staticvars['local_root'].'modules/congressos/system/errors/not_found.php');
				endif;
			endif;

		else:
	include($staticvars['local_root'].'modules/congressos/system/errors/not_found.php');
		endif;
	else:
		if($enable_mainpage):
			if (is_file($staticvars['local_root'].'modules/congressos/contents/mainpage/'.$lang.'/main.php')):
				include($staticvars['local_root'].'modules/congressos/contents/mainpage/'.$lang.'/main.php');
			else:
			include($staticvars['local_root'].'modules/congressos/system/errors/not_found.php');
			endif;
		else:
	include($staticvars['local_root'].'modules/congressos/system/errors/not_found.php');
		endif;
	endif;
    if ($cell_space<>0):
        echo '</td>'.chr(13).'</tr>'.chr(13).'</table>';
	endif;
else:
	echo 'You need to configure congressos general settings';
endif;
?>