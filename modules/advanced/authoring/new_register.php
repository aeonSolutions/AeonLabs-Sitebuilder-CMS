<?php 
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/authoring/language/pt.php');
else:
	include($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php');
endif;
if (isset($_POST['add_user']) ):
	include($staticvars['local_root'].'modules/authoring/update_db/add_user.php');
endif;
$tos_code=return_id('wtos_main.php');
$task=@$_GET['id'];
include('modules/authoring/system/security_img.php');
$_SESSION['txtstr'] = security_image();
?>
<h3><img src="<?php echo $staticvars['site_path'].'/modules/authoring/images/user-profile.gif'; ?>" alt="<?=$nr[0];?>" border="0" height="20" /><?=$nr[1];?></h3>
<script language="JavaScript" type="text/javascript">
<!--

function checkform ( form )
{
  if (form.name.value == "") {
    document.getElementById('t_name').style.color="#FF0000";
	form.name.focus();
    return false;
  }
  if (form.user_name.value == "") {
    document.getElementById('t_user_name').style.color="#FF0000";
	form.user_name.focus();
    return false;
  }
  if (form.email.value == "") {
    document.getElementById('t_email').style.color="#FF0000";
	form.email.focus();
    return false;
  }
  if (form.pass1.value != form.pass2.value ) {
    document.getElementById('t_pass1').style.color="#FF0000";
    document.getElementById('t_pass2').style.color="#FF0000";
	form.pass2.focus();
    return false;
  }
  if (form.security_name.value == "") {
    document.getElementById('t_security_name').style.color="#FF0000";
	form.security_name.focus();
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
  if (form.user_name.value != "") {
    document.getElementById('t_user_name').style.color="#2b2b2b";
  }
  if (form.email.value != "") {
    document.getElementById('t_email').style.color="#2b2b2b";
  }
  if (form.pass1.value != "") {
    document.getElementById('t_pass1').style.color="#2b2b2b";
  }
  if (form.pass2.value != "") {
    document.getElementById('t_pass2').style.color="#2b2b2b";
  }
  if (form.pass2.value == form.pass1.value && form.pass2.value!='') {
    document.getElementById('t_pass1').style.color="#2b2b2b";
    document.getElementById('t_pass2').style.color="#2b2b2b";
    document.getElementById('img').innerHTML="<img src='<?=$staticvars['site_path'];?>/modules/authoring/images/check_mark.gif'>";
  }else{
    document.getElementById('t_pass1').style.color="#FF0000";
    document.getElementById('t_pass2').style.color="#FF0000";
    document.getElementById('img').innerHTML="<img src='<?=$staticvars['site_path'];?>/modules/authoring/images/cross_mark.gif'>";
  }

  // ** END **
}
//-->
</script>

<SCRIPT src="modules/authoring/system/canalmail.js" type=text/javascript></SCRIPT>
	<FORM class="form" name="register" id="register" onsubmit="return checkform(this)" action="<?=session($staticvars,'index.php?id='.$task);?>" method="post" enctype="multipart/form-data">
        <div align="right"><font class="form_title"><?=$nr[2];?><font size="1" color="#FF0000">&#8226;</font><?=$nr[3];?></font>
        <?
        if (isset($_SESSION['erro_email']) or isset($_SESSION['erro_user']) or isset($_SESSION['erro_pass']) or isset($_SESSION['erro_sec_code']) ):
        ?>
        <br>
        <font class="form_title"><font color="#FF0000"><?=$nr[4];?></font></font>	
        <?
        elseif (isset($_SESSION['all_fields'])):
        ?>
        <br>
        <font class="form_title"><font color="#FF0000"><?=$nr[5];?></font></font>	
        <?
        endif;
        ?>
        </div>
        <br />
      <table>
          <tr>
            <td width="150"><font size="1" color="#FF0000">&#8226; </font><font id="t_name"><?=$nr[6];?></font></td>
            <td colspan="2"><input onchange="cleanform(document.register)" class="text" maxlength="60" size="40" name="name" value="<?=@$_POST['name'];?>" /></td>
          </tr>
          <tr>
            <td colspan="3" height="5"></td>
          </tr>
          <tr>
            <td width="150"><font size="1" color="#FF0000">&#8226;</font>
              <? if (isset($_SESSION['erro_user'])):
                ?>
              <font size="1" color="#FF0000" id="t_user_name"><?=$nr[7];?></font>
              <?
            else:
                 ?>
              <font id="t_user_name"><?=$nr[7];?></font>
              <?
            endif; ?></td>
            <td colspan="2"><input onchange="cleanform(document.register)" class="text" maxlength="24" size="30" name="user_name" value="<?=@$_POST['user_name'];?>" /></td>
          </tr>
          <tr>
            <td colspan="3" height="5"></td>
          </tr>
          <tr>
            <td width="150"><font size="1" color="#FF0000">&#8226;</font>
              <? if (isset($_SESSION['erro_email'])):
                ?>
              <font size="1" color="#FF0000" id="t_email"><?=$nr[8];?></font>
              <?
            else:
                ?>
              <font id="t_email"><?=$nr[8];?></font>
              <?
            endif; ?></td>
            <td colspan="2"><input onchange="cleanform(document.register)" class="text" maxlength="255" size="30" name="email"  value="<?=@$_POST['email'];?>" /></td>
          </tr>
          <tr>
            <td colspan="3" height="5"></td>
          </tr>
          <tr>
            <td width="150"><font size="1" color="#FF0000">&#8226; </font>
              <? if (isset($_SESSION['erro_pass'])):
                ?>
              <font size="1" color="#FF0000" id="t_pass1"><?=$nr[9];?></font>
              <?
            else:
                ?>
              <font id="t_pass1"><?=$nr[9];?></font>
              <?
            endif; ?></td>
            <td colspan="2"><input class="text" type="password" maxlength="15" size="25" name="pass1"  value="<?=@$_SESSION['pass'];?>" /></td>
          </tr>
          <tr>
            <td width="150"><font size="1" color="#FF0000">&#8226; </font><font  id="t_pass2"><?=$nr[10];?></font></td>
            <td width="170"><input onchange="cleanform(document.register)" class="text" type="password" maxlength="15" size="25" name="pass2"  value="<?=@$_SESSION['pass'];?>" /></td>
            <td><div id="img"></div></td>
          </tr>
          <tr>
            <td colspan="3" height="5"></td>
          </tr>
          <tr>
            <td colspan="3" class="body_text">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><hr noshade="noshade" size="1" /></td>
          </tr>
          <tr height="8">
            <td colspan="3"></td>
          </tr>
          <tr>
            <td colspan="3" align="left" class="header_text_1"><font size="1" color="#FF0000">&#8226; </font><strong><?=$nr[11];?></strong></td>
          </tr>
          <tr>
            <td colspan="
            3"><div align="left"><font class="body_text"><?=$nr[12];?></font></div></td>
          </tr>
          <tr>
            <td colspan="3"><div align='center'><img src='modules/authoring/<?=$_SESSION['txtstr'];?>.jpg' border='1' /></div></td>
          </tr>
          <tr>
            <td colspan="3"><? if (isset($_SESSION['erro_sec_code'])):
            ?>
              <font size="1" color="#FF0000" id="t_security_name"><?=$nr[13];?></font>
              <?
        else:
            ?>
              <font id="t_security_name"><?=$nr[13];?></font>
              <?
        endif; ?></td>
          </tr>
          <tr>
            <td colspan="3"><div align="center">
              <input type="hidden" name="txtstr" value="<?=$_SESSION['txtstr'];?>" />
              <input onchange="cleanform(document.register)" class="text" type="text" name="security_name" maxlength="25" size="25" />
            </div></td>
          </tr>
        <tr>
            <td colspan="3"><hr noshade="noshade" size="1" /></td>
        </tr>
      </table>
      <br />
<?php

// add profiles from other modules
$dir=glob($staticvars['local_root'].'modules/*',GLOB_ONLYDIR);
$query=$db->getquery('select link,cod_module from module');
if ($dir[0]<>''):
	for ($j=0; $j<count($query); $j++):
		$link=explode("/",$query[$j][0]);
		$mod[$j]=$link[0];
	endfor;
	for($ix=0; $ix<count($dir); $ix++):
		$dirX=explode("/",$dir[$ix]);
		if(in_array($dirX[count($dirX)-1],$mod)):		
			if (is_dir($dir[$ix].'/system')):
				if(is_file($dir[$ix].'/system/new_user_form.php') ):
					include($dir[$ix].'/system/new_user_form.php');
					echo '<hr size=1><br>';
				endif;
			endif;
		endif;
	endfor;
endif;
?>
<br />
<?=$nr[14];?>
<A href="index.php?id=<?=$tos_code.'&nav=tos';?>" target=_blank> <?=$nr[15];?></A><?=$nr[17];?>
<br /><br />

<div align="right">
	<input name="add_user" type="submit" class="button" id="add_user" value="<?=$nr[16];?>" />&nbsp;
</div><br />

</FORM>