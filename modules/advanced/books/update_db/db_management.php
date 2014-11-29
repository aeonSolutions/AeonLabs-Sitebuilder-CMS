<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found(dictionary managment)';
	exit;
endif;
$bc=mysql_escape_string(@$_GET['cod']);
include($staticvars['local_root'].'kernel/file_management_functions.php');
$message='';
if (isset($_FILES['imagem'])):
	if (stristr($_FILES['imagem']['type'],"jpeg")or stristr($_FILES['imagem']['type'],"gif")):
			$name=normalize($_FILES['imagem']['name']);
			if (check_files($upload_directory.'/books/images',$name)):
				$tmp=explode(".",$name);
				$tmp[0].=generate('5','No','Yes','No');
				$tmp1[1]=$tmp[0].'.'.$tmp[1];
				$location=$upload_directory.'/books/images/'.$tmp1[1];
			else:
				$location=$upload_directory.'/books/images/'.$name;					
				$tmp1[1]=$name;
			endif;
			if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $location)):
				$message='Erro no Upload. Por favor tente de novo.';
			else:
				// Set a maximum height and width
				$width = 244;
				$height = 128;			
				// Get new dimensions
				list($width_orig, $height_orig) = getimagesize($location);				
				if ($width && ($width_orig < $height_orig)):
				   $width = ($height / $height_orig) * $width_orig;
				else:
				   $height = ($width / $width_orig) * $height_orig;
				endif;
				// Resample
				$image_p = imagecreatetruecolor($width, $height);
				if (stristr($_FILES['imagem']['type'],"jpeg")):
					$image = imagecreatefromjpeg($location);
				else:
					$image = imagecreatefromgif($location);
				endif;
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
				// Output
				if (stristr($_FILES['imagem']['type'],"jpeg")):
					imagejpeg($image_p,$location);
				else:
					imagejpeg($image_p,$location);
				endif;
				$image=$tmp1[1];
			endif;
	else:
		$image='no_img.jpg';
	endif;
endif;
// end of image upload

if (isset($_POST['publish'])):
	$db->setquery("update livros set active='s' where cod_livro='".$bc."'");
	$_SESSION['update']='Livro publicado no dicionario';
elseif(isset($_POST['unpublish'])):
	$db->setquery("update livros set active='n' where cod_livro='".$bc."'");
	$_SESSION['update']='Livro retirado de publicação';
elseif (isset($_POST['del_book'])): // apagar  box
	$db->setquery("delete from livros where cod_livro='".$bc."'");
		$_SESSION['update']='Livro apagado';
elseif (isset($_POST['edit_book']) and $message=='')://editar box
	$db->setquery("update livros set titulo='".mysql_escape_string($_POST['titulo'])."', descricao='".mysql_escape_string($_POST['descricao'])."',
	preco='".mysql_escape_string($_POST['preco'])."', editora='".mysql_escape_string($_POST['editora'])."',
	 editora_link='".mysql_escape_string($_POST['editora_link'])."', imagem='".mysql_escape_string($image)."', where cod_livro='".$bc."'");
	$_SESSION['update']='Livro editado com sucesso';
elseif (isset($_POST['add_book']) and $message=='')://inserir box
	$db->setquery("insert into livros set titulo='".mysql_escape_string($_POST['titulo'])."', descricao='".mysql_escape_string($_POST['descricao'])."',
	preco='".mysql_escape_string($_POST['preco'])."', editora='".mysql_escape_string($_POST['editora'])."',
	 editora_link='".mysql_escape_string($_POST['editora_link'])."', imagem='".mysql_escape_string($image)."'");
	$_SESSION['update']='Livro adicionado com sucesso';
endif;
if (isset($_POST['send_email'])):
	include_once($absolute_path."/classes/email_engine.php");
	$email = new email_engine_class;
	$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$email->to=$user[0][1];
	$email->from='"'.$site_name.'" <'.$admin_mail.'>';
	$email->return_path=$admin_mail;
	$email->subject="publica&ccedil;&atilde;o de Livros no ".$site_name;
	$email->preview=false;
	$email->template='publish_contents_error';
	if (isset($_POST['publish'])):
		$email->message='O Livro que submeteu foi aceite para publicação.<br>
		Obrigado pela sua colaboração.';
	elseif (isset($_POST['del_book'])):
		$email->message='O Livro que submeteu não foi aceite para publicação.<br>
		Por favor verifique se preencheu adequadamente todos os campos ou se viola os termos de utiliza&ccedil;&atilde;o do site.
		Obrigado.';
	endif;		
	$email->send_email($staticvars['local_root']);
endif;
?>