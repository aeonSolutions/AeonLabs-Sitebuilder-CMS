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
<font color="#FF0000"><?=$authorized;?></font>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<table width="100%"  height="371" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="25">&nbsp;</td>
		  </tr>
		  <tr>
		<td height="139" align="center" valign="top">
				<table background="modules/login/images/header.gif" width="515" height="141" align="center">
					<tr>
					 	<td width="20"></td>
					 	<td width="230" align="left"><b>Bem Vindo!</b></td>
					 	<td></td>
					</tr>
					<tr>
					 	<td width="20"></td>
					 <td width="230" align="left"><font class="">Esta area &eacute; exclusiva a utilizadores registados</font></td>
					 	<td></td>
					</tr>
					<tr>
					 	<td width="20"></td>
					 <td width="230" align="center"><font class="">Para poder aceder indroduza os seus dados de acesso &agrave; area reservada.</font></td>
					 	<td></td>
					</tr>
			  </table>			</td>
		  </tr>
		  <tr>
			<td height="30">&nbsp;</td>
		  </tr>
		  <tr height="25">
			<td align="center" valign="top">
			<form action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" method="post">
            <input type="hidden" value="<?=@$_GET['navigate'];?>" name="navto" />
              <table width="200"  height="25" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center">
				  	Nome de Utilizador
				  	<input type="text" name="user" size="20" maxlength="25">				  </td>
				</tr>
				<tr>
				  <td align="center">Password<br />
			  	  <input type="password" name="p_chave" size="20" maxlength="25"></td>
				</tr>
				<tr>
				  <td align="center">
				  	<input type="hidden" name="login">
				  	<input name="log" type="submit" id="log" value="Entrar" class="form_submit" >				  </td>
				</tr>
              </table>
			</form>			</td>
		  </tr>
		  <tr>
			<td height="30">&nbsp;</td>
		  </tr>
		  <tr height="25">
			<td>&nbsp;</td>
		  </tr>
	  </table>
	</td>
  </tr>
  <tr>
    <td height="15">&nbsp;</td>
  </tr>
</table>
