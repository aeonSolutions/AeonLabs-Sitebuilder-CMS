<?php
/*
File revision date: 9-set-2008
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if(!is_file($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/authoring/language/pt.php');
else:
	include($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php');
endif;
$message='';
if (isset($_POST['add_p_chave'])):
   	$query=$db->getquery("select cod_user,nick,active,cod_user_type from users where nick='".$_SESSION['user']."' and password=PASSWORD('".mysql_escape_string($_POST['actual_pass'])."')");   
    if ($query[0][0]<>''): // actual pass ok
		if ($_POST['add_p_chave']==$_POST['add_p_chave2']):
			$db->setquery("update users set password=PASSWORD('".mysql_escape_string($_POST['add_p_chave'])."'), active='s' where nick='".$_SESSION['user']."'");
			header("Location: ".$staticvars['site_path']."/index.php?SID=".@$_GET['SID']);
			echo 'Im not suposed to be here-14';
			exit;
		else:
			$message=$l[13]; //password nao coincidem
		endif;
	else:
		$message=$l[14];// password actual incorrecta
	endif;
endif;
echo '<font size="-1" color="red" style>'.$message.'</font>';
?>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Altera&ccedil;&atilde;o da Password</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD width="36" vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/password.jpg" alt="" width="32" height="32" align="baseline"><BR></TD>
      <TD vAlign=top>Bem vindo &agrave; area de gest&atilde;o da sua p&aacute;gina web. Antes de come&ccedil;ar pedimos-lhe que altere a password de acesso.</TD>
    </TR>
  </TBODY>
</TABLE>
<br>
			<?php
			include($staticvars['local_root'].'kernel/staticvars.php');
			$link=session($staticvars,'index.php?id='.@$_GET['id']);
			?>
					<table height="371" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td height="25">&nbsp;</td>
					  </tr>
					  <tr>
					<td height="139" align="center" valign="top">
							<table background="modules/authoring/images/header.gif" width="515" height="141" align="center">
                              <tr>
                                <td width="50"></td>
                                <td width="290" align="left"><b>
                                  <?=$l[1];?>
                                </b></td>
                                <td width="159"></td>
                              </tr>
                              <tr>
                                <td width="50"></td>
                                <td width="290" align="left"><font class="">
                                  <?=$l[2].$site_name;?>
                                </font></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td width="50"><img src="<?=$staticvars['site_path'];?>/images/warning.jpg" alt="image" width="50" height="50" /></td>
                                <td width="290" align="left"><font class="">
                                  <?=$l[11];?>
                                </font></td>
                                <td></td>
                              </tr>
                            </table>
							</td>
					  </tr>
					  <tr>
						<td height="5" valign="top"></td>
					  </tr>
					  <tr height="25" >
						<td align="center" valign="top" style="border-color:#999999;border-style:solid;border-width:1px;">
                      
						<form class="form" action="<?=$link;?>" enctype="multipart/form-data" method="post">
						  <table  height="25" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td height="32" colspan="2" align="left" valign="bottom">&nbsp;</td>
							  <td height="32" colspan="2" align="left" valign="bottom">&nbsp;</td>
							  <td align="left" valign="bottom">&nbsp;</td>
							</tr>
							<tr>
							  <td height="32" colspan="2" align="left" valign="bottom">&nbsp;</td>
							  <td height="32" align="right" valign="bottom">Password Actual:&nbsp;</td>
							  <td align="left" valign="bottom"><input class="text" type="password" name="actual_pass" size="20" maxlength="25" /></td>
							  <td height="32" align="left" valign="bottom">&nbsp;</td>
							</tr>
							<tr>
							  <td height="5" colspan="5" align="left"></td>
							</tr>
							<tr>
							  <td height="32" colspan="2" align="left" valign="bottom">&nbsp;</td>
							  <td height="32" align="right" valign="bottom">Password:&nbsp;</td>
							  <td align="left" valign="bottom"><input class="text" type="password" name="add_p_chave" size="20" maxlength="25" /></td>
							  <td height="32" align="left" valign="bottom">&nbsp;</td>
							</tr>
							<tr>
							  <td height="32" colspan="2" align="left" valign="bottom"></td>
							  <td height="32" align="left" valign="bottom">Repita a Password:&nbsp;</td>
							  <td height="32" align="left" valign="bottom"><input class="text" type="password" name="add_p_chave2" size="20" maxlength="25" /></td>
							  <td height="32" align="left" valign="bottom">&nbsp;</td>
							</tr>
							<tr>
							  <td height="5" colspan="5" align="left"></td>
							</tr>
							<tr>
							  <td align="right" valign="top">&nbsp;</td>
							  <td width="30" align="right" valign="top">&nbsp;</td>
							  <td colspan="3" align="right" valign="top">
								<p>
								  <input type="hidden" name="login">
								  <input type="submit" class="button" value="<?=$l[12];?>">
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
