<?php
$task=@$_GET['id'];
$link=strip_address("type",$_SERVER['REQUEST_URI']);
echo '<div align="right"><a href="'.$link.'"><img border="0" title="go to previous" src="'.$globvars['site_path'].'/images/back.png" /></a></div><h3>Existing templates</h3>Select one to view details<br /><br />';
$dir_files = glob($globvars['local_root']."layouts/templates/*",GLOB_ONLYDIR);
$j=1;
if ($dir_files[count($dir_files)-1]==''):
	$nums=count($dir_files)-1;
else:
	$nums=count($dir_files);
endif;
echo '<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">'.chr(13).'<tr>';
for($i=0; $i < $nums; $i++):
	$fl=explode("/",$dir_files[$i]);
	$name=explode(".",$fl[count($fl)-1]);
	$location=explode(".",$fl[count($fl)-1]);
	if(!is_file($globvars['local_root'].'layouts/templates/'.$location[0].'/preview.jpg')):
		$location=$globvars['site_path'].'/images/no_preview.jpg';
	else:
		$location=$globvars['site_path'].'/layouts/templates/'.$location[0].'/preview.jpg';	
	endif;
	$sr= '';
	$sr .= '<br><font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id='.@$_GET['id'].'&type=view&file='.$fl[count($fl)-1]).'" target="_self">view</a>]&nbsp;&nbsp;[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id='.@$_GET['id'].'&type=skin&file='.$fl[count($fl)-1]).'" target="_self">Edit</a>]<br>'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;".chr(13);
	echo '<td width="190" align="center" valign="bottom"><img src="'.$location.'" border="1">'.$sr.'<br><br></td>';
	$j++;
	if ($j>3):
		$j=1;
		echo '</tr>'.chr(13).'<tr>';
	endif;
endfor;
if ($j<4):
	for ($i=$j;$i<4;$i++):
		echo '<td valign="top" align="center"></td>';
	endfor;
endif;
echo '</table><br><br>';
?>