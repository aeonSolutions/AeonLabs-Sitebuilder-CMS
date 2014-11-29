<?php
/*
File revision date: 14-jan-2008
*/
function check_status($local_root){
$step='none';
if((!is_file($local_root.'kernel/settings/layout.php'))or (!is_file($local_root.'kernel/settings/ums.php'))):
	update_status($local_root,0);
else:
	include($local_root.'general/staticvars.php');
	$link=mysql_connect($db->host, $db->user, $db->password);
	if (!$link):
	   echo 'Could not connect to mysql (is wizard - setup)';
	   exit;
	endif;
	if(!$result=mysql_select_db($db->name)):
		update_status($local_root,0);
		$step='none';
		return;
	endif;
	
	//Step 1  - General Settings
	if (!is_file($local_root.'general/staticvars.php')):
		update_status($local_root,1);
		$step='none';
		return;
	else:	//Step 2 & 3 - Desgin Layout - skin and box effects
		include($local_root.'kernel/settings/layout.php');
		if ($layout=='dynamic'):
			$skin=$db->getquery("select cod_skin from skin");
			if ($skin[0][0]<>''):
				$step=3;
			else:
				update_status($local_root,2);
				$step='none';
				return;
			endif;
		else:
			if($layout_name<>''):
				$step=4;
			else:
				update_status($local_root,2);
				$step='none';
				return;
			endif;
		endif;
		if ($box_fx=='installed'):
			$boxfx=$db->getquery("select box_code from box_effects");
			if ($boxfx[0][0]<>''):
				if (count($boxfx)==1):
					$step=3;
					return;
				else:
					$step=4;
				endif;
			else:
				update_status($local_root,3);
				$step=3;
				return;
			endif;
		else:
			update_status($local_root,4);
			$step=4;
		endif;
	endif;
	// Step 4 - User Management System
	if (is_file($local_root.'kernel/settings/ums.php')):
		$step=5; // goto step 5
	else:
		update_status($local_root,4);
		$step='none';
		return;
	endif;
	// Step 5- Web Site main Menu
	if (is_file($local_root.'kernel/settings/menu.php')):
		$step=6; // goto step 6
	else:
		update_status($local_root,5);
		$step='none';
		return;
	endif;
	// Step 6 - WebSite Modules
	$query=$db->getquery("select cod_module from module");
	if ($query[0][0]<>'' or is_file($local_root.'tmp/modules.php')):
		$step=7; // goto step 7
	else:
		update_status($local_root,6);
		$step='none';
		return;
	endif;
	// Step 7 - Features
	if (is_file($local_root.'kernel/settings/features.php')):
		$step=8; // goto step 8
	else:
		update_status($local_root,7);
		$step='none';
		return;
	endif;
	// Step 8 - Build files
	if (!is_file($local_root.'index.php')):
		update_status($local_root,8);
		$step=8;
		return;
	else:
		update_status($local_root,'finished');
		$step='none';
		return;
	endif;
	if ($step<>'none'):
		update_status($local_root,$step);
		return;
	endif;
endif;
};


//check step
$file_to_load[0]='ws_selector.php';
$file_to_load[1]='install_site.php';
$file_to_load[2]='skin.php';
$file_to_load[3]='box_effects.php';
$file_to_load[4]='users.php';
$file_to_load[5]='menu.php';
$file_to_load[6]='modules.php';
$file_to_load[7]='features.php';
$file_to_load[8]='finished.php';

$text_to_load[0]='Static Variables Environment.';
$text_to_load[1]='General Web Settings';
$text_to_load[2]='WebSite Skin Layout';
$text_to_load[3]='WebSite Box-Fx';
$text_to_load[4]='WebSite User Groups';
$text_to_load[5]='WebSite Main Menu Settings';
$text_to_load[6]='WebSite Modules';
$text_to_load[7]='Assign Contents to the WebPage Layout';
$text_to_load[8]='Wizard Setup Complete.';
// update status file if any changes were made 
check_status($local_root);
// end of status update




if(!is_file($local_root.'general/staticvars.php')):
	$step=0;
	$step_to=0;
else:
	$step_to=0;
	if (!isset($_GET['step'])):
		include($local_root.'core/status.php');
		if ($status==='finished' ):
			$step=8;
		else:
			$step=$status;	
		endif;
	else:
		$step=@$_GET['step'];
		$step_to=$step;
		include($local_root.'core/status.php');
		$step_to=$status;
		if ($step_to=='finished'):
			$step_to=8;
		endif;
	endif;
	include($local_root.'general/staticvars.php');
	// inicializa&ccedil;&atilde;o de fun&ccedil;&otilde;es
//	include_once($local_root.'core/functions.php'); 
//	include_once($local_root.'kernel/functions.php'); 
	if (!isset($file_to_load[$step])):
		$step=0;
		$step_to=$step;
	else:
		if($file_to_load[$step]==''):
			$step=0;
			$step_to=$step;
		endif;
	endif;
endif;	
$img='';
for ($i=0;$i<=8;$i++):
	if ($i>$step_to):
		$img.='<img src="wizard/images/icon_off.jpg" alt="'.($i+1).'º Passo incompleto" width="23" height="23" border=0 />';
	elseif($i>($step)):
		$img.='<a href="'.'index.php?taskid='.@$_GET['taskid'].'&step='.$i.'&mode=wizard'.'"><img src="wizard/images/icon_done.gif" alt="'.($i+1).'º Passo incompleto" width="23" height="23" border=0 /></a>';
	elseif($i==($step)):
		$img.='<img src="wizard/images/icon_do.gif" alt="'.($i+1).'º Passo incompleto" width="23" height="23" border=0 />';
	else:
		$img.='<a href="'.'index.php?taskid='.@$_GET['taskid'].'&step='.$i.'&mode=wizard'.'"><img src="wizard/images/icon_ok.jpg" alt="'.($i+1).'º Passo completo" width="23" height="23" border=0 /></a>';
	endif;
endfor;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?=$img;?></br><strong><?=$text_to_load[$step];?></strong></td>
  </tr>
  <tr>
    <td>
	<?php
	include($local_root.'wizard/'.$file_to_load[$step]);
	?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

