<?php
/*
File revision date: 25-Nov-2006
*/
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found(general settings)';
	exit;
endif;

if ((isset($_POST['dl']) or isset($_POST['fl']))and !isset($_POST['continue'])):
	save_settings_language($staticvars);
endif;

if (is_file($staticvars['local_root'].'kernel/settings/language.php')):
	include($staticvars['local_root'].'kernel/settings/language.php');
	if ($lang_type=='flags'):
		$chk[0]='checked="checked"';
		$chk[1]='';
	else:// dropdown menu
		$chk[0]='';
		$chk[1]='checked="checked"';
	endif;
endif;

?>
<script language="javascript">
function switch_dl()
{
  var cur_box = window.document.general_settings.dl;
  var alter_box = window.document.general_settings.fl;
  var the_switch = "";
  if (cur_box.checked == false) {
		alter_box.checked=true;
  } else {
		alter_box.checked=false;
  }
}
function switch_fl()
{
  var cur_box = window.document.general_settings.dl;
  var alter_box = window.document.general_settings.fl;
  if (alter_box.checked == false) {
		cur_box.checked=true;
  } else {
		cur_box.checked=false;
  }
}


</script>

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="85%">
		<form method="post" name="general_settings" action="<?=$_SERVER['REQUEST_URI'];?>"  enctype="multipart/form-data">
		  <table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
			  <td colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$staticvars['site_path'];?>//images/design.jpg">&nbsp;Language selector
		        <hr size="1" color="#666666" /></td>
			</tr>
			<tr>
			  <td colspan="2" class="body_text"><p><strong>Language</strong><br />
				  <br />
				  <input name="dl" type="checkbox" id="dl" value="checkbox" onClick="switch_dl();" <?=$chk[0];?>  />
				  <font style="font-size:12px"><strong>Flags Layout</strong></font> 
				  <br />
			    <font style="font-size:11px">With this option enabled when your layout has the {lang} tag code a menu with the country flags is shown.</font></p>
				<p>
				  <input name="fl" type="checkbox" id="fl" value="checkbox" onClick="switch_fl();" <?=$chk[1];?>  />
				  <font style="font-size:12px"><strong>DropDown Menu</strong></font><br />
				  <font style="font-size:11px">Enabling this option, will put a Dropdown menu with the languages available in the skin layout tag {lang}</font></p>			  </td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			  <td height="15"></td>
			</tr>
			<tr>
			  <td height="15"></td>
			</tr>
			<tr>
			  <td align="right" valign="bottom">
					<input name="image" type="submit" value="Save Settings" class="form_submit">			  </td>
			</tr>
		  </table>
	    </form>	</td>
  </tr>
</table>

<?php	

function save_settings_language($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$filename=$staticvars['local_root'].'kernel/settings/language.php';
if (file_exists($filename)):
	include($filename);
	unlink($filename);
else:
	$layout_name='';
endif;

if(isset($_POST['dl'])):
	$lang_type='flags';
else:
	$lang_type='dropdown';
endif;

$file_content='
<?PHP
// Language selector layout
$lang_type="'.$lang_type.'";
?>';
$handle = fopen($filename, 'a');
fwrite($handle, $file_content);
fclose($handle);
echo '<font class="body_text"> <font color="#FF0000">Settings Saved</font></font>';
};

?>
