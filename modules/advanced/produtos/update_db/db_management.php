<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
//$auth_type='Content Management';
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
			if (check_files($upload_directory.'/produtos/images',$name)):
				$tmp=explode(".",$name);
				$tmp[0].=generate('5','No','Yes','No');
				$tmp1[1]=$tmp[0].'.'.$tmp[1];
				$location_original=$upload_directory.'/produtos/images/original/'.$tmp1[1];
				$location=$upload_directory.'/produtos/images/'.$tmp1[1];
			else:
				$location_original=$upload_directory.'/produtos/images/original/'.$name;					
				$location=$upload_directory.'/produtos/images/'.$name;					
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
$catalogo='';
if (isset($_FILES['catalogo'])):
	if (stristr($_FILES['catalogo']['type'],"pdf")or stristr($_FILES['catalogo']['type'],"zip")):
			$name=normalize($_FILES['catalogo']['name']);
			if (check_files($upload_directory.'/produtos/catalogo',$name)):
				$tmp=explode(".",$name);
				$tmp[0].=generate('5','No','Yes','No');
				$tmp1[1]=$tmp[0].'.'.$tmp[1];
				$location=$upload_directory.'/produtos/catalogo/'.$tmp1[1];
			else:
				$location=$upload_directory.'/produtos/catalogo/'.$name;					
				$tmp1[1]=$name;
			endif;
			if (!move_uploaded_file($_FILES['catalogo']['tmp_name'], $location)):
				$message='Erro no Upload. Por favor tente de novo.';
				$catalogo='no_cat';			
			else:
				$catalogo=$tmp1[1];
			endif;
	else:
		$catalogo='no_cat';
	endif;
endif;
// end of brochure upload
if (isset($_POST['publish_product'])):// publicar
	$db->setquery("update produtos set active='s' where cod_produto='".$bc."'");
	$_SESSION['update']='produto publicado';
elseif(isset($_POST['unpublish_product'])): // retirar de publicaçao
	$db->setquery("update produtos set active='n' where cod_produto='".$bc."'");
	$_SESSION['update']='produto retirado de publicação';
elseif (isset($_POST['del_product'])): // apagar
	$db->setquery("delete from produtos where cod_produto='".$bc."'");
		$_SESSION['update']='produto apagado';
elseif (isset($_POST['edit_product']) and $message=='')://editar box
	if(isset($_POST['active'])):
		$active=" active='s'";
	else:
		$active="";
	endif;
	if($_POST['titulo']<>'' and $_POST['descricao']<>'' and $_POST['descricao2']<>'' and $_POST['preco']<>'' and $_POST['stock']<>'' and $_POST['prazo_entrega']<>''
	 and $_POST['ref_produto']<>'' and $_POST['categoria']<>'0' and $_POST['iva']<>'0' and $_POST['desconto']<>'null' ):
		$query="update produtos set titulo='".normalize_chars(stripslashes(mysql_escape_string($_POST['titulo'])))."', descricao='".normalize_chars(stripslashes(mysql_escape_string($_POST['descricao'])))."',
		short_descricao='".normalize_chars(stripslashes(mysql_escape_string($_POST['descricao2'])))."', preco='".mysql_escape_string($_POST['preco'])."',
		cod_iva='".mysql_escape_string($_POST['iva'])."', cod_desconto='".mysql_escape_string($_POST['desconto'])."',
		prazo_entrega='".mysql_escape_string($_POST['prazo_entrega'])."', stock='".mysql_escape_string($_POST['stock'])."', ref_produto='".mysql_escape_string($_POST['ref_produto'])."'";
		if (mysql_escape_string($_POST['categoria'])<>''):
			$query.=",cod_categoria='".mysql_escape_string($_POST['categoria'])."'";
		endif;
		if ($image<>'no_img.jpg'):
			$query.=", imagem='".mysql_escape_string($image)."'";
		endif;
		 if ($catalogo=='no_cat'):
			$query.=$active." where cod_produto='".$bc."'";
		else:
			$query.=", catalogo='".mysql_escape_string($catalogo)."'".$active." where cod_produto='".$bc."'";
		endif;
		$db->setquery($query);
		
		$_SESSION['update']='produto editado com sucesso';
	else:
		$_SESSION['update']='Falta preencher campos obrigatórios';
	endif;
elseif (isset($_POST['add_product']) and $message=='')://inserir box
	if(isset($_POST['active'])):
		$active=", active='s'";
	else:
		$active="";
	endif;
	if($_POST['titulo']<>'' and $_POST['descricao']<>'' and $_POST['descricao2']<>'' and $_POST['preco']<>'' and $_POST['stock']<>'' and $_POST['prazo_entrega']<>''
	 and $_POST['ref_produto']<>'' and $_POST['categoria']<>'0' and $_POST['iva']<>'0' and $_POST['desconto']<>'null' ):
		$db->setquery("insert into produtos set titulo='".normalize_chars(stripslashes(mysql_escape_string($_POST['titulo'])))."', descricao='".normalize_chars(stripslashes(mysql_escape_string($_POST['descricao'])))."',
		short_descricao='".normalize_chars(stripslashes(mysql_escape_string($_POST['descricao2'])))."', preco='".mysql_escape_string($_POST['preco'])."',
		cod_iva='".mysql_escape_string($_POST['iva'])."', cod_desconto='".mysql_escape_string($_POST['desconto'])."',
		cod_categoria='".mysql_escape_string($_POST['categoria'])."', prazo_entrega='".mysql_escape_string($_POST['prazo_entrega'])."',
		stock='".mysql_escape_string($_POST['stock'])."',
		 ref_produto='".mysql_escape_string($_POST['ref_produto'])."', imagem='".mysql_escape_string($image)."', catalogo='".mysql_escape_string($catalogo)."'".$active);
		$_SESSION['update']='produto adicionado com sucesso';
	else:
		$_SESSION['update']='Falta preencher campos obrigatórios';
	endif;
endif;
if ($message<>''):
	$_SESSION['update']='produtos:'.$message;
endif;
?>