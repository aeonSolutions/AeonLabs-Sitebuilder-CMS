<?php
/*
File revision date: 25-Set-2006
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
	if ($enable_publish):
		$publish='?';
	else:
		$publish='s';
	endif;
	$user=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
	$ext_allowed=$db->getquery("select extensions_allowed from items_types where cod_items_types='".mysql_escape_string($type)."'");
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

	if (isset($_FILES['ficheiro_zip'])and $_FILES['ficheiro_zip']['error']<>4 and isset($_POST['mod_alter_cat'])):
		include_once($staticvars['local_root'].'general/pass_generator.php');
		$name=normalize($_FILES['ficheiro_zip']['name']);
		if (check_files($temporary_directory,$name)):
			$tmp=explode(".",$name);
			$tmp[0].=generate('5','No','Yes','No');
			$extension=$tmp[1];
			$tmp1[1]=$tmp[0].'.'.$tmp[1];
			$location=$temporary_directory.'/'.$tmp1[1];
		else:
			$location=$temporary_directory.'/'.$name;					
			$tmp1[1]=$name;
		endif;
		if ($message==''):
			if (!move_uploaded_file($_FILES['ficheiro_zip']['tmp_name'], $location)):
				$message='Erro no Upload. Por favor tente de novo.';
			endif;
		endif;
		$dir_path = $upload_directory.'/items/';
		$zip_path = $temporary_directory.'/'.$_FILES['ficheiro_zip']['name'];
		
		if (($link = zip_open($zip_path))):
			$message=0;
			while ($zip_entry = zip_read($link)):
				if (zip_entry_open($link, $zip_entry, "r")):
					$data = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
					$dir_name = dirname(zip_entry_name($zip_entry));
					$name = zip_entry_name($zip_entry);
					$name=normalize($name);
					$error=false;
					if (check_files($upload_directory,$name)):
						$tmp=explode(".",$name);
						$tmp[0].=generate('5','No','Yes','No');
						$extension=$tmp[1];
						if (!preg_match ("# $extension #", str_replace(";"," ",$ext_allowed[0][0])) ):
							$message=$message+1;
							$error=true;
						endif;
						$tmp1[1]=$tmp[0].'.'.$tmp[1];
						$location=$upload_directory.'/items/'.$tmp1[1];
					else:
						$location=$upload_directory.'/items/'.$name;					
						$tmp1[1]=$name;
					endif;
					if (!$error):
						$stream = fopen($location, "w");
						fwrite($stream, $data);
						zip_entry_close($zip_entry);

						$query="insert into items set active='".$publish."', data=NOW(), cod_user='".$user[0][0]."', 
						cod_category='".mysql_escape_string($sub)."', downloads='0', descricao='".mysql_escape_string($_POST['descricao'])."',
						titulo='".mysql_escape_string($_POST['titulo'])."', cod_items_types='".mysql_escape_string($type)."',
						imagem='".$image."',content='".$tmp1[1]."'";
						$db->setquery($query);
					endif;
				else:
					$message='Erro ao localizar o ficheiro.';
				endif;
			endwhile;
			if ($message<>0):
				echo 'Foram encontrados '.$message.' ficheiros inválidos (tipo inválido).';
			endif;
			zip_close($link);  
		else:
			$message = "Erro ao descompactar o ficheiro.";
		endif;
	endif;
	// end of compressed zip file upload and unpacking
	if (isset($_FILES['ficheiro']) and isset($_POST['mod_current_cat'])):
		if ($_FILES['ficheiro']['error']==0):
			$name=normalize($_FILES['ficheiro']['name']);
			if (check_files($upload_directory.'/items',$name)):
				include_once($staticvars['local_root'].'general/pass_generator.php');
				$tmp=explode(".",$name);
				$tmp[0].=generate('5','No','Yes','No');
				$extension=$tmp[1];
				if (!preg_match ("# $extension #", str_replace(";"," ",$ext_allowed[0][0])) ):
					$message='Tipo de ficheiro inválido (ficheiro).';
				endif;
				$tmp1[1]=$tmp[0].'.'.$tmp[1];
				$location=$upload_directory.'/items/'.$tmp1[1];
			else:
				$location=$upload_directory.'/items/'.$name;					
				$tmp1[1]=$name;
			endif;
			$content=$tmp1[1];
			if ($message==''):
				if (!move_uploaded_file($_FILES['ficheiro']['tmp_name'], $location)):
					$message='Erro no Upload. Por favor tente de novo.';
				endif;
			endif;

			if ($message==''):
				$query="insert into items set active='".$publish."', data=NOW(), cod_user='".$user[0][0]."', 
				cod_category='".mysql_escape_string($sub)."', downloads='0', descricao='".mysql_escape_string($_POST['descricao'])."',
				titulo='".mysql_escape_string($_POST['titulo'])."', cod_items_types='".mysql_escape_string($type)."', 
				visible_to='".mysql_escape_string($_POST['user_group'])."',
				imagem='".$image."',content='".$content."'";
				$db->setquery($query);
				$message='';
			endif;
		else:
			$message=$ERROR_MSGS[$_FILES['ficheiro']['error']];
		endif;
	endif;
else:
	$message='Falta definir uma categoria.';
endif;
////////////////////////////////////////////////////////////////////////////////////////////7
  




function upload_image($staticvars['local_root']){
include($staticvars['local_root'].'kernel/staticvars.php');
$tmp1[0]=false;
$tmp1[1]='noimg.jpg';
if (isset($_FILES['imagem'])):
	
endif;
return $tmp1;
};
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