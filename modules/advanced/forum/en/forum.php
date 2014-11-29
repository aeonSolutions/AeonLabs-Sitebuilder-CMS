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
include($local.'../../kernel/staticvars.php');
$browse_id=return_id('directory_browsing.php');
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
	  <TD vAlign=top bgColor=#e3e3e3 align="center">
		<table border="0" cellspacing="3" cellpadding="0">
		  <tr>
			<td align="center" height="60" width="468">
				<script type="text/javascript"><!--
google_ad_client = "pub-2512865384610525";
google_alternate_color = "FFFFCC";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel ="5375060185";
google_color_border = "FFFF66";
google_color_bg = "FFFFFF";
google_color_link = "0000FF";
google_color_text = "000000";
google_color_url = "008000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></td>
		  </tr>
		</table>
	    <table width="90%" border="0" align="center" cellpadding="2" cellspacing="1" style="background-color: #FFFFFF; border: 2px #006699 solid; ">
          <tr>
            <td colspan="2" class="Header_text_1" height="25" nowrap="nowrap" align="center">&nbsp;Forum&nbsp;</td>
            <td width="100%" class="Header_text_1" nowrap="nowrap" align="center">&nbsp;Topics&nbsp;</td>
            <td width="100%" class="Header_text_1" nowrap="nowrap" align="center">&nbsp;Posts&nbsp;</td>
            <td class="Header_text_1" nowrap="nowrap" align="center">&nbsp;Last Post&nbsp;</td>
          </tr>
          <?php
		  $forum_cats=$db->getquery("select cod_cat, titulo from forum_cats where active='s'");
		  if ($forum_cats[0][0]<>''):
			$color='#C4D7FF';
			  for($i=0; $i<count($forum_cats);$i++):
				?>
          <tr bgcolor="#9999FF">
            <td height="28" colspan="5" align="left" class="header_text_2"><?=$forum_cats[$i][1];?></td>
          </tr>
          <?php
				$forums=$db->getquery("select cod_forum, nome, descricao, num_posts from forum_forum where active='s' and cod_cat='".$forum_cats[$i][0]."'");
				if ($forums[0][0]<>''):
					for($j=0;$j<count($forums);$j++):
						if ($color<>'#C4D7FF'):
							$color='#C4D7FF';				
						else:
							$color='#DFCAFF';
						endif;
						$topics=$db->getquery("select cod_topic,data,cod_user from forum_topic where cod_forum='".$forums[$j][0]."' and reply_to='0'");
						if ($topics[0][0]<>''):
							$num_topics=count($topics);
							$posts=$db->getquery("select cod_topic,data,cod_user from forum_topic where cod_forum='".$forums[$j][0]."' and reply_to!='0'");
							if ($posts[0][0]<>''):
								$num_posts=count($posts);
							else:
								$num_posts='0';
							endif;
							$last_post=$db->getquery("select cod_topic,data,cod_user,reply_to from forum_topic where cod_forum='".$forums[$j][0]."' order by data ASC");
							$user_name=$db->getquery("select nick from users where cod_user='".$last_post[0][2]."'");
								$post_link=session($staticvars,'index.php?id='.$task.'&topic='.$last_post[0][0]);
							$user_name='<a href="'.$post_link.'"><img src="'.$staticvars['site_path'].'/modules/forum/images/last_post.gif" border="0"/></a><br>
							<a href="view profile">'.$user_name[0][0].'</a>';
							$put_date=date ('d M Y',strtotime($last_post[0][1]));
						else:
							$num_topics='- -';
							$num_posts='- -';
							$user_name='- -';
							$put_date='- -';
						endif;
					  ?>
          <tr>
            <td align="center" valign="middle" height="50" bgcolor="<?=$color;?>"><img src="<?=$staticvars['site_path'];?>/modules/forum/images/forum.gif" width="31" height="30"/></td>
            <td class="row1" width="100%" height="50" bgcolor="<?=$color;?>" align="left"><a href="<?=session($staticvars,'index.php?id='.$task.'&view='.$forums[$j][0]);?>" class="header_text_2">
              <?=$forums[$j][1];?>
              </a><br>
              <span class="body_text">
              <?=$forums[$j][2];?>
              <br>
            </span></td>
            <td height="50" align="center" valign="middle" bgcolor="<?=$color;?>"><span class="body_text">
              <?=$num_topics;?>
            </span></td>
            <td align="center" valign="middle" height="50" bgcolor="<?=$color;?>"><span class="body_text">
              <?=$num_posts;?>
            </span></td>
            <td align="center" valign="middle" height="50" nowrap="nowrap" class="body_text" bgcolor="<?=$color;?>"><?=$user_name;?>
                <br>
                <?=$put_date;?>            </td>
          </tr>
          <?php
					endfor;
				else:
				  	echo 'No forums';
				endif;
			endfor;
		  else:
		  	echo 'No categories';
		endif;
		  ?>
        </table></TD>
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