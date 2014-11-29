<?php
/*
File revision date: 10-Out-2007
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
include($staticvars['local_root'].'kernel/staticvars.php');
if (isset($_POST['presents'])):
	load_text($staticvars);
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);
endif;
if (!file_exists($staticvars['local_root'].'modules/news/system/settings.php')):
	$enable_lateral=true;
	$smilies=false;
	$disable_header=false;
	$disable_news=false;
else:
	include($staticvars['local_root'].'modules/news/system/settings.php');
endif;

$address=$_SERVER['REQUEST_URI'];
?>
<h3><img src="<?=$staticvars['site_path'].'/modules/news';?>/images/icone_gestao.gif" />Configura&ccedil;&atilde;o geral<br />
  <br />
</h3>
<form class="form" method="post" action="<?=$address;?>"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td colspan="2"><font class="body_text">Presentation mode </font>&nbsp;&nbsp;
	    <select size="1" name="presents" class="text" >
		<option value="true" <?php if ($enable_lateral){?>selected="selected"<?php } ?>>Lateral frame (200px)</option>
		<option value="false" <?php if (!$enable_lateral){?>selected="selected"<?php } ?>>MainFrame (>200px)</option>
	</select>&nbsp;&nbsp;	</td></tr>
	<tr>
	  <td height="15"></td>
	</tr>
	
	<tr>
	  <td align="left" valign="bottom"> Smilies<font class="body_text">&nbsp; </font>&nbsp;&nbsp;
        <select size="1" name="smilies" class="text" id="smilies" >
          <option value="true" <?php if ($smilies){?>selected="selected"<?php } ?>>Activado</option>
          <option value="false" <?php if (!$smilies){?>selected="selected"<?php } ?>>Desactivado</option>
                        </select></td>
    </tr>
	<tr>
	  <td align="right" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom"><input <?php if ($disable_news){?>checked="checked"<?php } ?> class="text" type="checkbox" name="disable_news" id="disable_news" />
	    Disable if no news available</td>
    </tr>
	<tr>
	  <td align="left" valign="bottom"><input <?php if ($disable_header){?>checked="checked"<?php } ?> class="text" type="checkbox" name="disable_header" id="disable_header" /> 
	    Disable News Header</td>
    </tr>
	<tr>
	  <td align="right" valign="bottom">&nbsp;</td>
    </tr>
	
	<tr>
	  <td align="right" valign="bottom"><input name="add_sub_menu2" type="submit" value="Save" class="button" />          </td>
	</tr>
  </table>
</form>
<?php	

function load_text($staticvars){
$disable_header= isset($_POST['disable_header']) ? 1 : 0;
$disable_news= isset($_POST['disable_news']) ? 1 : 0;
$file_content='
<?PHP
// News general config
$enable_lateral='.$_POST['presents'].';
$disable_header='.$disable_header.';
$disable_news='.$disable_news.';
$smilies='.$_POST['smilies'].';
?>';
$filename=$staticvars['local_root'].'modules/news/system/settings.php';
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
