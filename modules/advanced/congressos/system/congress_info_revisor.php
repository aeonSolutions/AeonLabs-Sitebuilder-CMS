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
include($staticvars['local_root'].'modules/congressos/system/settings.php');
$sa=mktime(0,0,0,$sa_mes,$sa_dia,$sa_ano);
$current=time();
$ps=mktime(0,0,0,$ps_mes,$ps_dia,$ps_ano);
echo '<h1><img src="'.$staticvars['site_path'].'/modules/congressos/images/info_user.gif" height="20"/>&nbsp;'.$inf[11].'</h1>';

$th=$db->getquery("select cod_theme from congress_revisor where cod_user='".$staticvars['users']['code']."'");
if($th[0][0]<>''):
	// themes
	$ths='and (';
	for($i=0;$i<count($th);$i++):
		$ths=$ths.' cod_theme='.$th[$i][0];
		$ths.= ($i<(count($th)-1)) ? ' or' : '';
	endfor;
	$ths.=')';
	// abstracts
	$p=$db->getquery("select cod_abstract from congress_abstracts where revised='n'".$ths);
	if($p[0][0]<>''):
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/clip.gif">&nbsp;'.$inf[5].' '.count($p).' '.$inf[10].' <a href="'.session($staticvars,'index.php?id='.return_id('congress_listings.php').'&selection=revisor').'"><strong>'.$inf[7].'</strong></a><br />';
	else:
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/clip.gif">&nbsp;'.$inf[9].'<br />';
	endif;
	// papers to review
	$p=array();
	$p=$db->getquery("select cod_abstract from congress_papers where revised='n'".$ths);
	if($p[0][0]<>''):
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/clip.gif">&nbsp;'.$inf[5].' '.count($p).' '.$inf[6].' <a href="'.session($staticvars,'index.php?id='.return_id('congress_listings.php').'&selection=papers').'">'.$inf[7].'</a><br />';
	else:
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/clip.gif">&nbsp;'.$inf[28].'<br />';
	endif;	
else:
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif">&nbsp;'.$inf[27].'<br />';
endif;
$p=$db->getquery("select cod_abs from congress_revision_abs where cod_revisor='".$staticvars['users']['code']."'");
if($p[0][0]<>''):
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/clip.gif">&nbsp;'.$inf[5].' '.count($p).' <a href="'.session($staticvars,'index.php?id='.return_id('congress_listings.php').'&selection=reviewed').'">'.$inf[26].'</a><br />';
endif;
echo '<p>&nbsp;</p>';
?>
