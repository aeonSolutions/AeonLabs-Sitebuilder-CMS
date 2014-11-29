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
include_once($staticvars['local_root'].'general/return_module_id.php');
$login_id=return_id('login.php');
$new_register=return_id('new_register.php');
$lost_pass=return_id('lost_pass.php');
$navto=$_SERVER['REQUEST_URI'];
$in_addr=explode('?',$navto);
$navto=@$_GET['id'].'@';
if (isset($in_addr[1])):
	$in_addr=explode('&',$in_addr[1]);
	for ($i=0; $i<count($in_addr);$i++):
		if (substr($in_addr[$i],0,3)<>'SID' and substr($in_addr[$i],0,4)<>'lang' and substr($in_addr[$i],0,6)<>'id'):
			$navto.=$in_addr[$i].'@';
		endif;
	endfor;
$navto=substr($navto,0,strlen($navto)-1);
endif;
?>
<style>
	div.bxthdr    {
		font : 11px Verdana,Arial,Helvetica,sans-serif;
		color : #ffffff;
		background-color : #6A94CC;
		border-bottom: 0px solid #10438F;
		padding: 3px 3px 3px 5px;
		height: 20px;
		}
</style>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td colspan="2" valign="top" class="header-bk"><h3><?=$lr[0];?></h3></td>
    </tr>
    <tr>
    <td valign="baseline"><img alt="members" src="<?=$staticvars['site_path'];?>/modules/authoring/images/lock.gif" align="left" border="0" hspace="15"><br>    </td>
    <td valign="baseline"><p><?=$lr[1];?></p></td>
  </tr>
</tbody></table>
<p>&nbsp;</p>		
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td valign="top">
<div class="bxthdr">&nbsp;<?=$lr[2];?></div>
<br>

<p><b><?=$lr[3];?><br>
</b><br>
<?=$lr[4];?>
<br>
<br>
</p>
		<form class="form" action="<?=session($staticvars,'index.php?id='.$login_id.'&navto='.$navto);?>" enctype="multipart/form-data" method="post">
            <p>
			<?=$lr[5];?><br>
			<INPUT id="login-user" name="user" class="text" style="width: 200px;"><br>
			<?=$lr[6];?><br>
			<INPUT id="login-pass" type="password" name="p_chave" class="text" style="width: 200px;"><br>
			<input name="autologin" value="ON" type="checkbox" class="button">
			<?=$lr[7];?><br>
            <br>
			<INPUT type="submit" value="<?=$lr[13];?>" name="login" class="button"><br>
            <br>
            <a href="<?=session($staticvars,'index.php?id='.$lost_pass);?>"><?=$lr[8];?></a><br>

            <br>    
          </p>
		</form>
		</td>
    <td valign="top" width="10"><img alt="" src="<?=$staticvars['site_path'];?>/modules/authoring/images/space.gif" border="0" height="10" width="10"></td>
<td valign="top">
<div class="bxthdr"><?=$lr[9];?></div>
<br>
<p><b><?=$lr[10];?></b><br>
<br>
<?=$lr[11];?><br>
<br>
</p>
<form class="form" method="post" action="<?=session($staticvars,'index.php?id='.$new_register);?>">
  <p><input value="<?=$lr[12];?>" class="button" type="submit">
  </p>
</form>
<p>
<br>


<br>
</p>
</td>
  </tr>
</tbody></table>