<?php
/*
File revision date: 3-Set-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
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
if (isset($_POST['directory'])):
	load_text($staticvars);
endif;
if (!file_exists($staticvars['local_root'].'modules/directory/system/settings.php')):
	$enable_comments=true;
	$enable_voting=true;
	$enable_directory=true;
	$enable_publish=true;
	$enable_user_groups=true;
else:
	include($staticvars['local_root'].'modules/directory/system/settings.php');
endif;

$address=$_SERVER['REQUEST_URI'];
?>
<img src="<?=$staticvars['site_path'].'/modules/directory';?>/images/icone_gestao.gif" /><font class="Header_text_4">Configura&ccedil;&atilde;o geral </font><br />
<br />
<form class="form" method="post" action="<?=$address;?>"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td colspan="2"><font class="body_text">Activar Modo Directory</font>&nbsp;&nbsp;&nbsp;
	<select size="1" name="directory" class="text" >
		<option value="true" <?php if ($enable_directory){?>selected="selected"<?php } ?>>Sim</option>
		<option value="false" <?php if (!$enable_directory){?>selected="selected"<?php } ?>>N&atilde;o</option>
	</select>&nbsp;&nbsp; 
	</td></tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td colspan="2"><font class="body_text">Activar Coment&aacute;rios</font>&nbsp;&nbsp;&nbsp;
	<select size="1" name="comments" class="text" >
		<option value="true" <?php if ($enable_comments){?>selected="selected"<?php } ?>>Sim</option>
		<option value="false" <?php if (!$enable_comments){?>selected="selected"<?php } ?>>N&atilde;o</option>
	</select>&nbsp;&nbsp; 
	</td></tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td colspan="2"><font class="body_text">Activar Vota&ccedil;&atilde;o</font>&nbsp;&nbsp;&nbsp;
	<select size="1" name="voting" class="text" >
		<option value="true" <?php if ($enable_voting){?>selected="selected"<?php } ?>>Sim</option>
		<option value="false" <?php if (!$enable_voting){?>selected="selected"<?php } ?>>N&atilde;o</option>
	</select>&nbsp;&nbsp; 
	</td></tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td colspan="2"><font class="body_text">Activar Publica&ccedil;&atilde;o de conteúdos</font>&nbsp;&nbsp;&nbsp;
	    <select size="1" name="publish" class="text" >
		<option value="true" <?php if ($enable_publish){?>selected="selected"<?php } ?>>Sim</option>
		<option value="false" <?php if (!$enable_publish){?>selected="selected"<?php } ?>>N&atilde;o</option>
	</select>&nbsp;&nbsp; 
	</td></tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td colspan="2"><font class="body_text">Activar Grupos de utilizadores </font>&nbsp;&nbsp;&nbsp;
	    <select size="1" name="user_groups" class="text" >
		<option value="true" <?php if ($enable_user_groups){?>selected="selected"<?php } ?>>Sim</option>
		<option value="false" <?php if (!$enable_user_groups){?>selected="selected"<?php } ?>>N&atilde;o</option>
	</select>&nbsp;&nbsp; 
	</td></tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td align="right" valign="bottom"><input name="add_sub_menu2" type="submit" class="button" value="Gravar" />          </td>
	</tr>
  </table>
  </form>
<?php	

function load_text($staticvars){

$file_content='
<?PHP
// CMS general config
$enable_comments='.$_POST['comments'].';
$enable_voting='.$_POST['voting'].';
$enable_directory='.$_POST['directory'].';
$enable_publish='.$_POST['publish'].';
$enable_user_groups='.$_POST['user_groups'].';
?>';
$filename=$staticvars['local_root'].'modules/directory/system/settings.php';
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

fclose($handle);
};

?>
