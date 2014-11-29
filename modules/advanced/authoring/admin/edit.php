<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (edit user)';
	exit;
endif;
$task=@$_GET['id'];
if (isset($_POST['users_Activar'])):
	$db->setquery("update users set active='s' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador foi activado</font></font>';
elseif (isset($_POST['users_Desactivar'])):
	$db->setquery("update users set active='n' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador foi desactivado</font></font>';
elseif (isset($_POST['users_del'])):
	$db->setquery("delete from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador foi apagado</font></font>';
endif;

if ( isset($_POST['name']) and isset($_POST['email']) and isset($_POST['add_user'])):
	if ($_POST['pass1']==$_POST['pass2'] and $_POST['pass1']<>''):
		if ($_POST['name']<>'' and $_POST['email']<>'' and $_POST['user_name']<>''):
			$db->setquery("update users set email='".mysql_escape_string($_POST['email'])."', nome='".mysql_escape_string($_POST['name'])."', nick='".mysql_escape_string($_POST['user_name'])."', password=PASSWORD('".mysql_escape_string($_POST['pass1'])."') where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
			if (isset($_POST['send_user_email'])):
				include_once($absolute_path."/classes/email_engine.php");
				$email = new email_engine_class;
				$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
				$email->to=$user[0][1];
				$email->from='"'.$site_name.'" <'.$staticvars['site_path'].'>';
				$email->return_path=$admin_mail;
				$email->subject="Altera&ccedil;&atilde;o dos seus dados de acesso no site:".$site_name;
				$email->preview=true;
				$email->template='edit_user';
				$email->message='A seu pedido, os novos dados de acesso ao site s&atilde;o os seguintes:
				<hr size="1">
				Nome:<br>'.mysql_escape_string($_POST['name']).'<br><br>
				E-mail de contacto:<br>'.mysql_escape_string($_POST['email']).'<br><br>
				Nickname:<br>'.mysql_escape_string($_POST['user_name']).'<br><br>
				Password:<br>'.mysql_escape_string($_POST['pass1']).'<br><br>
				<hr size="1">
				Caso os dados acima indicados n&atilde;o se encontram correctos, por favor envie-nos um email com as correc&ccedil;&otilde;es a efectuar. Obrigado.';
				echo $email->send_email($staticvars['local_root']).'<br>';
			endif;
			echo '<font class="body_text"> <font color="#FF0000">Altera&ccedil;&atilde;o efectuada com sucesso [email:'.$_POST['email'].' UserCode:'.$_POST['cod_user'].']</font></font>';
		else:
			echo '<font class="body_text"> <font color="#FF0000">Preencher todos os campos obrigatórios.</font></font>';
		endif;
	 else:
		echo '<font class="body_text"> <font color="#FF0000">As Passwords n&atilde;o coincidem.</font></font>';
	endif;
endif;
$qw=$db->getquery("select nome, email, nick, cod_user_type from users where cod_user='".mysql_escape_string($_SESSION['users_edit'])."'");

if (isset($_POST['add_pass'])):
	include_once($staticvars['local_root'].'general/pass_generator.php');	
	$pass=generate(7,'No','Yes','Yes');	
else:
	$pass='';
endif;

?>
<br />
<img src="<?=$staticvars['site_path'].'/modules/authoring/images/';?>tweak.gif"><font class="header_text_3">Altera&ccedil;&atilde;o dos dados pessoais</font>
<form name="browse_edit" class="form" enctype="multipart/form-data" action="<?=session($staticvars,'index.php?id='.$_GET['id'].'&goto='.$_GET['goto'].'&load=main.php');?>" method="post">
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
		  <td align="left" class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome:&nbsp;&nbsp;<input class="text" type="text" name="name" value="<?=$qw[0][0];?>" size="50" maxlength="255"></td>
		  <td width="20">&nbsp;</td>
		</tr>			
		<tr height="5">
		  <td width="20"></td>
		  <td></td>
		  <td width="20"></td>
		</tr>			
		<tr>
		  <td width="20">&nbsp;</td>
		  <td align="left" class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail:&nbsp;<input type="text" class="text" name="email" value="<?=$qw[0][1];?>" size="50" maxlength="255"></td>
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
		  <td align="left" class="body_text">Username:&nbsp;&nbsp;<input class="text" type="text" name="user_name" value="<?=$qw[0][2];?>" size="30" maxlength="25"></td>
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
		  <input class="text" type="password" name="pass1" value="<?=$pass;?>" size="25" maxlength="25"></td>
		  <td width="20">&nbsp;</td>
		</tr>			
		<tr height="5">
		  <td width="20"></td>
		  <td></td>
		  <td width="20"></td>
		</tr>			
		<tr>
		  <td width="20">&nbsp;</td>
		  <td><font class="body_text">Confirme a Password:</font><input class="text" type="password" name="pass2" value="<?=$pass;?>" size="25" maxlength="25"></td>
		  <td width="20">&nbsp;</td>
		</tr>			
		<tr>
		  <td width="20">&nbsp;</td>
		  <td align="right"><input class="button" type="submit" name="add_pass" value="Gerar nova password"></td>
		  <td width="20">&nbsp;</td>
		</tr>			
		<tr height="15">
		  <td width="20">&nbsp;</td>
		  <td><input type="checkbox"  class="text" name="send_user_email" />&nbsp;Enviar Email de altera&ccedil;&atilde;o ao utilizador</td>
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
		  <td align="right"><input class="button" type="submit" name="add_user" value="Gravar Dados"></td>
		  <td width="20">&nbsp;</td>
		</tr>			
		<tr height="15">
		  <td width="20">&nbsp;</td>
		  <td align="center" class="body_text"><a href="<?=session($staticvars,'index.php?id='.$_GET['id'].'&goto='.$_GET['goto'].'&load=main.php');?>">Voltar a utilizadores</a></td>
		  <td width="20">&nbsp;</td>
		</tr>			
	</table>
</form>
