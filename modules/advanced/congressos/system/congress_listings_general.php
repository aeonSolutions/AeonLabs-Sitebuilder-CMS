<?php
/*
File revision date: 16-sept-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');


function search($staticvars){
	function normalize($text){
	// eliminates special characters and convert to lower case a text string
		$dim=array("&ccedil;","&ccedil;");
		$text = str_replace($dim, "c", $text);
	
		$dim=array("&atilde;","&aacute;","à","â","&atilde;","&aacute;","À","Â");
		$text = str_replace($dim, "a", $text);
	
		$dim=array("é","ê","Ê","É");
		$text = str_replace($dim, "e", $text);
	
		$dim=array("í","Í");
		$text = str_replace($dim, "i", $text);
	
		$dim=array("&otilde;","ó","ô","&otilde;","Ó","Ô");
		$text = str_replace($dim, "o", $text);
	
		$text=strtolower($text);
	return $text;
	};


include($staticvars['local_root'].'kernel/staticvars.php');
$searching[0][0]='';

if(isset($_POST['quick_search'])):
	$search_query=$_POST['quick_search'];
	$res=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc from congress_abstracts");
elseif(isset($_POST['adv_search'])):
	$search_query=$_POST['adv_search'];
	$res=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc from congress_abstracts ".$strings);	
endif;
if ($res[0][0]<>''):
	// efectuar as pesquisa no directorio
	for($k=0;$k<count($res);$k++): // for each query entry
		$j=3;
		$t=0;
		while($j<8): // for each field table until the first find
			$isit='';
			$isit=@strpos(normalize($res[$k][$j]),normalize($search_query));
			if ($isit <> ''): // string match found
				$searching[$t]=$res[$k]; // store all the fields 
				$t++;
				$j=100;
			endif;
			$j++;
		endwhile;
	endfor;
endif;
return $searching;
};

if(isset($_GET['orderby'])):
	if ($_GET['orderby']=='asc'):
		$orderby='ASC';
		$order_img=$staticvars['site_path'].'/modules/congressos/images/sort_asc.png';
		$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=ASC';
		$order_txt=$cl[7];
	else:
		$orderby='DESC';
		$order_img=$staticvars['site_path'].'/modules/congressos/images/sort_desc.png';
		$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=DESC';
		$order_txt=$cl[8];
	endif;
else:
	$orderby='ASC';
	$order_img=$staticvars['site_path'].'/modules/congressos/images/sort_asc.png';
	$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=ASC';
	$order_txt=$pmg[7];
endif;

if(isset($_POST['field_orderby'])):
	if ($_POST['field_orderby']=='name'):
		$order=' order by title '.$orderby;
	elseif ($_POST['field_orderby']=='price'):
		$order=' order by author '.$orderby;
	else:
		$order=' order by cod_theme '.$orderby;
	endif;
else:
	$order=' order by title '.$orderby;
endif;

if(isset($_POST['limit'])):
	if ($_POST['limit']=='5'):
		$limit=5;
	elseif ($_POST['limit']=='10'):
		$limit=10;
	elseif ($_POST['limit']=='15'):
		$limit=15;
	elseif ($_POST['limit']=='20'):
		$limit=20;
	elseif ($_POST['limit']=='25'):
		$limit=25;
	elseif ($_POST['limit']=='30'):
		$limit=30;
	else:
		$limit=50;
	endif;
elseif(isset($_GET['limit'])):
	if ($_GET['limit']=='5'):
		$limit=5;
	elseif ($_GET['limit']=='10'):
		$limit=10;
	elseif ($_GET['limit']=='15'):
		$limit=15;
	elseif ($_GET['limit']=='20'):
		$limit=20;
	elseif ($_GET['limit']=='25'):
		$limit=25;
	elseif ($_GET['limit']=='30'):
		$limit=30;
	else:
		$limit=50;
	endif;
else:
	$limit=50;
endif;
$selection='';
if(isset($_GET['selection'])):
	$opt=$_GET['selection'];
	if($opt<>'revisor' and $opt<>'all' and $opt<>'reviewed'):
		$opt='';
	endif;
else:
	$opt='';
endif;
if($staticvars['users']['user_type']['auth']==$staticvars['users']['group']):
	$t=$db->getquery("select cod_user_type from users where cod_user='".$staticvars['users']['code']."'");
	$type=$db->getquery("select name from user_type where cod_user_type='".$t[0][0]."'");
	if($type[0][0]=='revisor' and ($opt=='revisor' or $opt=='reviewed')):
		$th=$db->getquery("select cod_theme from congress_revisor where cod_user='".$staticvars['users']['code']."'");
		if($th[0][0]<>''):
			$ths='';
			for($i=0;$i<count($th);$i++):
				$ths=$ths.' and cod_theme='.$th[$i][0];
			endfor;
		else:
			$ths='';
		endif;
		if($opt=='revisor'):
			$selection="where revised='n'".$ths;
		else:
			$selection="where revised='s'".$ths;
		endif;
	elseif($type[0][0]=='revisor' and $opt=='all'):
		$selection="where revised='n'";
	elseif($type[0][0]=='revisor'):
		$selection="";
	else:
		$selection="where cod_user='".$staticvars['users']['code']."'";	 
	endif;
endif;
if(isset($_POST['quick_search'])):
	$prod=search_products($staticvars['local_root']);
	$header='  <h2>'.$cl[9].'</h2>';
elseif(isset($_POST['adv_search'])):
	$prod=search_products($staticvars['local_root']);
	$header='  <h2>'.$cl[9].'</h2>';
else:
	if($opt=='revisor'):
		$header='  <h2>'.$cl[28].'</h2>';
	else:
		$header='  <h2>'.$cl[10].'</h2>';
	endif;
	$prod=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc from congress_abstracts ".$selection.' '.$order);
endif;
if($prod[0][0]<>''):
	$list_max_posts=$limit;
	$total=(count($prod)-1)>$list_max_posts ? intval(count($prod)/$list_max_posts): 1;// list_max_posts  posts per page
	if(isset($_GET['page']) and !isset($_POST['limit'])):
		$page= is_numeric($_GET['page'])? $_GET['page'] : 1;
	else:
		$page=1;
	endif;
	$page_selection=select_page($page,$total,strip_address("limit",$_SERVER['REQUEST_URI']).'&limit='.$limit,$staticvars);// page starts at 1 not at 0
	$page--;
	$lower=$page*$list_max_posts;
	$uper=($lower+$list_max_posts)>(count($prod)-1)? count($prod)-1 : ($lower+$list_max_posts);

	echo $header;
?>
    <form name="order" action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
    <table border="0">
      <tr>
        <td><?=$cl[3];?>:
          <select class="form_input" onchange="order.submit()" name="field_orderby">
            <option value="title" <? if(@$_POST['field_orderby']<>'author' and @$_POST['field_orderby']<>'author'){ echo 'selected="selected"'; };?>><?=$cl[14];?></option>
            <option value="author" <? if(@$_POST['field_orderby']=='author' ){ echo 'selected="selected"'; };?>><?=$cl[15];?></option>
            <option value="cod_theme" <? if(@$_POST['field_orderby']=='cod_theme' ){ echo 'selected="selected"'; };?>><?=$cl[0];?></option>
          </select></td>
        <td width="12"><a href="<?=$order_href;?>"><img height="12" alt="<?=$order_txt;?>" src="<?=$order_img;?>" width="12" border="0" /></a></td>
        <td><?=$cl[13];?> #&nbsp;&nbsp;
          <select class="form_input" onchange="order.submit()" size="1" name="limit">
            <option value="5" <? if(@$_POST['limit']=='5' ){ echo 'selected="selected"'; };?>>5</option>
            <option value="10" <? if(@$_POST['limit']=='10' ){ echo 'selected="selected"'; };?>>10</option>
            <option value="15" <? if(@$_POST['limit']=='15' ){ echo 'selected="selected"'; };?>>15</option>
            <option value="20" <? if(@$_POST['limit']=='20' ){ echo 'selected="selected"'; };?>>20</option>
            <option value="25" <? if(@$_POST['limit']=='25' ){ echo 'selected="selected"'; };?>>25</option>
            <option value="30" <? if(@$_POST['limit']=='30' ){ echo 'selected="selected"'; };?>>30</option>
            <option value="50" <? if(@$_POST['limit']=='50' or $limit==50 ){ echo 'selected="selected"'; };?>>50</option>
          </select></td>
      </tr>
    </table>
    </form>
    <?php
    ?>
    <hr size="1" color="#006600" />
    <?
	//$prod=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc from congress_abstracts ".$order);
	for ($i=$lower;$i<=$uper;$i++):
		echo '<h2><a href="'.session($staticvars,'index.php?id='.$_GET['id'].'&abs='.$prod[$i][0]).'">'.$prod[$i][4].'</a><br>
		<font style="font-style:italic; font-size:x-small">'.$prod[$i][6].'</font></h2>';
	endfor;
	echo $page_selection;
else:
	if(isset($_POST['quick_search']) or isset($_POST['adv_search'])):
		echo '<table width="500" border="0"><tr><td>'.$cl[11].'</td></tr></table>';
	else:
		echo '<table width="500" border="0"><tr><td>'.$cl[12].'</td></tr></table>';
	endif;
endif;


function select_page($page,$total,$link,$staticvars){
if ($total==0):
	return;
endif;
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
?>
    <style>
.page_select{
	text-align: center;color:#000;
	border: 1px solid #fff;
	padding: 2px 5px;
	font-size: 11px;
	font-family: Arial,Verdana, Helvetica, sans-serif;
	background: #f0f0f0;
	width: 50px;
	font-weight: bold;
}
</style>

<?php
$address=strip_address("page",$link);
$string='<div style="padding: 5px 5px 5px 5px;" align="center">';
if ($page==1 ):
	$string.='<span class="page_select">'.$pss[1].'</span>&nbsp;<span class="page_select">'.$pss[0].'</span>&nbsp;';
else:
	$string.='<span class="page_select"><a href="'.$address.'&page=1">'.$pss[1].'</a></span>&nbsp;<span class="page_select"><a href="'.$address.'&page='.($page-1).'">'.$pss[0].'</a></span>&nbsp;';
endif;
$page= $page>$total ? $total : $page;
$page= $page<0 ? 1 : $page;
if($page==$total and $total>4):
	$lower=$total-4;
	$uper=$total;
elseif($page==($total-1) and $total>4):
	$lower=$total-3;
	$uper=$total;
elseif($page<3 and $total>4):
	$lower=1;
	$uper= 5>$total ? $total: 5;
elseif($page<3 and $total<=4):
	$lower=1;
	$uper= 5>$total ? $total: 5;
else:
	$lower=$page-2;
	$uper= $page+2;
endif;
for($i=$lower;$i<=$uper;$i++):
	if($i<>$page):
		$string.='<span class="page_select"><a href="'.$address.'&page='.($i).'">'.$i.'</a></span>&nbsp;';
	else:
		$string.='<span class="page_select">'.$i.'</span>&nbsp;';
	endif;
endfor;
if ($page==$total ):
	$string.='<span class="page_select">'.$pss[2].'</span>&nbsp;<span class="page_select">'.$pss[3].'</span>';
else:
	$string.='<span class="page_select"><a href="'.$address.'&page='.($page+1).'">'.$pss[2].'</a></span>&nbsp;<span class="page_select"><a href="'.$address.'&page='.$total.'">'.$pss[3].'</a></span>';
endif;

return $string.'</div>';
};

?>