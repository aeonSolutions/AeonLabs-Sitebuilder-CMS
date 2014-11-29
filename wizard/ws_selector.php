<?php
if (isset($_POST['ws'])):
	include($globvars['local_root'].'core/status.php');
	if($_POST['ws']=='sa'):// simple with auth
		$file_content="
		<?PHP
		// New site status file
		"."$"."globvars['site']['sid']='".$globvars['site']['sid']."';
		"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
		"."$"."globvars['site']['type']='".$_POST['ws']."';
		?>";
		$filename=$globvars['local_root'].'core/status.php';
		if (file_exists($filename)):
			unlink($filename);
		endif;
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		header("Location: ".strip_address('ws',$_SERVER['REQUEST_URI']));
	elseif($_POST['ws']=='shtml'):// simple html basic
		$file_content="
		<?PHP
		// New site status file
		"."$"."globvars['site']['sid']='".$globvars['site']['sid']."';
		"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
		"."$"."globvars['site']['type']='".$_POST['ws']."';
		?>";
		$filename=$globvars['local_root'].'core/status.php';
		if (file_exists($filename)):
			unlink($filename);
		endif;
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		header("Location: ".strip_address('ws',$_SERVER['REQUEST_URI']));
	else:
		$file_content="
		<?PHP
		// New site status file
		"."$"."globvars['site']['sid']='".$globvars['site']['sid']."';
		"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
		"."$"."globvars['site']['type']='advanced';
		?>";
		$filename=$globvars['local_root'].'core/status.php';
		if (file_exists($filename)):
			unlink($filename);
		endif;
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		header("Location: ".strip_address('ws',$_SERVER['REQUEST_URI']));	
		exit;
	endif;
endif;
$link3=strip_address("step",$_SERVER['REQUEST_URI']);
$link2=strip_address("step",$_SERVER['REQUEST_URI']);
$link1=strip_address("step",$_SERVER['REQUEST_URI']);
?>
<script language="JavaScript" type="text/javascript"> 

function display_simple() {

document.getElementById('simple_content').innerHTML ="<table id='tbl_site' align='center' width='90%' style='BORDER-RIGHT: #fe4518 2px solid; BORDER-TOP: #fe4518 2px solid; BORDER-LEFT: #fe4518 2px solid; BORDER-BOTTOM: #fe4518 2px solid; BACKGROUND-COLOR: #ffffff' cellspacing=5 cellpadding=0 border=0>"
+"    <tr>"
+"      <td><img src='<?=$site_path;?>/wizard/images/simple_site.gif' /></td>"
+"      <td style='PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px' align=left width='100%'>"
+"      <h2>Simple WebSite</h2>"
+"      <h4>Create a basic website without database suport. With this option you can build a basic html site with PHP suppot only. As aditional feature you can integrate a basic authentication system.</h4>"
+"      </td>"
+"      <td style='PADDING-RIGHT: 10px'><img src='<?=$site_path;?>/wizard/images/check_active.gif' align=absMiddle /> </td>"
+"    </tr>"
+"</table>"
+"<br>"
+"<table width='90%' border='0' align='center' cellspacing='20' style='BORDER-RIGHT: #fe4518 2px solid; BORDER-TOP: #fe4518 2px solid; BORDER-LEFT: #fe4518 2px solid; BORDER-BOTTOM: #fe4518 2px solid; BACKGROUND-COLOR: #ffffff'>"
+"  <tr>"
+"    <td>"
+"    <h3><a href=javascript:document.form_ws1.submit();><img src='<?=$site_path;?>/wizard/images/with_login.gif' border='0'>&nbsp;Basic Authentication Support</a></h3>"
+"    <br>"
+"    <h3><a href=javascript:document.form_ws2.submit();><img src='<?=$site_path;?>/wizard/images/no_login.gif' border='0' align='bottom'>&nbsp;Simple Html & PHP site</a></h3>"
+"    </td>"
+"  </tr>"
+"</table>"
+"<form name='form_ws1' id='form_ws1' action='<?=$link1;?>' method='post' enctype='multipart/form-data'><input type='hidden' name='ws' value='sa' /></form>"
+"<form name='form_ws2' id='form_ws2' action='<?=$link2;?>' method='post' enctype='multipart/form-data'><input type='hidden' name='ws' value='shtml' /></form>";


}

</script> 
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="simple_content">
    <table width="90%" id="tbl_site" onClick="javascript:display_simple();" onmouseover="try{this.style.borderColor = '#909090'; document.getElementById('site_disabcheck').src='<?=$site_path;?>/wizard/images/check_notactive.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$site_path;?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="site_imgfam" src="<?=$site_path;?>/wizard/images/simple_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
      <h2>Simple WebSite</h2>
      <h4>Create a basic website without database suport. With this option you can build a basic html site with PHP suppot only. As aditional feature you can integrate a basic authentication system.</h4>
        </td>
        <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$site_path;?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
    </tr>
    </table>
</div>

<br>
<div id="adv_content">
    <table width="90%" id="tbl_dynsite" onclick="javascript:document.form_ws.submit();" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
      <tr>
        <td><img id="site_imgfam2" src="<?=$globvars['site_path'];?>/wizard/images/simple_site.gif" /></td>
        <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%"><h2>Advanced Website</h2>
            <h4>Create an advanced website with MySQL or MsSQL database suport. A number of features are included and configurable on the mode: from managing Emails, UserGroups and a number o modules custum made suitable for your needs.</h4></td>
        <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck2" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
      </tr>
    </table>
    <form name='form_ws' id='form_ws' action='<?=$link3;?>' method='post' enctype='multipart/form-data'><input type='hidden' name='ws' value='advanced' /></form>
  </div>
<p>&nbsp;</p>
<p>&nbsp;</p>
