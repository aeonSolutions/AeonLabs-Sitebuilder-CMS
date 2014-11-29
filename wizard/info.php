<?php
include_once($globvars['local_root'].'setup/core/functions.php');
include_once($globvars['local_root'].'kernel/functions.php');
if ($_SERVER['REQUEST_URI']==''):
	$site_path=substr( $_SERVER['HTTP_REFERER'], 0, strpos( $_SERVER['HTTP_REFERER'], "/setup" ) ) ;
else:
	$site_path=substr( $_SERVER['REQUEST_URI'], 0, strpos( $_SERVER['REQUEST_URI'], "setup" ) ) ;
endif;
if ($site_path[0]=='/'):
	$site_path=substr( $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 0, strpos( $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], "setup" )-1 ) ;
	$site_path='http://'.$site_path;
endif;
//if ($_SERVER['HTTP_HOST']=='localhost'):
//	$site_path=substr('http://localhost'.$site_path,0,strlen('http://localhost'.$site_path)-1);
//endif;
?>
<html>
<head>
<META NAME="description" CONTENT="">
<META NAME="keywords" CONTENT="">
<META NAME="author" CONTENT="">
<META NAME="robots" CONTENT="">
<link href="<?=$site_path;?>/setup/core/layout/default.css" rel="stylesheet" type="text/css">
</head>
<body>
<style type="text/css">
.body_text{
		color: #000000;
		font-size : 11px;
		font-weight:normal;
		font:Arial, Helvetica, sans-serif;
		TEXT-DECORATION: none;
}
.header_text_1{
		color: #000000;
		font-size : 14px;
		font-weight : bolder;
		font:Arial, Helvetica, sans-serif;
		TEXT-DECORATION: none;
}
.hash {
	BACKGROUND-POSITION: left top; BACKGROUND-IMAGE: url(<?=$site_path;?>/setup/core/layout/hash.jpg); BACKGROUND-REPEAT: repeat-x
}

.copyright {
	MARGIN-TOP: 0px; FONT-SIZE: 8pt; COLOR: gray; FONT-FAMILY: Arial; TEXT-ALIGN: center
}
</style>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
          <TR>
            <TD vAlign=top align="left" class="hash"><IMG height=50 src="<?=$site_path;?>/setup/core/layout/top-logo.jpg" border=0></td>
          </TR>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
          <TR>
            <TD style="BACKGROUND-COLOR: #434E59" align=right>&nbsp;</TD>
          </TR>
        </TBODY>
      </TABLE>
	  
	</td>
  </tr>
  <tr>
    <td >
      <table width="100%" border="0" cellpadding="5" cellspacing="0" >
	    <tr>
          <td valign="top">
			<DIV class="main-box">
			  <DIV class="main-box-title">WebSite Wizard</DIV>
			  <DIV class="main-box-data">
				<TABLE height="430" cellSpacing=0 cellPadding=10 width="1024" border=0 background="core/wizard/images/keyboard.gif" align="center">
				  <TBODY>
					
					<TR>
					  <TD valign="top">
					  <?php
					  if(is_wizard($local_root)>=0):
						include($local_root.'setup/core/install_wiz.php');
					  else:
					  ?>
						  <p align="justify"><font style="font:Georgia, 'Times New Roman', Times, serif; font-size:16px; font-weight:bold">Welcome to  SiteBuilder's Website Wizard!</font><br /><br />
						  <font style="font:Georgia, 'Times New Roman', Times, serif; font-size:12px; font-weight:bold">Click  <a href="<?=$site_path.'/setup/index.php?goto=wiz&wizard=1';?>">here</a> to start building your site.<br /></font></p>
					  <?php
					  endif;
					  ?>					  </TD>
					</TR>
				  </TBODY>
				</TABLE>
			  </DIV>
			</DIV>		  
		</td>
        </tr>
      </table>	
	</td>
  </tr>
  <tr valign="bottom">
    <td width="100%" height="5" align="center">
		<DIV class="copyright">Copyright © 2007 SiteBuilder &nbsp;All Rights Reserved.</DIV>
	</td>
  </tr>
</table>
</body>
</html>
