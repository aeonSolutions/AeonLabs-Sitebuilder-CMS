<?php
if(!isset($_POST['send_email']) and !isset($package)):
	// navigate to main
	$_SESSION['erro']='Error (Publish SE) - Unauthorized file acess!';
	$link=session($staticvars,'index.php?id=error');
	?>
	<script language="javascript">
		parent.location="<?=$link;?>"
	</script>
	<?php
	exit;
endif;
$task=@$_GET['id'];
include($local_pds.'../../../kernel/staticvars.php');
include($local_pds.'../../../general/smtp.php');
// send mail
if(isset($_POST['send_email']) and $_POST['send_email']<>''):
	$info=$_POST['assunto'];
else:
	$info=$package;
endif;
$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
$email=$user[0][1];
$user=$user[0][0];
$subject='Email: vara&ccedil;&atilde;o de conteúdos no site:'.$site_name;
$message='<!DOCTYPE HTML var "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style2 {
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size:17px;
}
.style5 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<table width="500"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#0099CC"><span class="style2">'.$site_name.' </span></td>
  </tr>
  <tr>
    <td height="30" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style5">Email: vara&ccedil;&atilde;o de conteúdos no site.</span></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td class="style6">'.$user.'&nbsp;(&nbsp;'.$email.'&nbsp;)</td>
  </tr>
  <tr>
    <td colspan="2"><hr size="1" color="#FF0000"></td>
  </tr>
  <tr>
    <td colspan="2">'.$info.'</td>
  </tr>
  <tr>
    <td colspan="2"><hr size="1" color="#FF0000"></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td width="300" class="style6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="justify"><span class="style6"></span></div></td>
  </tr>
</table>
</body>
</html>
';
// end of mail message
smtpmail($email,$subject,$message);
unset($message);
?>