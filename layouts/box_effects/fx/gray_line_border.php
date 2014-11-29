<TABLE width=530 border=0 align="center" cellPadding=0 cellSpacing=0>
	<TBODY>
	<TR height=31>
	  <TD vAlign=top width=23 background="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Boxw_Top_Left.gif">&nbsp;</TD>
	  <TD vAlign=top align=right background="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Box_Top.gif" colSpan=2 
	  height=31><IMG height=34 alt="" src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/fade_strip.gif" width=205 border=0><IMG height=34
	   alt="" src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/fade_strip1.gif" width=32 border=0><IMG height=34 alt=""
		src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/fade_strip2.gif" width=34 border=0><IMG height=34 alt="" src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/new_top_right.gif" width=17 border=0></TD>
	</TR>
	<TR>
	  <TD vAlign=top width=23 background="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Boxw_Left.gif">&nbsp;</TD>
	  <TD vAlign=top bgColor=#e3e3e3>
		<?php 
		if (!isset($box_setup)):
			include($be_link_module);
		else:
			include($local_root.'layout/box_effects/empty.php');
			unset($box_setup);
		endif;
		 ?>
	  </TD>
	  <TD width="29" background="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Box_Right.gif"><IMG 
		height=100 alt="" src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/empty.gif" 
		width=10 border=0></TD></TR>
	<TR>
	  <TD width=23 
		background="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Box_Bottom.gif"><IMG 
		height=14 alt="" 
		src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Box_Bottom_Left.gif" width=23 
		border=0></TD>
	  <TD width=478 
		background="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Box_Bottom.gif"><IMG 
		height=10 alt="" src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/empty.gif" 
		width=10 border=0></TD>
<TD><IMG height=14 alt="" 
		src="<?=$site_path;?>/layout/box_effects/fx/gray_line_border/Box_Bottom_Right.gif" width=29 
		border=0></TD>
</TR>
</TBODY>
</TABLE>