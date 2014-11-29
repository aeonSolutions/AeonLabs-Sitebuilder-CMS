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

#promote {
background:#14568a;
color:#fff;
height:70px;
padding:5px 10px;
text-align:left;
line-height:1.4em;
}
#promote a {
	color:#FFF;
}
</style>
<?php
if(!include($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$split_post=5;
	$enable_comments=true;
	$enable_voting=true;
endif;
include_once($staticvars['local_root'].'modules/congressos/system/functions.php');
$art= isset($_GET['article']) ? mysql_escape_string($_GET['article']) : 0 ;
$query=$db->getquery("select cod_congresso,cod_categoria, cod_user, title, texto, UNIX_timestamp(data_publicacao) as fld_unixtimestamp, lida, UNIX_timestamp(data) as fld_unixtimestamp2, num_votos, votacao from congressos where cod_congresso='".$art."' and active='s'");
if($query[0][0]<>''):// results found
	if (isset($_POST['votacao'])):
		$votos=$db->getquery("select num_votos,votacao from congressos where cod_congresso='".$art."'");
		$votacao=$votos[0][1]*$votos[0][0]/($votos[0][0]+1)+$_POST['votacao']/($votos[0][0]+1);
		$db->setquery("update congressos set num_votos='".($votos[0][0]+1)."', votacao='".$votacao."' where cod_congresso='".$art."'");
		unset($_POST['votacao']);
	endif;
	if (isset($_POST['comment'])):
		$comment=mysql_escape_string($_POST['comment']);
		$cod_user=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
		$db->setquery("insert into items_comments set data=NOW(), cod_user='".$cod_user[0][0]."',
		 comment='".$comment."', cod_congresso='".$art."'");
		unset($_POST['comment']);
	endif;
	if(!isset($_POST['comment']) and !isset($_POST['votacao'])):
		$lida=$query[0][6]+1;
		$db->setquery("update congressos set lida='".$lida."' where cod_congresso='".$art."'");
	endif;
	$cats=$db->getquery("select cod_categoria, cod_sub_cat, nome from congressos_categorias");
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
	echo '<h2>'.$query[0][3].'</h2>';// titulo
	?>
	<div align='right'>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/pdf.php?article=<?=$art;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="PDF">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/pdf_button.png" alt="PDF" name="PDF" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/print.php?article=<?=$art;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="Print">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/printButton.png" alt="Print" name="Print" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/email.php?article=<?=$art;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="E-mail">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/emailButton.png" alt="E-mail" name="E-mail" align="middle" border="0"></a>
	 </div>
	<?php
	for($k=count($cat_tree)-1;$k>=0;$k--):
		$tmp= $k==0 ? ' ' : '>';
		echo '<a href="'.session($staticvars,'index.php?id='.$pub_list.'&cat='.$cat_cod[$k]).'">'.$cat_nome[$cat_tree[$k]].'</a>'.$tmp;
	endfor;
	setlocale(LC_CTYPE, 'portuguese');
	setlocale(LC_TIME, 'portuguese');
	echo '<br><span class="header">Escrito por '.$user.'<br>'.strftime('%A, %d %B %Y',$query[0][5]).'</span><br><br>';
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
	$page_selection=select_page($page,$total,$_SERVER['REQUEST_URI']);// page starts at 1 not at 0
	echo 'P&aacute;gina '.$page.' de '.$total.'<br>';
	echo $page_txt[$page-1];
	echo '<br><br><font style="font-size:smaller">&Uacute;ltima actualiza&ccedil;&atilde;o ('.strftime('%A, %d %B %Y',$query[0][7]).')</font>';
	echo '<br><br>'.$page_selection.chr(13);
	$artigos=$db->getquery("select cod_ficheiro, ficheiro, descricao from congressos_ficheiros where cod_congresso='".$query[0][0]."'");
	if($artigos[0][0]<>''):
		echo '<br /><br /><hr size="3" color="#999999" />';
		echo '<font style="text-transform:uppercase;font-size:x-small">Arquivos relacionados para download</font><br />';
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

	if ($query[0][8]>0):
		$points=$query[0][9];
		$num_votos=$query[0][8];
	else:
		$points=3;
		$num_votos=0;
	endif;

	$stars='';
	for ($i=1;$i<=round($points,0);$i++):
		$stars .='<img src="'.$staticvars['site_path'].'/modules/congressos/images/vote_star_full.gif" alt="vota&ccedil;&atilde;o" width="16" height="16" />';
	endfor;
	for ($i=round($points,0)+1;$i<=5;$i++):
		$stars .='<img src="'.$staticvars['site_path'].'/modules/congressos/images/vote_star_empty.gif" alt="vota&ccedil;&atilde;o" width="16" height="16" />';
	endfor;
	$comments=$db->getquery("select cod_comment, comment, data, cod_user from congressos_comments where cod_congresso='".$art."'");
	if ($comments[0][0]<>''):
		$num_comments=count($comments);
	else:
		$num_comments=0;
	endif;

?>
<br />
<div id="promote">
Partilhe ou envie por email a um amigo: <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#tabs=web%2Cpost%2Cemail&amp;charset=utf-8&amp;style=rotate&amp;publisher=edda96d3-55ab-4337-968b-2aaf45b8763a"></script>
<? include($staticvars['local_root'].'modules/congressos/system/promote.php'); ?>
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
	<img src="<?=$staticvars['site_path'].'/modules/congressos/images/comment.gif';?>" alt="coment&aacute;rio" width="40" height="40" />
	<?php
	endif;
	?>
	</td>
	<td width="50%" >
	<?php
	if ($enable_comments):
	?>
		<a name="#" id="#"></a>
		<?php
		if (isset($_SESSION['user'])):
			?>
			<a class="header_text_1" href="<?=session($staticvars,'index.php?id='.return_id('new_register.php'));?>" onclick="show('add_comment')">Tem que estar registado para comentar</a>&nbsp;<br />
			<?php
		else:
			?>
			<a class="header_text_1" href="<?=session($staticvars,'index.php?id='.return_id('new_register.php'));?>" >Tem que estar registado para comentar</a>&nbsp;<br />
			<?php
		endif;
		?>
		<a class="body_text" href="#" onclick="show('view_comment')">existem <?=$num_comments;?> coment&aacute;rios</a></td>
	<?php
	endif;
	?>
	<td width="50%" align="right">
	<?php
	if ($enable_voting):
		?>
		<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
		<select size="1" name="votacao" class="form_input">
		<option value="1" >- 1 -</option>
		<option value="2" >- 2 -</option>
		<option value="3" selected>- 3 -</option>
		<option value="4" >- 4 -</option>
		<option value="5" >- 5 -</option>
		</select>&nbsp;&nbsp;
		<input type="submit" class="form_submit" name="vota" value="Votar" />
		<br /><?=$stars;?><br />
		<font class="body_text">Pontuação:<?=round($points,1);?><br />
		(<?=$num_votos;?> votos)</font><br />
		<?php
		if (isset($_POST['votacao'])):
			echo '<font style="color=red">Votação efectuada.</font>';
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
	  <div id="add_comment" style="visibility:visible">
		<?php
		if (isset($_SESSION['user'])):
		?>
		<hr size="1" color="#006633"/>
		<font class="header_text_1">Inserir Comentário</font>
		<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
		  <div align="center"><textarea name="comment" cols="30" rows="7" wrap="virtual"></textarea></div>
		<div align="right">
		<input class="form_submit" type="submit" name="insert_comment" value="Inserir" />
		</div>
		</form>
		<hr size="1" color="#006633"/>
		<?php
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
	  <div id="view_comment" style="visibility:hidden" >
		<hr size="1" color="#006633"/>
		<font class="header_text_1">Comentários</font><br />
		<?php
		if($comments[0][0]<>''):
			for($i=0;$i<count($comments);$i++):
				$user=$db->getquery("select nick from users where cod_user='".$comments[$i][3]."'");
				echo $comments[$i][1].'<br>Colocado por:'.@$user[0][0].'&nbsp;em '.$comments[$i][2].'<br><hr size="1" color="#006633"/><br>';
			endfor;
		else:
			echo 'não há comentários colocados.<br>';
		endif;
		?>	
		<hr size="1" color="#006633"/>
		</div>
		<?php
		endif;
		?>
	</td>
  </tr>
</table>
<?php
else:
	echo 'Artigo nao encontrado!';
endif;
?>