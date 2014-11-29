<?php
/*
File revision date: 4-apr-2009
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
echo '<h4>'.$inf[11].'</h4>';
//general
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_general.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/manage_folder.gif" title="'.$inf[15].'" border="0">&nbsp;'.$inf[15].'</a><br>';
//deadlines
if($sa=="//" or $na=="//" or $sp=="//" or $np=="//" or $rp=="//"):
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_deadlines.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif" title="'.$inf[12].'" border="0">&nbsp;'.$inf[16].'</a><br>';
else:
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_deadlines.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/icon_date.gif" title="'.$inf[19].'" border="0">&nbsp;'.$inf[19].'</a><br>';
endif;
//Themes
$th=$db->getquery("select cod_theme, cod_topic, name, translations from congress_themes where cod_topic='0'");
if($th[0][0]<>''):
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_themes.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/themes.gif" title="'.$inf[22].'" border="0">&nbsp;'.$inf[22].'</a><br>';
else:
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_themes.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif" title="'.$inf[22].'" border="0">&nbsp;'.$inf[22].'</a><br>';
endif;
//categories
unset($query);
$query=$db->getquery("select cod_category from congress_category");
if($query[0][0]==''):
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_cats.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif" title="'.$inf[17].'" border="0">&nbsp;'.$inf[17].'</a><br>';
else:
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_cats.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/icon_categorias.gif" title="'.$inf[18].'" border="0">&nbsp;'.$inf[18].'</a><br>';
endif;
//Menu
unset($query);
$query=$db->getquery("select cod_menu from congress_menu");
if($query[0][0]<>''):
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_menu.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/menu.png" title="'.$inf[20].'" border="0">&nbsp;'.$inf[20].'</a><br>';
else:
	echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_menu.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif" title="'.$inf[20].'" border="0">&nbsp;'.$inf[20].'</a><br>';
endif;
// Accounts
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_users.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/accounts.gif" title="'.$inf[14].'" border="0">&nbsp;'.$inf[14].'</a><br>';
$cod_type=$db->getquery("select cod_user_type from user_type where name='revisor'");
$query=$db->getquery("select cod_user from users where cod_user_type='".$cod_type[0][0]."'");
if($query[0][0]==''): // there aren't revisor users
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_users.php')).'&add=revisor"><img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif" title="'.$inf[12].'" border="0">&nbsp;'.$inf[12].'</a><br>';
endif;
$cod_type=$db->getquery("select cod_user_type from user_type where name='secretariado'");
unset($query);
$query=$db->getquery("select cod_user from users where cod_user_type='".$cod_type[0][0]."'");
if($query[0][0]==''): // there aren't secretariado users
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_users.php')).'&add=secretariat"><img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif" title="'.$inf[12].'" border="0">&nbsp;'.$inf[13].'</a><br>';
endif;
// Submissions
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_listings.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/submitted.gif" title="'.$inf[21].'" border="0">&nbsp;'.$inf[21].'</a><br>';
// downloads
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_downloads.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/disk.gif" title="'.$inf[23].'" border="0">&nbsp;'.$inf[23].'</a><br>';
// statistics
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('statistics.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/stats.gif" title="'.$inf[24].'" border="0">&nbsp;'.$inf[24].'</a><br>';
// revisors
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_config_revisors.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/accounts.gif" title="'.$inf[25].'" border="0">&nbsp;'.$inf[25].'</a><br>';
// Listings
echo '&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('congress_listings_mng.php')).'"><img src="'.$staticvars['site_path'].'/modules/congressos/images/submitted.gif" title="'.$inf[29].'" border="0">&nbsp;'.$inf[29].'</a><br>';
?>