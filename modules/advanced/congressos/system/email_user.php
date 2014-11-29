<?php 
/*
File revision date: 4-apr-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

$task=@$_GET['id'];
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
$qw=$db->getquery("select nome, email, nick, cod_user_type from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");

if (isset($_POST['send_user_email'])):
	include_once($staticvars['local_root']."email/email_engine.php");
	$email = new email_engine_class;
	$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$email->to=$user[0][1];
	$email->from=$staticvars['smtp']['admin_mail'];
	$email->return_path=$staticvars['smtp']['admin_mail'];
	$email->subject="Informa&ccedil;&atilde;o do site:".$staticvars['name'];
	$email->preview=false;
	if(is_file($staticvars['local_root'].'modules/congresssos/templates/emails/users/'.$lang.'/abstract_submission.html')):
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/users/'.$lang.'/';
		$email->template='users';
	else:
		$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/users/en/';
		$email->template='users';
	endif;
	$email->message=mysql_escape_string($_POST['user_email']);
	echo $email->send_email($staticvars).'<br>';
endif;
?>
<form name="browse_edit" enctype="multipart/form-data" action="" method="post">
<input type="hidden" name="cod_user" value="<?=$_POST['cod_user'];?>"><input type="hidden" name="users_email" value="">
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
	  <td><div align="left"><strong>E-mail</strong></div></td>
	  <td width="20">&nbsp;</td>
	</tr>			
	<tr>
	  <td width="20">&nbsp;</td>
	  <td align="left" class="body_text"><textarea name="user_email" cols="40" rows="8"></textarea></td>
	  <td width="20">&nbsp;</td>
	</tr>			
	<tr>
	  <td width="20"></td>
	  <td>&nbsp;</td>
	  <td width="20"></td>
	</tr>			
	<tr height="5">
	  <td width="20"></td>
	  <td></td>
	  <td width="20"></td>
	</tr>			
	<tr height="15">
	  <td width="20">&nbsp;</td>
	  <td></td>
	  <td width="20">&nbsp;</td>
	</tr>			
	<tr>
	  <td width="20">&nbsp;</td>
	  <td align="right"><input class="form_submit" type="submit" name="send_user_email" value="Enviar Email"></td>
	  <td width="20">&nbsp;</td>
	</tr>			
</table>
</form>
