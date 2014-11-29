<?php
$msg='';
if(isset($_POST['submit'])):
	$filename=$globvars['site']['directory'].'/kernel/staticvars.php';
	include($filename);
	$file_content="
	<?PHP
	// WebPage Static Vars
	".'$'."staticvars['site_path']=' ".$_POST['site_path']." ';
	".'$'."staticvars['local_root']='".$globvars['site']['directory']."';
	".'$'."staticvars['site_name']='".$_POST['name']."';
	".'$'."staticvars['layout']['file']='".$staticvars['layout']['file']."';
	?>";
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);

	$file_content="
	<?PHP
	// New site status file
	"."$"."globvars['site']['sid']='".$globvars['site']['sid']."';
	"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
	"."$"."globvars['site']['name']='".$_POST['name']."';
	"."$"."globvars['site']['directory']='".$globvars['site']['directory']."';
	?>";
	$filename=$globvars['local_root'].'core/siteedit.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);

	header("Location: ".strip_address("step",$_SERVER['REQUEST_URI']));
endif;
$filename=$globvars['site']['directory'].'/kernel/staticvars.php';
include($filename);
?>
<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{
  if (form.name.value == "") {
    document.getElementById('t_name').style.color="#FF0000";
	form.name.focus();
    return false;
  }
  if (form.site_path.value == "") {
    document.getElementById('t_url').style.color="#FF0000";
	form.site_path.focus();
    return false;
  }
  if (form.local_root.value == "") {
    document.getElementById('t_path').style.color="#FF0000";
	form.local_root.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.name.value != "") {
    document.getElementById('t_name').style.color="#2b2b2b";
  }
  if (form.site_path.value != "") {
    document.getElementById('t_url').style.color="#2b2b2b";
  }
  if (form.local_root.value != "") {
    document.getElementById('t_path').style.color="#2b2b2b";
  }

  // ** END **
}
//-->
</script>
<?=$msg;?>
<form class="form" id="form_settings" name="form_settings" onsubmit="return checkform(this)" method="post" action="">
  <table width="100%" border="0" align="center">
    <tr>
      <td width="150" rowspan="10"><img src="<?=$globvars['site_path'];?>/images/cables.gif" alt="connect" width="143" height="285" /></td>
      <td width="150">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="top">&nbsp;</td>
      <td><h4 id="t_name">Site Name<br />
          <input class="text" onchange="cleanform(document.form_settings)" value="<?=$staticvars['site_name'];?>" name="name" type="text" id="name" tabindex="1" size="40" maxlength="80" /></h4>
      The name of the website</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
    
    <tr>
      <td align="right">&nbsp;</td>
      <td><h4 id="t_url">Url address<br />
          <input class="text" name="site_path" onchange="cleanform(document.form_settings)"  type="text" id="site_path" tabindex="2" value="<?=$staticvars['site_path'];?>" size="50" maxlength="100" />
      </h4>
          Url base address (Ex.: http://www.moradadigital.com)
      </td>
    </tr>
    <tr>
      <td height="5"></td>
      <td height="5"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><h4 id="t_path">Site directory&nbsp;<br />
          <input class="text" onchange="cleanform(document.form_settings)" disabled="disabled"  name="local_root" value="<?=$staticvars['local_root'];?>" type="text" id="local_root" tabindex="3" size="50" maxlength="255" />
      </h4>
		   Local hard drive directory (Ex.: c:\www\mysite\)
      </td>
    </tr>
    <tr>
      <td height="5"></td>
      <td height="5"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><label>
        <input class="button" type="submit" name="submit" id="submit" value="Save" tabindex="4" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p><br />
    <br />
    <br />
  
    </p>
</form>
<?php
?>
