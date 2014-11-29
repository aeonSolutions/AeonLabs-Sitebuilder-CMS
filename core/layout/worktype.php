<?php
if (isset($_POST['edit'])):
	$tmp=$_POST['website'];
	$name=str_replace("[simple]","",str_replace("[advanced]","",$tmp));
	$ndir=substr( $globvars['local_root'], 0, strpos( $globvars['local_root'], "sitebuilder" ) ).$name."/";
	//code only for webhosting
	if($name=='Boxvenue.net'):
		$ndir='/home/boxvenue/public_html/';
	endif;
	$file_content="<?PHP
	// New site status file
	"."$"."globvars['site']['sid']='".$_GET['SID']."';
	"."$"."globvars['site']['mode']='".str_replace("]","",str_replace("[","",str_replace($name,"",$tmp)))."';
	"."$"."globvars['site']['name']='".$name."';
	"."$"."globvars['site']['directory']='".$ndir."';
	?>";
	$filename=$globvars['local_root'].'core/editsite.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);

	header("Location: ".$_SERVER['REQUEST_URI']);
elseif (isset($_POST['new'])):
	$file_content="<?PHP
	// New site status file
	"."$"."globvars['site']['sid']='".$_GET['SID']."';
	"."$"."globvars['site']['mode']='wizard';
	"."$"."globvars['site']['type']='advanced';
		"."$"."globvars['site']['directory']='".$globvars['site']['directory']."';
	?>";
	$filename=$globvars['local_root'].'core/status.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
	header("Location: ".$_SERVER['REQUEST_URI']);
elseif(isset($_GET['server'])):
	$file_content="<?PHP
	// New site status file
	"."$"."globvars['site']['sid']='".$_GET['SID']."';
	"."$"."globvars['site']['mode']='server';
	?>";
	$filename=$globvars['local_root'].'core/server.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);

	header("Location: ".$_SERVER['REQUEST_URI']);
endif;



$dir=glob($globvars['local_root'].'/../*',GLOB_ONLYDIR);
if ($dir[0]<>''):
	$options='';
	for($i=0;$i<count($dir);$i++):
		$dirX=explode("/",$dir[$i]);
		$install=true;
		if (file_exists($globvars['local_root'].'../'.$dirX[count($dirX)-1].'/kernel/staticvars.php') and $dirX[count($dirX)-1]<>'sitebuilder'):
			unset($staticvars);
			include($globvars['local_root'].'../'.$dirX[count($dirX)-1].'/kernel/staticvars.php');
			if (isset($staticvars['smtp']['enable'])):
				$options.="<option value='".$dirX[count($dirX)-1]."[advanced]'>".$dirX[count($dirX)-1]." [advanced]</option>";
			elseif(isset($staticvars['layout']['file'])):
				$options.="<option value='".$dirX[count($dirX)-1]."[simple]'>".$dirX[count($dirX)-1]." [simple]</option>";
			endif;
		endif;
	endfor;
	// available on webhosting only!
	$options.="<option value='Boxvenue.net[advanced]'>Boxvenue.net[advanced]</option>";
else:
	$options="<option value='disabled' disabled='disabled'>Not Found</option>";
endif;

?>

<script language="JavaScript" type="text/javascript"> 

function pausecomp(millis) 
{
var date = new Date();
var curDate = null;

do { curDate = new Date(); } 
while(curDate-date < millis);
} 




function display_simple() {

document.getElementById('adv_content').innerHTML ="<table width='90%' id='tbl_dynsite' onClick='javascript:display_adv();' onmouseover='try{this.style.borderColor = \"#909090\"; document.getElementById(\"dynsite_disabcheck\").src=\"<?=$globvars['site_path'];?>/wizard/images/check_notactive.gif\";}catch(e){}'"
+"style='BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff' "
+"onmouseout='try{this.style.borderColor = \"#E3E3E3\"; document.getElementById(\"dynsite_disabcheck\").src=\"<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif\";}catch(e){}' "
+"cellspacing='5' cellpadding='0' align='center' border='0'>"
+"<tr>"
+"  <td><img id='dynsite_imgfam' src='<?=$globvars['site_path'];?>/wizard/images/db_site.gif' /></td>"
+"  <td style='PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px' align='left' width='100%'>"
+"		  <h2>Edit an existing  WebSite</h2>"
+"		  <h4>Tune up an already setup website. Enter advanced mode to install new modules or change layout profiles.</h4>"
+"  </td>"
+"	<td style='PADDING-RIGHT: 10px'><img id='dynsite_disabcheck' style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif' align='absmiddle' /></td>"
+"</tr>"
+"</table>";

document.getElementById('simple_content').innerHTML ="<table id='tbl_dynsite' align='center' width='90%' style='BORDER-RIGHT: #fe4518 2px solid; BORDER-TOP: #fe4518 2px solid; BORDER-LEFT: #fe4518 2px solid; BORDER-BOTTOM: #fe4518 2px solid; BACKGROUND-COLOR: #ffffff' cellspacing=5 cellpadding=0 border=0>"
+"    <tr>"
+"      <td><img src='<?=$globvars['site_path'];?>/wizard/images/simple_site.gif' /></td>"
+"      <td style='PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px' align=left width='100%'>"
+"	  <h2>Build a new webSite</h2>"
+"	  <h4>Create a new website. With this option you can build a basic html site with PHP suppot or an advanced website featuring Database support.</h4>"
+"      </td>"
+"      <td style='PADDING-RIGHT: 10px'><img src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif' align=absMiddle /> </td>"
+"    </tr>"
+"</table>"
+"<br>"
+"<table width='90%' border='0' align='center' cellspacing='20' style='BORDER-RIGHT: #fe4518 2px solid; BORDER-TOP: #fe4518 2px solid; BORDER-LEFT: #fe4518 2px solid; BORDER-BOTTOM: #fe4518 2px solid; BACKGROUND-COLOR: #ffffff'>"
+"  <tr>"
+"    <td>"
+"      <form id='web_form' name='web_form' method='post' action=''>"
+"         <h3>Are you sure? <input align='absmiddle' type='image' src='<?=$globvars['site_path'];?>/core/layout/worktype/go.gif' />"
+"</h3><h4>You are about to start building a new website</h4>"
+"         <input type='hidden' name='new' value='news' />"
+"         </form>"
+"    </td>"
+"  </tr>"
+"</table>";

}


function display_adv(){
document.getElementById('adv_content').innerHTML ="<table id='tbl_dynsite' align='center' width='90%' style='BORDER-RIGHT: #fe4518 2px solid; BORDER-TOP: #fe4518 2px solid; BORDER-LEFT: #fe4518 2px solid; BORDER-BOTTOM: #fe4518 2px solid; BACKGROUND-COLOR: #ffffff' cellspacing=5 cellpadding=0 border=0>"
+"    <tr>"
+"      <td><img src='<?=$globvars['site_path'];?>/wizard/images/db_site.gif' /></td>"
+"      <td style='PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px' align=left width='100%'>"
+"              <h2>Advanced WebSite</h2>"
+"              <h4>Create an advanced website with MySQL or MsSQL database suport. A number of features are included and configurable on the mode: from managing Emails, UserGroups and a number o modules custum made suitable for your needs.</h4>"
+"      </td>"
+"      <td style='PADDING-RIGHT: 10px'><img src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif' align=absMiddle /> </td>"
+"    </tr>"
+"</table>"
+"<br>"
+"<table width='90%' border='0' align='center' cellspacing='20' style='BORDER-RIGHT: #fe4518 2px solid; BORDER-TOP: #fe4518 2px solid; BORDER-LEFT: #fe4518 2px solid; BORDER-BOTTOM: #fe4518 2px solid; BACKGROUND-COLOR: #ffffff'>"
+"  <tr>"
+"    <td>"
+"      <form id='web_form' name='web_form' method='post' action=''>"
+"         <h3>Choose a website "
+"           <select name='website' id='website' accesskey='w' tabindex='1'>"
+"			<?=$options;?>"
+"         </select>"
+"         <input align='absmiddle' type='image' src='<?=$globvars['site_path'];?>/core/layout/worktype/go.gif' /></h3>"
+"         <input type='hidden' name='edit' value='edit' />"
+"         </form>"
+"    </td>"
+"  </tr>"
+"</table>";

document.getElementById('simple_content').innerHTML ="<table width='90%' id='tbl_site' onClick='display_simple();' onmouseover='try{this.style.borderColor = \"#909090\"; document.getElementById(\"site_disabcheck\").src=\"<?=$site_path;?>/wizard/images/check_notactive.gif\";}catch(e){}'"
+"    style='BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff' "
+"    onmouseout='try{this.style.borderColor = \"#E3E3E3\"; document.getElementById(\"site_disabcheck\").src=\"<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif\";}catch(e){}' "
+"    cellspacing='5' cellpadding='0' align='center' border='0'>"
+"    <tr>"
+"      <td><img id='site_imgfam' src='<?=$globvars['site_path'];?>/wizard/images/simple_site.gif' /></td>"
+"      <td style='PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px' align='left' width='100%'>"
+"	  <h2>Build a new webSite</h2>"
+"	  <h4>Create a new website. With this option you can build a basic html site with PHP suppot or an advanced website featuring Database support.</h4>"
+"        </td>"
+"        <td style='PADDING-RIGHT: 10px'><img id='site_disabcheck' style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' src='<?=$site_path;?>/wizard/images/check_disabled.gif' align='absmiddle' /></td>"
+"    </tr>"
+"    </table>";


}
</script> 
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="simple_content">
    <table width="90%" id="tbl_site" onClick="javascript:display_simple();" onmouseover="try{this.style.borderColor = '#909090'; document.getElementById('site_disabcheck').src='<?=$site_path;?>/wizard/images/check_notactive.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="site_imgfam" src="<?=$site_path;?>/wizard/images/simple_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
      <h2>Build a new webSite</h2>
      <h4>Create a new website. With this option you can build a basic html site with PHP suppot or an advanced website featuring Database support.</h4>
      </td>
        <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$site_path;?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
    </tr>
    </table>
</div>

<br>
<div id="adv_content">
  <table width="90%" id="tbl_dynsite" onClick="javascript:display_adv();" onmouseover="try{this.style.borderColor = '#909090'; document.getElementById('dynsite_disabcheck').src='<?=$site_path;?>/wizard/images/check_notactive.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('dynsite_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="dynsite_imgfam" src="<?=$globvars['site_path'];?>/wizard/images/db_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
              <h2>Edit an existing  WebSite</h2>
              <h4>Tune up an already setup website. Enter advanced mode to install new modules or change layout profiles.</h4>
      </td>
      <td style="PADDING-RIGHT: 10px"><img id="dynsite_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$site_path;?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
   </tr>
  </table>
</div>
<br>
<div id="server">
  <table width="90%" id="tbl_server" onClick="javascript:document.location.href='<?=$_SERVER['REQUEST_URI'].'&server=1';?>';" onmouseover="try{this.style.borderColor = '#909090'; document.getElementById('server_disabcheck').src='<?=$site_path;?>/wizard/images/check_notactive.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('server_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="server_imgfam" src="<?=$globvars['site_path'];?>/wizard/images/db_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
              <h2>Server Management</h2>
              <h4>Manage WebServer</h4>
      </td>
      <td style="PADDING-RIGHT: 10px"><img id="server_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$site_path;?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
   </tr>
  </table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
