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
  if (form.id.value == "") {
    document.getElementById('t_id').style.color="#FF0000";
	form.id.focus();
    return false;
  }
  if (form.expire.value == "") {
    document.getElementById('t_expire').style.color="#FF0000";
	form.expire.focus();
    return false;
  }
  if (form.path.value == "") {
    document.getElementById('t_path').style.color="#FF0000";
	form.path.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.id.value != "") {
    document.getElementById('t_id').style.color="#2b2b2b";
  }
  if (form.expire.value != "") {
    document.getElementById('t_expire').style.color="#2b2b2b";
  }
  if (form.path.value != "") {
    document.getElementById('t_path').style.color="#2b2b2b";
  }

  // ** END **
}
//-->
</script>

<h3><img src="<?=$globvars['site_path'];?>/images/cookies.gif" alt="Paths">&nbsp;COOKIES</h3>
<form name="form_cookies" id="form_cookies" class="form" action="<?=strip_address("set",strip_address("step",$_SERVER['REQUEST_URI']));?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
  <p><h4 id="t_id">Session ID</h4>
    <input onchange="cleanform(document.form_cookies)" name="id" type="text" class="text" id="id" value="<?=$_SESSION['cookies']['id'];?>" size="80"><br />
  <a href="<?=strip_address("gen",$_SERVER['REQUEST_URI']).'&gen=1';?>">Generate a new ID</a>  <br>
    <h4 id="t_expire">Expire</h4>
    <input onchange="cleanform(document.form_cookies)" name="expire" type="text" class="text" id="expire" value="<?=$_SESSION['cookies']['expire'];?>" size="10">
    <br>
    <h4 id="t_path">Relative Path</h4>
    <input onchange="cleanform(document.form_cookies)" name="path" type="text" class="text" id="path" value="<?=$_SESSION['cookies']['path'];?>" size="80">
    <br>
    <br>
  </p>
  <p align="right">
    <input class="button" type="submit" name="save_cookies" id="save_cookies" value="Save" tabindex="3">
    </p>
</form>
