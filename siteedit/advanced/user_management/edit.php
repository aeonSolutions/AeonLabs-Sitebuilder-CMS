<?php 
$task=@$_GET['id'];
if (isset($_POST['users_Activar'])):
	$db->setquery("update users set active='s' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	?>
	<script language="javascript">
	 document.location.href="<?=session_setup($globvars,'index.php?id='.$task);?>"
	</script>
	<?php					
elseif (isset($_POST['users_Desactivar'])):
	$db->setquery("update users set active='n' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	?>
	<script language="javascript">
	document.location.href="<?=session_setup($globvars,'index.php?id='.$task);?>"
	</script>
	<?php					
elseif (isset($_POST['users_del'])):
	$db->setquery("delete from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	?>
	<script language="javascript">
	document.location.href="<?=session_setup($globvars,'index.php?id='.$task);?>"
	</script>
	<?php					
endif;
$skin=@$_GET['css'];
$type=@$_GET['type'];
$alfa=@$_GET['alfa'];
if ($type==''):
	$type=3;
endif;
if ($alfa==''):
	$alfa='-1';
endif;
?>


<table class="main_module_table_body" width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3">
		<table class="main_module_table_header" width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td> <div align="center"><b>Manuten&ccedil;&atilde;o de utilizadores</b></div></td>
		  </tr>
		  </table>
	</td>
  </tr>
		
	<tr>
		<td height="25" colspan="3" valign="bottom"><div align="center"></div></td>
		  </tr>
		  <tr>
			<td width="20">&nbsp;
			</td>
		    <td>
			<?php
			if ( isset($_POST['name']) and isset($_POST['email'])):
				if ($_POST['pass1']==$_POST['pass2'] and $_POST['pass1']<>''):
					if ($_POST['name']<>'' and $_POST['email']<>'' and $_POST['user_name']<>''):
						$db->setquery("update users set email='".mysql_escape_string($_POST['email'])."', nome='".mysql_escape_string($_POST['name'])."', nick='".mysql_escape_string($_POST['user_name'])."', password=PASSWORD('".mysql_escape_string($_POST['pass1'])."') where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
						send_mail($_POST['email'],$_POST['user_name'],$_POST['pass1'],$globvars);
						?>
						<script language="javascript">
							window.alert("Altera&ccedil;&atilde;o efectuada com sucesso.<?='email:'.$_POST['email'].' code:'.$_POST['cod_user'];?>");
							document.location.href="<?=session_setup($globvars,'index.php?id='.$task);?>"
						</script>
						<?php					
					else:
						?>
						<script language="javascript">
							window.alert("Preencher todos os campos obrigatórios.");
						</script>
						<?php
					endif;
				 else:
					?>
					<script language="javascript">
						window.alert("As Passwords n&atilde;o coincidem.");
					</script>
					<?php
				endif;
			endif;
			if (isset($_SESSION['users_edit'])): // editar utilizador
				$qw=$db->getquery("select nome, email, nick, cod_user_type from users where cod_user='".mysql_escape_string($_SESSION['users_edit'])."'");
				if (isset($_POST['add_pass'])):
					include($globvars['local_root'].'copyfiles/advanced/general/pass_generator.php');	
					$pass=generate(7,'No','Yes','Yes');	
				else:
					$pass='';
				endif;
				?>
			<img src="<?=$globvars['site_path'].'/siteedit/advanced/user_management/';?>tweak.gif">Altera&ccedil;&atilde;o de dados pessoais
				<form name="browse_edit" enctype="multipart/form-data" action="<?=session_setup($globvars,'index.php?id='.$task);?>" method="post">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="25" valign="bottom"><div align="left"></div></td>
							  <td height="25" valign="bottom">&nbsp;</td>
							  <td height="25" valign="bottom">&nbsp;</td>
						</tr>
						<tr>
						  <td width="20">&nbsp;</td>
						  <td><div align="right"><font class="form_title">Os campos marcados com <font size="1" color="#FF0000">&#8226;</font> s&atilde;o obrigatórios</font></div></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td align="left" class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome:&nbsp;&nbsp;<input type="text" name="name" value="<?=$qw[0][0];?>" size="50" maxlength="255"></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td align="left" class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail:&nbsp;&nbsp;<input type="text" name="email" value="<?=$qw[0][1];?>" size="50" maxlength="255"></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr height="5">
						  <td width="20"></td>
						  <td></td>
						  <td width="20"></td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td><HR noShade SIZE=1></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr height="5">
						  <td width="20"></td>
						  <td></td>
						  <td width="20"></td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td><div align="left"><font class="form_title"><strong>Dados de acesso</strong></font></div></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td align="left" class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username:&nbsp;&nbsp;<input type="text" name="user_name" value="<?=$qw[0][2];?>" size="30" maxlength="25"></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr>
						  <td width="20"></td>
						  <td><input type="hidden" name="cod_user" value="<?=$_SESSION['users_edit'];?>"><input type="hidden" name="users_edit"></td>
						  <td width="20"></td>
						</tr>			
						<tr height="5">
						  <td width="20"></td>
						  <td></td>
						  <td width="20"></td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td><font class="body_text"><font color="#FF0000">&#8226; </font>Password:</font>
						  <input type="password" name="pass1" value="<?=$pass;?>" size="25" maxlength="25"></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr height="5">
						  <td width="20"></td>
						  <td></td>
						  <td width="20"></td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td><font class="body_text">Confirme a Password:</font><input type="password" name="pass2" value="<?=$pass;?>" size="25" maxlength="25"></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td align="right"><input class="form_submit" type="submit" name="add_pass" value="Gerar nova password"></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr height="15">
						  <td width="20">&nbsp;</td>
						  <td></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td><HR noShade SIZE=1></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr height="15">
						  <td width="20">&nbsp;</td>
						  <td></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr>
						  <td width="20">&nbsp;</td>
						  <td align="right"><input class="form_submit" type="submit" name="add_user" value="Gravar Dados"></td>
						  <td width="20">&nbsp;</td>
						</tr>			
						<tr height="15">
						  <td width="20">&nbsp;</td>
						  <td align="center" class="body_text"><a href="<?=session_setup($globvars,'');?>">Voltar a utilizadores</a></td>
						  <td width="20">&nbsp;</td>
						</tr>			
					</table>
				</form>
				<?php
				endif;
				?>
			</td>
		    <td width="20">&nbsp;</td>
		  </tr>
		  <tr>
		    <td height="25" colspan="3" valign="bottom"><div align="center"></div></td>
		  </tr>
		  <tr>
			<td width="20">&nbsp;
			</td>
		    <td>
			<?php
			if (isset($_POST['send_mail'])):
			 // por aqui include da funcao de envio de mail
			endif;
			if (isset($_POST['users_email']) and isset($_POST['cod_user'])): // editar utilizador
				include('classes/forms_class.php');
				include('general/staticvars.php');
				$forms =  &new forms_class;
				$forms->legend_css='form_legend';
				$forms->input_css='form_input';
				$forms->title_css='form_title';
				$forms->submit_css='form_submit';
				$qw=$db->getquery("select nome, email, nick, cod_user_type from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
				$forms->start('form_browse_edit',session_setup($globvars,'modules/users/send_mail.php?&id='.$task),'.: Enviar Email ao utilizador :.','5');
				$forms->add_text('<div align="left"><font class="form_title"><strong>Dados Pessoais:</strong></font></div>');
				$forms->textfield('inline','<font size="1" color="#FF0000">&#8226; </font>Nome:','name','50','200',$qw[0][0],'left');
				$forms->textfield('inline','<font size="1" color="#FF0000">&#8226; </font>E-mail:','email','50','200',$qw[0][1],'left');
				$forms->space(15);
				$forms->add_text("<HR noShade SIZE=1>");
				$forms->space(15);
				$forms->add_text('<div align="left"><font class="form_title"><strong>Email:</strong></font></div>');
				$forms->textarea('inline','','user_email','5','50','','left');
				$forms->add_text('<input type="hidden" name="cod_user" value="'.$_POST['cod_user'].'"><input type="hidden" name="users_email">');
				$forms->space(15);
				$forms->submit('send_mail','     Enviar     ','center');
				$forms->space(15);
				$forms->add_text("<HR noShade SIZE=1>");
				$forms->add_text('<div align="center"><font class="form_title"><strong><a href="'.session_setup($globvars,'index.php?id=34').'">Voltar a Utilizadores</a></strong></font></div>');
				$forms->add_text("<HR noShade SIZE=1>");
				$forms->close('');
			endif;
			?>
			</td>
		    <td width="20">&nbsp;</td>
		  </tr>
		  <tr>
		    <td height="25" colspan="3" valign="bottom"><div align="center"></div></td>
		  </tr>
</table>

<?php
function send_mail($email,$user,$pass,$globvars){
$task=@$_GET['id'];
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
include($globvars['site']['directory'].'kernel/staticvars.php');
// send mail
$subject='Recupera&ccedil;&atilde;o de Utilizador e password do site:'.$site_name;
$message='<!DOCTYPE HTML var "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="500"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#0099CC"><font style="color: #FFFFFF;	font: Arial, Helvetica, sans-serif;	font-weight: bold;">Recupera&ccedil;&atilde;o dos dados de utilizador do site: '.$site_name.' </font></td>
  </tr>
  <tr>
    <td height="30" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; ">Nome do utilizador: </div></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td width="300"><div style="font-family: Arial, Helvetica, sans-serif;	font-size: 12px; ">'.$user.'</div></td>
  </tr>
  <tr>
    <td colspan="2"><div style="font-family: Arial, Helvetica, sans-serif;	font-size: 12px; ">Password:</div></td>
  </tr>
  <tr>
    <td width="100">&nbsp;</td>
    <td width="300"><div style="font-family: Arial, Helvetica, sans-serif;	font-size: 12px; ">'.$pass.'</div></td>
  </tr>
  <tr>
    <td height="30" colspan="2"><hr size="1" color="#FF0000"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="justify" style="font-family: Arial, Helvetica, sans-serif;	font-size: 12px;  "><strong>Nota:</strong> esta password foi gerada autom&aacute;ticamente, no pedido de recupera&ccedil;&atilde;o de password, para alterar a password, autentique-se no '.$site_name.' e altere a password em <strong><em>o meu perfil</em></strong></div></td>
  </tr>
</table>
</body>
</html>'; // end of mail message
include($globvars['local_root'].'copyfiles/advanced/general/email/smtp.php');
//smtpmail($email,$subject,$message);
};
?>

