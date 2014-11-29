<?php
$task=@$_GET['id'];
if ( isset($_POST['send_mail']) and isset($_POST['nome']) and $_POST['email']<>'' and $_POST['nome']<>''):
	include($staticvars['local_root'].'kernel/staticvars.php');
	// send mail
	$user=$_POST['nome'];
	$info=$_POST['assunto'];
	$subject='Email de contacto / sugest&atilde;o do site:'.$site_name;
	$message='
<table width="500"  border="0" align="center" cellpadding="0" cellspacing="0">
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
    <td colspan="2" class="body_text">'.$info.'</td>
  </tr>
</table>
'; // end of mail message
	include_once($absolute_path."/classes/email_engine.php");
	$email = new email_engine_class;
	$email->to='josefernandes@egreens.pt';
	$email->from=$admin_mail;
	$email->return_path=$admin_mail;
	$email->subject=$subject;
	$email->preview=false;
	$email->template='contacto';
	$email->message=$message;
	$message=$email->send_email($staticvars['local_root']);
	$_SESSION['update']= 'Recomendação enviada. Obrigado!';
else:
	$_SESSION['update']= 'Tem que preencher todos os campos.';
endif; 

?>