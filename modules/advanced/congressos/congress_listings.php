<?php
/*
File revision date: 3-july-2009
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
if(isset($_SESSION['success'])):
	echo $_SESSION['success'];
	$_SESSION['success']=array();
	unset($_SESSION['success']);
endif;

$task=@$_GET['id'];
if(isset($_POST['delete'])):
	$_SESSION['success']='<font class="body_text"> <font color="#FF0000">'.$cl[26].'</font></font>';
	$th=$db->getquery("select cod_theme from congress_abstracts where cod_abstract='".mysql_escape_string($_POST['code'])."'");
	$topic=$db->getquery("select reference from congress_themes where cod_theme='".$th[0][0]."'");
	$idc=$topic[0][0].'-'.mysql_escape_string($_POST['code']);
	@unlink($staticvars['upload'].'/congress/abstracts/'.$idc.'.rtf');
	$file=$db->setquery("select file from congress_papers where cod_abstract='".mysql_escape_string($_POST['code'])."'");
	if($file[0][0]<>''):
		@unlink($staticvars['upload'].'/congress/papers/'.$file[0][0]);
	endif;
	$db->setquery("delete from congress_abstracts where cod_abstract='".mysql_escape_string($_POST['code'])."'");
	$db->setquery("delete from congress_papers where cod_abstract='".mysql_escape_string($_POST['code'])."'");
	session_write_close();
	sleep(1);
	header("Location: ".$_SERVER['REQUEST_URI']);

elseif(isset($_POST['edit'])):
	include($staticvars['local_root'].'modules/congressos/abstract_submit.php');
elseif (isset($_GET['abs'])): // 1 resumo
	$cod=mysql_escape_string($_GET['abs']);
	$prod=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc, revised, revision_data from congress_abstracts where cod_abstract='".$cod."'");
	if ($prod[0][0]<>''):
		list_on_abstract($staticvars,$cod,$prod,$cl);
	else:
		general_product_listing($staticvars,$cl);
	endif;
elseif (isset($_GET['paper'])): // 1 artigo
	$cod=mysql_escape_string($_GET['paper']);
	$prod=$db->getquery("select cod_paper, cod_user, cod_abstract, theme, file, data, active from congress_papers where cod_paper='".$cod."'");
	if ($prod[0][0]<>''):
		list_on_abstract($staticvars,$cod,$prod,$cl);
	else:
		general_product_listing($staticvars,$cl);
	endif;
else: // listagem de resumos
	general_product_listing($staticvars,$cl);
endif;

function list_on_abstract($staticvars,$cod,$prod,$cl){
include($staticvars['local_root'].'kernel/staticvars.php');
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
$status=$db->getquery("select comments, revision_data, cod_revisor, accepted from congress_revision_abs where cod_abs='".$prod[0][0]."'");
$bt_name='revabs';
if($prod[0][10]=='s'):
	if($status[0][3]=='y'):
		$bt_name='revpaper';
		$st=$cl[29];
	else:
		$st=$cl[30];
	endif;
	$revision='<img src="'.$staticvars['site_path'].'/modules/congressos/images/check_mark.gif">&nbsp;'.$cl[22].'<div align="left">
	<h3>'.$re[0].'</h3><p>'.$status[0][0].'</p><p>Status: '.$st.'</p></div>';
	
else:
	$revision='<img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif">&nbsp;'.$cl[23];
endif;
$th=$db->getquery("select name, translations from congress_themes where cod_theme='".$prod[0][2]."'");
if($th[0][1]<>''):// there are translations
	$pipes=explode("||",$th[0][1]);
	$display_name='';
	for($l=0; $l<count($pipes);$l++):
		$names=explode("=",$pipes[$l]);
		if ($lang==$names[0]):
			$display_name=$names[1];
		endif;
	endfor;
	if ($display_name==''):
		$display_name=" - - ";
	endif;
else:
	$display_name=$th[0][0];
endif;
$theme=$display_name;
$title=$prod[0][4];
$authors=$prod[0][6];
$keywords=$prod[0][5];
$abstract=$prod[0][7];

$topic=$db->getquery("select reference, name, translations, cod_topic from congress_themes where cod_theme='".$prod[0][2]."'");
$idc=$topic[0][0].'-'.$prod[0][0];
if($staticvars['users']['user_type']['auth']==$staticvars['users']['group'] or $staticvars['users']['user_type']['admin']==$staticvars['users']['group']):
	$t=$db->getquery("select cod_user_type from users where cod_user='".$staticvars['users']['code']."'");
	$type=$db->getquery("select name from user_type where cod_user_type='".$t[0][0]."'");
	if($type[0][0]=='secretariado' or $type[0][0]=='revisor' or $type[0][0]=='gestorcongresso' or $staticvars['users']['user_type']['admin']==$staticvars['users']['group']):
		$det=$db->getquery("select nome, email from users where cod_user='".$prod[0][1]."'");
		$details=$det[0][0].'('.$det[0][1].')';
	endif;
else:
	$details='';
endif;
?>
	<div align='right'>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/pdf.php?abs=<?=$prod[0][0];?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="PDF">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/pdf_button.png" alt="PDF" name="PDF" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/print.php?abs=<?=$prod[0][0];?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="Print">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/printButton.png" alt="Print" name="Print" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/email.php?abs=<?=$prod[0][0];?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="E-mail">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/emailButton.png" alt="E-mail" name="E-mail" align="middle" border="0"></a>
	 </div>
<?php
echo '<div style="font-family:\'Times New Roman\', Times, serif;font-size:medium">';
echo '<div align="center"><h2>'.$title.'</h2>'.$cl[0].': '.$theme.'<br><font style="font-size:small">'.$authors.'</font></div>';
echo '</div>';
echo '<hr size="1"><div align="left" style="font-family:\'Times New Roman\', Times, serif"><strong>'.$cl[1].'</strong><br>'.$abstract.'<br><br><font style="font-size:small"><strong>'.$cl[2].':</strong>'.$keywords.'</font><hr size="1"><br /><h3>'.$cl[25].'</h3><blockquote>'.$cl[37].': '.$details.'<br />'.$cl[24].' <strong>'.$idc.'</strong><br />'.$revision.'</blockquote></div>';
$paper_db=$db->getquery("select file, cod_paper, revised, revision_data from congress_papers where cod_abstract='".$prod[0][0]."'");
$txt='';
if($paper_db[0][0]<>''): // paper is submitted
	include($staticvars['local_root'].'kernel/initialize_download.php');
	echo '<p></p><hr size="1"><div align="left" style="font-family:\'Times New Roman\', Times, serif">
	<h3>'.$cl[31].'</h3><blockquote>'.$cl[32].' <strong>p-'.$paper_db[0][1].'</strong><br />'.'<STRONG>'.$cl[33].'</STRONG><br>'.initialize_download($staticvars,'congress/papers/'.$paper_db[0][0],'link').'</blockquote></div>';
	if($paper_db[0][2]=='y'):
		$txt='disabled="disabled"';	
		$st=$cl[29];
		echo '<img src="'.$staticvars['site_path'].'/modules/congressos/images/check_mark.gif">&nbsp;'.$cl[34];
	else:
		$st=$cl[30];
		echo '<img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif">&nbsp;'.$cl[35];
	endif;
else:
	$paper_db[0][0]='';
	$paper_db[0][1]='-1';
	if($prod[0][10]=='s'):
		$txt='disabled="disabled"';	
	endif;
endif;

$type=$db->getquery("select name from user_type where cod_user_type='".$staticvars['users']['type']."'");
if($type[0][0]=='revisor' or $staticvars['users']['user_type']['admin']==$staticvars['users']['code']):
	$th=$db->getquery("select cod_theme from congress_revisor where cod_user='".$staticvars['users']['code']."'");
	if($th[0][0]<>''):
		for($h=0;$h<count($th);$h++):
			$ths[$h]=$th[$h][0];
		endfor;
		if(in_array($prod[0][2],$ths)):
			$inff='';
		else:
			$txt='disabled="disabled"';
			$inff='<img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif">&nbsp;'.$cl[27];
		endif;
	
	else:
		$inff='<img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif">&nbsp;'.$cl[27];
		$txt='disabled="disabled"';
	endif;
	if($prod[0][10]=='y'):
		$txt='disabled="disabled"';
	endif;
	?>
    <br><br>
	<form action="<?=session($staticvars,'index.php?id='.return_id('revisors_mng.php'));?>" method="post" class="form">
        <div align="right">
            <input type="hidden" name="abs_code" value="<?=$prod[0][0];?>" />
            <input type="hidden" name="paper_code" value="<?=$paper_db[0][1];?>" />
            <input name="<?=$bt_name;?>" <?=$txt;?> class="button" type="submit" value="<?=$cl[6];?>"><br />
            <?=$inff;?>
        </div>
	</form>
	<?php
elseif($staticvars['users']['user_type']['auth']==$staticvars['users']['group'] and $type[0][0]<>'secretariado'):
	$txt='';
	if($status[0][3]=='y'):
		$txt='disabled="disabled"';
	endif;
	
	?>
    <br>
	<br>
	<SCRIPT LANGUAGE="JavaScript">
      function confirmAction() {
        return confirm("<?=$cl[21];?>")
      }   
    </SCRIPT>
	<form action="" method="post" class="form">
	<div align="right">
    <input type="hidden" value="<?=$prod[0][0];?>" name="code" />
	<input <? if($prod[0][10]=='s'){ echo 'disabled="disabled"';}?> name="delete" onclick="return confirmAction()" class="button" type="submit" value="<?=$cl[19];?>">
	<input <?=$txt?> name="edit" class="button" type="submit" value="<?=$cl[20];?>">
    </div>
	</form>
	<?php
endif;
};

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

function general_product_listing($staticvars,$cl) {
include($staticvars['local_root'].'kernel/staticvars.php');
include($staticvars['local_root'].'kernel/reload_credentials.php');
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
	if ($_POST['field_orderby']=='title'):
		$order=' order by title '.$orderby;
	elseif ($_POST['field_orderby']=='author'):
		$order=' order by authors '.$orderby;
	elseif ($_POST['field_orderby']=='data'):
		$order=' order by data '.$orderby;
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
	if($opt<>'revisor' and $opt<>'all' and $opt<>'reviewed' and $opt<>'papers' and $opt<>'secretariat'):
		$opt='';
	endif;
else:
	$opt='';
endif;
$ths='';
if($staticvars['users']['user_type']['auth']==$staticvars['users']['group']):
	$t=$db->getquery("select cod_user_type from users where cod_user='".$staticvars['users']['code']."'");
	$type=$db->getquery("select name from user_type where cod_user_type='".$t[0][0]."'");
	if($type[0][0]=='secretariado' and $opt=='secretariat'):
		$selection="";
	elseif($type[0][0]=='revisor' and ($opt=='revisor' or $opt=='reviewed')):
		$th=$db->getquery("select cod_theme from congress_revisor where cod_user='".$staticvars['users']['code']."'");
		if($th[0][0]<>''):
			$ths='and(';
			for($i=0;$i<count($th);$i++):
				$ths=$ths.' cod_theme='.$th[$i][0];
				$ths.= ($i<(count($th)-1)) ? ' or' : '';
			endfor;
			$ths.=')';
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
	elseif($opt=='papers'):
		$selection="";
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
	if($opt=='papers'):
		$prod=$db->getquery("select congress_abstracts.cod_abstract,congress_abstracts.cod_user, congress_abstracts.cod_theme, congress_abstracts.file, congress_abstracts.title, congress_abstracts.keywords, congress_abstracts.authors, congress_abstracts.abstract, congress_abstracts.data,congress_abstracts.idc from congress_abstracts INNER JOIN congress_papers ON congress_abstracts.cod_abstract=congress_papers.cod_abstract where congress_papers.revised='n' ".$ths.' '.$order);
	else:
		$prod=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc from congress_abstracts ".$selection.' '.$ths.' '.$order);
	endif;
endif;
if($prod[0][0]<>''):
	$list_max_posts=$limit;
	$total=(count($prod)-1)>$list_max_posts ? intval(count($prod)/$list_max_posts): 1;// list_max_posts  posts per page
	$total= ($total*$list_max_posts)<(count($prod)-1) ? $total+1 : $total;
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
            <option value="data" <? if(@$_POST['field_orderby']=='data' ){ echo 'selected="selected"'; };?>><?=$cl[36];?></option>
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

};

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
$page= ($page>$total) ? $total : $page;
$lower= ($lower>$total) ? $total-1 : $lower;
$uper= ($uper>$total) ? $total : $uper;


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
