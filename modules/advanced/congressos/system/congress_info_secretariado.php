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
echo '<h3><img src="'.$staticvars['site_path'].'/modules/congressos/images/secretariado.gif"/>&nbsp;'.$inf[11].'</h3>';
echo '&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/congressos/images/submitted.gif"/>&nbsp;<a href="'.session($staticvars,'index.php?id='.return_id('congress_listings.php')).'&selection=secretariat">'.$inf[4].'</a><br>';
// downloads
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_downloads.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/disk.gif" alt="'.$inf[23].'" border="0">&nbsp;'.$inf[23].'</a><br>';
// statistics
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('statistics.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/stats.gif" alt="'.$inf[24].'" border="0">&nbsp;'.$inf[24].'</a><br>';
?>
