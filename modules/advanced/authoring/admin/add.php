<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (add user)';
	exit;
endif;
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_POST['add_user'])):
	$user=mysql_escape_string($_POST['cod_user']);
	$pass=mysql_escape_string($_POST['pass1']);
	$nome=mysql_escape_string($_POST['nome']);
	$nick=mysql_escape_string($_POST['nick']);
	$post_email=mysql_escape_string($_POST['email']);
	$user_type=mysql_escape_string($_POST['user_type']);
	if ($pass<>''):
		$db->setquery("insert into users set password=PASSWORD('".$pass."'),
		cod_user_type='".$user_type."', nome='".$nome."', nick='".$nick."', email='".$post_email."', active='?'");
		
		include_once($staticvars['local_root']."email/email_engine.php");
		$email = new email_engine_class;
		$user=$db->getquery("select nick, email, cod_user from users where password=PASSWORD('".$pass."') and nick='".$nick."'");
		$email->to=$user[0][1];
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		
		$link=$staticvars['site_path'].'/index.php?id='.return_id('login.php').'&active='.$user[0][2];
		$email->subject="Foi criada uma conta de acesso para o site ".$site_name;
		$email->preview=true;
		$email->template='create_new_user';
		$email->message='A sua conta de acessso ao site '.$site_name.' acabou de ser criada. Após activar a conta no link disponibilizado abaixo, pode aceder a sua area reservada. Obrigado.
		<hr size="1">
		<strong>username:</strong> '.$nick.'<br>
		<strong>password:</strong> '.$pass.'
		<hr size="1">
		<a href="'.$link.'">'.$link.'</a>
		<hr size="1">
		Obrigado.';
		echo $email->send_email($staticvars);
		echo '<br><font class="body_text"> <font color="#FF0000">Informa&ccedil;&atilde;o adicionada.</font></font>';
	else:
		echo '<font class="body_text"> <font color="#FF0000">O utilizador n&atilde;o foi criado. Erro de passwords</font></font>';
		$pass='O utilizador n&atilde;o foi criado!';
	endif;
endif;
if (isset($_POST['add_pass'])):
	include_once($staticvars['local_root'].'general/pass_generator.php');	
	$pass=generate(7,'No','Yes','Yes');	
else:
	$pass='';
endif;
?>
<br />
    <img src="modules/authoring/images/tweak.gif">Cria&ccedil;&atilde;o de nova conta de utilizador
    <form class="form" enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="25" valign="bottom"><div align="left"></div></td>
					  <td height="25" valign="bottom" class="body_text">&nbsp;</td>
					  <td height="25" valign="bottom">&nbsp;</td>
				</tr>
				<tr>
				  <td width="20">&nbsp;</td>
				  <td class="body_text" align="right">Os campos marcados com <font size="1" color="#FF0000">&#8226;</font> s&atilde;o obrigatórios</td>
				  <td width="20">&nbsp;</td>
				</tr>
				<tr>
                  <td>&nbsp;</td>
                  <td class="header_text_1" align="left">Dados de acesso</td>
                  <td>&nbsp;</td>
			  </tr>			
				<tr>
				  <td colspan="3" height="5"></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td class="body_text">Utilizador do tipo:&nbsp;&nbsp;<select size="1" name="user_type" class="text">
						<?php
						$query=$db->getquery("select cod_user_type, name from user_type");
						$selected=0;
						$option[0][0]='--';
						$option[0][1]='-----------------';
						for ($i=1;$i<=count($query);$i++):
							$option[$i][0]=$query[$i-1][0];
							$option[$i][1]=$query[$i-1][1];
							if ($query[$i-1][0]==$user_type):
								$selected=$i;
							endif;
						endfor;
						for ($i=0 ; $i<count($option); $i++):
							 if ($option[$i][0]=='optgroup'):
							 ?>
								<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
							 <?php
							 else:
								?>
								<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
								<?php echo $option[$i][1]; ?></option>
							<?php
							endif;
						endfor; ?>
					</select>&nbsp;&nbsp; 
					</td>
				  <td>&nbsp;</td>
			  </tr>
				<tr>
                  <td colspan="3" height="5"></td>
			  </tr>
				<tr>
				  <td width="20">&nbsp;</td>
				  <td class="body_text" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">&#8226; </font>Nome:&nbsp;&nbsp;
				    <input class="text" type="text" name="nome" value="<?=$nome;?>" size="25" maxlength="25">
				  </td>
				  <td width="20">&nbsp;</td>
				</tr>
				<tr>
                  <td colspan="3" height="5"></td>
			  </tr>			
				<tr>
				  <td>&nbsp;</td>
				  <td class="body_text" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">&#8226; </font>Nickname:&nbsp;&nbsp;
                          <input class="text" name="nick" type="text" id="nick" value="<?=$nick;?>" size="25" maxlength="25">
                  </td>
				  <td width="20">&nbsp;</td>
				</tr>
				<tr>
                  <td colspan="3" height="5"></td>
			  </tr>			
				<tr>
				  <td>&nbsp;</td>
				  <td class="body_text" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">&#8226; </font>E-mail:&nbsp;&nbsp;
                          <input class="text" type="text" name="email" value="<?=$post_email;?>" size="25" maxlength="255">
                  </td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="5">
				  <td width="20"></td>
				  <td class="body_text"></td>
				  <td width="20"></td>
				</tr>			
				<tr>
				  <td width="20">&nbsp;</td>
				  <td class="body_text"><HR noShade SIZE=1></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="5">
				  <td width="20"></td>
				  <td class="body_text"></td>
				  <td width="20"></td>
				</tr>			
				<tr height="5">
				  <td width="20"></td>
				  <td class="body_text"></td>
				  <td width="20"></td>
				</tr>			
				<tr>
				  <td width="20">&nbsp;</td>
				  <td class="body_text"><font color="#FF0000">&#8226; </font>Password:
				  <input class="text" type="password" name="pass1" value="<?=$pass;?>" size="25" maxlength="25"></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="5">
				  <td width="20"></td>
				  <td class="body_text"></td>
				  <td width="20"></td>
				</tr>
				<tr>
                  <td colspan="3" height="5"></td>
			  </tr>			
				<tr>
				  <td width="20">&nbsp;</td>
				  <td class="body_text">Confirme a Password:<input class="text" type="password" name="pass2" value="<?=$pass;?>" size="25" maxlength="25"></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr>
				  <td width="20">&nbsp;</td>
				  <td align="right" class="body_text"><input class="text" class="form_submit" type="submit" name="add_pass" value="Gerar nova password"></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="15">
				  <td width="20">&nbsp;</td>
				  <td class="body_text"></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr>
				  <td width="20">&nbsp;</td>
				  <td class="body_text"><HR noShade SIZE=1></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="15">
				  <td width="20">&nbsp;</td>
				  <td class="body_text"></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr>
				  <td width="20">&nbsp;</td>
				  <td align="right" class="body_text"><input class="text" class="form_submit" type="submit" name="add_user" value="Gravar Dados"></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="15">
				  <td width="20">&nbsp;</td>
				  <td class="body_text"></td>
				  <td width="20">&nbsp;</td>
				</tr>			
			</table>
	</form>