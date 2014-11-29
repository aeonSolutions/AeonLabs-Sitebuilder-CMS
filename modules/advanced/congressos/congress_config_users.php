<?php
/*
File revision date: 4-apr-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
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
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_POST['add_user']) or isset($_POST['edit_user'])):
	// todos os campos estao correctamente preeenchidos - fixe: adicionar a BD!
	$_SESSION['goback']=false;
	$_SESSION['erro_email']="";
	// verificaçao da password
	if ($_POST['pass1']<>$_POST['pass2'] ):
		$_SESSION['goback']=true;
		$_SESSION['erro_pass']="As passwords não coincidem!";
		echo '<font class="body_text"> <font color="#FF0000">As passwords não coincidem!</font></font>';
	endif;											
	if ( ($_POST['pass1']=='' or $_POST['pass2']=='') and isset($_POST['add_user'])):
		$_SESSION['goback']=true;
		$_SESSION['erro_pass']="Tem que indicar uma password!";
		echo '<font class="body_text"> <font color="#FF0000">As passwords não coincidem!</font></font>';
	endif;											
	//verificaçao do nome de utilizador
	$qw=$db->getquery("select nick from users where nick='".mysql_escape_string($_POST['nick'])."'");
	if ($qw[0][0]<>'' and isset($_POST['add_user'])):
		$_SESSION['goback']=true;
		//Já existe um utilizador com o nome de utilizador que escolheu.
		$_SESSION['erro_user']="Já existe um utilizador com o nome de utilizador que escolheu.";
		echo '<font class="body_text"> <font color="#FF0000">Já existe um utilizador com o nome de utilizador que escolheu.</font></font>';
	endif;
	
	//verificaçao do email
	$qw2=$db->getquery("select email from users where email='".mysql_escape_string($_POST['email'])."'");
	if ($qw2[0][0]<>'' and isset($_POST['add_user'])):
		$_SESSION['goback']=true;
		$_SESSION['erro_email']="O Email que inseriu já existe.";
		echo '<font class="body_text"> <font color="#FF0000">O Email que inseriu já existe.</font></font>';
	endif;
	if(!function_exists('checkEmail')):
		include($staticvars['local_root'].'modules/authoring/system/functions.php');
	endif;
	$not_found=checkEmail(mysql_escape_string($_POST['email']));
	if(!$not_found and isset($_POST['add_user'])):
		$_SESSION['goback']=true;
		$_SESSION['erro_email']="O Email que introduziu nao é válido.";
		echo '<font class="body_text"> <font color="#FF0000">O Email que introduziu nao é válido.</font></font>';
	endif;
	if ($_SESSION['goback']==false):
		$user=mysql_escape_string($_POST['cod_user']);
		$pass=mysql_escape_string($_POST['pass1']);
		$nome=mysql_escape_string($_POST['nome']);
		$nick=mysql_escape_string($_POST['nick']);
		$post_email=mysql_escape_string($_POST['email']);
		$user_type=mysql_escape_string($_POST['user_type']);
		if (isset($_POST['add_user'])):
			$db->setquery("insert into users set password=PASSWORD('".$pass."'), cod_user_type='".$user_type."', nome='".$nome."', nick='".$nick."', email='".$post_email."', active='?'");
			echo '<br><font class="body_text"> <font color="#FF0000">Informa&ccedil;&atilde;o adicionada.</font></font>';
			$user=$db->getquery("select nick, email, cod_user from users where password=PASSWORD('".$pass."') and nick='".$nick."'");
		else:
			if($pass==''):
				$passw="";
			else:
				$passw="password=PASSWORD('".$pass."'),";
			endif;
			$db->setquery("update users set ".$passw." cod_user_type='".$user_type."', nome='".$nome."', nick='".$nick."', email='".$post_email."' where cod_user='".$user."'");
			echo '<br><font class="body_text"> <font color="#FF0000">Informa&ccedil;&atilde;o editada.</font></font>';
			$user=$db->getquery("select nick, email, cod_user from users where cod_user='".$user."'");
		endif;
		include_once($staticvars['local_root']."email/email_engine.php");
		$email = new email_engine_class;
		$email->to=$user[0][1];
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		
		$link=$staticvars['site_path'].'/index.php?id='.return_id('login.php').'&active='.$user[0][2];
		$email->subject="Conta de acesso no ".$staticvars['name'];
		$email->preview=false;
		if(is_file($staticvars['local_root'].'modules/congresssos/templates/emails/users/'.$lang.'/abstract_submission.html')):
			$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/users/'.$lang.'/';
			$email->template='users';
		else:
			$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/users/en/';
			$email->template='users';
		endif;
		$email->message='A sua conta de acessso ao site '.$staticvars['name'].' acabou de ser criada. Após activar a conta no link disponibilizado abaixo, pode aceder a sua area reservada. Obrigado.
		<hr size="1">
		<strong>username:</strong> '.$nick.'<br>
		<strong>password:</strong> '.$pass.'
		<hr size="1">
		<a href="'.$link.'">'.$link.'</a>
		<hr size="1">
		Obrigado.';
		echo $email->send_email($staticvars);
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
if (isset($_POST['users_del_all'])):
	if (isset($_GET['uo'])):
		$to_do='&uo=true';					
		$data_year=date('Y');
		$data_month=date('m');
		$data_day=date('d');
		$data_hour=date('His');
		$data_month=$data_month-6;
		if ($data_month<0):
			$data_month=12+$data_month;
			$data_year=$data_year-1;
		endif;
		$query=$db->getquery("select data from users");
		if (strpos("-".$query[0][0]," ")):
			$data=$data_year.'-'.$data_month.'-'.$data_day;
		else:
			$data=$data_year.$data_month.$data_day;
		endif;
		$query=$db->getquery("select cod_user from users where data<'".$data."'");
		if ($query[0][0]<>''):
			for($i=0;$i<count($query);$i++):
				$db->setquery("delete from users where cod_user='".$query[$i][0]."'");
				$db->setquery("delete from sessions where cod_user='".$query[$i][0]."'");
			endfor;
			echo '<font class="body_text"> <font color="#FF0000"><strong>TODOS</strong>os utilizadores inactvos foram apagados</font></font>';
		endif;
	elseif(isset($_GET['ui'])):
		$query=$db->getquery("select cod_user from users where active='n'");
		if ($query[0][0]<>''):
			for($i=0;$i<count($query);$i++):
				$db->setquery("delete from users where cod_user='".$query[$i][0]."'");
				$db->setquery("delete from sessions where cod_user='".$query[$i][0]."'");
			endfor;
			echo '<font class="body_text"> <font color="#FF0000"><strong>TODOS</strong>os utilizadores inactvos foram apagados</font></font>';
		endif;
	endif;
endif;
if (isset($_POST['users_del'])):
	$nick=$db->getquery("select nick from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("delete from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("delete from sessions where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador,<strong>'.$nick[0][0].', </strong>foi apagado</font></font>';
endif;
if (isset($_POST['users_activar'])):
	$nick=$db->getquery("select nick from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("update users set active='s' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador,<strong>'.$nick[0][0].', </strong>foi activado</font></font>';
endif;
if (isset($_POST['users_desactivar'])):
	$nick=$db->getquery("select nick from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("update users set active='n' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador,<strong>'.$nick[0][0].', </strong>foi desactivado</font></font>';
endif;

?>
<h2><img src="modules/congressos/images/accounts_big.gif">Gestao de utilizadores</h2>
<div align="center"><a href="<?=strip_address("view",$_SERVER['REQUEST_URI']).'&view=a';?>">Ver contas de autores</a> | <a href="<?=strip_address("view",$_SERVER['REQUEST_URI']).'&view=s';?>">Ver contas de secretariado</a> | <a href="<?=strip_address("view",$_SERVER['REQUEST_URI']).'&view=r';?>">Ver contas de revisores</a> | <a href="<?=strip_address("view",$_SERVER['REQUEST_URI']).'&view=n';?>">Nova conta</a></div>
<?php
$view= isset($_GET['view']) ? $_GET['view'] : 'n';
if ( isset($_POST['users_email'])):
	include($staticvars['local_root'].'modules/congressos/system/email_user.php');
elseif(($view=='s' or $view=='r' or $view=='a') and !isset($_POST['users_edit'])):
	if($view=='s'):
		$name='secretariado';
	elseif($view=='a'):
		$name='Authenticated Users';
	else:
		$name='revisor';
	endif;
	$ut=$db->getquery("select cod_user_type from user_type where name='".$name."'");
	$query=$db->getquery("select nome, email, nick, data, active, cod_user from users where cod_user_type='".$ut[0][0]."'");
	if ($query[0][0]<>''):
		$address=strip_address('alfa',$_SERVER['REQUEST_URI']);
		echo '<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">';
		echo '<tr height="15"><td colspan="2">';
		echo '</td></tr>';
		for ($i=0;$i<count($query);$i++):
			if ($query[$i][4]=='s'):
				$tmp='Activo';
				$tmp2='desactivar';
			elseif ($query[$i][4]=='n'):
				$tmp='Inactivo';
				$tmp2='activar';
			elseif ($query[$i][4]=='?'):
				$tmp='Por Activar';
				$tmp2='activar';
			elseif ($query[$i][4]=='d'):
				$tmp='Desactivado (+6meses)';
				$tmp2='activar';
			endif;
			$last_date=$db->getquery("select data from sessions where cod_user='".$query[$i][5]."'");
			if ($last_date[0][0]<>''):
				$last_date=$last_date[0][0];
			else:
				$last_date='Never logged in';
			endif;
			echo '<tr><td><div align="left"><font class="body_text">&nbsp;&nbsp;Nick: <b>'.$query[$i][2].'</b>&nbsp;( '.$query[$i][0].' )<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email: '.$query[$i][1].'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado: '.$tmp.'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Último Login: '.$last_date.'</font></div>';
			echo'</td></tr><tr><td><form class="form" enctype="multipart/form-data" action="'.$address.'" method="post">';
			echo '<div align="right"><input class="button" name="users_edit" type="submit" value=" Editar ">&nbsp;&nbsp;<input type="hidden" name="cod_user" value="'.$query[$i][5].'"><input class="button" name="users_'.$tmp2.'" type="submit" value=" '.$tmp2.' ">&nbsp;&nbsp;<input class="button" name="users_email" type="submit" value=" Email ">&nbsp;&nbsp;<input class="button" name="users_del" type="submit" value=" Apagar "></div>';
			echo '</form></td></tr>';
			echo '<tr height="1"><td colspan="2"><hr size="1">';
			echo '</td></tr>';
		endfor;
		echo '<tr height="15"><td colspan="2">';
		echo '</td></tr></table>';
		echo'<form class="form" enctype="multipart/form-data" action="'.$address.'" method="post">';
		echo '<div align="right"><input class="button" name="users_del_all" type="submit" value=" Apagar Todos "></div>';
		echo '</form>';
	else:
		if (isset($_POST['search_query']) and $_POST['search_query']<>''):
			echo 'n&atilde;o existem utilizadores para a pesquisa: '.$_POST['search_query'];	
		else:
			echo "n&atilde;o existem utilizadores do tipo '".$name."'";	
		endif;
 endif; //query not empty

else:
?>
<form class="form" enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
<?php
if(isset($_POST['cod_user'])):
		$edit=$db->getquery("select cod_user,cod_user_type, nome, nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
		$btn='edit_user';
		if($edit[0][0]==''):
			$edit[0][0]='';
			$edit[0][1]='';
			$edit[0][2]='';
			$edit[0][3]='';
			$edit[0][4]='';
			$btn='add_user';
		else:
		echo '<input type="hidden" name="cod_user" value="'.$edit[0][0].'">';
		endif;
	else:
		$btn='add_user';
		$edit[0][0]='';
		$edit[0][1]='';
		$edit[0][2]='';
		$edit[0][3]='';
		$edit[0][4]='';
	endif;
?>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="25" valign="bottom"><div align="left"></div></td>
                  <td height="25" valign="bottom" class="body_text">&nbsp;</td>
                  <td height="25" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td width="20">&nbsp;</td>
              <td class="body_text" align="right">Os campos marcados com <font size="1" color="#FF0000">&#8226;</font> s&atilde;o obrigatórios<br>
              <?=$_SESSION['erro_email'];?>
			</td>
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
                    $query=$db->getquery("select cod_user_type, name from user_type where name='revisor' or name='secretariado' or name='Authenticated Users'");
                    $selected=0;
                    $option[0][0]='--';
                    $option[0][1]='-----------------';
                    for ($i=1;$i<=count($query);$i++):
                        $option[$i][0]=$query[$i-1][0];
                        $option[$i][1]=$query[$i-1][1];
                        if ($query[$i-1][0]==$edit[0][1]):
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
                <input class="text" type="text" name="nome" value="<?=$edit[0][2];?>" size="25" maxlength="25">
              </td>
              <td width="20">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" height="5"></td>
          </tr>			
            <tr>
              <td>&nbsp;</td>
              <td class="body_text" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">&#8226; </font>Nickname:&nbsp;&nbsp;
                      <input class="text" name="nick" type="text" id="nick" value="<?=$edit[0][3];?>" size="25" maxlength="25">
              </td>
              <td width="20">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" height="5"></td>
          </tr>			
            <tr>
              <td>&nbsp;</td>
              <td class="body_text" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">&#8226; </font>E-mail:&nbsp;&nbsp;
                      <input class="text" type="text" name="email" value="<?=$edit[0][4];?>" size="25" maxlength="255">
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
              <td align="right" class="body_text"><input class="text"  type="submit" name="add_pass" value="Gerar nova password"></td>
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
              <td align="right" class="body_text"><input class="text" type="submit" name="<?=$btn;?>" value="Gravar Dados"></td>
              <td width="20">&nbsp;</td>
            </tr>			
            <tr height="15">
              <td width="20">&nbsp;</td>
              <td class="body_text"></td>
              <td width="20">&nbsp;</td>
            </tr>			
        </table>
	</form>
<?php
endif;
?>