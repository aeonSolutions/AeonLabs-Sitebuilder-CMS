<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;

if (isset($_POST['titulo'])):
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
	if ($message==''):
		if (isset($_POST['email_alert'])):
			$db->setquery("insert into livros set titulo='".mysql_escape_string($_POST['titulo'])."', descricao='".mysql_escape_string($_POST['descricao'])."', email='".mysql_escape_string($_POST['email'])."',
			preco='".mysql_escape_string($_POST['preco'])."', descricao='".mysql_escape_string($_POST['descricao'])."', editora='".mysql_escape_string($_POST['editora'])."',
			 editora_link='".mysql_escape_string($_POST['editora_link'])."', imagem='".mysql_escape_string($image)."'");
		else:
			$db->setquery("insert into livros set titulo='".mysql_escape_string($_POST['titulo'])."', descricao='".mysql_escape_string($_POST['descricao'])."',
			preco='".mysql_escape_string($_POST['preco'])."', descricao='".mysql_escape_string($_POST['descricao'])."', editora='".mysql_escape_string($_POST['editora'])."',
			 editora_link='".mysql_escape_string($_POST['editora_link'])."', imagem='".mysql_escape_string($image)."'");
		endif;
		$_SESSION['update']='Caso seja aprovada, será publicada no dicionário. Obrigado por ter participado!';
		$address=strip_address($staticvars['local_root'],"update",$_SERVER['REQUEST_URI']);
	else:
		unset($_POST);
		$_SESSION['update']=$message;
		$address=$_SERVER['REQUEST_URI'];
	endif;
	session_write_close();
	header("Location:".$address);
endif;
if (isset($_SESSION['user'])):
	$email="Email:&nbsp;<input type='hidden' name='email' value='".$credentials['user']['email']."'><input name='email2' type='text' size='30' maxlength='255' value='".$credentials['user']['email']."' disabled='diabled' class='body_text'>";
else:
	$email="Email:&nbsp;<input name='email' type='text' size='30' maxlength='255' class='body_text'>";
endif;
?>
<script language="javascript">
function add_email(){

var box = window.document.propose.email_alert;
  if (box.checked == false) {
	document.getElementById('email_alert_tag').innerHTML="<input type='hidden' name='email' value=''>";
  } else {
	document.getElementById('email_alert_tag').innerHTML="<?=$email;?>";
  }
};
</script>
<div id="module-border">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Prop&ocirc;r Livro</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
      </TR>
    <TR>
      <TD vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/books/images/puzzle-pieces.gif" alt="" width="32" height="26"><BR></TD>
      <TD vAlign=bottom>Caso conhe&ccedil;a algum Livro, que n&atilde;o se encontre listado pode prop&ocirc;r &agrave; equipa do Construtec que o adicione.<br>
        <br>
        Obrigado pela sua participa&ccedil;&atilde;o!</TD>
    </TR>
  </TBODY>
</TABLE>
<form name="propose" method="post" action="<?=session($staticvars,'index.php?id='.@$_GET['id'].'&update=34');?>" enctype="multipart/form-data">
  <table width="100%" border="0">
    <tr>
      <td width="10%">&nbsp;</td>
      <td width="90%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">T&iacute;tulo&nbsp;</td>
      <td><label>
        <input name="titulo" type="text" id="titulo" size="30" maxlength="255" class='body_text'>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Descri&ccedil;&atilde;o&nbsp;</td>
      <td><label>
        <textarea name="descricao" cols="50" rows="3" wrap="virtual" id="descricao" class='body_text'></textarea>
      </label></td>
    </tr>
    <tr>
      <td>Pre&ccedil;o</td>
      <td align="left"><input name="preco" type="text" id="preco" size="30" maxlength="255" class='body_text' /></td>
    </tr>
    <tr>
      <td>Editora</td>
      <td align="left"><input name="editora" type="text" id="editora" size="30" maxlength="255" class='body_text' /> 
        endere&ccedil;o web: 
        <input name="editora_web" type="text" id="editora_web" size="30" maxlength="255" class='body_text' /></td>
    </tr>
    <tr>
      <td>Capa do livro</td>
      <td align="left"><label>
        <input type="file" name="capa" id="capa" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><input type="checkbox" name="email_alert" id="email_alert" onclick="javascript:add_email();" />
      Quero ser avisado por email da publica&ccedil;&atilde;o no dicion&aacute;rio
        <div id="email_alert_tag"><input type='hidden' name='email' value=''></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right"><input type="submit" name="add_book" id="add_book" value="Submeter Livro" class="form_submit"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</div>