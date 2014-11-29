<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if (isset($_POST['termo'])):
	if (isset($_POST['email_alert'])):
		$db->setquery("insert into dictionary set termo='".mysql_escape_string($_POST['termo'])."', definicao='".mysql_escape_string($_POST['descricao'])."', email='".mysql_escape_string($_POST['email'])."'");
	else:
		$db->setquery("insert into dictionary set termo='".mysql_escape_string($_POST['termo'])."', definicao='".mysql_escape_string($_POST['descricao'])."'");
	endif;
	unset($_POST);
	$_SESSION['update']='Caso seja aprovada, será publicada no dicionário. Obrigado por ter participado!';
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);
endif;
if (isset($_SESSION['user'])):
	$email="Email:&nbsp;<input type='hidden' name='email' value='".$credentials['user']['email']."'><input name='email2' type='text' size='30' maxlength='255' value='".$credentials['user']['email']."' disabled='diabled' class='body_text'>";
else:
	$email="Email:&nbsp;<input name='email' type='text' size='30' maxlength='255' class='body_text'>";
endif;
?>
<script language="javascript">
function add_email(){

var box = window.document.propose.email_alert;
  if (box.checked == false) {
	document.getElementById('email_alert_tag').innerHTML="<input type='hidden' name='email' value=''>";
  } else {
	document.getElementById('email_alert_tag').innerHTML="<?=$email;?>";
  }
};
</script>
<div id="module-border">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Prop&ocirc;r palavra no dicion&aacute;rio</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
      </TR>
    <TR>
      <TD vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/dictionary/images/puzzle-pieces.gif" alt="" width="32" height="26"><BR></TD>
      <TD vAlign=bottom>Caso conhe&ccedil;a algum termo t&eacute;cnico, ou mesmo g&iacute;ria do engenheiro, que n&atilde;o se encontre listado no dicion&aacute;rio pode prop&ocirc;r &agrave; equipa do Construtec que a adicione.<br>
        <br>
        Obrigado pela sua participa&ccedil;&atilde;o!</TD>
    </TR>
  </TBODY>
</TABLE>
<form name="propose" method="post" action="<?=session($staticvars,'index.php?id='.@$_GET['id'].'&update=34');?>" enctype="multipart/form-data">
  <table width="100%" border="0">
    <tr>
      <td width="10%">&nbsp;</td>
      <td width="90%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Palavra&nbsp;</td>
      <td><label>
        <input name="termo" type="text" id="termo" size="30" maxlength="255" class='body_text'>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Descri&ccedil;&atilde;o&nbsp;</td>
      <td><label>
        <textarea name="descricao" cols="50" rows="3" wrap="virtual" id="descricao" class='body_text'></textarea>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><input type="checkbox" name="email_alert" id="email_alert" onclick="javascript:add_email();" />
      Quero ser avisado por email da publica&ccedil;&atilde;o no dicion&aacute;rio
        <div id="email_alert_tag"><input type='hidden' name='email' value=''></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right"><input type="submit" name="add_term" id="add_term" value="Submeter palavra" class="form_submit"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</div>