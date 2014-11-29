<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;

$cats=$db->getquery("select cod_category, titulo, descricao from congress_dl_category where active='s'");
if($cats[0][0]<>''):
	echo '<h2>'.$d[0].'</h2>';
	for($i=0;$i<count($cats);$i++):
		echo '<h3>'.$cats[$i][1].'</h3>';
		echo '<p>'.$cats[$i][2].'</p>';
		$dw=$db->getquery("select cod_download, ficheiro, nome from congress_download where cod_category='".$cats[$i][0]."'");
		if($dw[0][0]<>''):
			echo '<ul>';
			for($j=0;$j<count($dw);$j++):
				echo '<li><a href="'.session($staticvars,'index.php?id='.$_GET['id'].'&mnu='.$_GET['mnu'].'&dw='.$dw[$j][0]).'">'.$dw[$j][2].'</a>';
			endfor;
			echo '</ul>';
		endif;
	endfor;
else:
	echo $d[1];
endif;
if(isset($_GET['dw'])):
	$dw=$db->getquery("select ficheiro from congress_download where cod_download='".mysql_escape_string($_GET['dw'])."'");
	include($staticvars['local_root'].'kernel/initialize_download.php');
	initialize_download($staticvars,'congress/downloads/'.$dw[0][0],'header'); // relative file path
endif;
?>