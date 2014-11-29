<?php
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
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

unset($site_id);
if(!include($staticvars['local_root'].'modules/publicacoes/system/settings.php')):
	$split_post=5;
	$enable_comments=true;
	$enable_voting=true;
endif;
include_once($staticvars['local_root'].'modules/publicacoes/system/functions.php');
$art= isset($_GET['article']) ? mysql_escape_string($_GET['article']) : 0 ;
$lc= isset($_GET['lc']) ? mysql_escape_string($_GET['lc']) : count($site_id) ;
if($lc>count($site_id)):
	$lc=count($site_id);
endif;
$base=explode("\\",$staticvars['local_root']);
$base=$base[count($base)-1];
$sdn= $base[strlen($base)-1]=='/' ? substr($base,0,strlen($base)-1) : $base;
$count= isset($site_id) ? count($site_id) : 0 ;
$site_id[$count]=$sdn;
$site[$sdn]['host']=$db->host;
$site[$sdn]['user']=$db->user;
$site[$sdn]['password']=$db->password;
$site[$sdn]['db_name']=$db->name;

$ems_db = new database_class;
$ems_db->host=$site[$site_id[$lc]]['host'];
$ems_db->user=$site[$site_id[$lc]]['user'];
$ems_db->password=$site[$site_id[$lc]]['password'];
$ems_db->name=$site[$site_id[$lc]]['db_name'];
$query=$ems_db->getquery("select cod_publicacao,cod_categoria, cod_user, title, texto, UNIX_timestamp(data_publicacao) as fld_unixtimestamp, lida, UNIX_timestamp(data) as fld_unixtimestamp2, num_votos, votacao from publicacoes where cod_publicacao='".$art."' and active='s'");
if(isset($_GET['post']) and isset($_SERVER['HTTP_REFERER'])):
	$post=$_GET['post'];
	if($post=='vote'):
		echo '<font class="body_text"> <font color="#FF0000">'.$sa[22].'</font></font>';
	elseif($post=='comment'):
		echo '<font class="body_text"> <font color="#FF0000">'.$sa[23].'</font></font>';
	endif;
endif;
if($query[0][0]<>''):// results found
	if (isset($_POST['votacao'])):
		$votos=$ems_db->getquery("select num_votos,votacao from publicacoes where cod_publicacao='".$art."'");
		$votacao=$votos[0][1]*$votos[0][0]/($votos[0][0]+1)+$_POST['votacao']/($votos[0][0]+1);
		$ems_db->setquery("update publicacoes set num_votos='".($votos[0][0]+1)."', votacao='".$votacao."' where cod_publicacao='".$art."'");
		header("referer: add_user");
		sleep(1);
		header("Location: ".session($staticvars,'index.php?id='.return_id("show_article.php").'&'.$lc.'&article='.$art.'&post=vote'));
		echo 'vote added - show post';
		exit;
	endif;
	if (isset($_POST['comment'])):
		$comment=mysql_escape_string($_POST['comment']);
		$cod_user=$ems_db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
		$db->ems_setquery("insert into publicacoes_comments set data=NOW(), cod_user='".$cod_user[0][0]."',
		 comment='".$comment."', cod_publicacao='".$art."'");
		header("referer: add_user");
		sleep(1);
		header("Location: ".session($staticvars,'index.php?id='.return_id("show_article.php").'&lc='.$lc.'&article='.$art.'&post=comment'));
		echo 'comment added - show post';
		exit;
	endif;
	if(!isset($_POST['comment']) and !isset($_POST['votacao'])):
		$lida=$query[0][6]+1;
		$ems_db->setquery("update publicacoes set lida='".$lida."' where cod_publicacao='".$art."'");
	endif;
	$cats=$ems_db->getquery("select cod_categoria, cod_sub_cat, nome from publicacoes_categorias");
	$user=$ems_db->getquery("select nome from users where cod_user='".$query[0][2]."'");
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
	echo '<h2>'.$query[0][3].'</h2>';// titulo
	?>
	<div align='right'>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/publicacoes/system/pdf.php?article=<?=$art.'&lc='.$lc;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="PDF">
		<img src="<?=$staticvars['site_path'];?>/modules/publicacoes/images/pdf_button.png" alt="PDF" name="PDF" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/publicacoes/system/print.php?article=<?=$art.'&lc='.$lc;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="Print">
		<img src="<?=$staticvars['site_path'];?>/modules/publicacoes/images/printButton.png" alt="Print" name="Print" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/publicacoes/system/email.php?article=<?=$art.'&lc='.$lc;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="E-mail">
		<img src="<?=$staticvars['site_path'];?>/modules/publicacoes/images/emailButton.png" alt="E-mail" name="E-mail" align="middle" border="0"></a>
	 </div>
	<?php
	for($k=count($cat_tree)-1;$k>=0;$k--):
		$tmp= $k==0 ? ' ' : '>';
		echo '<a href="'.session($staticvars,'index.php?id='.$pub_list.'&lc='.$lc.'&cat='.$cat_cod[$k]).'">'.$cat_nome[$cat_tree[$k]].'</a>'.$tmp;
	endfor;
	echo '<br><span class="header">'.$sa[0].' '.$user.'<br>'.strftime('%A, %d %B %Y',$query[0][5]).'</span><br><br>';
	$article=stripslashes($query[0][4]);
	// split text into several pages
	$ok=true;
	$k=0;
	$page_txt[0]='';
	$counter=1;
	$tmp2=0;
	while ($ok):
		$tmp=strpos($article,"<p",$tmp2);
		if ($tmp === false):
			$ok=false;
		else:
			$tmp2=strpos($article,"/p>",$tmp);
			$page_txt[$k].=substr($article,$tmp,($tmp2+3)-($tmp));
			$counter++;
			if($counter>$split_post):
				$counter=1;
				$k++;
				$page_txt[$k]='';
			endif;
		endif;
	endwhile;
	$k++;
	$total= $k;// slipt_post paragraphs per page
	// build index - search for h1 headers
	for($i=0;$i<=$k;$i++):
		$ok=true;
		$l=0;
		while ($ok):
			$tmp=strpos($article,"<h1");
			if ($tmp === false):
				$ok=false;
			else:
				$tmp=strpos($article,">",$tmp);
				$tmp2=strpos($article,"/h1>",$tmp);
				$idx[$l]='<a href="&page='.$i.'">'.substr($article,$tmp+1,($tmp2)-($tmp+1)).'</a>';
				$l++;
			endif;
		endwhile;
	endfor;
	if(isset($_GET['page'])):
		$page= is_numeric($_GET['page'])? $_GET['page'] : 1;
		$page = $page==0 ? 1 : $page;
	else:
		$page=1;
	endif;
	$page=($page)>($total)? $total : $page;
	$page_selection=select_page($page,$total,$_SERVER['REQUEST_URI'],$staticvars);// page starts at 1 not at 0
	echo $sa[1].' '.$page.' de '.$total.'<br>';
	echo $page_txt[$page-1];
	echo '<br><br><font style="font-size:smaller">'.$sa[2].' ('.strftime('%A, %d %B %Y',$query[0][7]).')</font>';
	echo '<br><br>'.$page_selection.chr(13);
	$artigos=$db->getquery("select cod_ficheiro, ficheiro, descricao from publicacoes_ficheiros where cod_publicacao='".$query[0][0]."'");
	if($artigos[0][0]<>''):
		echo '<br /><br /><hr size="3" color="#999999" />';
		echo '<font style="text-transform:uppercase;font-size:x-small">'.$sa[3].'</font><br />';
		echo '	<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">';
		if(isset($_SESSION['user'])):
			$access=strip_address("file",$_SERVER['REQUEST_URI']).'&lc='.$lc.'&file=';
		else:
			
			$access='index.php?id='.return_id('login_requiered.php').'&lc='.$lc.'&file=';
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

	if ($query[0][8]>0):
		$points=$query[0][9];
		$num_votos=$query[0][8];
	else:
		$points=3;
		$num_votos=0;
	endif;

	$stars='';
	for ($i=1;$i<=round($points,0);$i++):
		$stars .='<img src="'.$staticvars['site_path'].'/modules/publicacoes/images/vote_star_full.gif" alt="'.$sa[4].'" width="16" height="16" />';
	endfor;
	for ($i=round($points,0)+1;$i<=5;$i++):
		$stars .='<img src="'.$staticvars['site_path'].'/modules/publicacoes/images/vote_star_empty.gif" alt="'.$sa[4].'" width="16" height="16" />';
	endfor;
	$comments=$ems_db->getquery("select cod_comment, comment, UNIX_timestamp(data), cod_user from publicacoes_comments where cod_publicacao='".$art."'");
	if ($comments[0][0]<>''):
		$num_comments=count($comments);
		if($num_comments==1):
			$num_comments=$sa[9].' '.$num_comments.' '.$sa[5];
		else:
			$num_comments=$sa[10].' '.$num_comments.' '.$sa[8];
		endif;
	else:
		$num_comments=$sa[11];
	endif;

?>
<br />
<div id="promote">
<?=$sa[12];?> <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#tabs=web%2Cpost%2Cemail&amp;charset=utf-8&amp;style=rotate&amp;publisher=edda96d3-55ab-4337-968b-2aaf45b8763a"></script>
<? include($staticvars['local_root'].'modules/publicacoes/system/promote.php'); ?>
<br />
<br />
</div>
<br />
<table width="99%" align="center" border="0" cellpadding="5" cellspacing="0">
  <tr valign="top">
  <td width="40" height="32">
	<?php
	if ($enable_comments):
	?>
	<img src="<?=$staticvars['site_path'].'/modules/publicacoes/images/comment.gif';?>" alt="<?=$sa[5];?>" width="40" height="40" />
	<?php
	endif;
	?>
	</td>
	<td width="50%" >
	<?php
	if ($enable_comments):
		if (isset($_SESSION['user'])):
			?>
			<a class="header_text_1" href="#ins_c" onclick="show('add_comment')"><?=$sa[6];?></a>&nbsp;<br />
			<?php
		else:
			?>
			<a class="header_text_1" href="<?=session($staticvars,'index.php?id='.return_id('new_register.php'));?>" ><?=$sa[7];?></a>&nbsp;<br />
			<?php
		endif;
		?>
		<a class="body_text" href="#view_c" onclick="show('view_comment')"><?=$num_comments;?></a></td>
	<?php
	endif;
	?>
	<td width="50%" align="right">
	<?php
	if ($enable_voting):
		?>
		<form class="form" action="<?=strip_address("post",$_SERVER['REQUEST_URI']);?>" method="post" enctype="multipart/form-data">
		<select size="1" name="votacao" class="form_input">
		<option value="1" >- 1 -</option>
		<option value="2" >- 2 -</option>
		<option value="3" selected>- 3 -</option>
		<option value="4" >- 4 -</option>
		<option value="5" >- 5 -</option>
		</select>&nbsp;&nbsp;
		<input type="submit" class="button" name="vota" value="<?=$sa[13];?>" />
		<br /><?=$stars;?><br />
		<font class="body_text"><?=$sa[14].' '.round($points,1);?><br />
		(<?=$num_votos.' '.$sa[15];?> )</font><br />
		<?php
		if (isset($_POST['votacao'])):
			echo '<font style="color=red">'.$sa[16].'</font>';
		endif;
		?>	
		</form>
	<?php
	endif;
	?>
	</td>
  </tr>
  <tr>
	<td colspan="3" height="15"></td>
  </tr>
  <tr>
  <td colspan="3">
	<?php
	if ($enable_comments):
	?>
	  <div id="view_comment" style="visibility:visible" >
		<hr size="1" color="#006633"/><a name="view_c" id="view_c"></a>
		<h3><?=$sa[8];?></h3>
		<?php
		if($comments[0][0]<>''):
			for($i=0;$i<count($comments);$i++):
				$user=$ems_db->getquery("select nick from users where cod_user='".$comments[$i][3]."'");
				echo $comments[$i][1].'<br>'.$sa[17].' '.@$user[0][0].' '.$sa[18].' '.strftime('%A, %d %B %Y',$comments[$i][2]).'<br><br>';
			endfor;
		else:
			echo $sa[11].'<br>';
		endif;
		?>	
		</div>
		<?php
		endif;
		?>
	</td>
  </tr>
  <tr>
  <td colspan="3" class="body_text">
	<?php
	if ($enable_comments):
	?>
	  <div id="add_comment" style="visibility:hidden">
		<?php
		if (isset($_SESSION['user'])):
		?>
		<h3><a name="ins_c" id="ins_c"></a><?=$sa[19];?></h3>
		<form class="form" action="<?=strip_address("post",$_SERVER['REQUEST_URI']);?>" method="post" enctype="multipart/form-data">
		  <div align="center"><textarea class="text" name="comment" cols="30" rows="7" wrap="virtual"></textarea></div>
		<div align="right">
		<input class="button" type="submit" name="insert_comment" value="<?=$sa[20];?>" />
		</div>
		</form>
		<?php
		endif;
		?>
		</div>
		<?php
		endif;
		?>
	</td>
  </tr>
</table>
<?php
else:
	echo $sa[21];
endif;
?>