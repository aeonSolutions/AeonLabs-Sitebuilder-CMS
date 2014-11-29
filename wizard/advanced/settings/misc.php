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
  if (form.page_title.value == "") {
    document.getElementById('t_title').style.color="#FF0000";
	form.page_title.focus();
    return false;
  }
  if (form.site_version.value == "") {
    document.getElementById('t_version').style.color="#FF0000";
	form.site_version.focus();
    return false;
  }
  if (form.site_name.value == "") {
    document.getElementById('t_name').style.color="#FF0000";
	form.site_name.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.page_title.value != "") {
    document.getElementById('t_title').style.color="#2b2b2b";
  }
  if (form.site_version.value != "") {
    document.getElementById('t_version').style.color="#2b2b2b";
  }
  if (form.site_name.value != "") {
    document.getElementById('t_name').style.color="#2b2b2b";
  }

  // ** END **
}
//-->
</script>

<h3><img src="<?=$globvars['site_path'];?>/images/set_misc.gif" alt="Paths">&nbsp;GENERAL SETTINGS</h3>
<form name="form_misc" id="form_misc" class="form" action="<?=strip_address("set",$_SERVER['REQUEST_URI']).'&set=2';?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
  <p><h4 id="t_title">Page Title</h4>
    <input onchange="cleanform(document.form_misc)" name="page_title" type="text" class="text" id="page_title" value="<?=$_SESSION['misc']['page_title'];?>" size="80">
    <br>
    <h4 id="t_version">Site version</h4>
    <input onchange="cleanform(document.form_misc)" name="site_version" type="text" class="text" id="site_version" value="<?=$_SESSION['misc']['site_version'];?>" size="10">
    <br>
    <h4 id="t_name">Site Name</h4>
    <input onchange="cleanform(document.form_misc)" name="site_name" type="text" class="text" id="site_name" value="<?=$_SESSION['misc']['site_name'];?>" size="80">
    <br>
    <br>
  </p>
  <p align="right">
    <input class="button" type="submit" name="save_misc" id="save_misc" value="Save" tabindex="3">
    </p>
</form>
