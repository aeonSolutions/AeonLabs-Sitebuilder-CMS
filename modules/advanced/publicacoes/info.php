<?php
/*
File revision date: 09-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(!include($staticvars['local_root'].'modules/publicacoes/system/settings.php')):
	$list_max_posts=10;
endif;
$my_posts=$db->getquery("select cod_publicacao from publicacoes where cod_user='".$staticvars['users']['code']."'");
if($my_posts[0][0]<>''):
	if(count($my_posts)>1):
		$my_posts=$inf[0].' '.count($my_posts).' '.$inf[1];
	else:
		$my_posts=$inf[2];
	endif;
else:
	$my_posts=$inf[3];
endif;
$group=$db->getquery("select cod_user_group, name from user_type where cod_user_type='".$staticvars['users']['type']."'");
if($group[0][1]=='revisor' or $staticvars['users']['type']==$staticvars['users']['user_type']['admin']):
	$pubs=$db->getquery("select cod_publicacao from publicacoes where active='?'");
	if($pubs[0][0]<>''):
		if(count($pubs)>1):
			$pubs=$inf[4].' '.count($pubs).' '.$inf[5];
		else:
			$pubs=$inf[6];
		endif;
	else:
		$pubs='';
	endif;	
endif;

?>
<?=$my_posts;?>
<?=$pubs;?>
<a href="<?=session($staticvars,'index.php?id='.return_id('my_posts.php'));?>"><?=$inf[7];?></a>