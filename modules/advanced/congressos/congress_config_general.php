<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;

$task=@$_GET['id'];
$cod_category=0;
if (isset($_POST['update'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
endif;
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
if (isset($_POST['gravar'])):
	load_text($staticvars);
	session_write_close();
	sleep(1);
	header("Location: ".$_SERVER['REQUEST_URI']);
endif;
if(isset($_SESSION['status'])):
	echo $_SESSION['status'];
	$_SESSION['status']=array();
	unset($_SESSION['status']);
endif;

if (!file_exists($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$cell_space=0;
	$max_papers=1;
	$max_chars=3000;
	$type_file='pdf';
	$secretariat_email='@';
	$cloaking=false;
	$forwarding=false;
else:
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
endif;
$address=$_SERVER['REQUEST_URI'];
if(is_file($staticvars['local_root'].'modules/congressos/system/logo/logo.jpg')):
	$logo='<img src="'.$staticvars['site_path'].'/modules/congressos/system/logo/logo.jpg" border="0" />';
elseif(is_file($staticvars['local_root'].'modules/congressos/system/logo/logo.gif')):
	$logo='<img src="'.$staticvars['site_path'].'/modules/congressos/system/logo/logo.gif" border="0" />';
else:
	$logo='';
endif;
?>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<h2><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/icone_gestao.gif" width="20" />Configura&ccedil;&atilde;o geral </h2>
<br />
<form method="post" action="<?=$address;?>"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td height="15"><strong>CellSpacing</strong></td>
	</tr>
	<tr>
	  <td width="701" colspan="2" class="body_text">A op&ccedil;&atilde;o CellSpacing permir definir uma margem em pixeis &agrave; volta da p&aacute;gina a carregar.<br />
	    Caso pretenda controlar as margens manualmente. Introduza o valor 0.<br />
        <br />
	    CellSpacing 
	    <label>
	    <input name="cellspacing" type="text" id="cellspacing" value="<?=$cell_space;?>" size="5" maxlength="2" class="form_input" />
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">(max&iacute;mo recomendado 10)</font></label></td>
	</tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td height="15">Type of file allowed in submission of Papers 
	    <select name="type_file" id="type_file">
	      <option value="pdf" <?php if($type_file=='pdf'){ echo 'selected="selected"';}?>>Pdf</option>
	      <option value="doc" <?php if($type_file=='doc'){ echo 'selected="selected"';}?>>Doc</option>
	      <option value="both" <?php if($type_file=='both'){ echo 'selected="selected"';}?>>Both</option>
      </select></td>
    </tr>
	<tr>
	  <td height="15"></td>
    </tr>
	<tr>
	  <td height="15">How many Papers can a user submit 
      <input name="max_papers" type="text" id="max_papers" size="2" maxlength="2" value="<?=$max_papers;?>" /></td>
	</tr>
	<tr>
	  <td align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">Max charecters allowed on Abstract submission 
      <input name="max_chars" type="text" id="max_chars" size="5" maxlength="5"  value="<?=$max_chars;?>" /></td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">Tipo de evento
	    <select name="event_type" id="event_type">
	      <option value="congress" <?php if($type_file=='congress'){ echo 'selected="selected"';}?>>Congress</option>
	      <option value="conferece" <?php if($type_file=='conferece'){ echo 'selected="selected"';}?>>Conferece</option>
	      <option value="workshop" <?php if($type_file=='workshop'){ echo 'selected="selected"';}?>>Workshop</option>
      </select></td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom"><p>Email secretariado 
	    <input name="secretariat_email" type="text" id="secretariat_email" size="40" maxlength="100" value="<?=$secretariat_email;?>" />
	  </p>
      <p><strong>
        <input type="checkbox" name="forwarding" id="forwarding" <?php if($forwarding=='on'){ echo 'checked="checked"';}?>/>
Forwarding<br />
      </strong>a op&ccedil;&atilde;o Forwarding permite que os emails enviados aos autores ap&oacute;s a submiss&atilde;o de um resumo ou artigo sejam reenviados para o secretariado. </p></td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom"><strong>
	    <input type="checkbox" name="cloaking" id="cloaking" <?php if($cloaking=='on'){ echo 'checked="checked"';}?>/>
	    Cloaking<br />
	    </strong>a op&ccedil;&atilde;o cloaking permite bloquear determinadas op&ccedil;&otilde;es caso n&atilde;o se encontrem dentro das Deadlines definidas. Por exemplo n&atilde;o faz sentido mostrar a op&ccedil;&atilde;o de submiss&atilde;o de artigos quando ainda se encontra na fase de submiss&atilde;o de resumos.<strong><br />
	  </strong></td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom"><strong>Logotipo</strong><br /><?=$logo;?>
      <br /><input name="imagem" type="file" id="imagem" size="40" maxlength="255" /></td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="right" valign="bottom"><input name="gravar" class="form_submit" type="submit" value="Gravar" /></td>
	</tr>
  </table>
</form>
<?php	

function load_text($staticvars){
if (!file_exists($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$sa='//';
	$na='//';
	$sp='//';
	$np='//';
	$rp='//';
else:
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
endif;
$ovr_abs= ($ovr_abs==false) ? 'false' : 'true';
$ovr_paper= ($ovr_paper==false) ? 'false' : 'true';
$ovr_revised= ($ovr_revised==false) ? 'false' : 'true';
$file_content='
<?PHP
// Congress general config
$enable_mainpage=true;
$cell_space='.$_POST['cellspacing'].';
$max_papers='.$_POST['max_papers'].';
$max_chars='.$_POST['max_chars'].';
$type_file="'.$_POST['type_file'].'";
$event_type="'.$_POST['event_type'].'";
$cloaking="'.$_POST['cloaking'].'";
$forwarding="'.$_POST['forwarding'].'";
$secretariat_email="'.$_POST['secretariat_email'].'";
$sa="'.$sa.'";
$na="'.$na.'";
$sp="'.$sp.'";
$np="'.$np.'";
$rp="'.$rp.'";
$ovr_abs='.$ovr_abs.';
$ovr_paper='.$ovr_paper.';
$ovr_revised='.$ovr_revised.';
?>';
$message='';
$image='';
if (isset($_FILES['imagem'])):
	if (stristr($_FILES['imagem']['type'],"jpeg")or stristr($_FILES['imagem']['type'],"gif")):
		$name=$_FILES['imagem']['name'];
		$tmp=explode(".",$name);
		$location_original=$staticvars['local_root'].'modules/congressos/system/logo/original/logo.'.$tmp[1];
		@unlink($staticvars['local_root'].'modules/congressos/system/logo/original/logo.gif');
		@unlink($staticvars['local_root'].'modules/congressos/system/logo/original/logo.jpg');
		@unlink($staticvars['local_root'].'modules/congressos/system/logo/logo.gif');
		@unlink($staticvars['local_root'].'modules/congressos/system/logo/logo.jpg');		
		$location=$staticvars['local_root'].'modules/congressos/system/logo/logo.'.$tmp[1];
		if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $location_original)):
			echo '<font class="body_text"> <font color="#FF0000">Erro no Upload. Por favor tente de novo.</font></font>';
		else:
			// Set a maximum height and width
			$width = 500;
			$height = 250;			
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
	endif;
endif;
// end of image upload

$filename=$staticvars['local_root'].'modules/congressos/system/settings.php';
if (file_exists($filename)):
	unlink($filename);
endif;
if (!$handle = fopen($filename, 'a')):
	echo '<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
endif;
if (fwrite($handle, $file_content) === FALSE):
	echo '<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
endif;
	echo '<font class="body_text"> <font color="#FF0000">Success. Settings Saved.</font></font><br />';
$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Success. Settings Saved.</font></font><br />';
fclose($handle);
include($staticvars['local_root'].'kernel/staticvars.php');
};

?>
