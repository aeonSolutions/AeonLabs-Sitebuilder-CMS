<?php
/*
File revision date: 28-jul-2008
*/
if(is_file($staticvars['local_root'].'modules/pages/system/settings.php')):
	include($staticvars['local_root'].'modules/pages/system/settings.php');
    if ($cell_space<>0):
		echo '<table width="100%" height="100%" border="0" cellspacing="'.$cell_space.'">'.chr(13).'<tr valign="top">'.chr(13).'<td>';
	endif;
	if (is_file($staticvars['local_root'].'modules/pages/system/id_file.php')):
		include($staticvars['local_root'].'modules/pages/system/id_file.php');
	else:
		include($staticvars['local_root'].'modules/pages/system/functions.php');
		rebuild_id_file($staticvars);
		include($staticvars['local_root'].'modules/pages/system/id_file.php');
	endif;
	$lang= isset($_GET['lang']) ? $_GET['lang'] : $staticvars['language']['main'];
	if (isset($_GET['did'])):
		$did=mysql_escape_string($_GET['did']);
		$dirname=$file_id[$did];
		if(isset($_GET['goto'])):
			$goto=$_GET['goto'];
		else:
			$goto='main.php';
		endif;
		if (is_file($staticvars['local_root'].'modules/pages/webpages/'.$dirname.'/'.$lang.'/'.$goto)):
			include($staticvars['local_root'].'modules/pages/webpages/'.$dirname.'/'.$lang.'/'.$goto);
		else:
			include($staticvars['local_root'].'modules/pages/system/errors/not_found.php');
		endif;
	else:
		if($enable_mainpage):
			if (is_file($staticvars['local_root'].'modules/pages/webpages/mainpage/'.$lang.'/mainpage.php')):
				include($staticvars['local_root'].'modules/pages/webpages/mainpage/'.$lang.'/mainpage.php');
			else:
				include($staticvars['local_root'].'modules/pages/system/errors/not_found.php');
			endif;
		else:
			include($staticvars['local_root'].'modules/pages/system/errors/not_found.php');
		endif;
	endif;
    if ($cell_space<>0):
        echo '</td>'.chr(13).'</tr>'.chr(13).'</table>';
	endif;
else:
	echo 'You need to configure Pages general settings';
endif;
?>