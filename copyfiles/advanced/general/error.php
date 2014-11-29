<?php 
/*
File revision date: 9-Apr-2007
*/
function load_unauthorized_acess($message){
$local_root = __FILE__ ;
$local_root = ''.substr( $local_root, 0, strpos( $local_root, "general" ) ) ;

include($local_root.'kernel/functions.php'); 
include($local_root.'general/staticvars.php');
$where=explode("/", $_SERVER['REQUEST_URI']);
$where=explode(".",$where[count($where)-1]);

?>
<!DOCTYPE HTML var "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Erro</title>
<style>
BODY {
	MARGIN-TOP: 0px; BACKGROUND: #dddddd repeat-x; MARGIN-LEFT: 0px; MARGIN-RIGHT: 0px
}
.item-title {
	FONT-WEIGHT: bold; FONT-SIZE: 20px; FONT-FAMILY: Arial Narrow, Arial, Helvetica, sans-serif; text-shadow: #666666 0px 2px 4px
}
.author-name {
	FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #717171; FONT-FAMILY: Arial, Helvetica, sans-serif; text-shadow: #999999 0px 2px 4px
}
.item-text {
	FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.td_large {
	FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
.extra-info {
	FONT-SIZE: 10px; COLOR: #717171; FONT-FAMILY: Verdana, Geneva, Arial, Helvetica, sans-serif
}
TD.box-left {
	BACKGROUND-IMAGE: url(<?=$site_path;?>/general/images/Box_Left.gif); BACKGROUND-REPEAT: repeat-y; BACKGROUND-COLOR: #e3e3e3
}
</style>
</head>
<body>
<br>
<br>
<br>
<br>
<TABLE width=530 border=0 align="center" cellPadding=0 cellSpacing=0>
        <TBODY>
        <TR height=31>
          <TD width=150 rowSpan=2 align="left" vAlign=top background="<?=$site_path;?>/general/images/Boxw_Top_Left.gif"><img src="<?=$site_path;?>/general/images/error.gif" border="0" ></TD>
          <TD vAlign=top align=right background="<?=$site_path;?>/general/images/Box_Top.gif" colSpan=2 
          height=31><IMG height=34 alt="" src="<?=$site_path;?>/general/images/fade_strip.gif" width=205 border=0><IMG height=34
		   alt="" src="<?=$site_path;?>/general/images/fade_strip1.gif" width=32 border=0><IMG height=34 alt=""
		    src="<?=$site_path;?>/general/images/fade_strip2.gif" width=34 border=0><IMG height=34 alt="" src="<?=$site_path;?>/general/images/new_top_right.gif" width=17 border=0></TD>
        </TR>
        <TR>
          <TD vAlign=top width=351 bgColor=#e3e3e3>
            <TABLE cellSpacing=3 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD width="100%" colSpan=2>
                  <TABLE height="100%" cellSpacing=0 cellPadding=2 
                    width="100%"><TBODY>
                    <TR>
                      <TD bgColor=#e3e3e3 colSpan=2><SPAN 
                        class=item-title>Opps!</SPAN></TD>
                    </TR>
                    <TR>
                      <TD width=6 bgColor=#e3e3e3><IMG height=1 src="<?=$site_path;?>/general/images/empty.gif" width=6></TD>
                      <TD vAlign=top bgColor=#e3e3e3 height="100%"><SPAN 
                        class=author-name></SPAN></TD></TR>
                    <TR>
                      <TD width=6 bgColor=#e3e3e3><IMG height=1 src="<?=$site_path;?>/general/images/empty.gif" width=6></TD>
                      <TD vAlign=top bgColor=#e3e3e3 height="100%"><div align="left"><SPAN 
                        class=td_large>
					      <?php
						echo $message;
						?></SPAN></div><div align="right">
					      <BR><br><a href="<?=session($staticvars,$where[0].'.php');?>" class="extra-info">Voltar &aacute; p&aacute;gina inicial</a></div></TD>
                    </TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
          <TD background="<?=$site_path;?>/general/images/Box_Right.gif"><IMG height=100 alt="" src="<?=$site_path;?>/general/images/empty.gif" width=10 border=0></TD></TR>
        <TR>
          <TD width=150 
            background="<?=$site_path;?>/general/images/Box_Bottom.gif"><IMG height=14 alt="" src="<?=$site_path;?>/general/images/Box_Bottom_Left.gif" width=23 border=0></TD>
          <TD width=351 
            background="<?=$site_path;?>/general/images/Box_Bottom.gif"><IMG height=10 alt="" src="<?=$site_path;?>/general/images/empty.gif" width=10 border=0></TD>
<TD><IMG height=14 alt="" src="<?=$site_path;?>/general/images/Box_Bottom_Right.gif" width=29 border=0></TD>
	</TR>
	</TBODY>
</TABLE>
<br>
<br>
<br>
</body>
</html>
<?php
};
?>