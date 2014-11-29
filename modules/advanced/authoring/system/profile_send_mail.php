<?php
function manda_info($pass1,$user,$email_to){
$task=@$_GET['id'];
include('kernel/staticvars.php');
// send mail
$subject='Informa&ccedil;&atilde;o do site:'.$staticvars['name'];
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
    <td colspan="2" bgcolor="#0099CC"><span class="style2">'.$staticvars['name'].' </span></td>
  </tr>
  <tr>
    <td height="30" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style5">Altera&ccedil;&atilde;o de dados do utilizador : </span></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td width="300" class="style6">'.$user.'</td>
  </tr>
  <tr>
    <td colspan="2"><hr size="1" color="#FF0000"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left"><strong>Dados de acesso: </strong></div></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Password:</strong>'.$pass1.'</td>
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
include_once($staticvars['local_root']."/email/email_engine.php");
$email = new email_engine_class;
$email->to=$email_to;
$email->from=$staticvars['smtp']['admin_mail'];
$email->return_path=$staticvars['smtp']['admin_mail'];
$email->subject=$subject;
$email->preview=false;
$email->template='edit_user';
$email->message=$message;
$message=$email->send_email($staticvars);
echo '<font style="font-size:x-small"> <font color="#FF0000">'.$message.'</font></font>';
$_SESSION['update']= 'Registo no site efectuado com sucesso';
};
?>
