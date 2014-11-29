<?php
/*
File revision date: 24-set-2008
*/

$ERROR_MSGS[0] = "";
$ERROR_MSGS[1] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[2] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[3] = "O upload do ficheiro não foi efectuado na totalidade.";
$ERROR_MSGS[4] = "Não foi feito o upload do arquivo.";
include($staticvars['local_root'].'kernel/reload_credentials.php');
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
$query=$db->getquery("select nome from eventos_categorias where cod_categoria='".$cat."'");
// events management
if(isset($_POST['save'])):
	$db->setquery("update eventos set texto='".str_replace("'","&#8217",stripslashes(normalize_chars($_POST['elm1'])))."' where cod_evento='".mysql_escape_string($_GET['edititem'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Evento gravado.</font></font>';
elseif (isset($_POST['apagar'])): // apagar 
	$db->setquery("delete from eventos where cod_evento='".mysql_escape_string($_POST['edititem'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Evento apagado</font></font>';
	unset($_POST['del_cat']);
elseif ($query[0][0]<>''):
	$image='';
	$active=" active='s',";
	$erro=true;
	if (isset($_FILES['up_img']) and $_FILES['up_img']['name']<>''):
		$erro=false;
		if (stristr($_FILES['up_img']['type'],"jpeg")or stristr($_FILES['up_img']['type'],"gif")):
			$location=$staticvars['upload'].'/eventos/images/'.$_FILES['up_img']['name'];
			if (!move_uploaded_file($_FILES['up_img']['tmp_name'], $location)):
				echo '<font class="body_text"> <font color="#FF0000">Erro no Upload. Por favor tente de novo</font></font>';
				$_SESSION['update']='Erro no Upload. Por favor tente de novo';
			else:
			// set maximum hight and width
				$width = 80;
				$height = 80;			
				// Get new dimensions
				list($width_orig, $height_orig) = getimagesize($location);				
				if ($width && ($width_orig < $height_orig)):
				   $width = ($height / $height_orig) * $width_orig;
				else:
				   $height = ($width / $width_orig) * $height_orig;
				endif;
				// Resample
				$image_p = imagecreatetruecolor($width, $height);
				if (stristr($_FILES['up_img']['type'],"jpeg")):
					$image = imagecreatefromjpeg($location);
				else:
					$image = imagecreatefromgif($location);
				endif;
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
				// Output
				if (stristr($_FILES['up_img']['type'],"jpeg")):
					imagejpeg($image_p,$location);
				else:
					imagejpeg($image_p,$location);
				endif;
				$erro=true;
				$image= "image='".mysql_escape_string($_FILES['up_img']['name'])."' , ";	
			endif;
		else:
			echo '<font class="body_text"> <font color="#FF0000">Só sao permitidos ficheiros do tipo jpeg ou gif na imagem</font></font>';
		$_SESSION['update']= 'Apenas ficheiros jpeg ou gif';
		endif;
	endif;
	if (isset($_POST['edit']) and $erro)://editar
			$title=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['titulo'])))));
			$sd=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['descricao'])))));
			$data_evento=mysql_escape_string($_POST['ano']).'-'.mysql_escape_string($_POST['mes']).'-'.mysql_escape_string($_POST['dia']);
			$db->setquery("update eventos set short_description='".$sd."', ".$image."
			title='".$title."', ".$active." cod_user='".$staticvars['users']['code']."', data=NOW(), data_evento='".$data_evento."' where cod_evento='".$art."'");
		if(isset($_POST['activar'])):
			$active=" active='s',";
		else:
			$active=" active='?',";
		endif;

		echo '<font class="body_text"> <font color="#FF0000">Evento editado com sucesso</font></font>';
		unset($_POST['cat_name']);
		$message='<h2>'.$title.'</h2><p>'.$sd.'</p><hr size="1"><p>';
		$subject='Confirmaçao de alteraçao de evento no '.$staticvars['name'];
		include_once($staticvars['local_root']."email/email_engine.php");
		$email = new email_engine_class;
		$email->to=$staticvars['users']['email'];
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		$email->subject=$subject;
		$email->preview=false;
		$email->template_location=$staticvars['local_root'].'modules/eventos/email/';
		$email->template='send_email';
		$email->message=$message;
		$message=$email->send_email($staticvars);
	elseif (isset($_POST['add_new']) and $erro)://adicionar
		$title=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['titulo'])))));
		$sd=str_replace('\"',"&quot;",str_replace("'","&#8217",normalize_chars(stripslashes(mysql_escape_string($_POST['descricao'])))));
		$data_evento=mysql_escape_string($_POST['ano']).'-'.mysql_escape_string($_POST['mes']).'-'.mysql_escape_string($_POST['dia']);
		$db->setquery("insert into eventos set short_description='".$sd."', ".$image." cod_categoria='".mysql_escape_string($_POST['categoria'])."', title='".$title."', ".$active." cod_user='".$staticvars['users']['code']."', data_evento='".$data_evento."', data=NOW()");

		echo '<font class="body_text"> <font color="#FF0000">Evento adicionado</font></font>';
		$new_item=$db->getquery("select cod_evento from eventos where title='".$title."' and short_description='".$sd."'");
		$new_item=$new_item[0][0];
		$message='<h2>'.$title.'</h2><p>'.$sd.'</p><hr size="1"><p>';
		$subject='Adicionou um evento no '.$staticvars['name'];
		include_once($staticvars['local_root']."email/email_engine.php");
		$email = new email_engine_class;
		$email->to=$staticvars['users']['email'];
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		$email->subject=$subject;
		$email->preview=false;
		$email->template_location=$staticvars['local_root'].'modules/eventos/email/';
		$email->template='send_email';
		$email->message=$message;
		$message=$email->send_email($staticvars);
	endif;
else:
	echo '<font class="body_text"> <font color="#FF0000">Erro na Categoria</font></font>';
endif;

?>