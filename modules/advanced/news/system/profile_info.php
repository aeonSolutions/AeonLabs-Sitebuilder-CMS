<?php
/*
File revision date: 26-apr-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if($staticvars['users']['user_type']['admin']==$staticvars['users']['group'] or $staticvars['users']['group']==$staticvars['users']['user_type']['cm']):
	echo '<h4>Gestao de notícias</h4>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('create_news.php')).'"><img src="'.$staticvars['site_path'].'/modules/news/images/new_news.png" border="0">&nbsp;Nova notícia</a><br>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('edit_news.php')).'"><img src="'.$staticvars['site_path'].'/modules/news/images/edit_news.png" border="0">&nbsp;Editar notícia</a><br>';
endif;
?>