<?php
/*
File revision date: 12-Abr-2008
*/
if ( !defined('ON_SiTe')):
	echo 'not for direct access';
	exit;
endif;
$msg='';
if(isset($_POST['submit'])):
	$loca_root=$_POST['local_root'];
	if ($loca_root[strlen($loca_root)-1]=='/' or $loca_root[strlen($loca_root)-1]=='\\'):
		$loca_root=substr($loca_root,0,strlen($loca_root)-1);
	endif;
	if(!@mkdir($loca_root) and !isset($_POST['resetdir'], 0755, true)):
		$error=true;
		$msg='Unable to create website main directory. Already exists? ';
	else:
		if(!@mkdir($loca_root) and isset($_POST['resetdir'], 0755, true)):
			delr($globvars,$loca_root);
			@mkdir($loca_root, 0755, true);
		endif;
		copyr($globvars['local_root'].'copyfiles/simple/kernel',$loca_root.'/kernel',$globvars);
		mkdir($_POST['local_root'].'/layout', 0755, true);
		mkdir($_POST['local_root'].'/modules', 0755, true);
		@unlink($loca_root.'/index.php');
		copy($globvars['local_root'].'copyfiles/simple/sa/index.php',$loca_root.'/index.php');
		$_SESSION['directory']=$loca_root.'/';
		$filename=$loca_root.'/kernel/staticvars.php';
		$file_content="
		<?PHP
		// WebPage Static Vars
		".'$'."staticvars['site_path']='".str_replace(" ","",$_POST['site_path'])."';
		".'$'."staticvars['local_root']='".$loca_root."/';
		".'$'."staticvars['site_name']='".$_POST['name']."';
		".'$'."staticvars['layout']['file']='';
		".'$'."staticvars['language']['main']='".$_POST['main_lang']."';
		".'$'."staticvars['language']['available']='".$_POST['avail_lang']."';
		".'$'."staticvars['language']['current']='';
		".'$'."staticvars['module']['location']='';
		?>";
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		$tmp=$_POST['local_root'];
		$tmp=$tmp[strlen($tmp)-1]<>'/' ? $tmp.'/' : $tmp;
		$file_content="
		<?PHP
		// New site status file
		"."$"."globvars['site']['sid']='".$globvars['site']['sid']."';
		"."$"."globvars['site']['mode']='".$globvars['site']['mode']."';
		"."$"."globvars['site']['type']='".$globvars['site']['type']."';
		"."$"."globvars['site']['directory']='".$tmp."';
		?>";
		$filename=$globvars['local_root'].'core/status.php';
		if (file_exists($filename)):
			unlink($filename);
		endif;
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		header("Location: ".strip_address("step",$_SERVER['REQUEST_URI']));
	endif;
	$site_name=$_POST['name'];
	$site_path=$_POST['site_path'];
	$local_root=$_POST['local_root'];
	$main_lang=$_POST['main_lang'];
	$avail_lang=$_POST['avail_lang'];
else:
	$site_name='';
	$site_path='http://www.';
	$local_root=substr( $globvars['local_root'], 0, strpos( $globvars['local_root'], "sitebuilder" ) );
	$main_lang='pt';
	$avail_lang='pt;en';
endif;
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
  if (form.main_lang.value != "") {
    document.getElementById('t_lang').style.color="#2b2b2b";
  }
  if (form.avail_lang.value != "") {
    document.getElementById('t_avail_lang').style.color="#2b2b2b";
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
          <input class="text" onchange="cleanform(document.form_settings)" name="name" type="text" id="name" tabindex="1" size="40" maxlength="80" value="<?=$site_name;?>" /></h4>
      The name of the website</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
    
    <tr>
      <td align="right">&nbsp;</td>
      <td><h4 id="t_url">Url address<br />
          <input class="text" name="site_path" onchange="cleanform(document.form_settings)"  type="text" id="site_path" tabindex="2" value="<?=$site_path;?>" size="50" maxlength="100" />
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
          <input class="text" onchange="cleanform(document.form_settings)"  name="local_root" value="<?=local_root;?>" type="text" id="local_root" tabindex="3" size="50" maxlength="255" />
      </h4>
		   Local hard drive directory (Ex.: c:\www\mysite\)
      </td>
    </tr>
    <tr>
      <td height="5"></td>
      <td height="5"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><h4 id="t_lang">Main language&nbsp;<br />
          <input class="text" onchange="cleanform(document.form_settings)"  name="main_lang" value="<?=$main_lang;?>" type="text" id="main_lang" tabindex="3" size="50" maxlength="2" />
      </h4>
		   Website main language
      (pt)</td>
    </tr>
    <tr>
      <td height="5"></td>
      <td height="5"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><h4 id="t_avail_lang">Available languages<br />
          <input class="text" onchange="cleanform(document.form_settings)"  name="avail_lang" value="<?=$avail_lang;?>" type="text" id="avail_lang" tabindex="3" size="50" maxlength="255" />
      </h4>
      Comma separated languages (en;pt;es;fr)</td>
    </tr>
    <tr>
      <td height="5"></td>
      <td height="5">
	  <?php
	  if($msg<>''):
	  ?>
      <input type="checkbox" name="resetdir" />&nbsp;Reset Directory
	  <?php
	  endif;
	  ?>
	  </td>
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
