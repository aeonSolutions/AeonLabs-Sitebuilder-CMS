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
  if (form.meta_keywords.value == "") {
    document.getElementById('t_key').style.color="#FF0000";
	form.meta_keywords.focus();
    return false;
  }
  if (form.meta_description.value == "" or form.meta_description.value == "<?=$_SESSION['paths']['meta_description'];?>") {
    document.getElementById('t_desc').style.color="#FF0000";
	form.meta_description.focus();
    return false;
  }
  if (form.meta_robots.value == "") {
    document.getElementById('t_robots').style.color="#FF0000";
	form.meta_robots.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.meta_keywords.value != "") {
    document.getElementById('t_key').style.color="#2b2b2b";
  }
  if (form.meta_description.value != "") {
    document.getElementById('t_desc').style.color="#2b2b2b";
  }
  if (form.meta_robots.value != "") {
    document.getElementById('t_robots').style.color="#2b2b2b";
  }

  // ** END **
}
//-->
</script>

<h3><img src="<?=$globvars['site_path'];?>/images/meta_tags.gif" alt="Meta Tags">&nbsp;META TAGS</h3>
<form name="form_meta" id="form_meta" class="form" action="<?=strip_address("set",$_SERVER['REQUEST_URI']).'&set=4';?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
  <p>
  <h4 id="t_key">Keywords</h4>
  <textarea name="meta_keywords" cols="80" rows="5" wrap="physical" class="text" id="meta_keywords" onchange="cleanform(document.form_meta)"><?=$_SESSION['meta']['keywords'];?></textarea>
    <br>
    <h4 id="t_desc">Description</h4>
    <textarea name="meta_description" cols="80" rows="5" wrap="virtual" class="text" id="meta_description" onchange="cleanform(document.form_meta)"><?=$_SESSION['meta']['description'];?></textarea>
    <br>
    <h4 id="t_robots">Robots</h4>
    <textarea name="meta_robots" cols="80" rows="5" wrap="virtual" class="text" id="meta_robots" onchange="cleanform(document.form_meta)"><?=$_SESSION['meta']['robots'];?></textarea>
    <br>
    <br>
  </p>
  <p align="right">
    <input class="button" type="submit" name="save_meta" id="save_meta" value="Save" tabindex="3">
    </p>
</form>
