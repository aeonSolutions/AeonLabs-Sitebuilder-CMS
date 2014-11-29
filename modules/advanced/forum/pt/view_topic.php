<?php
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
@session_start();
// returns the current hard drive directory not the root directory
$path=explode("/",__FILE__);
$local_pds=$path[0];
for ($i=1;$i<count($path)-1;$i++):
	$local_pds=$local_pds.'/'.$path[$i];
endfor;
$local_pds=$local_pds.'/';
$task=@$_GET['id'];
if (isset($_GET['topic'])):
	$topic=mysql_escape_string($_GET['topic']);
endif;
$query=$db->getquery("select cod_topic from forum_topic where cod_topic='".$topic."'");
if ($query[0][0]==''):
	?>
	<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td align="center">
		<font class="body_text">N&atilde;o existe o tópico.</font>
		</td>
	  </tr>
	</table>
	<?php
	exit;
endif;
$query=$db->getquery("select reply_to from forum_topic where cod_topic='".$topic."'");
if ($query[0][0]<>'0'):
	$topic=$db->getquery("select cod_topic from forum_topic where cod_topic='".$query[0][0]."'");
	if ($topic[0][0]==''):
		?>
		<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr>
			<td align="center">
			<font class="body_text">N&atilde;o existe o tópico.</font>
			</td>
		  </tr>
		</table>
		<?php
		exit;
	endif;
	$topic=$topic[0][0];
endif;
include($local.'../../kernel/staticvars.php');
$view=$db->getquery("select cod_forum from forum_topic where cod_topic='".$topic."'");
if ($view==''):
	echo 'Error topic';
	exit;
endif;

$view=$view[0][0];
$forum_name=$db->getquery("select nome from forum_forum where cod_forum='".$view."'");
$forum_topics=$db->getquery("select cod_topic,cod_user, assunto,mensagem,data,num_views,cod_forum,locked from forum_topic where cod_topic='".$topic."'");
$num_views=$forum_topics[0][5]+1;
$db->setquery("update forum_topic set num_views='".$num_views."', data='".$forum_topics[0][4]."' where cod_topic='".$topic."'");
$posts=$db->getquery("select cod_topic,cod_user, assunto,mensagem, data,num_views from forum_topic where reply_to='".$topic."' order by data ASC");
if($posts<>''):
	$total=count($forum_topics)-1;
else:
	$total=0;
endif;
$lower=@$_GET['lower'];
$upper=@$_GET['upper'];
if ($lower==''):
	$lower=1;
endif;
if ($upper==''):
	$upper=15;
endif;
if ($upper > $total):
	$upper=$total;
endif;
$browse_id=return_id('directory_browsing.php');
include($local.'system/bbcode.php');

$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
if ($admin_code[0][0]<>''):
	$admin_code=$admin_code[0][0];
else:
	$admin_code=-1;
endif;
if (isset($_SESSION['user'])):
	$auth_user=$db->getquery("select cod_user_type,cod_user from users where nick='".mysql_escape_string($_SESSION['user'])."'");

	if ($auth_user[0][0]<>''):
		$tmp=$auth_user;
		$auth_user=$tmp[0][0];
		$user_code=$tmp[0][1];
	else:
		$auth_user=-2;
		$user_code=-2;
	endif;
else:
	$auth_user=-2;
	$user_code=-2;
endif;
if ($auth_user==$admin_code):
	$admin_logged=true;
else:
	$admin_logged=false;
endif;
?>
<!DOCTYPE HTML var "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Forum</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {color: #006699}
-->
</style>
</head>
<style>
BODY {
	FONT-SIZE: 9pt;
	FONT-FAMILY: verdana;
	BACKGROUND-COLOR:#dddddd ;
	SCROLLBAR-FACE-COLOR: white;
	SCROLLBAR-SHADOW-COLOR: white;
	SCROLLBAR-ARROW-COLOR: green
}
.header_text_0{
        color: #000000;
        font-size : 16px;
        font-weight : bolder;
		font:Arial, Helvetica, sans-serif;
		TEXT-DECORATION: none;
		text-transform:capitalize;
}
.header_text_1{
        color: #000000;
        font-size : 11px;
        font-weight : bolder;
		font:Arial, Helvetica, sans-serif;
		TEXT-DECORATION: none;
}
.header_text_2{
        color: #000000;
        font-size : 13px;
        font-weight : bolder;
		font:Arial, Helvetica, sans-serif;
		TEXT-DECORATION: none;
}
.body_text{
        color: #000000;
        font-size : 9px;
        font-weight : normal;
		font:Arial, Helvetica, sans-serif;
		TEXT-DECORATION: none;
}
.form_submit{
	border-style : solid;
	border-top-width : 1px;
	border-right-width : 1px;
	border-bottom-width : 1px;
	border-left-width : 1px;		
	color : #FFFFFF;
	background: #2c4563;	
	font-size : 9px;
	font-weight : normal;
	font:Arial, Helvetica, sans-serif;
}
</style>
<body>
<a name="topo"></a>
<table cellSpacing="0" cellPadding=2 width="98%" border="0">
  <tr>
    <td width="1%"><A href="<?=session($staticvars,'index.php');?>"><IMG height=43 src="modules/forum/images/logo.gif" width=275 border="0"></A></td>
    <td>
      <table cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tr>
          <td vAlign=bottom align=right>&nbsp;</td>
          <td width="90" align=right vAlign=bottom noWrap><font class="body_text"><A href="<?=session($staticvars,'index.php?id='.$browse_id);?>"></A></font></td>
          <td width="70" align=right vAlign=bottom noWrap><font class="body_text"><A href="<?=session($staticvars,'index.php?id=?');?>"></A></font></td>
        </tr>
      </table>
      <HR noShade SIZE=1>
    </td>
  </tr>
</table>
<TABLE width=100% border=0 align="center" cellPadding=0 cellSpacing=0>
	<TBODY>
	<TR height=31>
	  <TD vAlign=top width=42 background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Boxw_Top_Left.gif">&nbsp;</TD>
	  <TD vAlign=top align=right background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Top.gif" colSpan=2 
	  height=31><IMG height=34 alt="" src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/fade_strip.gif" width=205 border=0><IMG height=34
	   alt="" src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/fade_strip1.gif" width=32 border=0><IMG height=34 alt=""
		src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/fade_strip2.gif" width=34 border=0><IMG height=34 alt="" src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/new_top_right.gif" width=17 border=0></TD>
	</TR>
	<TR>
	  <TD vAlign=top width=42 background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Boxw_Left.gif">&nbsp;</TD>
	  <TD vAlign=top bgColor=#e3e3e3 align="center"><table width="100%"  border="0" cellspacing="3" cellpadding="0">
		  <tr>
			<td colspan="2" class="header_text_0"><?=$forum_name[0][0];?></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="3">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="200" nowrap="nowrap"><a href="<?=session($staticvars,'index.php?id='.return_id('new_topic.php').'&forum='.$view);?>">
			<img src="<?=$staticvars['site_path'].'/modules/forum/images/buttons/'.$lang.'/new_topic.gif';?>" border="0"></a>&nbsp;
			<?php
			if ($forum_topics[0][7]<>'s'):?>
			<a href="<?=session($staticvars,'index.php?id='.return_id('new_topic.php').'&forum='.$view.'&reply='.$topic);?>">
			<img src="<?=$staticvars['site_path'].'/modules/forum/images/buttons/'.$lang.'/reply_topic.gif';?>" border="0"></a>
			<?php
			endif;?></td>
			<td class="header_text_2" valign="middle"> <a href="<?=session($staticvars,'index.php?id='.$task);?>">Forum</a> &gt;
              <a href="<?=session($staticvars,'index.php?id='.$task.'&view='.$view);?>"><?=$forum_name[0][0];?></a></td>
			<td class="header_text_1"><?=put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?id='.$task.'&lower='.$lower.'&upper='.$upper.'&view='.$view));?></td>
		  </tr>
		</table>

	    <table width="100%" cellpadding="5" cellspacing="1" border="0" style="background-color: #FFFFFF; border: 2px #006699 solid; ">
          <tr>
            <td width="150" height="25" align="center" nowrap="nowrap" class="Header_text_1">&nbsp;Autor&nbsp;</td>
            <td align="center" nowrap="nowrap" class="Header_text_1">&nbsp;Mensagem&nbsp;</td>
          </tr>
          
		  <tr>
		    <td width="150" height="50" align="left" valign="top" bgcolor="#EFEFEF" class="body_text">
	        <?php
			$user_name=$db->getquery("select nick,data,avatar from users where cod_user='".$forum_topics[0][1]."'");
			if ($user_name[0][2]=='no_avatar'):
				$avatar=$staticvars['site_path'].'/modules/authoring/images/no_avatar.gif';
			else:
				$avatar=$upload_path.'/avatars/'.$user_name[0][2];
			endif;
			echo '<img border="1" src="'.$avatar.'" width="100" height="100" /><br />';
			echo $user_name[0][0].'<br>Membro desde:<br>&nbsp;&nbsp;'.date ('d M Y',strtotime($user_name[0][1]));
			?></td>
            <td valign="top" align="left" class="body_text" bgcolor="#EFEFEF">
			
			Colocado em:<?=date ('d M Y',strtotime($forum_topics[0][4]));?>&nbsp;&nbsp;Assunto:<?=$forum_topics[0][2];?> 
			<HR noShade SIZE=1>
			<?=load_txt($forum_topics[0][3]);?></td>
          </tr>
          <tr>
            <td width="150" height="10" align="center" valign="middle" bgcolor="#EFEFEF"> <a href="#topo" class="header_text_1">
            <font color="#006699">Voltar a cima</font></a></td>
            <td height="10" align="left" valign="middle" bgcolor="#EFEFEF">
				<table border="0" cellpadding="0" cellspacing="5">
				  <tr height="5">
				<?php
				if ($admin_logged==true or $user_code==$forum_topics[0][1]):
					?>
						<td width="30">
						<form action="<?=session($staticvars,'index.php?id='.return_id('edit_topic.php'));?>" enctype="multipart/form-data" method="post">
						<input type="hidden" name="cod_topic" value="<?=$forum_topics[0][0];?>">
						<input class="form_submit" type="submit" value="Editar" name="editar"></form></td>
					<?php
				endif;
				if ($admin_logged==true):
					?>
						<td width="30">
						<form action="<?=session($staticvars,'modules/forum/update_db/manage_forum.php?id='.$task.'&topic='.$topic);?>" enctype="multipart/form-data" method="post">
							<input type="hidden" name="cod_topic" value="<?=$forum_topics[0][0];?>">
							<input class="form_submit" type="submit" value="Apagar" name="apagar"></form></td>
					<?php
				endif;
				if($admin_logged==false and $user_code<>$forum_topics[0][1]):
					?>
						<td></td>
					<?php
				endif;
				?>
				  </tr></table>
			</td>
          </tr>
          <tr>
		  <td style="background-color: #D1D7DC; border: #FFFFFF; border-style: solid;" colspan="2" height="3"></td>
		  </tr>
          <?php
		  if ($posts[0][0]<>''):
			$color='#C4D7FF';
		  	for($i=0; $i<count($posts);$i++):
				if ($color<>'#DEE3E7'):
					$color='#DEE3E7';				
				else:
					$color='#EFEFEF"';
				endif;
			  ?>
			  <tr>
				<td width="150" height="50" align="left" valign="middle" bgcolor="<?=$color;?>" class="body_text">
				<?php
				$user_name=$db->getquery("select nick,data,avatar from users where cod_user='".$posts[$i][1]."'");
				if ($user_name[0][2]=='no_avatar' or $user_name[0][2]==''):
					$avatar=$staticvars['site_path'].'/modules/authoring/images/no_avatar.gif';
				else:
					$avatar=$upload_path.'/avatars/'.$user_name[0][2];
				endif;
				echo '<img border="1" src="'.$avatar.'" width="100" height="100" /><br />';
				echo $user_name[0][0].'<br>Membro desde:<br>&nbsp;&nbsp;'.date ('d M Y',strtotime($user_name[0][1]));
				?></td>
				<td valign="top" align="left" class="body_text" bgcolor="<?=$color;?>">
				Colocado em:<?=date ('d M Y',strtotime($forum_topics[0][4]));?>&nbsp;&nbsp;Assunto:<?=$posts[$i][2];?> 
				<HR noShade SIZE=1>
				<?=load_txt($posts[$i][3]);?></td>
			  </tr>
			  <tr>
				<td width="150" height="10" align="center" valign="middle" bgcolor="<?=$color;?>"> <a href="#topo" class="header_text_1">
				<font color="#006699">Voltar a cima</font></a></td>
				<td height="10" align="left" valign="middle" bgcolor="<?=$color;?>">
					<table border="0" cellpadding="0" cellspacing="0">
					  <tr>
					<?php
					if ($admin_logged==true or $user_code==$posts[$i][1]):
						?>
							<td valign="middle">
							<form action="<?=session($staticvars,'index.php?id='.return_id('edit_topic.php'));?>" enctype="multipart/form-data" method="post">
						<input type="hidden" name="cod_topic" value="<?=$posts[$i][0];?>">
						<input class="form_submit" type="submit" value="Editar" name="editar">&nbsp;
							</form></td>
						<?php
					endif;
					if ($admin_logged==true):
						?>
							<td valign="middle">
							<form action="<?=session($staticvars,'modules/forum/update_db/manage_forum.php?id='.$task.'&topic='.$topic);?>" enctype="multipart/form-data" method="post">
								<input type="hidden" name="cod_topic" value="<?=$posts[$i][0];?>">
								<input class="form_submit" type="submit" value="Apagar" name="apagar">
							</form></td>
						<?php
					endif;
					if($admin_logged==false and $user_code<>$posts[$i][1]):
						?>
							<td></td>
						<?php
					endif;
					?>
				  </tr>
				</table></td>
				  </tr>
				  <tr>
				  <td style="background-color: #D1D7DC; border: #FFFFFF; border-style: solid;" colspan="2" height="3"></td>
				  </tr>
				  <?php
			endfor;
		endif;
		  ?>
        </table>	    
	    <table width="100%"  border="0" cellspacing="3" cellpadding="0">
		  <tr>
			<td width="200"><a href="<?=session($staticvars,'index.php?id='.return_id('new_topic.php').'&forum='.$view);?>"><img src="<?=$staticvars['site_path'].'/modules/forum/images/buttons/'.$lang.'/new_topic.gif';?>" border="0"></a>&nbsp;
			<?php
			if ($forum_topics[0][7]<>'s'):?>
			<a href="<?=session($staticvars,'index.php?id='.return_id('new_topic.php').'&forum='.$view.'&reply='.$topic);?>">
			<img src="<?=$staticvars['site_path'].'/modules/forum/images/buttons/'.$lang.'/reply_topic.gif';?>" border="0"></a>
			<?php
			endif;?></td>
			<td class="header_text_2" valign="middle"> <a href="<?=session($staticvars,'index.php?id='.$task);?>">Forum</a> &gt;
              <a href="<?=session($staticvars,'index.php?id='.$task.'&view='.$view);?>"><?=$forum_name[0][0];?></a></td>
			<td class="header_text_1"><?=put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?id='.$task.'&lower='.$lower.'&upper='.$upper.'&view='.$view));?></td>
		  </tr>
		  <tr>
		  <td colspan="3" align="right">
			<form method="post" action="<?=session($staticvars,'index.php?id='.$task);?>" enctype="multipart/form-data">
			<font class="body_text">Forum&nbsp;</font><select size="1" name="jump_to" class="body_text">
				<?php
				$query=$db->getquery("select cod_cat, titulo from forum_cats where active='s'");
				$k=0;
				$option[$k][0]='';
				$option[$k][1]='-----------------';
				$k=1;
				if($query[0][0]<>''):
					for ($i=0;$i<count($query);$i++):
						$query2=$db->getquery("select cod_forum, nome from forum_forum where active='s' and cod_cat='".$query[$i][0]."'");
						$option[$k][0]="optgroup";
						$option[$k][1]=$query[$i][1];
						$k++;
						for ($j=0;$j<count($query2);$j++):
							$option[$k][0]=$query2[$j][0];
							$option[$k][1]='&nbsp;&nbsp;&nbsp;'.$query2[$j][1];
							$k++;
						endfor;
					endfor;
				endif;
				for ($i=0 ; $i<count($option); $i++):
					 if ($option[$i][0]=='optgroup'):
					 ?>
						<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
					 <?php
					 else:
						?>
						<option value="<?=$option[$i][0];?>"><?=$option[$i][1]; ?></option>
					<?php
					endif;
				endfor; ?>
			</select>&nbsp;&nbsp; 
			<input type="image" src="<?=$staticvars['site_path'];?>/images/buttons/pt/ver.gif" name="user_input">
			</form>
		  </td>
		  </tr>
		</table></TD>
	  <TD width="10" align="right" background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Right.gif" bgColor=#e3e3e3><IMG 
		height=100 alt="" src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/empty.gif" 
		width=10 border=0></TD>
	  </TR>
	<TR>
	  <TD width=42 
		background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Bottom.gif"><IMG 
		height=14 alt="" 
		src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Bottom_Left.gif" width=23 
		border=0></TD>
	  <TD width=891 
		background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Bottom.gif"><IMG 
		height=10 alt="" src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/empty.gif" 
		width=10 border=0></TD>
      <TD width="28" align="right" background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Bottom.gif"><IMG height=14 alt="" 
		src="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Bottom_Right.gif" width=28 
		border=0></TD>
      </TR>
</TBODY>
</TABLE>
</body>
</html>

<?php

function put_previous_next_page($lower,$upper,$total,$link){
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
if ($lang=='pt'):
	$last_page='P&aacute;g. Anterior';
	$next_page='P&aacute;g. Seguinte';
else:
	$last_page='Last Page';
	$next_page='Next Page';
endif;
if ($lower==1 ):
  	$p_antes='<font class="body_text" ><font color="#999999">'.$last_page.'</font></font>';
endif;
if ($lower<>1):
  	$lower_a=$lower-15;
  	if ($lower_a<1):
		$lower_a=1;
	endif;
	$upper_a=$upper-15;
	if ($upper_a<1):
		$upper_a=$upper-$upper_a;
	endif;
	if ($upper_a==1 && $lower_a==1):
		$upper_a=15;
	endif;
  	$p_antes='<font class="body_text"><a href="'.$link.'&lower='.$lower_a.'&upper='.$upper_a.'"><font color="#000000">'.$last_page.'</font></a></font>';
endif;
if ($upper==$total ):
	$p_depois='<font class="body_text" ><font color="#999999">'.$next_page.'</font></font>';
endif;
if ($upper<>$total):
	$lower_d=$lower+15;
	$upper_d=$upper+15;
	if ($upper_d>$total):
		$upper_d=$total;
	endif;
	$p_depois='<font class="body_text"><a href="'.$link.'&lower='.$lower_d.'&upper='.$upper_d.'"><font color="#000000">'.$next_page.'</font></a></font>';
endif;
echo '<div align="right">'.$p_antes.'<font class="body_text" color="#000000"> | </font>'.$p_depois.'</div>';
};

?>
