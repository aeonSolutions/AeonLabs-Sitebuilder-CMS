<?php
/*
File revision date: 10-Fev-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$login_id=return_id('login.php');
$new_register=return_id('new_register.php');
$lost_pass=return_id('lost_pass.php');
$edit_profile=return_id('profile_edit.php');
if ($login_id==$task or return_id('login_requiered.php')==$task):
	$id=true;
else:
	$id=false;
endif;
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
if (isset($_SESSION['user'])):
	?>
		  <DIV class="header_text_1"><?=$ll[9].$_SESSION['user'];?> </DIV>
		  	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
			<tr height="32">
			  <td align="right"><img src="modules/authoring/images/login.gif"></td>
			  <td align="left">
				&nbsp;&nbsp;<A class="body_text" title="<?=$ll[0];?>" href="<?=session($staticvars,'index.php?id='.$edit_profile);?>"><?=$ll[2];?></A><br>
				&nbsp;&nbsp;<A class="body_text" title="<?=$ll[1];?>" href="index.php?logout=1"><?=$ll[3];?></A>
			  </td>
			  </tr>
			</table>
		<?php
elseif ($id==false):
	?>
    <script language="javascript">
	function login_form(){
		var formToSend = document.getElementById("login");
		formToSend.submit();	
	};
	</script>
		<form name='login' id="login" action="index.php?id=<?=$login_id;?>&lang=<?=$lang;?>&update=login&areaid=<?=@$_GET['areaid'];?>" enctype="multipart/form-data" method="post">
				<TABLE cellpadding="0" cellspacing="0" border="0">
				  <TR>
					<TD colspan="2" class="module"><LABEL for=login-user class="body_text"><?=$ll[4];?><br />
				    <input name="user" class="body_text" id="login-user" size="14" />
					</LABEL>					</TD>
				</TR>
				  <TR>
				    <TD colspan="2" class="module" height="3"></TD>
			      </TR>
				  <TR>
					<TD colspan="2" valign="bottom" class="module"><LABEL for=login-pass class="body_text"><?=$ll[5];?><br />
				    <input name="p_chave" type="password" class="body_text" id="login-pass" size="14" />
					</LABEL>
                    <a href="javascript:login_form();"><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/seta.gif" alt="Login" border="0" width="17" height="17" /></a> </TD>
				</TR>
				</TABLE>
<font class="litle_text"><input name="autologin" type="checkbox" id="autologin" value="ON" /><?=$ll[6];?><br />
[ <A class="litle_text" title="Clique aqui para se registar" href="index.php?id=<?=$new_register;?>"><?=$ll[7];?></A> 
					  | <A class="litle_text" title="Clique aqui caso se tenha esquecido da password" href="index.php?id=<?=$lost_pass;?>"><?=$ll[8];?></A> ]	</font>
		  </FORM>
		<?php
endif;
?>