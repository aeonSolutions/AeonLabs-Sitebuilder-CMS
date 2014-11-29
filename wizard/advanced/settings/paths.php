<?php
/*
File revision date: 12-Abr-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;
?>
<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{
  if (form.site_path.value == "") {
    document.getElementById('t_url').style.color="#FF0000";
	form.site_path.focus();
    return false;
  }
  if (form.local_root.value == "" || form.local_root.value == "<?=$globvars['local_root'];?>") {
    document.getElementById('t_root').style.color="#FF0000";
	form.local_root.focus();
    return false;
  }
  if (form.upload.value == "") {
    document.getElementById('t_upload').style.color="#FF0000";
	form.upload.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.site_path.value != "") {
    document.getElementById('t_url').style.color="#2b2b2b";
  }
  if (form.local_root.value != "") {
    document.getElementById('t_root').style.color="#2b2b2b";
  }
  if (form.upload.value != "") {
    document.getElementById('t_upload').style.color="#2b2b2b";
  }

  // ** END **
}
//-->
</script>

<h3><img src="<?=$globvars['site_path'];?>/images/paths.gif" alt="Paths">&nbsp;PATHS</h3>
<form name="form_paths" id="form_paths" class="form" action="<?=strip_address("set",$_SERVER['REQUEST_URI']).'&set=3';?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
  <p>
  <h4 id="t_url">URL Address</h4>
<input onchange="cleanform(document.form_paths);" name="site_path" type="text" class="text" id="site_path" value="<?=$_SESSION['paths']['site_path'];?>" size="50">
    <br>
    <h4 id="t_root">Site location</h4>
    <input onchange="cleanform(document.form_paths);" name="local_root" type="text" class="text" id="local_root" value="<?=$_SESSION['paths']['local_root'];?>" size="50">
    <br />
    <input type="checkbox" name="overwrite" id="overwrite" /> Overwrite folder if exists
<br>
    <h4 id="t_upload">Uploads Directory</h4>
    <input onchange="cleanform(document.form_paths);" name="upload" type="text" class="text" id="upload" value="<?=$_SESSION['paths']['upload'];?>" size="30">
    <br>
    <br>
  </p>
  <p align="right">
    <input class="button" type="submit" name="save_paths" id="save_paths" value="Save" tabindex="3">
    </p>
</form>
