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
  if (form.id.value == "" && form.enable.value=="Enabled") {
    document.getElementById('t_id').style.color="#FF0000";
	form.id.focus();
    return false;
  }
  if (form.expire.value == "" && form.enable.value=="Enabled") {
    document.getElementById('t_expire').style.color="#FF0000";
	form.expire.focus();
    return false;
  }
  if (form.path.value == "" && form.enable.value=="Enabled") {
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
<table width="100%" border="0">
  <tr>
    <td><h3><img src="<?=$globvars['site_path'];?>/images/cookies.gif" alt="Paths">&nbsp;COOKIES</h3>
    </td>
    <td width="30"><a href="<?=session_setup($globvars,'index.php?id='.$_GET['id']);?>"><img src="<?=$globvars['site_path'];?>/images/back.png" alt="go back" border="0" /></a> </td>
  </tr>
</table>



<form name="form_cookies" id="form_cookies" class="form" action="<?=strip_address("set",strip_address("step",$_SERVER['REQUEST_URI']));?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
  <p>
  <h4 id="t_expire2">Cookies are 
        <select class="text" size="1" name="enable" id="enable" >
          <option value="true" <?php if ($staticvars['cookies']['enable']){?>selected<?php } ?>>Enabled</option>
          <option value="false" <?php if (!$staticvars['cookies']['enable']){?>selected<?php } ?>>Disabled</option>
        </select>
  </h4><br />
  <h4 id="t_id">Session ID</h4>
  <input onchange="cleanform(document.form_cookies)" name="id" type="text" class="text" id="id" value="<?=$staticvars['cookies']['id'];?>" size="80"><br />
  <a href="<?=strip_address("gen",$_SERVER['REQUEST_URI']).'&gen=1';?>">Generate a new ID</a>  <br>
    <h4 id="t_expire">Expire</h4>
    <input onchange="cleanform(document.form_cookies)" name="expire" type="text" class="text" id="expire" value="<?=$staticvars['cookies']['expire'];?>" size="10">
    <br>
    <h4 id="t_path">Relative Path</h4>
    <input onchange="cleanform(document.form_cookies)" name="path" type="text" class="text" id="path" value="<?=$staticvars['cookies']['path'];?>" size="80">
    <br>
    <br>
  </p>
  <p align="right">
    <input class="button" type="submit" name="save_cookies" id="save_cookies" value="Save" tabindex="3">
    </p>
</form>
