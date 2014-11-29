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
	$smilies=false;
	$disable_header=false;
	$disable_news=false;
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
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/news/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/news/language/pt.php');
else:
	include($staticvars['local_root'].'modules/news/language/'.$lang.'.php');
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
if ($disable_header==false):
	?>
	<h3><img src="<?=$staticvars['site_path'].'/modules/news/images/'.$img;?>" alt="vara&ccedil;&atilde;o de conte&uacute;dos" width="<?=$w;?>" height="<?=$h;?>" /><?=$nwsm[5];?></h3>
	<?php
endif;
$query=$db->getquery("select title, cod_news,data from news where active='s' order by data DESC");
if (!($query[0][0]=='' and $disable_news==true)):
	?>
	<table width="100%" height="<?=$tbl_h;?>" border="0" cellpadding="0" cellspacing="0" >
	<?php
	if (isset($_GET['id']) and isset($_GET['news'])):
		include($staticvars['local_root'].'modules/news/system/main_funcs.php');
		list_one_news($staticvars);
	elseif (isset($_GET['id']) and isset($_GET['all'])):
		include($staticvars['local_root'].'modules/news/system/main_funcs.php');
		list_all_news($staticvars);
	else:
		if($enable_lateral):
			include($staticvars['local_root'].'modules/news/system/main_lateral_funcs.php');
			general_news_lateral($task,$staticvars);
		else:
			include($staticvars['local_root'].'modules/news/system/main_funcs.php');
			general_news($task,$staticvars);
		endif;
	endif;
	?>
      <tr>  
        <td height="100%" colspan="3" >&nbsp;</td>
      </tr>
    </table>
<?php
endif;
?>