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
  if (form.main.value == "") {
    document.getElementById('t_main').style.color="#FF0000";
	form.main.focus();
    return false;
  }
  if (form.available.value == "") {
    document.getElementById('t_avail').style.color="#FF0000";
	form.available.focus();
    return false;
  }
  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.main.value != "") {
    document.getElementById('t_main').style.color="#2b2b2b";
  }
  if (form.available.value != "") {
    document.getElementById('t_avail').style.color="#2b2b2b";
  }

  // ** END **
}
//-->
</script>

<h3><img src="<?=$globvars['site_path'];?>/images/set_lang.gif" alt="Paths">&nbsp;LANGUAGE</h3>
<form name="form_lang" id="form_lang" class="form" action="<?=strip_address("set",$_SERVER['REQUEST_URI']).'&set=6';?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
  <p><h4 id="t_main">Main</h4>
    <input onchange="cleanform(document.form_lang)" name="main" type="text" class="text" id="main" value="<?=$_SESSION['language']['main'];?>" size="30" maxlength="30">
    <br>
    <h4 id="t_avail">Availabe</h4>
    <input onchange="cleanform(document.form_lang)" name="available" type="text" class="text" id="available" value="<?=$_SESSION['language']['available'];?>" size="30" maxlength="30">
    <br>
    <br>
    <br>
  </p>
  <p align="right">
    <input class="button" type="submit" name="save_lang" id="save_misc" value="Save" tabindex="3">
    </p>
</form>
