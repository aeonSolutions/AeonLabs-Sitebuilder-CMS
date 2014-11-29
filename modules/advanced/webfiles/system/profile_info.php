<?php
/*
File revision date: 26-apr-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if($staticvars['users']['user_type']['admin']==$staticvars['users']['group'] or $staticvars['users']['group']==$staticvars['users']['user_type']['cm']):
	echo '<h4>WebFiles</h4>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('manage_webfiles.php')).'"><img src="'.$staticvars['site_path'].'/modules/webfiles/images/webfiles.gif" border="0">&nbsp;Gestão Ficheiros</a><br>';
endif;
?>