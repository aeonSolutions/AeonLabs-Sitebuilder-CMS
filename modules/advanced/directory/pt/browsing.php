<?php
/*
File revision date: 3-Set-2006
*/
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
$browse_id=return_id('directory_browsing.php');
$search_id=return_id('directory_search.php');
$_SESSION['directory']=session($staticvars,'index.php?id='.$task.'&cod='.@$_GET['cod']);
if (isset($_POST['busca']) ):
	$search_query=$_POST['busca'];
elseif (isset($_GET['spider']) ):
	$search_query=$_GET['spider'];
else:
	$search_query='';
endif;
include($staticvars['local_root'].'modules/directory/system/dir_functions.php');
?>
<!DOCTYPE HTML var "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD><TITLE></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<STYLE>
LI {
	FONT-SIZE: 12px;
	MARGIN-BOTTOM: 2px;
}
.u1 {
	COLOR: #008000;
}
UL.ovr {
	PADDING-RIGHT: 0px;
	PADDING-LEFT: 0px;
	PADDING-BOTTOM: 2px;
	MARGIN: 0px 0px 0px 16px;
	PADDING-TOP: 3px;
}
UL.ovr LI {
	FONT-WEIGHT: normal;
	FONT-SIZE: 100%;
	MARGIN: 6px 0px 0px;
}

h1 {
	margin: 0px;
	font: 100% arial;
	font-size:80%;
}

.normal_text {
	margin: 0px;
	font: 100% arial;
	font-size:70%;
}

.dir_list {
	BORDER-RIGHT: #656565 0px solid;
	PADDING-RIGHT: 3px;
	BORDER-TOP: #656565 1px solid;
	PADDING-LEFT: 3px;
	BACKGROUND: #ccf;
	PADDING-BOTTOM: 6px;
	MARGIN: 0px 7px;
	BORDER-LEFT: #656565 0px solid;
	PADDING-TOP: 6px;
	BORDER-BOTTOM: #656565 1px solid;
	TEXT-ALIGN: left;
}
.searchbt {
	BORDER-RIGHT: #2e8908 1px solid;
	BORDER-TOP: #2e8908 1px solid;
	FONT-SIZE: 10px; BACKGROUND: #fff;
	MARGIN: 7px 1px 5px;
	VERTICAL-ALIGN: middle;
	BORDER-LEFT: #2e8908 1px solid;
	BORDER-BOTTOM: #2e8908 1px solid;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
}
.form_submit{
	border-style : solid;
	border-top-width : 1px;
	border-right-width : 1px;
	border-bottom-width : 1px;
	border-left-width : 1px;		
	color : #FFFFFF;
	background: #2c4563;	
   font-size : 10px;
   font-weight : bolder;
	font: normal normal Verdana, Arial, Helvetica, sans-serif;
}

</STYLE>
<BODY>
<CENTER>
<table cellSpacing="0" cellPadding=2 width="98%" border="0">
	<tr>
		<td width="1%"><A href="<?=session($staticvars,'index.php');?>"><IMG height=43 src="modules/directory/images/logo.gif" width=275 border="0" alt="Sair do directório"></A></td>
		<td>
	      <table cellSpacing="0" cellPadding="0" width="100%" border="0">
			<tr>
       		  <td vAlign=bottom align=right>&nbsp;</td>
			  <td width="90" align=right vAlign=bottom noWrap><font class="normal_text"><A  class=drk href="<?=session($staticvars,'index.php?id='.$browse_id);?>"></A></font></td>
			  <td width="70" align=right vAlign=bottom noWrap><font class="normal_text"><A  class=drk href="<?=session($staticvars,'index.php');?>">Voltar</A></font></td>
			</tr>
		</table>
      <HR noShade SIZE=1>
      </td>
	</tr>
</table>
<CENTER>
<BR>
<table cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
	  <td height=30 class="dir_list" colspan="6" noWrap>
	  <?php
	  if ($search_query==''):
	   		directory_listing($staticvars,'');
	  else:
	  ?>
	  <div align="right"><h1><strong>Resultados da pesquisa:</strong>&nbsp;<em><?=$search_query;?></em><h1></div>
	  <?php
	  endif;
	  ?></td>
	  </tr>
	<tr bgColor="#eeeeee">
		<FORM  method="POST" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
		<td noWrap width=69 height=30><B>Pesquisar</B>&nbsp;</td>
		<td><INPUT class="searchbt" type="text" name="busca" size="80" value="<?=$search_query;?>" ></td>
		<td width="217"><INPUT type=submit class="searchbt" value="pesquisar" style="width:130px;" name="submit_busca"></td>
		<td width="5"></FORM><td width="7"></td>
		<td noWrap align=right width=235>&nbsp;</td>
	</tr>
	<tr bgColor=#636363>
    	<td colSpan=6 height=1><SPACER height="1" width="1" type="block"></td>
	</tr>
</table>
<table cellSpacing="0" cellPadding="0" width="98%" border="0">
	<tr>
		<td align=right width="100%" height=25>
		<IMG height=16 alt="Email to a Friend" src="modules/directory/images/email.gif" width=16 border="0">
		</td>
		<td vAlign=top noWrap>&nbsp;
		</td>
	</tr>
</table>
<table cellSpacing="0" cellPadding="0" width="100%" border="0">
	<tr>
		<td valign="top" align="left">
		<?
		if ($search_query==''):
	 		load_subcategories($staticvars,'');
		   load_site_listings($staticvars,'');
		else:
		   load_search_listings($staticvars,'');
		endif;?>		
		</td>
		<td width="200"><? load_sponsors($staticvars);?></td>
	</tr>
</table>
<P><BR></P>
<table cellSpacing="0" cellPadding="0" width="100%" border="0">
  
  <tr bgColor=#656565>
    <td colSpan=6 height=1><SPACER height="1" width="1" type="block"></td></tr>
  <tr bgColor=#eeeeee>
      <FORM  method="POST" action="x<?=session($staticvars,'index.php?id='.$search_id);?>" enctype="multipart/form-data">
    <td width=69 height=15 noWrap><B>Pesquisar</B>&nbsp;</td>
    <td><INPUT name="busca" type="text" class="searchbt" size="80"></td>
    <td width="429"><INPUT name="submit_busca" type=submit class="searchbt" style="width:130px;" value="pesquisar"></td>
    <td width="8"></FORM><td width="9"></td></tr>
  <tr align="center">
    <td height=15 colspan="5" noWrap class="dir_list"><? directory_listing($staticvars,''); ?></td>
    </tr>
</table>
<table cellSpacing="0" cellPadding="0" width="100%" border="0">
   <tr>
    <td align=middle>
	<font class="normal_text">
      <HR noShade SIZE=1>
      Copyright © 2006 Todos os direitos reservados.
	</font>
	</td>
  </tr>
</table>
</CENTER>
</CENTER>
</BODY>
</HTML>

<?php


function load_sponsors($staticvars){
		//include($staticvars['local_root'].'modules/varity/adsense_sky_scraper.php');
};


?>