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

include_once($staticvars['local_root'].'kernel/file_management_functions.php');
include_once($staticvars['local_root'].'general/pass_generator.php');
$message='';
$image='';
if (isset($_FILES['imagem'])):
	if (stristr($_FILES['imagem']['type'],"jpeg")or stristr($_FILES['imagem']['type'],"gif")):
			$name=normalize($_FILES['imagem']['name']);
			if (check_files($upload_directory.'/cartazes/images',$name)):
				$tmp=explode(".",$name);
				$tmp[0].=generate('5','No','Yes','No');
				$tmp1[1]=$tmp[0].'.'.$tmp[1];
				$location_original=$upload_directory.'/cartazes/images/original/'.$tmp1[1];
				$location=$upload_directory.'/cartazes/images/'.$tmp1[1];
			else:
				$location_original=$upload_directory.'/cartazes/images/original/'.$name;					
				$location=$upload_directory.'/cartazes/images/'.$name;					
				$tmp1[1]=$name;
			endif;
			if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $location_original)):
				$message='Erro no Upload. Por favor tente de novo.';
			else:
				// Set a maximum height and width
				$width = 244;
				$height = 128;			
				// Get new dimensions
				list($width_orig, $height_orig) = getimagesize($location_original);				
				if ($width && ($width_orig < $height_orig)):
				   $width = ($height / $height_orig) * $width_orig;
				else:
				   $height = ($width / $width_orig) * $height_orig;
				endif;
				// Resample
				$image_p = imagecreatetruecolor($width, $height);
				if (stristr($_FILES['imagem']['type'],"jpeg")):
					$image = imagecreatefromjpeg($location_original);
				else:
					$image = imagecreatefromgif($location_original);
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
	$db->setquery("update cartazes set active='s' where cod_cartaz='".$bc."'");
	$_SESSION['update']='cartaz publicado no dicionario';
elseif(isset($_POST['unpublish'])):
	$db->setquery("update cartazes set active='n' where cod_cartaz='".$bc."'");
	$_SESSION['update']='cartaz retirado de publicação';
elseif (isset($_POST['del_term'])): // apagar  box
	$db->setquery("delete from cartazes where cod_cartaz='".$bc."'");
		$_SESSION['update']='cartaz apagado';
elseif (isset($_POST['edit_term']))://editar box
	$query="update cartazes set termo='".mysql_escape_string($_POST['termo'])."', definicao='".mysql_escape_string($_POST['definicao'])."'";
	if ($image<>'no_img.jpg'):
		$query.=", imagem='".mysql_escape_string($image)."' where cod_cartaz='".$bc."'";
	else:
		$query.="where cod_cartaz='".$bc."'";
	endif;
	$db->setquery($query);
	$_SESSION['update']='cartaz editado com sucesso';
elseif (isset($_POST['add_term']))://inserir box
	$query="insert into cartazes set termo='".mysql_escape_string($_POST['termo'])."', definicao='".mysql_escape_string($_POST['definicao'])."'");
	if ($image<>'no_img.jpg'):
		$query.=", imagem='".mysql_escape_string($image)."'";
	endif;
	$db->setquery($query);

	$_SESSION['update']='cartaz adicionado com sucesso';
endif;
if (isset($_POST['send_email'])):
	include_once($absolute_path."/classes/email_engine.php");
	$email = new email_engine_class;
	$user=$db->getquery("select nick, email from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$email->to=$user[0][1];
	$email->from='"'.$site_name.'" <'.$admin_mail.'>';
	$email->return_path=$admin_mail;
	$email->subject="publica&ccedil;&atilde;o em cartaz do ".$site_name;
	$email->preview=false;
	$email->template='publish_contents_error';
	if (isset($_POST['publish'])):
		$email->message='A palavra que submeteu ao cartaz foi aceite para publicação.<br>
		Obrigado pela sua colaboração.';
	elseif (isset($_POST['del_term'])):
		$email->message='O cartaz que submeteu não foi aceite para publicação.<br>
		Por favor verifique se preencheu adequadamente todos os campos ou se viola os termos de utiliza&ccedil;&atilde;o do site.
		Obrigado.';
	endif;		
	$email->send_email($staticvars['local_root']);
endif;
?>