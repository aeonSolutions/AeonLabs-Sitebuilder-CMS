<?php
$task=@$_GET['id'];
if ( isset($_POST['send_mail']) and isset($_POST['nome']) and $_POST['email']<>'' and $_POST['nome']<>''):
	include($staticvars['local_root'].'kernel/staticvars.php');
	// send mail
	$user=$_POST['nome'];
	$info=$_POST['assunto'];
	$subject='Email de contacto / sugest&atilde;o do site:'.$site_name;
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
    <td colspan="2"><span class="style5">Email de contacto / Sugestao:</span></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td class="style6">'.$user.'&nbsp;(&nbsp;'.$_POST['email'].'&nbsp;)</td>
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
	include($staticvars['local_root'].'general/smtp.php');
	smtpmail($admin_mail,$subject,$message);
	?>
	<script language="javascript">
		window.alert("Your Email was successfully sent!");
	</script>
	<?php
elseif (isset($_POST['nome']) and isset($_POST['email']) and isset($_POST['assunto'])):
		$message = ' ASSUNTO:\n'.$_POST['assunto'].'\n Email de resposta:\n      '.$_POST['email']
		.'\n Telefone:\n       '.$_POST['telef'].'\n Telémovel:\n          '.$_POST['tele']
		.'\n Hor&aacute;rio de Contacto:\n            '.$_POST['hor&aacute;rio'];	   	    	 
		 
	include('../../kernel/staticvars.php');
	// send mail
	$user=$_POST['name'];
	$info=$_POST['user_email'];
	$subject=$site_name." - Contacto de Compra / Venda de um utilizador do site";	
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
    <td colspan="2"><span class="style5">Email de contacto / Sugestao:</span></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td class="style6">'.$user.'&nbsp;(&nbsp;'.$_POST['email'].'&nbsp;)</td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td class="style6">ASSUNTO:&nbsp;'.$_POST['assunto'].'<br> Email de resposta:&nbsp;      '.$_POST['email']
		.'<br> Telefone:&nbsp;       '.$_POST['telef'].'<br> Telémovel:&nbsp;          '.$_POST['tele']
		.'<br> Hor&aacute;rio de Contacto:&nbsp;            '.$_POST['hor&aacute;rio'].'</td>
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
	smtpmail($admin_mail,$subject,$message);
	?>
	<script language="javascript">
		window.alert("Email enviado! Prometemos Ser breves.");
	</script>
	<?php

else:
	?>
	<script language="javascript">
		window.alert("Tem de preencher os campos obrigatórios todos!");
	</script>
	<?php
endif; 

nav(session($staticvars,"../../index.php"));

function nav($location){
?>
<script>
	document.location.href="<?=$location;?>"
</script>
<?php
};
