<?php
$task=@$_GET['id'];
if ( isset($_POST['sendername']) and isset($_POST['senderemail']) and $_POST['senderemail']<>'' and $_POST['sendername']<>'' and
isset($_POST['receivername']) and isset($_POST['receiveremail']) and $_POST['receiveremail']<>'' and $_POST['receivername']<>''):
	include_once($staticvars['local_root'].'kernel/staticvars.php');
	// send mail
	$user=$_POST['receiveremail'];
	if (isset($_POST['COPY'])):
		$user.=', '.$_POST['senderemail'];
	endif;
	$info=$_POST['message'];
	$subject='Email de sugestão do site:'.$site_name.' enviado por '.$_POST['sendername'];
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
    <td colspan="2"><span class="style5">Email de convite enviado por '.$_POST['sendername'].'(&nbsp;'.$_POST['senderemail'].'&nbsp;)</span></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td class="style6">O '.$_POST['sendername'].' convida-o a visitar o site '.$site_name.'<br><br />
	'.$meta_description.'... e muito mais. Clique no Link abaixo e fique a conhecer-nos!<br>
	<a href="'.$staticvars['site_path'].'/index.php" targuet="_blank">'.$staticvars['site_path'].'</a><br />
	<br />
	Agradecemos a sua visita,<br />
	a equipa do '.$site_name.'
	</td>
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
	smtpmail($user,$subject,$message);
else:
	?>
	<script language="javascript">
		window.alert("Tem de preencher os campos obrigatórios todos!");
	</script>
	<?php
endif; 
