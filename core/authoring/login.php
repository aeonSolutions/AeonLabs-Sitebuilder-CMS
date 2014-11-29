<?php
/*
File revision date: 19-Ago-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Guests';
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if (isset($_POST['user']) and isset($_POST['p_chave'])):
	include($local_root.'core/authoring/authoring.php');
	echo 'Im not suposed to be here-14';
	exit;
endif;
?>
<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
  <TBODY>
  <TR>
    <TD>
      <DIV class="lateral-box">
      	<DIV class="lateral-box-title">Login</DIV>
		<DIV class="lateral-box-data">
			<?php
			if (isset($_SESSION['user'])):
				browse_menu();
			else:
				form_login($local_root);
			endif;
			?>
		</DIV>
	  </DIV>
      </TD>
    </TR></TBODY></TABLE>
<?php

function browse_menu(){	 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
	<table width="200" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		  </tr>
			<tr>
				<td height="2">
				  <font class="blue"><div align="center"><b>J&aacute; se autenticou no site!</b></div></font>
			</td>
		  </tr>
	  <tr>
		<td height="15"></td>
	  </tr>
	  <tr>
		<td width="100%" >
		</td>
	  </tr>
	  <tr>
		<td height="15">&nbsp;</td>
	  </tr>
    </table>	</td>
  </tr>
	<tr>
    <td height="15">&nbsp;</td>
  </tr>
</table>

<?php
 }; // end of funtion browse menu

function form_login($local_root){
include($local_root.'general/staticvars.php');
$link=session_setup($globvars,'index.php?id='.@$_GET['id']);
?>
<style type="text/css">
<!--
.forgot_password {
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-top-style: solid;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #000099;
	border-bottom-color: #000099;
	background-color: #6666CC;
}
-->
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<table width="1024"  height="371" border="0" align="center" cellpadding="0" cellspacing="0" background="../login/authoring/keyboard.gif">
		  <tr>
			<td height="25">&nbsp;</td>
		  </tr>
		  <tr>
		<td height="139" align="center" valign="top">
				<table width="350" height="137" align="center">
					<tr>
					 	<td colspan="3"><b>Bem Vindo!</b></td>
				 	</tr>
					<tr>
					 	<td colspan="3"><font class="">Esta area é exclusiva a administra&ccedil;&atilde;o do <?=$site_name;?>
					 	</font></td>
				    </tr>
					<tr>
					 	<td width="20"><img src="<?=$site_path;?>/core/authoring/img.gif" alt="image" width="143" height="61" /></td>
					 <td colspan="2" valign="top"><font class=""><br />
				     Para poder aceder pedimos-lhe o favor de introduzir os seus dados de autentica&ccedil;&atilde;o</font></td>
				 	</tr>
			  </table>
			</td>
		  </tr>
		  <tr>
			<td height="5" valign="top"></td>
		  </tr>
		  <tr height="25">
			<td align="center" valign="top">
			<form action="<?=$link;?>" enctype="multipart/form-data" method="post" name="login" >
			<?php
			if(isset($_GET['session'])):
			?>
			<font class="body_text"><font style="color:#FF0000">A sua sess&atilde;o expirou. Ter&aacute; que se autenticar novamente no site.</font></font><br>';
			<?php
			endif;
			?>
              <br />
              <table  height="25" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="32" align="left" valign="bottom"><img src="<?=$site_path;?>/core/authoring/password.jpg" alt="Password" width="32" height="32" /> Username:
                  <input type="text" name="user" size="20" maxlength="25" tabindex="1" /></td>
                  <td width="30" align="left">&nbsp;</td>
                  <td height="32" align="left" valign="bottom">Password:&nbsp;
                    <input type="password" name="p_chave" size="20" maxlength="25" tabindex="1" />
			  	  </td>
				</tr>
				<tr>
				  <td height="5" colspan="3" align="left"></td>
			    </tr>
				<tr>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="right" valign="top">&nbsp;</td>
				  <td align="right" valign="top">
				  	<p>
				  	  <input type="hidden" name="login">
				  	  <input type="image" src="../images/buttons/pt/entrar.gif">
	  	            </p>			  	  </td>
				</tr>
              </table>
			</form>
			</td>
		  </tr>
		  <tr>
			<td height="30">&nbsp;</td>
		  </tr>
	  </table>
	</td>
  </tr>
  <tr>
    <td height="15">&nbsp;</td>
  </tr>
</table>
<script language="JavaScript">
<!--
document.login.user.focus();
//-->
</script>

<?php
};

?>

