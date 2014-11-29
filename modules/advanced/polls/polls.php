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
drawstats();



function drawstats(){
include('kernel/staticvars.php');
$header='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<img src="<?=$staticvars['site_path'];?>/modules/polls/images/icon.gif" />&nbsp;<font class="header_text_3">Inquérito</font>
<table style="background:url(<?=$staticvars['site_path'];?>/modules/polls/images/puzzle-pieces.gif) no-repeat" align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td>
	<?php
	if (isset($_POST['polls_vota']) and isset($_POST['submit_poll'])): // efectuar a vota&ccedil;&atilde;o
			$st=$db->getquery("select name,questions, votes from polls where active='s'");
			$questions=explode(",",$st[0][1]);
			$questions[0]=' '.$questions[0];
			$votes=explode(":",$st[0][2]);
			$votes[$_POST['polls_vota']]=$votes[$_POST['polls_vota']]+1;
			$votes=implode(":",$votes);
			$db->setquery("update polls set votes='".$votes."' where active='s'");
			unset($_POST['polls_vota']);
			unset($_POST['submit_poll']);
	endif;
	if (isset($_POST['view_poll'])): // mostra resultados de vota&ccedil;&atilde;o
			$st=$db->getquery("select name,questions,votes from polls where active='s'");
			$questions=explode(",",$st[0][1]);
			$questions[0]=' '.$questions[0];
			$votes=explode(":",$st[0][2]);
			$sum=array_sum($votes);
			echo '<div align="left"><font class="body_text"><b>'.$st[0][0].'</font></b></div>';
			echo '</td></tr>';
			echo '<form name="poll" method="POST" action="'.$header.'" enctype="multipart/form-data">';
			for ($i=0;$i<count($questions);$i++):
				if ($sum==0):
					$res=0;
				else:
					$res=round($votes[$i]*100/$sum,2);
				endif;
				echo '<tr><td height="5">';
				echo '<div align="left"><font class="body_text">&nbsp;&nbsp;&nbsp;'.$questions[$i].': '.$res.'%</font></div>';
				echo '</td></tr>';		
			endfor;
			echo '<tr><td height="5">';
			echo '</td></tr>';		
			echo '<tr><td height="5">';
			echo '<div align="right"><input class="form_submit" type="submit" name="submit_poll" value=" Vota&ccedil;&atilde;o "></div>';
			echo '</td></tr></form>';		
	else: // $stats=false
		$st=$db->getquery("select name,questions from polls where active='s'");
		if ($st[0][0]<>''):
			$questions=explode(",",$st[0][1]);
			$questions[0]=' '.$questions[0];
			echo '<div align="left"><font class="body_text"><b>'.$st[0][0].'</font></b></div>';
			echo '</td></tr>';
			echo '<form name="poll" method="POST" action="'.$header.'" enctype="multipart/form-data">';
			for ($i=0;$i<count($questions);$i++):
				echo '<tr><td height="5">';
				echo '<div align="left"><input name="polls_vota" type="radio" value="'.$i.'">&nbsp;<font class="body_text">'.$questions[$i].'</font></div>';
				echo '</td></tr>';		
			endfor;
			echo '<tr><td height="5">';
			echo '</td></tr>';		
			echo '<tr><td height="5">';
			echo '<div align="right"><input class="form_submit" type="submit" name="submit_poll" value=" Votar ">&nbsp;<input class="form_submit" type="submit" name="view_poll" value="Resultados"></div>';
			echo '</td></tr></form>';	
		else:
			//echo '<div align="center"><font class="simpletext"><b>Nao h&aacute; vota&ccedil;&otilde;es activas</font></b></div>';
		endif;
	endif;
	?>
   </td>
  </tr>
</table>

<?php
};

?>