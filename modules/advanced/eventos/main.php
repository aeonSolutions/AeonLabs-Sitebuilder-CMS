<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$task=@$_GET['id'];
if(!include($staticvars['local_root'].'modules/news/system/settings.php')):
	$enable_lateral=false;
endif;
if($enable_lateral):
	$w=20;
	$h=16;
	$img='icon_news_litle.gif';
	$tbl_h=10;
else:
	$w=39;
	$h=32;
	$img='icon_news.gif';
	$tbl_h=300;
endif;

function format_data($data){
/*	$txt=substr($data,0,4);
	$txt.='-'.substr($data,4,2);
	$txt.='-'.substr($data,6,2);
	$txt .=' @ '.substr($data,8,2);
	$txt.=':'.substr($data,10,2);
*/
return $data;
};
include_once($staticvars['local_root'].'general/return_module_id.php');
$task_id=return_id('news/main.php');
if (!isset($_GET['all'])):
	$opt='<a href="'.session($staticvars,'index.php?id='.$task_id.'&all=true').'">Ver todas as not&iacute;cias</a>';
else:
	$opt='<a href="'.session($staticvars,'index.php?id='.$task_id).'">Ver últimas notícias</a>';
endif;
?>
<table border="0" cellpadding="3" width="100%">
	  <tr>
		<td valign="top" width="32"><img src="<?=$staticvars['site_path'].'/modules/news/images/'.$img;?>" alt="vara&ccedil;&atilde;o de conte&uacute;dos" width="<?=$w;?>" height="<?=$h;?>" /></td>
		<td align="left" valign="bottom"><h2>Not&iacute;cias</h2><div align="right"><?=$opt;?></div></td>
    </tr>
</table>
<table width="100%" height="<?=$tbl_h;?>" border="0" cellpadding="0" cellspacing="0" >
	<?php
	if (isset($_GET['id']) and isset($_GET['news'])):
		include($staticvars['local_root'].'modules/news/system/main_funcs.php');
		list_one_news($staticvars['local_root']);
	elseif (isset($_GET['id']) and isset($_GET['all'])):
		include($staticvars['local_root'].'modules/news/system/main_funcs.php');
		list_all_news($staticvars['local_root']);
	else:
		if($enable_lateral):
			include($staticvars['local_root'].'modules/news/system/main_lateral_funcs.php');
			general_news_lateral($task,$staticvars['local_root']);
		else:
			include($staticvars['local_root'].'modules/news/system/main_funcs.php');
			general_news($task,$staticvars['local_root']);
		endif;
	endif;
	?>
  <tr>  
	<td height="100%" colspan="3" >&nbsp;</td>
  </tr>
</table>
