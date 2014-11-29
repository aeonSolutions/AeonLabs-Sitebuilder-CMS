<?php 
/*
File revision date: 1-Set-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;

$task=@$_GET['id'];
if (isset($_GET['type'])):
	$type=mysql_escape_string(@$_GET['type']);
else:
	$type='';
endif;
$message='';
$_SESSION['local_root']=$staticvars['local_root'];
if (isset($_POST['item_apagar'])):
	$info=$db->getquery("select titulo, descricao, content from items where cod_item='".mysql_escape_string($_POST['code'])."'");
	//$db->setquery("delete from items where cod_item='".mysql_escape_string($_POST['code'])."'");
	$package='O seu contributo no directório n&atilde;o foi autorizado para publica&ccedil;&atilde;o no nosso site.';
	$user=$db->getquery("select cod_user_type from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$user=$db->getquery("select name from user_type where cod_user_type='".$user[0][0]."'");
	if ($user=='Estudante'):
		$db->setquery("update user_student set downloads='10' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	endif;
	include_once($absolute_path."/classes/email_engine.php");
	$email = new email_engine_class;
	$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$email->to=$user[0][1];
	$email->from='"'.$site_name.'" <'.$admin_mail.'>';
	$email->return_path=$admin_mail;
	
	$email->subject="publica&ccedil;&atilde;o de conteúdos no site:".$site_name;
	$email->preview=true;
	$email->template='publish_contents_error';
	$email->message='Foram encontrados erros na submiss&atilde;o  '.$info[0][2].'  ao directório.<br>
	Por favor verifique se preencheu adequadamente todos os campos ou se viola os termos de utiliza&ccedil;&atilde;o do site.
	<hr size="1">
	Titulo:<br>'.$info[0][0].'<br><br>
	Descri&ccedil;&atilde;o:<br>'.$info[0][1].'<br><br>
	<hr size="1">
	Obrigado.';
	$message='Item apagado! - '.$email->send_email($staticvars['local_root']);
elseif (isset($_POST['item_activar'])):
	$db->setquery("update items set active='s' where cod_item='".mysql_escape_string($_POST['code'])."'");

	$item_details=return_id('ds_main.php');
	include($absolute_path."/classes/email_engine.php");
	$email = new email_engine_class;

	$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$info=$db->getquery("select titulo, descricao, content from items where cod_item='".mysql_escape_string($_POST['code'])."'");

	$email->to=$user[0][1];
	$email->from='"'.$site_name.'" <'.$staticvars['site_path'].'>';
	$email->return_path="<".$admin_mail.">";
	
	$email->subject="publica&ccedil;&atilde;o de conteúdos no site:".$site_name;
	$email->preview=true;
	$email->template='publish_contents_ok';
	$email->message='Foi aceite para publica&ccedil;&atilde;o no  directório: '.$info[0][2].'.<br>
	<hr size="1">
	<strong>Titulo:</strong><br>'.$info[0][0].'<br><br>
	<strong>Descri&ccedil;&atilde;o:</strong><br>'.$info[0][1].'<br><br>
	<hr size="1">
	para visualizar clique no seguinte endere&ccedil;o:<br>
	<a href="'.$staticvars['site_path'].'index.php?id='.$item_details.'&cod='.mysql_escape_string($_POST['code']).'">'.$staticvars['site_path'].'index.php?id='.$item_details.'&cod='.mysql_escape_string($_POST['code']).'</a><br>
	Obrigado por participar e Bons Downloads!';
	$message='Item publicado! - '.$email->send_email($staticvars['local_root']);
	if (return_id('email_alert.php')<>-1): // alerts are instaled
		$publish=$db->getquery("select cod_alerts from alerts where linked_to='items'");
		if ($publish[0][0]<>''):
			for($i=0;$i<count($publish);$i++):
				$emails=$db->getquery("SELECT name,email FROM users WHERE cod_user IN (SELECT cod_user FROM from alerts_users where cod_alerts='".$publish[$i][0]."')");
				if ($emails[0][0]<>''):
					$email->from='"'.$site_name.'" <'.$staticvars['site_path'].'>';
					$email->return_path="<".$admin_mail.">";
					$email->subject="Novos Programas/Documentos para download:".$site_name;
					$email->preview=false;
					$email->template='alert_items';
					$email->message='Foi adicionado ao  directório uma nova entrada submetido por '.$user[0][0].'.<br>
					<hr size="1">
					<strong>Titulo:</strong><br>'.$info[0][0].'<br><br>
					<strong>autor:</strong><br>'.$info[0][2].'<br><br>
					<strong>Descri&ccedil;&atilde;o:</strong><br>'.$info[0][1].'<br><br>
					<hr size="1">';
					for($j=0;$j<count($emails);$j++):
						$email->to=$emails[$j][1];
						$email->send_email($staticvars['local_root']);
					endfor;
				endif;
			endfor;
		endif;
	endif;
elseif(isset($_POST['send_email']) and !isset($_POST['back'])):
	include_once($absolute_path."/classes/email_engine.php");
	$email = new email_engine_class;

	$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");

	$email->to=$user[0][1];
	$email->from='"'.$site_name.'" <'.$staticvars['site_path'].'>';
	$email->return_path="<".$admin_mail.">";
	
	$email->subject="Publica&ccedil;&atilde;o de conteúdos no site:".$site_name;
	$email->preview=true;
	$email->template='publish_contents';
	$email->message=$_POST['assunto'];
	$message='Email - '.$email->send_email($staticvars['local_root']);
endif;
$_SESSION['publicar_items']=true;
include($staticvars['local_root'].'modules/directory/system/settings.php');
?>
<img src="<?=$staticvars['site_path'].'/modules/directory';?>/images/publish.gif" /><font class="Header_text_4">Publica&ccedil;&atilde;o de conte&uacute;dos</font><br />
<?php
if (!$enable_publish):
	?>
	<table  width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
	  <td height="25" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="5" align="right" valign="middle" class="body_text"><img src="<?=$staticvars['site_path'].'/modules/directory';?>/images/warning.gif" /></td>
	    <td align="center" class="body_text"><font color="#FF0000"><strong>A activa&ccedil;&atilde;o da publica&ccedil;&atilde;o de conte&uacute;dos encontra-se desactivada.<br />
		  Para alterar, reconfigure as defini&ccedil;&otilde;es gerais do sistema C.M.S.</strong></font></td>
	  </tr>
	  </table>
	  <?php
else:
	?>
	<table  width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="center" colspan="3" height="5" class="body_text"><font color="#FF0000"><?=$message;?></font></td>
	  </tr>
	  <tr>
	  <td colspan="3" align="center">
	  <?php
	   $itemtypes=$db->getquery("select cod_items_types, tipos from items_types");
		$address=$_SERVER['REQUEST_URI'];
		for ($i=0;$i<count($itemtypes);$i++):
			$address=str_replace("&type=".$itemtypes[$i][1],"",$address);
		endfor;
		if ($itemtypes[0][0]<>''):
			echo '| ';
			for ($i=0;$i<count($itemtypes);$i++):
				echo '<a class="body_text" href="'.$address.'&type='.$itemtypes[$i][1].'" target="_self">'.$itemtypes[$i][1].'</a> | ';
			endfor;
		endif;
	  ?>
		<hr size="1" />
	  </td>
	  </tr>
		<tr>
			<td height="25" colspan="3" valign="bottom"><div align="center"></div></td>
	  </tr>
			  <tr>
				<td width="20">&nbsp;
				</td>
				<td><?php
				if(isset($_POST['users_email'])):
					include($local_pds.'publish_items_email.php');
				elseif($type<>''):
					publica($type,$staticvars);
				else:
					display_publish_info($staticvars);
				endif;
				?></td>
				<td width="20">&nbsp;</td>
			  </tr>
	</table>
<?php
endif;


function display_publish_info($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$itemtypes=$db->getquery("select cod_items_types, tipos from items_types");
$address=str_replace("&type=","",$_SERVER['REQUEST_URI']);
echo '<br /><font class="body_text">';
if ($itemtypes[0][0]<>''):
	for ($i=0;$i<count($itemtypes);$i++):
		$nums=$db->getquery("select cod_item from items where cod_items_types='".$itemtypes[$i][0]."' and active='?'");
		if ($nums[0][0]<>''):
			$nums=count($nums);
			echo '<img src="'.$staticvars['site_path'].'/modules/directory/images/flash.gif" border="0" /> existem '.$nums.' '.$itemtypes[$i][1].' para publicar<br />';
		endif;
	endfor;
else:
		echo '<font class="body_text">N&atilde;o existem tipos de conteúdos definidos de momento.<br>';
endif;
echo '</font>';
};


function publica($type,$staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$edit_item=return_id('ds_my_items.php');
$task=@$_GET['id'];
$query4=$db->getquery("select titulo,active,cod_item, cod_category, cod_user,content,cod_items_types from items where active='?' and tipo='".$type."'");
$itemtypes=$db->getquery("select nome from items_types where cod_items_types='".$query4[0][6]."'");
if (@$query4[0][1]<>''):
	?>
	<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr height="15"><td colspan="2"></td></tr>
	<tr><td colspan="2"><font class="header_text_1"><?=$itemtypes[0][0];?></font></td></tr>
	<tr><td colspan="2"><hr size="1"></td></tr>
	<tr><td colspan="2">
	<?php
	$total=count($query4);
	$lower=@$_GET['lower'];
	$upper=@$_GET['upper'];
	if ($lower==''):
		$lower=1;
	endif;
	if ($upper==''):
		$upper=15;
	endif;
	$up=$upper;
	put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
	if ($up > ($total-1)):
		$up=($total-1);
	endif;
	for ($i=($lower-1);$i<=$up;$i++):
		$user=$db->getquery("select nick from users where cod_user='".$query4[$i][4]."'");
		if (strpos("-".$query4[$i][5],"http")):
			$tmp='<a href="'.$query4[$i][5].'" target="_blank">'.$query4[$i][5].'</a>';
		else:
			$tmp='<a href="'.$upload_path.'/items/'.$query4[$i][5].'">'.$query4[$i][5].'</a>';
		endif;
		?>
		<form action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" method="post">
		<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td align="left">
		  <font class="body_text">&nbsp;&nbsp;Título: <a href="<?=session($staticvars,'index.php?type='.$type.'&id='.$edit_item.'&code='.$query4[$i][2]);?>"><b>[ <?=$query4[$i][0];?> ]</b></a><br>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Colocado por: <?=$user[0][0];?><br>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$type;?>:<?=$tmp;?></font>
		  </td>
		  <td align="center">
		 <input type="hidden" name="code" value="<?=$query4[$i][2];?>">
		 <input type="hidden" name="cod_user" value="<?=$query4[$i][4];?>">
		 <input class="form_submit" name="item_activar" type="submit" value=" Activar ">&nbsp;&nbsp;
		 <input class="form_submit" name="item_apagar" type="submit" value=" Apagar ">&nbsp;&nbsp;
		 <input class="form_submit" name="users_email" type="submit" value=" Email ">
		 </td></tr>
		 <tr><td colspan="2" height="5">
		 </td></tr>
		</table></form>
		<?php
	endfor;
	put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?type='.$type.'&id='.$task));
	?>
	</td></tr></table>
	<?php
else:
	echo 'n&atilde;o existem links a publicar';
endif;
};

function put_previous_next_page($lower,$upper,$total,$link){
if ($lower==1 ):
  	$p_antes='<font class="body_text" ><font color="#999999">P&aacute;g. Anterior</font></font>';
endif;
if ($lower<>1):
  	$lower_a=$lower-15;
  	if ($lower_a<1):
		$lower_a=1;
	endif;
	$upper_a=$upper-15;
	if ($upper_a<1):
		$upper_a=$upper-$upper_a;
	endif;
	if ($upper_a==1 && $lower_a==1):
		$upper_a=15;
	endif;
  	$p_antes='<font class="body_text"><a href="'.$link.'&lower='.$lower_a.'&upper='.$upper_a.'"><font color="#000000">P&aacute;g. Anterior</font></a></font>';
endif;
if ($upper>=$total ):
	$p_depois='<font class="body_text" ><font color="#999999">P&aacute;g. seguinte</font></font>';
endif;
if ($upper<$total):
	$lower_d=$lower+15;
	$upper_d=$upper+15;
	if ($upper_d>$total):
		$upper_d=$total;
	endif;
	$p_depois='<font class="body_text"><a href="'.$link.'&lower='.$lower_d.'&upper='.$upper_d.'"><font color="#000000">P&aacute;g. seguinte</font></a></font>';
endif;
echo '<div align="right">'.$p_antes.'<font class="body_text" color="#000000"> | </font>'.$p_depois.'</div>';
};

?>