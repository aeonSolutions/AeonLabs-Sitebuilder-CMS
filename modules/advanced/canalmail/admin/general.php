<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
$cod_category=0;
include($staticvars['local_root'].'kernel/staticvars.php');
if (isset($_POST['presents'])):
	load_text($staticvars);
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);
endif;
if (!file_exists($staticvars['local_root'].'modules/canalmail/system/settings.php')):
	$red='';
	$nombreweb='webmaster@';
	$asociadoFuente = "thepath";
else:
	include($staticvars['local_root'].'modules/canalmail/system/settings.php');
endif;

$address=$_SERVER['REQUEST_URI'];
?>
<h3><img src="<?=$staticvars['site_path'].'/modules/canalmail';?>/images/icone_gestao.gif" />Configura&ccedil;&atilde;o geral<br />
  <br />
</h3>
<form class="form" method="post" action="<?=$address;?>"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td colspan="2"><font class="body_text">RED<br />
	  </font>
    <input name="red" type="text" class="text" id="red" value="<?=$red;?>" size="30" maxlength="16" /></td></tr>
	<tr>
	  <td height="15"></td>
	</tr>
	
	<tr>
	  <td align="left" valign="bottom"> nombreweb<br />
      <input name="nombreweb" type="text" class="text" id="nombreweb" value="<?=$nombreweb;?>" size="50" maxlength="255" /></td>
    </tr>
	<tr>
	  <td align="right" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom">asociadoFuente<br />
      <input name="asociadoFuente" type="text" class="text" id="asociadoFuente" value="<?=$asociadoFuente;?>" size="50" maxlength="255" /></td>
    </tr>
	<tr>
	  <td align="right" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="right" valign="bottom"><input name="presents" type="submit" value="gravar" class="button"  />          </td>
	</tr>
  </table>
</form>
<?php	

function load_text($staticvars){

$file_content='
<?PHP
// Canalmail general config
$nombreweb="'.$_POST['nombreweb'].'";
$red="'.$_POST['red'].'";
$asociadoFuente="'.$_POST['asociadoFuente'].'";
?>';
$filename=$staticvars['local_root'].'modules/canalmail/system/settings.php';
if (file_exists($filename)):
	unlink($filename);
endif;
if (!$handle = fopen($filename, 'a')):
	$_SESSION['update']= 'Cannot open file ('.$filename.')';
endif;
if (fwrite($handle, $file_content) === FALSE):
	$_SESSION['update']= 'Cannot write file ('.$filename.')';
endif;
	$_SESSION['update']= 'Success. Settings Saved.';

fclose($handle);
};

?>
