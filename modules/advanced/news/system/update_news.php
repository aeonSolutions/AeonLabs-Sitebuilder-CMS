<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	$_SESSION['update']= 'Error: Security Not Found (update news)';
	exit;
endif;
if (isset($_POST['apagar'])):
	$res=$db->setquery("delete from news where cod_news='".mysql_escape_string($_POST['cod_news'])."'");
	unset($_POST['message']);
	unset($_POST['news']);
	$_SESSION['update']= 'Post informativo Apagado.';
elseif (isset($_POST['duo_active'])):
 $res=$db->getquery("select active from news where cod_news='".mysql_escape_string($_POST['cod_news'])."'");
 if ($res[0][0]=='s'):
	 $res=$db->setquery("update news set active='n' where cod_news='".mysql_escape_string($_POST['cod_news'])."'");
	$_SESSION['update']= 'Post informativo desactivado.';
 else:
	 $res=$db->setquery("update news set active='s' where cod_news='".mysql_escape_string($_POST['cod_news'])."'");
	$_SESSION['update']= 'Post informativo activado.';
 endif;
unset($_POST);
elseif ( isset($_POST['message']) ):
	$option=1;
	if (isset($_POST['disable_smilies'])):
		$option=0;
	endif;	
	if (isset($_POST['message'])):
		$erro=false;
		include('kernel/staticvars.php');
		if (isset($_FILES['up_img'])):
			if (stristr($_FILES['up_img']['type'],"jpeg")or stristr($_FILES['up_img']['type'],"gif")):
				$location=$upload_directory.'/news/images/'.$_FILES['up_img']['name'];
				if (!move_uploaded_file($_FILES['up_img']['tmp_name'], $location)):
					?>
					<script language="javascript">
						window.alert("Erro no Upload. Por favor tente de novo.");
					</script>
					<?php
				else:
					// Set a maximum height and width
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
				endif;
			endif;
		else:
			$_SESSION['update']= 'Apenas ficheiros jpeg ou gif';
		endif;
		$erro=true;
		if ($erro):
		echo 'update-';
			$user=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
			if (isset($_FILES['up_img']) and (stristr($_FILES['up_img']['type'],"jpeg")or stristr($_FILES['up_img']['type'],"gif"))):
			$db->setquery("update news set cod_user='".$user[0][0]."', title='".normalize_chars(stripslashes(mysql_escape_string($_POST['subject'])))."',
			 texto='".normalize_chars(stripslashes(mysql_escape_string($_POST['message'])))."', data=NOW(), emoticons='".$option."',
			 image='".mysql_escape_string($_FILES['up_img']['name'])."' where cod_news='".$_SESSION['news']."'");
			else:
			$db->setquery("update news set cod_user='".$user[0][0]."', title='".normalize_chars(stripslashes(mysql_escape_string($_POST['subject'])))."',
			 texto='".normalize_chars(stripslashes(mysql_escape_string($_POST['message'])))."', data=NOW(), emoticons='".$option."' where cod_news='".$_SESSION['news']."'");
			endif;
			$_SESSION['update']= 'Post informativo alterado com sucesso!';
		else:
			$_SESSION['update']= 'Erro ao alterar o Post informativo!';
		endif;
	endif;
endif;

