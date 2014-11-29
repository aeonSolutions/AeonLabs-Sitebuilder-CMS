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
if (isset($_GET['view'])):
	$view=$_GET['view']; 
elseif (isset($_POST['jump_to'])):
	$view=$_POST['jump_to'];
endif;
include($local.'../../kernel/staticvars.php');
$query=$db->getquery("select cod_forum from forum_forum where cod_forum='".mysql_escape_string($view)."'");
if ($query[0][0]==''):
	?>
	<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td align="center">
		<font class="body_text">N&atilde;o existe o forum.</font>
		</td>
	  </tr>
	</table>
	<?php
	exit;
endif;
$forum_name=$db->getquery("select nome from forum_forum where cod_forum='".$view."'");
$forum_topics=$db->getquery("select cod_topic,cod_user, assunto,data,num_views,locked from forum_topic where cod_forum='".$view."' and reply_to='0'");
$total=count($forum_topics)-1;
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

$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
if ($admin_code[0][0]<>''):
	$admin_code=$admin_code[0][0];
else:
	$admin_code=-1;
endif;
if (isset($_SESSION['user'])):
	$auth_user=$db->getquery("select cod_user_type from users where nick='".mysql_escape_string($_SESSION['user'])."'");
	if ($auth_user[0][0]<>''):
		$auth_user=$auth_user[0][0];
	else:
		$auth_user=-2;
	endif;
else:
	$auth_user=-2;
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
</style>
<body>
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
			<td width="82"><a href="<?=session($staticvars,'index.php?id='.return_id('new_topic.php').'&forum='.$view);?>"><img src="<?=$staticvars['site_path'].'/modules/forum/images/buttons/'.$lang.'/new_topic.gif';?>" border="0"></a></td>
			<td class="header_text_2" valign="middle"> <a href="<?=session($staticvars,'index.php?id='.$task);?>">Forum</a> &gt;
              <?=$forum_name[0][0];?></td>
			<td class="header_text_1"><?=put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?id='.$task.'&lower='.$lower.'&upper='.$upper.'&view='.$view));?></td>
		  </tr>
		</table>
	    <table width="100%" cellpadding="2" cellspacing="1" border="0" style="background-color: #FFFFFF; border: 2px #006699 solid; ">
        <tr>
          <td colspan="2" class="Header_text_1" height="25" nowrap="nowrap" align="center">&nbsp;T&oacute;picos&nbsp;</td>
          <td width="100%" class="Header_text_1" nowrap="nowrap" align="center">&nbsp;Respostas&nbsp;</td>
          <td width="100%" class="Header_text_1" nowrap="nowrap" align="center">Autor</td>
          <td width="100%" class="Header_text_1" nowrap="nowrap" align="center">&nbsp;Visualiza&ccedil;&otilde;es&nbsp;</td>
          <td class="Header_text_1" nowrap="nowrap" align="center">&nbsp;&Uacute;ltima resposta &nbsp;</td>
        </tr>
        <?php
		  if ($forum_topics[0][0]<>''):
			  for($i=0; $i<count($forum_topics);$i++):
						$num_replies=$db->getquery("select cod_topic from forum_topic where reply_to='".$forum_topics[$i][0]."'");
						if ($num_replies<>''):
							$num_replies=count($num_replies);
						else:
							$num_replies=0;
						endif;
						$user_name=$db->getquery("select nick from users where cod_user='".$forum_topics[$i][1]."'");
						$user_name='<a href="view profile">'.$user_name[0][0].'
						</a><a href="display last post"><img src="'.$staticvars['site_path'].'/modules/forum/images/last_post.gif" border="0"/></a>';
						$put_date=date ('d M Y',strtotime($forum_topics[0][3]));
						$num_views=$forum_topics[$i][4];
						if($forum_topics[$i][5]=='n'):
							$forum_img='forum.gif';
						else:
							$forum_img='forum_locked.gif';
						endif;
					  ?>
					<tr>
					  <td height="50" align="center" valign="middle" bgcolor="#EFEFEF"> <img src="<?=$staticvars['site_path'].'/modules/forum/images/'.$forum_img;?>" width="31" height="30"/></td>
					  <td width="100%" height="50" align="left" bgcolor="#EFEFEF" class="row1">
						<?php
						if ($admin_logged==true):
							if($forum_topics[$i][5]=='n'):
								$button_txt='Bloquear tópico';
								$button_name='lock';
							else:
								$button_txt='Desbloquear tópico';
								$button_name='unlock';
							endif;
							?>
							<form action="<?=session($staticvars,'modules/forum/update_db/manage_forum.php?id='.$task.'&view='.$view);?>" enctype="multipart/form-data" method="post">
							  <a href="<?=session($staticvars,'index.php?id='.$task.'&topic='.$forum_topics[$i][0]);?>" class="header_text_2">
								<?=$forum_topics[$i][2];?></a>&nbsp;
								<input type="hidden" name="cod_topic" value="<?=$forum_topics[$i][0];?>">
								<input class="body_text" type="submit" value="<?=$button_txt;?>" name="<?=$button_name;?>">
							</form>
							<?php
						else:
						?>
					  <a href="<?=session($staticvars,'index.php?id='.$task.'&topic='.$forum_topics[$i][0]);?>" class="header_text_2">
						<?=$forum_topics[$i][2];?></a>
					  <?php
						endif;
						?></td>
					  <td height="50" align="center" valign="middle" bgcolor="#DEE3E7"><span class="body_text">
						<?=$num_replies;?>
					  </span></td>
					  <td align="center" valign="middle" bgcolor="#D1D7DC"><span class="body_text">
					    <?=$user_name;?>
					  </span></td>
					  <td height="50" align="center" valign="middle" bgcolor="#DEE3E7"><span class="body_text">
						<?=$num_views;?>
					  </span></td>
					  <td height="50" align="center" valign="middle" nowrap="nowrap" bgcolor="#D1D7DC"> <span class="body_text">
						<?=$put_date;?>
					  </span></td>
					</tr>
					<?php
			endfor;
		  else:
		  	echo '<tr><td colspan="6" class="body_text">N&atilde;o existem tópicos colocados neste forum. Para adicionar clique no bot&atilde;o novo tópico</td></tr>';
		endif;
		  ?>
      </table>
		<table width="100%"  border="0" cellspacing="3" cellpadding="0">
		  <tr>
			<td width="82"><a href="<?=session($staticvars,'index.php?id='.return_id('new_topic.php').'&forum='.$view);?>"><img src="<?=$staticvars['site_path'].'/modules/forum/images/buttons/'.$lang.'/new_topic.gif';?>" border="0"></a></td>
			<td class="header_text_2" valign="middle"> <a href="<?=session($staticvars,'index.php?id='.$task);?>">Forum</a> &gt;
              <?=$forum_name[0][0];?></td>
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
		</table>
	  </TD>
	  <TD width="28" background="<?=$staticvars['site_path'].'/modules/forum';?>/images/gray_line_border/Box_Right.gif" bgColor=#e3e3e3><IMG 
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
function display_date(){
};

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
