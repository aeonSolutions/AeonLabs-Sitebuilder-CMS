<?php
/*
File revision date: 24-set-2008
*/

$ERROR_MSGS[0] = "";
$ERROR_MSGS[1] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[2] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[3] = "O upload do ficheiro não foi efectuado na totalidade.";
$ERROR_MSGS[4] = "Não foi feito o upload do arquivo.";
include_once($staticvars['local_root']."kernel/reload_credentials.php");
if(isset($_POST['categoria'])):
	$cat=mysql_escape_string($_POST['categoria']);
else:
	$cat=mysql_escape_string($_GET['cat']);
endif;
if(isset($_POST['art'])):
	$art=mysql_escape_string($_POST['art']);
else:
	$art=mysql_escape_string($_GET['art']);
endif;
$query=$db->getquery("select nome from publicacoes_categorias where cod_categoria='".$cat."'");
// Revisions management
if(isset($_POST['publish_rev'])):
	$db->setquery("insert into publicacoes_revisor set cod_publicacao='".$art."', observacoes='".mysql_escape_string($_POST['obs'])."', cod_revisor='".$staticvars['users']['code']."'");
	$db->setquery("update publicacoes set active='s' where cod_publicacao='".$art."'");
	// enviar email
	$subject='Artigo submetido no '.$staticvars['name'].' foi aceite';
	$message='<h2>O artigo que submeteu foi aceite. Obrigado.</h2>
	<p><strong>Observaçoes:</strong><br />'.mysql_escape_string($_POST['obs']).'</p>';
	include_once($staticvars['local_root']."email/email_engine.php");
	$email = new email_engine_class;
	$email->to=$staticvars['users']['email'];
	$email->from=$staticvars['smtp']['admin_mail'];
	$email->return_path=$staticvars['smtp']['admin_mail'];
	$email->subject=$subject;
	$email->preview=false;
		$email->template_location=$staticvars['local_root'].'modules/publicacoes/email/';
		$email->template='send_email';
	$email->message=$message;
	$message=$email->send_email($staticvars);
	echo '<font class="body_text"> <font color="#FF0000">Publicação aceite e activada</font></font>';
elseif(isset($_POST['new_revision'])):
	$db->setquery("insert into publicacoes_revisor set cod_publicacao='".$art."', observacoes='".mysql_escape_string($_POST['obs'])."', cod_revisor='".$staticvars['users']['code']."'");
	//enviar email
	$subject='Revisao do artigo submetido no '.$staticvars['name'];
	$message='<h2>O artigo que submeteu necessita de revisao. Por favor efectue a alteraçoes indicadas pelo revisor. Obrigado.</h2>
	<p><strong>Observaçoes:</strong><br />'.mysql_escape_string($_POST['obs']).'</p>';
	include_once($staticvars['local_root']."email/email_engine.php");
	$email = new email_engine_class;
	$email->to=$staticvars['users']['email'];
	$email->from=$staticvars['smtp']['admin_mail'];
	$email->return_path=$staticvars['smtp']['admin_mail'];
	$email->subject=$subject;
	$email->preview=false;
		$email->template_location=$staticvars['local_root'].'modules/publicacoes/email/';
		$email->template='send_email';
	$email->message=$message;
	$message=$email->send_email($staticvars);
	echo '<font class="body_text"> <font color="#FF0000">Publicação enviada para Revisao</font></font>';
	
// Posts management
elseif(isset($_POST['del_pages'])):// apagar ficheiro a uma publicacao
	$query3=$db->getquery("select cod_ficheiro, ficheiro from publicacoes_ficheiros where cod_publicacao='".mysql_escape_string($art)."'");
	if($query3[0][0]<>''):
		echo '<font class="body_text"> <font color="#FF0000">Ficheiros a apagar:</font></font>';
		for($i=0;$i<count($query3);$i++):
			if(isset($_POST['cf_'.$query3[$i][0]])):
				$db->setquery("delete from publicacoes_ficheiros where cod_ficheiro='".$query3[$i][0]."'");
				unlink($staticvars['upload'].'/publicacoes/'.$query3[$i][1]);
				echo '<font class="body_text"> <font color="#FF0000">'.$query3[$i][1].'</font></font>';
			endif;
		endfor;
	endif;
elseif(isset($_POST['save'])):
	$contents=str_replace("'","&#8217",stripslashes(normalize_chars($_POST['elm1'])));
	$up=str_replace($staticvars['site_path'].'/',"",$staticvars['upload_path']);
	$contents=str_replace('src="'.$up.'/publicacoes/images/','src="'.$staticvars['upload_path'].'/publicacoes/images/',$contents);
	$db->setquery("update publicacoes set texto='".$contents."' where cod_publicacao='".mysql_escape_string($_GET['edititem'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Publicação gravada.</font></font>';
elseif (isset($_POST['apagar'])): // apagar 
	$db->setquery("delete from publicacoes where cod_publicacao='".mysql_escape_string($_POST['edititem'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Publicação apagada</font></font>';
	unset($_POST['del_cat']);
elseif ($query[0][0]<>''):
	$group=$db->getquery("select cod_user_type, name from user_type where cod_user_type='".$staticvars['users']['group']."'");
	if($group[0][1]=='revisor' or $staticvars['users']['group']==$staticvars['users']['user_type']['admin']):
		if(isset($_POST['activar'])):
			$active=" active='s',";
		else:
			$active=" active='?',";
		endif;
	else:
		$active=" active='?',";
	endif;
	if (isset($_POST['edit']))://editar
			$title=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['titulo'])))));
			$sd=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['descricao'])))));
			$db->setquery("update publicacoes set short_description='".$sd."',
			title='".$title."', ".$active." cod_user='".$staticvars['users']['code']."' where cod_publicacao='".$art."'");
		echo '<font class="body_text"> <font color="#FF0000">Publicação editada com sucesso</font></font>';
		unset($_POST['cat_name']);
		$message='<h2>'.$title.'</h2><p>'.$sd.'</p><hr size="1"><p>';
		$subject='Adicionou um artigo no '.$staticvars['name'];
		include_once($staticvars['local_root']."email/email_engine.php");
		$email = new email_engine_class;
		$email->to=$staticvars['users']['email'];
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		$email->subject=$subject;
		$email->preview=false;
		$email->template_location=$staticvars['local_root'].'modules/publicacoes/email/';
		$email->template='send_email';
		$email->message=$message;
		$message=$email->send_email($staticvars);
	elseif (isset($_POST['add_new']))://adicionar
			$title=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['titulo'])))));
			$sd=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['descricao'])))));
			$db->setquery("insert into publicacoes set short_description='".$sd."', cod_categoria='".mysql_escape_string($_POST['categoria'])."', title='".$title."', ".$active." cod_user='".$staticvars['users']['code']."', lida='0', data_publicacao=NOW()");
		echo '<font class="body_text"> <font color="#FF0000">Publicação adicionada</font></font>';
		$new_item=$db->getquery("select cod_publicacao from publicacoes where title='".$title."' and short_description='".$sd."'");
		$new_item=$new_item[0][0];
		$message='<h2>'.$title.'</h2><p>'.$sd.'</p><hr size="1"><p>';
		$subject='Adicionou um artigo no '.$staticvars['name'];
		include_once($staticvars['local_root']."email/email_engine.php");
		$email = new email_engine_class;
		$email->to=$staticvars['users']['email'];
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		$email->subject=$subject;
		$email->preview=false;
		$email->template_location=$staticvars['local_root'].'modules/publicacoes/email/';
		$email->template='send_email';
		$email->message=$message;
		$message=$email->send_email($staticvars);
	endif;
	if(isset($_POST['add_file'])):// adicionar ficheiro a uma publicacao
		if (isset($_FILES['ficheiro'])):
			if (stristr($_FILES['ficheiro']['type'],"pdf")):
					$name=normalize($_FILES['ficheiro']['name']);
					$tmp=explode(".",$name);
					$tmp[0].=generate('5','No','Yes','No');
					$tmp1[1]=$tmp[0].'.'.$tmp[1];
					$location=$staticvars['upload'].'/publicacoes/'.$tmp1[1];
					if (!move_uploaded_file($_FILES['ficheiro']['tmp_name'], $location)):
						echo '<font class="body_text"> <font color="#FF0000">Erro no Upload. Por favor tente de novo.</font></font>';
					else:
						$db->setquery("insert into publicacoes_ficheiros set descricao='".mysql_escape_string($_POST['descricao'])."', ficheiro='".$tmp1[1]."', active='s', cod_publicacao='".$art."'");
						echo '<font class="body_text"> <font color="#FF0000">Ficheiro Adicionado com sucesso.</font></font>';
					endif;
			else:
				echo '<font class="body_text"> <font color="#FF0000">Apenas Ficheiro do tipo Acrobat Reader</font></font>';
			endif;
		endif;
	endif;
else:
	echo '<font class="body_text"> <font color="#FF0000">Erro na Categoria</font></font>';
endif;

?>