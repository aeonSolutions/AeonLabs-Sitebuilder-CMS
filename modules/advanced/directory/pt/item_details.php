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
if(isset($_GET['id'])):
	$task=$_GET['id'];
else:
//erro
endif;
if(!isset($_GET['cod'])):
	$_SESSION['erro']='Item não encontrado!(detailed-41)';
	$link=session($staticvars,'index.php?id=error');
	header("location: ".$link);
	exit;
endif;
$cod=$_GET['cod'];
include($staticvars['local_root'].'kernel/staticvars.php');
if (isset($_POST['votacao'])):
	$votos=$db->getquery("select num_votos,votacao from items where active='s' and cod_item='".mysql_escape_string($cod)."'");
	$votacao=$votos[0][1]*$votos[0][0]/($votos[0][0]+1)+$_POST['votacao']/($votos[0][0]+1);
	$db->setquery("update items set num_votos='".($votos[0][0]+1)."', votacao='".$votacao."' where cod_item='".mysql_escape_string($cod)."'");
	unset($_POST['votacao']);
endif;
if (isset($_POST['comment'])):
	$comment=mysql_escape_string($_POST['comment']);
	$cod_user=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
	$db->setquery("insert into items_comments set data=NOW(), cod_user='".$cod_user[0][0]."',
	 comment='".$comment."', cod_item='".mysql_escape_string($cod)."'");
	unset($_POST['comment']);
endif;
$myrow=$db->getquery("select titulo, descricao,cod_items_types, content, imagem, downloads,cod_user,num_votos,votacao,cod_category, visible_to from items where active='s' and cod_item='".mysql_escape_string($cod)."'");
if ($myrow[0][0]==''):
	$_SESSION['erro']='Item não encontrado!(detailed-63)';
	$link=session($staticvars,'index.php?id=error');
	header("location: ".$link);
	exit;
else:
	
	if (isset($_POST['do'])):
		$down=1+$myrow[0][5];
		$db->setquery("update items set downloads='".$down."' where cod_item='".mysql_escape_string($cod)."'");
		include($staticvars['local_root'].'kernel/initialize_download.php');
		initialize_download('items/'.$myrow[0][3]);// no initial splash / in the string
		$location=$staticvars['site_path'].'/tmp/'.$myrow[0][3];
		unset($_POST['do']);
		header('HTTP/1.1 200 OK');
		header("Location:".$location);
	endif;
	$user=$db->getquery("select nick,email from users where cod_user='".$myrow[0][6]."'");
	if (file_exists($staticvars['local_root'].'software/images/'.$myrow[0][4])):
		$img=$upload_path.'/items/images/'.$myrow[0][4];
	else:
		$query_a=$db->getquery("select cod_items_types, nome, tipos from items_types where cod_items_types='".$myrow[0][2]."'");
		if ($query_a[0][0]==''):
			$img=$staticvars['site_path'].'/modules/directory/images/no_img.jpg';
		elseif ($query_a[0][2]=='audio'):
			$img=$staticvars['site_path'].'/modules/directory/images/icon_audio.gif';
		elseif ($query_a[0][2]=='video'):
			$img=$staticvars['site_path'].'/modules/directory/images/icon_video.gif';
		elseif ($query_a[0][2]=='image'):
			$img=$staticvars['site_path'].'/modules/directory/images/icon_image.gif';
		elseif ($query_a[0][2]=='zip'):
			$img=$staticvars['site_path'].'/modules/directory/images/icon_zip.gif';
		elseif ($query_a[0][2]=='modulo'):
			$img=$staticvars['site_path'].'/modules/directory/images/no_img.jpg';
		elseif ($query_a[0][2]=='linkexterno'):
			$img=$staticvars['site_path'].'/modules/directory/images/no_img.jpg';
		elseif ($query_a[0][2]=='webpage'):
			$img=$staticvars['site_path'].'/modules/directory/images/no_img.jpg';
		elseif ($query_a[0][2]=='docs'):
			$tmp=explode(".",$myrow[0][3]);
			if ($tmp[1]=='doc'):
				$img=$staticvars['site_path'].'/modules/directory/images/icon_word.gif';
			elseif($tmp[1]=='xls'):
				$img=$staticvars['site_path'].'/modules/directory/images/icon_excel.gif';
			elseif($tmp[1]=='pdf'):
				$img=$staticvars['site_path'].'/modules/directory/images/icon_pdf.gif';
			else:
				$img=$staticvars['site_path'].'/modules/directory/images/icon_word.gif';
			endif;
		else:
			$img=$staticvars['site_path'].'/modules/directory/images/no_img.jpg';
		endif;
	endif;
	
	
	include($staticvars['local_root'].'modules/directory/system/settings.php');
	if ($enable_user_groups==true and isset($_SESSION['user'])):
		// procurar os utilizdores autorizados
		$store=$db->getquery("select cod_user_group from user_type where cod_user_type='".$myrow[0][6]."'");
		$store[0]=$store[0][0];
		$tmp=$store[0];
		$i=1;
		while ($tmp<>0):
			$cug=$db->getquery("select cod_user_type, cod_user_group from user_type where cod_user_type='".$tmp."'");
			if ($cug[0][0]<>0):
				$store[$i]=$cug[0][0];
				$tmp=$store[$i];
				$i++;
			endif;
		endwhile;
		// procurar as categorias autorizadas
		$tmp="where cod_user_type='".$store[0]."'";
		for ($i=1; $i<count($store);$i++):
			$tmp.=" and cod_user_type='".$store[$i]."'";
		endfor;
	endif;
	$ca=$db->getquery("select cod_category from category ".$tmp);
	$default_code=$db->getquery("select cod_user_type from user_type where name='Default'");
	if ($default_code[0][0]<>''):
		$default_code=$default_code[0][0];
	else:
		$default_code=-1;
	endif;
	if (array_search($my_row[0][9],$ca)<>NULL or $staticvars['users']['user_type']['admin']==$staticvars['users']['group'] or $myrow[0][10]==$default_code):
		$down='<a href="javascript:document.dodown.submit();">'.$myrow[0][3].'</a>';
	else:
		$down='';
	endif;
	
	if ($myrow[0][7]>0):
		$points=$myrow[0][8];
		$num_votos=$myrow[0][7];
	else:
		$points=3;
		$num_votos=0;
	endif;
	$stars='';
	for ($i=1;$i<=round($points,0);$i++):
		$stars .='<img src="'.$staticvars['site_path'].'/modules/directory/images/vote_star_full.gif" alt="vota&ccedil;&atilde;o" width="16" height="16" />';
	endfor;
	for ($i=round($points,0)+1;$i<=5;$i++):
		$stars .='<img src="'.$staticvars['site_path'].'/modules/directory/images/vote_star_empty.gif" alt="vota&ccedil;&atilde;o" width="16" height="16" />';
	endfor;
	$comments=$db->getquery("select cod_comment, comment, data, cod_user from items_comments where cod_item='".mysql_escape_string($cod)."'");
	if ($comments[0][0]<>''):
		$num_comments=count($comments);
	else:
		$num_comments=0;
	endif;
endif;
include($staticvars['local_root'].'modules/directory/system/settings.php');
?>
<script type="text/javascript" language="JavaScript">
function checkBrowser(){
	this.ver=navigator.appVersion
	this.dom=document.getElementById?1:0
	this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom)?1:0;
	this.ie4=(document.all && !this.dom)?1:0;
	this.ns5=(this.dom && parseInt(this.ver) >= 5) ?1:0;
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie5 || this.ie4 || this.ns4 || this.ns5)
	return this
}
bw=new checkBrowser()
//With nested layers for netscape, this function hides the layer if it's visible and visa versa
function showHide(div,nest){
	obj=bw.dom?document.getElementById(div).style:bw.ie4?document.all[div].style:bw.ns4?nest?document[nest].document[div]:document[div]:0;
	if(obj.visibility=='visible' || obj.visibility=='show') obj.visibility='hidden'
	else obj.visibility='visible'
}
//Shows the div
function show(div,nest){
	obj=bw.dom?document.getElementById(div).style:bw.ie4?document.all[div].style:bw.ns4?nest?document[nest].document[div]:document[div]:0;
	obj.visibility='visible'
}
//Hides the div
function hide(div,nest){
	obj=bw.dom?document.getElementById(div).style:bw.ie4?document.all[div].style:bw.ns4?nest?document[nest].document[div]:document[div]:0;
	obj.visibility='hidden'
}
</script>

<table  border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td colspan="3"><h1><img src="<?=$staticvars['site_path'];?>/modules/directory/images/folder_open.gif" alt="Informa&ccedil;&atilde;o detalhada" width="16" height="16" />
	Informa&ccedil;&atilde;o detalhada</h1></td>
  </tr>
  <tr>
  <td colspan="3">	</td>
  </tr>
  <tr>
    <td height="15" colspan="3"><font class="header_text_1"><br>
		<b><?=$myrow[0][0];?></b></font>
		<hr class="orangebar">
      <font class="body_text"><p align="justify"><?=$myrow[0][1];?>
	    <br>
	  </p>
      </font>
		<p align="center"><img src="<?=$img;?>" >
		<form  name="dodown" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="do" value="do" />
		<?=$down;?>
		</form>
		<font class="body_text">(<?=$myrow[0][5];?> downloads)</font></p>
		<p align="left"><font class="body_text"><font class="body_text"><strong>Colocado por:</strong>&nbsp;&nbsp;&nbsp;<a href="mailto:<?=$user[0][1];?>">
        <?=$user[0][0];?>
        </a></font></font></p>
	<hr class="orangebar">		<br></td>
  </tr>
  <tr valign="top">
  <td width="32" height="32">
  	<?php
	if ($enable_comments):
	?>
	<img src="<?=$staticvars['site_path'].'/modules/directory';?>/images/comment.gif" alt="coment&aacute;rio" width="40" height="40" />
	<?php
	endif;
	?>
	</td>
    <td >
	<?php
	if ($enable_comments):
	?>
		<a name="#" id="#"></a>
		<?php
		if (isset($_SESSION['user'])):
			?>
			<a class="header_text_1" href="#" onclick="show('add_comment')">Comentar</a>&nbsp;<br />
			<?php
		else:
			?>
			Comentar&nbsp;<br />
			<?php
		endif;
		?>
		<a class="body_text" href="#" onclick="show('view_comment')">existem <?=$num_comments;?> coment&aacute;rios</a></td>
	<?php
	endif;
	?>
    <td align="right">
	<?php
	if ($enable_voting):
		?>
		<form action="<?=session($staticvars,'index.php?id='.@$_GET['id'].'&cod='.$cod);?>" method="post" enctype="multipart/form-data">
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
		<form action="<?=session($staticvars,'index.php?id='.@$_GET['id'].'&cod='.$cod);?>" method="post" enctype="multipart/form-data">
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

