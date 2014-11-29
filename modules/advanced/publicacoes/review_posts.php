<?php
/*
File revision date: 30-mar-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if (isset($_POST['obs']) or isset($_POST['publish']) or isset($_POST['new_revision'])):
	include($staticvars['local_root'].'modules/publicacoes/update_db/pub_management.php');
endif;
?>
<style>
/*Author Text*/
.header {
	font: normal small-caps 11px/12px "Lucida Sans", Lucida, Verdana, sans-serif;
	color: #666;
	text-transform: uppercase;
}
/*Last Updated Text*/
.modifydate {
	font: normal small-caps 11px/12px "Lucida Sans", Lucida, Verdana, sans-serif;
	color: #666;
	text-transform: uppercase;
}

</style>
<script type="text/javascript" language="JavaScript">
function checkBrowser(){
	this.ver=navigator.appVersion;
	this.dom=document.getElementById?1:0;
	this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom)?1:0;
	this.ie4=(document.all && !this.dom)?1:0;
	this.ns5=(this.dom && parseInt(this.ver) >= 5) ?1:0;
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie5 || this.ie4 || this.ns4 || this.ns5);
	return this;
}
bw=new checkBrowser()
//With nested layers for netscape, this function hides the layer if it's visible and visa versa;
function showHide(div,nest){
	obj=bw.dom?document.getElementById(div).style:bw.ie4?document.all[div].style:bw.ns4?nest?document[nest].document[div]:document[div]:0;
	if(obj.visibility=='visible' || obj.visibility=='show') obj.visibility='hidden';
	else obj.visibility='visible';
}
//Shows the div
function show(div,nest){
	obj=bw.dom?document.getElementById(div).style:bw.ie4?document.all[div].style:bw.ns4?nest?document[nest].document[div]:document[div]:0;
	obj.visibility='visible';
}
//Hides the div
function hide(div,nest){
	obj=bw.dom?document.getElementById(div).style:bw.ie4?document.all[div].style:bw.ns4?nest?document[nest].document[div]:document[div]:0;
	obj.visibility='hidden';
}
</script>
<?php
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
$language['pt']='portuguese';
$language['en']='english';

setlocale(LC_CTYPE, $language[$lang]);
setlocale(LC_TIME, $language[$lang]);
if(!is_file($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/publicacoes/language/pt.php');
else:
	include($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php');
endif;


if(!include($staticvars['local_root'].'modules/publicacoes/system/settings.php')):
	$split_post=5;
endif;
include_once($staticvars['local_root'].'modules/publicacoes/system/functions.php');
$art= isset($_GET['article']) ? mysql_escape_string($_GET['article']) : 0 ;
$query=$db->getquery("select cod_publicacao,cod_categoria, cod_user, title, short_description, UNIX_timestamp(data_publicacao) as fld_unixtimestamp, lida, UNIX_timestamp(data) as fld_unixtimestamp2, num_votos, votacao from publicacoes where cod_publicacao='".$art."' and active<>'s'");
if($query[0][0]<>''):// results found
	$cats=$db->getquery("select cod_categoria, cod_sub_cat, nome from publicacoes_categorias");
	$user=$db->getquery("select nome from users where cod_user='".$query[0][2]."'");
	$user=explode(" ",$user[0][0]);
	$user=$user[0].' '.$user[count($user)-1];
	for($i=0;$i<count($cats);$i++):
		$cat_cod[$i]=$cats[$i][0];
		$cat_sub[$i]=$cats[$i][1];
		$cat_nome[$i]=$cats[$i][2];
	endfor;
	$pos=sweap($query[0][1],$cat_cod);
	$k=0;
	while (is_numeric($pos)):
		$cat_tree[$k]=$pos;
		$k++;	
		$pos=sweap($cat_sub[$pos],$cat_cod);
	endwhile;
	echo '<h2>'.$rpl[4].'</h2>';// titulo
	echo '<h2>'.$query[0][3].'</h2>';// titulo
	?>
	<div align='right'>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/publicacoes/system/pdf.php?article=<?=$art;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="PDF">
		<img src="<?=$staticvars['site_path'];?>/modules/publicacoes/images/pdf_button.png" alt="PDF" name="PDF" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/publicacoes/system/print.php?article=<?=$art;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="Print">
		<img src="<?=$staticvars['site_path'];?>/modules/publicacoes/images/printButton.png" alt="Print" name="Print" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/publicacoes/system/email.php?article=<?=$art;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="E-mail">
		<img src="<?=$staticvars['site_path'];?>/modules/publicacoes/images/emailButton.png" alt="E-mail" name="E-mail" align="middle" border="0"></a>
    </div>
	<?php
	for($k=count($cat_tree)-1;$k>=0;$k--):
		$tmp= $k==0 ? ' ' : '>';
		echo '<a href="'.session($staticvars,'index.php?id='.$pub_list.'&cat='.$cat_cod[$k]).'">'.$cat_nome[$cat_tree[$k]].'</a>'.$tmp;
	endfor;
	echo '<br><span class="header">'.$sa[0].' '.$user.'<br>'.strftime('%A, %d %B %Y',$query[0][5]).'</span><br><br>';
	$article=stripslashes($query[0][4]);
	echo $article;
	echo '<br><br><font style="font-size:smaller">'.$sa[2].' ('.strftime('%A, %d %B %Y',$query[0][7]).')</font>';
	$artigos=$db->getquery("select cod_ficheiro, ficheiro, descricao from publicacoes_ficheiros where cod_publicacao='".$query[0][0]."'");
	if($artigos[0][0]<>''):
		echo '<br /><br /><hr size="3" color="#999999" />';
		echo '<font style="text-transform:uppercase;font-size:x-small">'.$sa[3].'</font><br />';
		echo '	<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">';
		if(isset($_SESSION['user'])):
			$access=strip_address("file",$_SERVER['REQUEST_URI']).'&file=';
		else:
			
			$access='index.php?id='.return_id('login_requiered.php').'&file=';
		endif;
		$i=0;
		while($i<count($artigos)):
			$tmp='<a href="'.$access.$artigos[$i][0].'">'.$artigos[$i][2].'</a>';
			$tmp='<a href="'.$access.$artigos[$i][0].'">'.$artigos[$i][2].'</a>';
			if(isset($artigos[$i+1][0])):
				$tmp2='<a href="'.$access.$artigos[$i+1][0].'">'.$artigos[$i+1][2].'</a>';
			else:
				$tmp2='';
			endif;		
			echo '<tr><td height="20" width="50%" align="left"><font style="text-transform:uppercase; font-size:x-small";>'.$tmp.'</font></td><td width="50%" align="left"><font style="text-transform:uppercase; font-size:x-small";>'.$tmp2.'</font></td></tr>';		
			$i=$i+2;
		endwhile;
		echo '</table>';
	endif;
	$rev=$db->getquery("select cod_revision, observacoes, cod_revisor from publicacoes_revisor where cod_publicacao='".$art."'");
	if($rev[0][0]<>''):
		$user_rev=$db->getquery("select nome from users where cod_user='".$rev[0][2]."'");
		$revisor_name=$user_rev[0][0];
		$obs=$rev[0][1];
	else:
		$user_rev=$db->getquery("select nome from users where cod_user='".$staticvars['users']['code']."'");
		$revisor_name=$user_rev[0][0];
		$obs='';
	endif;
	?>
    <br />
	<h2><?=$rpl[5].$revisor_name;?><h2 />
    
	<h2><?=$rpl[1];?><h2 />
    <form action="" method="post" enctype="multipart/form-data" class="form">
      <textarea class="text" name="obs" cols="40" rows="10" id="obs"><?=$obs;?></textarea>
    <br />
    <input type="hidden" name="art" value="<?=$art;?>" />
    <input class="button" type="submit" name="publish_rev" id="publish" value="<?=$rpl[2];?>" />
    <input class="button" type="submit" name="new_revision" id="new_revision" value="<?=$rpl[3];?>" />
	</form>	
    <?php
else:
	echo $sa[21];
endif;
?>