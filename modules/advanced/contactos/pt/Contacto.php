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
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
if (isset($_GET['id'])):
	$task=$_GET['id'];
endif;
if ( isset($_POST['send_mail']) and isset($_POST['nome']) and $_POST['email']<>'' and $_POST['nome']<>''):
	include($staticvars['local_root'].'modules/contactos/'.$lang.'/send_mail.php');
	echo '<font color="red">Email Enviado. Prometemos ser breves na resposta. Obrigado!</font>';
endif;
?>
<style>
	H3 {
		font : bold 17px Verdana, Arial, Helvetica, sans-serif;
		margin : 0px 0px 0px 0px;
		color: #222222;
	}
.sobre_nos {
	FONT-SIZE: 11px;
	COLOR: #666666;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
.about_links {
	COLOR: #0056af;
	TEXT-DECORATION: none
}
</style>
<table  border="0" class="newtable" width="100%" cellspacing="0" cellpadding="5">
      <tr>
        <td height="30"><h3><img src="<?=$staticvars['site_path'];?>/modules/contactos/images/icon.gif" width="37" height="34" align="absbottom" />Contacto</h3>
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
              <tr>
                <td valign="top"><br />
                    <img alt="email" src="<?=$staticvars['site_path'];?>/modules/contactos/images/email.gif" align="left" border="0" hspace="15" /><br />                </td>
                <td valign="top"><p><br />
                  Caso tenha alguma d&uacute;vida ou deseje ser contactado pessoalmente preencha o seguinte formul&aacute;rio.<br />
Deixe o seu nome e o seu contacto assim como o motivo.<br />
Prometemos ser breves na resposta.</p></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      
		<tr>
		<td>
            <form method="POST" action="<?=session($staticvars,'index.php?id='.$task);?>">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
				  <tr>
				    <td height="30" colspan="2" class="sobre_nos">&nbsp;</td>
			      </tr>
				  <tr>
					<td width="150" class="sobre_nos">
					  <div align="right">Nome</div></td>
					<td width="77%" class="sobre_nos">
					<input class="textfield" type="text" name="nome" size="50"></td>
				  </tr>
				  <tr>
				    <td colspan="2" class="sobre_nos" height="10"></td>
			      </tr>
				  <tr>
					<td width="150" class="sobre_nos">
					  <div align="right"></div></td>
					<td width="77%" class="sobre_nos"></td>
				  </tr>
				  <tr>
                    <td colspan="2" class="sobre_nos" height="10"></td>
			      </tr>
				  <tr>
					<td width="150" class="sobre_nos">
					  <div align="right">Email</div></td>
					<td width="77%" class="sobre_nos">
					<input class="textfield" type="text" name="email" size="30"></td>
				  </tr>
				  <tr>
                    <td colspan="2" class="sobre_nos" height="10"></td>
			      </tr>
				  <tr>
					<td width="150" class="sobre_nos"></td>
					<td width="77%" class="sobre_nos">					</td>
				  </tr>
				  <tr>
                    <td colspan="2" class="sobre_nos" height="10"></td>
			      </tr>
				  <tr>
					<td width="150" valign="top" class="sobre_nos">
				    <div align="right">Assunto</div></td>
					<td width="77%" class="sobre_nos">
					<textarea class="textfield" rows="13" name="assunto" cols="50"></textarea>
					<br>
					<br>
					<div align="right"><INPUT name="send_mail" type="submit" value="Enviar" class="form_submit"></div>					</td>
				  </tr>
				</table>
				<p>&nbsp;</p>
         </form>		</td>
      </tr>
      </table>
