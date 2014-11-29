<?php
/*
File revision date: 20-Ago-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
include($local_root.'general/staticvars.php');
$task=@$_GET['id'];
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
@session_start();
@include_once('../../kernel/functions.php');
if ( isset($_POST['send_mail']) and isset($_POST['user_email'])):
	include('../../general/staticvars.php');
	// send mail
	$user=$_POST['name'];
	$info=$_POST['user_email'];
	$subject='Informa&ccedil;&atilde;o do site:'.$site_name;
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
    <td colspan="2"><span class="style5">Informa&ccedil;&atilde;o ao utilizador : </span></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td width="300" class="style6">'.$user.'</td>
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
'; // end of mail message
	include('../../general/smtp.php');
	smtpmail($_POST['email'],$subject,$message);
else:
	?>
	<script language="javascript">
		window.alert("erro ao enviar Email!");
	</script>
	<?php
endif; 
?>
<script language="javascript">
	window.alert("Email enviado!");
	document.location.href="<?=session_setup($globvars,'../../index.php?id=34');?>"
</script> 
