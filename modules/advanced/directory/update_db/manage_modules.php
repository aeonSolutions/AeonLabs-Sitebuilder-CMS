<?php
/*
File revision date: 28-Set-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;


$ERROR_MSGS[0] = "";
$ERROR_MSGS[1] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[2] = "Tamanho do ficheiro exede o limite máximo.";
$ERROR_MSGS[3] = "O upload do ficheiro não foi efectuado na totalidade.";
$ERROR_MSGS[4] = "Não foi feito o upload do arquivo.";



$message='';
$sub=@$_GET['cod'];
$content='';
if ($sub<>''):
	// image upload
	if (isset($_FILES['imagem'])):
		if (stristr($_FILES['imagem']['type'],"jpeg")or stristr($_FILES['imagem']['type'],"gif")):
				$name=normalize($_FILES['imagem']['name']);
				if (check_files($upload_directory.'/items/images',$name)):
					$tmp=explode(".",$name);
					$tmp[0].=generate('5','No','Yes','No');
					$tmp1[1]=$tmp[0].'.'.$tmp[1];
					$location=$upload_directory.'/items/images/'.$tmp1[1];
				else:
					$location=$upload_directory.'/items/images/'.$name;					
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
else:
	$message='Falta seleccionar a categoria.';
endif;
if ($message==''):
	$user=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
	if ($enable_publish):
		$publish='?';
	else:
		$publish='s';
	endif;
	$query="insert into items set active='".$publish."', data=NOW(), cod_user='".$user[0][0]."', 
	cod_category='".mysql_escape_string($sub)."', downloads='0', descricao='".mysql_escape_string($_POST['descricao'])."',
	titulo='".mysql_escape_string($_POST['titulo'])."', cod_items_types='".mysql_escape_string($type)."',
	visible_to='".mysql_escape_string($_POST['user_group'])."',
	imagem='".$image."',content='".mysql_escape_string($_POST['modules'])."'";
	$db->setquery($query);
	$message='';
endif;
////////////////////////////////////////////////////////////////////////////////////////////7
  
function normalize($text){
// eliminates special characters and convert to lower case a text string
	$dim=array("ç","Ç");
	$text = str_replace($dim, "c", $text);

	$dim=array("ã","á","à","â","Ã","Á","À","Â");
	$text = str_replace($dim, "a", $text);

	$dim=array("é","ê","Ê","É");
	$text = str_replace($dim, "e", $text);

	$dim=array("í","Í");
	$text = str_replace($dim, "i", $text);

	$dim=array("õ","ó","ô","Õ","Ó","Ô");
	$text = str_replace($dim, "o", $text);

	$text=strtolower($text);
	$text =str_replace(" ","",$text);
return $text;
};

function check_files($dir,$filename){
$filename=$dir.'/'.$filename;
$files = glob($dir."/*.*");
$tmp=false;
for($i = 0; $i < count($files); $i++):
	if ($files[$i]==$filename):
		$tmp=true;
	endif;
endfor;
return $tmp;
};
?>