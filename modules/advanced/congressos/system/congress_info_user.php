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
echo '<h2><img src="'.$staticvars['site_path'].'/modules/congressos/images/info_user.gif"/>&nbsp;Info</h2>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/disk.gif">&nbsp;<a href="'.session($staticvars,'index.php?id='.return_id('congress_listings.php').'&selection=user').'">'.$inf[2].'</a><br>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/submitted.gif">&nbsp;<a href="'.session($staticvars,'index.php?id='.return_id('abstract_submit.php')).'">'.$inf[3].'</a><br>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/icon_categorias.gif">&nbsp;<a href="'.session($staticvars,'index.php?id='.return_id('paper_submit.php')).'">'.$inf[1].'</a><br>';
echo '<p>&nbsp;</p>';
?>
