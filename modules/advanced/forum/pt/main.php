<?php 
$bar=@include('general/site_handler.php');
if (!$bar):
	// erro possible hack
	exit;
endif; 
$sid=@$_GET['SID'];
$forum_id=return_id('forum.php');
$posts=$db->getquery("select cod_topic, cod_forum, assunto, mensagem,reply_to from forum_topic order by data DESC limit 0,3");
include_once('modules/forum/system/bbcode_main.php');

function put_200_char($txt){
$i=0;
$open_char=false;
$string='';
while($i<strlen($txt) ):
	if ($txt[$i]=='<'):
		$open_char=true;
	elseif($txt[$i]=='>'):
		$open_char=false;
	endif;
	$string.=$txt[$i];
	$i++;
	if (($i+1)>strlen($txt)):
		break;
	elseif(($i+1)>200 and $open_char==false):
		break;
	endif;
endwhile;
$string=str_replace("<img","<img width=200",$string);
return $string;
};
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="300">
  <tr height="10">
    <td width="110" valign="top"><a href="<?=session($staticvars,'index.php?id='.$forum_id);?>"><img src="<?=$staticvars['site_path'].'/modules/forum/images/'.$lang.'/forum_eng.gif';?>" border="0"/></a></td>
    <td align="right" valign="top" class="body_text">&uacute;ltimos posts adicionados ao forum </td>
  </tr>
  <tr>
    <td colspan="2" class="body_text" valign="top"><br>
	<?php
	if($posts[0][0]<>''):
		for($i=0;$i<count($posts);$i++):
			$forum_name=$db->getquery("select nome from forum_forum where cod_forum='".$posts[$i][1]."'");
			if($posts[$i][4]=='0'):
				echo '<strong>'.$forum_name[0][0].'</strong><br>&nbsp;&nbsp;&nbsp;<a href="'.session($staticvars,'index.php?id='.$forum_id.'&topic='.$posts[$i][0]).'">'.$posts[$i][2].'</a><br>&nbsp;&nbsp;&nbsp;'.put_200_char(load_txtf($posts[$i][3])).' ...<br><hr size="1" color="#006633"/><br>';
			else:
				echo '<strong>'.$forum_name[0][0].'</strong><br>&nbsp;&nbsp;&nbsp;<a href="'.session($staticvars,'index.php?id='.$forum_id.'&topic='.$posts[$i][4]).'">'.$posts[$i][2].'</a><br>&nbsp;&nbsp;&nbsp;'.put_200_char(load_txtf($posts[$i][3])).' ...<br><hr size="1" color="#006633"/><br>';
			endif;
		endfor;
	endif;
	?>	</td>
  </tr>
</table>
