<?php
/*
File revision date: 21-mar-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
include($staticvars['local_root'].'kernel/reload_credentials.php');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;

if(!is_file($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/publicacoes/language/pt.php');
else:
	include($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php');
endif;
echo '<h4><a href="'.session($staticvars,'index.php?id='.return_id('my_posts.php')).'">'.$inf[7].'</a></h4>';
$my_posts=$db->getquery("select cod_publicacao from publicacoes where cod_user='".$staticvars['users']['code']."'");
if($my_posts[0][0]<>''):
	if(count($my_posts)>1):
		$my_posts=$inf[0].' '.count($my_posts).' '.$inf[1];
	else:
		$my_posts=$inf[2];
	endif;
else:
	$my_posts=$inf[11];
endif;
$group=$db->getquery("select cod_user_type, name from user_type where cod_user_type='".$staticvars['users']['group']."'");
if($group[0][1]=='revisor & cat mng' or $group[0][1]=='revisor' or $staticvars['users']['group']==$staticvars['users']['user_type']['admin']):
	$pubs=$db->getquery("select cod_publicacao from publicacoes where active='?'");
	$tr='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/publicacoes/images/article_review.gif" border="0">&nbsp;';
	if($pubs[0][0]<>''):
		if(count($pubs)>1):
			$pubs=$tr.'<a  href="'.session($staticvars,'index.php?id='.return_id('review_posts_list.php')).'">'.$inf[4].' '.count($pubs).' '.$inf[5].'</a>';
		else:
			$pubs=$tr.'<a  href="'.session($staticvars,'index.php?id='.return_id('review_posts_list.php')).'">'.$inf[6].'</a>';
		endif;
	else:
		$pubs=$tr.$inf[8];
	endif;	
else:
	$pubs='';
endif;
if($group[0][1]=='revisor & cat mng'  or $staticvars['users']['group']==$staticvars['users']['user_type']['admin']):
	$tr='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/publicacoes/images/icon_categorias.gif" border="0">&nbsp;';
	$cat_mng=$tr.'<a  href="'.session($staticvars,'index.php?id='.return_id('management_cats.php')).'">'.$inf[12].'</a>';
else:
	$cat_mng='';
endif;
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="'.session($staticvars,'index.php?id='.return_id('my_posts.php')).'"><img src="'.$staticvars['site_path'].'/modules/publicacoes/images/my_posts.png" alt="'.$inf[10].'" border="0">&nbsp;'.$my_posts.'</a><br>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.session($staticvars,'index.php?id='.return_id('management_pubs.php')).'"><img src="'.$staticvars['site_path'].'/modules/publicacoes/images/article_new.gif" alt="'.$inf[3].'" border="0">&nbsp;'.$inf[3].'</a><br>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.session($staticvars,'index.php?id='.return_id('management_files.php')).'"><img src="'.$staticvars['site_path'].'/modules/publicacoes/images/article_files.gif" alt="'.$inf[9].'" border="0">&nbsp;'.$inf[9].'</a><br>';
echo $pubs.'<br>';
echo $cat_mng;
?>
