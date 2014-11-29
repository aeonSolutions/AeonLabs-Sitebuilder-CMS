<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
include($globvars['site']['directory'].'kernel/staticvars.php');
if(!is_dir($filename=$globvars['site']['directory'].'kernel/settings')):
	mkdir($filename=$globvars['site']['directory'].'kernel/settings');
endif;
$chg=false;
if (isset($_POST['dl']) or isset($_POST['fl'])):
	save_settings_layout($globvars);
	$chg=true;
endif;
if (isset($_POST['ums']) or isset($_POST['no_ums'])):
	save_settings_ums($globvars);
	$chg=true;
endif;
if (isset($_POST['dm']) or isset($_POST['sm']) or isset($_POST['nm'])):
	save_settings_menu($globvars);
	$chg=true;
endif;
if(isset($_POST['continue'])):
	header("Location: ".strip_address("step",$_SERVER['REQUEST_URI']));
	//echo 'used to be a header here general_settings';
	exit;
endif;
if($chg==true):
	$chg='<input name="save" id="save" type="submit" value="Save Settings" class="button">';
else:
	$chg='<input id="continue" name="continue" type="submit" value="Continue" class="button">';
endif;
$query=$db->getquery("SHOW TABLES LIKE 'skin'");
if ($query[0][0]<>''):
	$chk[0]='checked="checked"';
	$chk[1]='';
else:
	$chk[0]='';
	$chk[1]='checked="checked"';
endif;
$query=$db->getquery("SHOW TABLES LIKE 'menu'");
if ($query[0][0]<>''):
	$chk[5]='checked="checked"';
		$chk[6]='';
		$chk[7]='';
elseif (is_file($globvars['site']['directory'].'kernel/settings/menu.php')):
	include($globvars['site']['directory'].'kernel/settings/menu.php');
	if ($menu_type=='static'):
		$chk[5]='';
		$chk[6]='checked="checked"';
		$chk[7]='';
	else:// menu disabled
		$chk[5]='';
		$chk[6]='';
		$chk[7]='checked="checked"';
	endif;
else:
		$chk[5]='checked="checked"';
		$chk[6]='';
		$chk[7]='';
endif;

$query=$db->getquery("SHOW TABLES LIKE 'users'");
if ($query[0][0]<>''):
	$chk[2]='checked="checked"';
	$chk[3]='';
	$dsb[0]='';
else:
	$chk[2]='';
	$chk[3]='checked="checked"';
	$dsb[0]='disabled="disabled"';
	$chk[5]='';
	$chk[6]='checked="checked"';
	$chk[7]='';
endif;
$query=$db->getquery("SHOW TABLES LIKE 'box_effects'");
if ($query[0][0]<>''):
	$chk[4]='checked="checked"';
else:
	$chk[4]='';
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
function switch_ums()
{
  var cur_box = window.document.general_settings.ums;
  var alter_box = window.document.general_settings.no_ums;
  var alter_box2 = window.document.general_settings.dm;
  if (cur_box.checked == false) {
		alter_box.checked=true;
		alter_box2.disabled=true;
  } else {
		alter_box.checked=false;
		alter_box2.disabled=false;
  }
}
function switch_no_ums()
{
  var cur_box = window.document.general_settings.ums;
  var alter_box = window.document.general_settings.no_ums;
  var alter_box2 = window.document.general_settings.dm;
  if (alter_box.checked == false) {
		cur_box.checked=true;
		alter_box2.disabled=false;
  } else {
		cur_box.checked=false;
		alter_box2.disabled=true;
  }
}

function switch_dm()
{
  var cur_box = window.document.general_settings.dm;
  var alter_box = window.document.general_settings.sm;
  var alter_box2 = window.document.general_settings.nm;
cur_box.checked=true;
alter_box.checked=false;
alter_box2.checked=false;
}

function switch_sm()
{
  var cur_box = window.document.general_settings.sm;
  var alter_box = window.document.general_settings.dm;
  var alter_box2 = window.document.general_settings.nm;
cur_box.checked=true;
alter_box.checked=false;
alter_box2.checked=false;
}
function switch_nm()
{
  var cur_box = window.document.general_settings.nm;
  var alter_box = window.document.general_settings.dm;
  var alter_box2 = window.document.general_settings.sm;
cur_box.checked=true;
alter_box.checked=false;
alter_box2.checked=false;
}

</script>

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="85%">
		<form class="form" method="post" name="general_settings" action="<?=strip_address("step",strip_address("set",$_SERVER['REQUEST_URI']));?>"  enctype="multipart/form-data">
		  <table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
			  <td colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$globvars['site_path'];?>//images/design.jpg">&nbsp;Design<hr size="1" color="#666666" /></td>
			</tr>
			<tr>
			  <td colspan="2" class="body_text"><p><strong>WebPage Design Layout</strong><br />
				  <br />
				  <input name="dl" type="checkbox" id="dl" value="checkbox" onClick="switch_dl();" <?=$chk[0];?>  />
				  <font style="font-size:12px"><strong>Dynamic Layout</strong></font> 
				  <br />
				  <font style="font-size:11px">Choose dynamic Layout if you would like to have more than one Design Layout for your website. <br />
				With this option you can switch between Design layouts according with the contents displayed</font></p>
				<p>
				  <input name="fl" type="checkbox" id="fl" value="checkbox" onClick="switch_fl();" <?=$chk[1];?>  />
				  <font style="font-size:12px"><strong>Fixed Layout</strong></font> <br />
			    <font style="font-size:11px">Choose fixed layout if want the website to have always the same WebPage Layout.</font></p></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			  <TD colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$globvars['site_path'];?>/images/users.jpg">&nbsp;Users
				<hr size="1" color="#666666" /></TD>
			</tr>
			<tr>
			  <td colspan="2"><p><br />
				  <input name="ums" type="checkbox" id="ums" value="checkbox" onClick="switch_ums();" <?=$chk[2];?> />
				  <font style="font-size:12px"><strong>With User Management System</strong></font> <br />
				  <font style="font-size:11px">A user management system, with user groups customization, reserved area and login authentication.<br />
				  With This option enabled you can customize Main Menu for each user group and define access Rights in your website. </font>
			  
				</p><p>
				  <input name="no_ums" type="checkbox" id="no_ums" value="checkbox" onClick="switch_no_ums();" <?=$chk[3];?> />
				  <font style="font-size:12px"><strong>Without User Groups</strong></font> <br />
				  <font style="font-size:11px">Without user groups, the hole website is browsable for everyone</font> </p></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			  <TD colspan="2" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$globvars['site_path'];?>/images/contents.jpg">&nbsp;Contents
				<hr size="1" color="#666666" /></TD>
			</tr>
			<tr>
			  <td colspan="2"><p><strong>Menu</strong><br />
                    <br />
                    <input name="dm" type="checkbox" id="dm" value="checkbox" onclick="switch_dm();" <?=$chk[5];?>  <?=$dsb[0];?>/>
                    <font style="font-size:12px"><strong>Dynamic Menu</strong></font> <br />
                <font style="font-size:11px">Choose dynamic Menu if you would like to have a custumizable menu for each user group. <br />
                With this option enabled you can switch the menu options according the type of user that is browsing the website.<br />
                To enable this option you also need to enable the User Management System in the user options above.</font></p>
			    <p>
                  <input name="sm" type="checkbox" id="sm" value="checkbox" onclick="switch_sm();" <?=$chk[6];?>  />
                  <font style="font-size:12px"><strong>Static Menu</strong></font> <br />
                  <font style="font-size:11px">Choose satic Menu if want the same menu for every user or user type that visits you website.</font></p>
		      <p>
		        <input name="nm" type="checkbox" id="nm" value="checkbox" onclick="switch_nm();" <?=$chk[7];?>  />
                <font style="font-size:12px"><strong>No  Menu</strong></font> <br />
                <font style="font-size:11px">Choose No Menu if your site doesn't have a menu or if you want to manually define one.</font></p></td>
			</tr>
			<tr>
			  <td colspan="2">&nbsp;</td></tr>
			<tr>
			  <td height="15"></td>
			</tr>
			<tr>
			  <td height="15"></td>
			</tr>
			<tr>
			  <td align="right" valign="bottom">
					<?php
					echo $chg;
					?>
			  </td>
			</tr>
		  </table>
	    </form>
	</td>
    <td width="15%" align="left" valign="bottom">	</td>
  </tr>
</table>

<?php	

function save_settings_layout($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
copy($globvars['local_root'].'copyfiles/advanced/layout/language_code.php',$globvars['site']['directory'].'/layout/language_code.php');
copy($globvars['local_root'].'copyfiles/advanced/layout/main_code.php',$globvars['site']['directory'].'/layout/main_code.php');

$filename=$globvars['site']['directory'].'kernel/settings/layout.php';
if (file_exists($filename)):
	include($filename);
	unlink($filename);
else:
	$layout_name='';
endif;

if(isset($_POST['dl'])):
	$query=$db->getquery("SHOW TABLES LIKE 'skin'");
	if ($query[0][0]==''):
		$db->setquery("CREATE TABLE `skin` (
		  `cod_skin` int(11) NOT NULL auto_increment,
		  `ficheiro` varchar(255) NOT NULL default '',
		  `num_cells` tinyint(4) NOT NULL default '0',
		  `active` char(1) NOT NULL default 'n',
		  `default_cell` tinyint(4) NOT NULL default '0',
		  PRIMARY KEY  (`cod_skin`)
		) ENGINE=MyISAM AUTO_INCREMENT=1");
		$verify=$db->getquery("SHOW TABLES LIKE 'skin'");
		if ($verify[0][0]==''):
			$globvars['warnings']='Unable to insert table to  DB! < skin >';
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit;
			endif;
		endif;
	endif;
	$layout='dynamic';
	$layout_name='$layout_name="'.$layout_name.'"';
else:
	$query=$db->getquery("SHOW TABLES LIKE 'skin'");
	if ($query[0][0]<>''):
		$db->setquery("drop table skin");
	endif;
	$layout="static";
	$layout_name='$layout_name="'.$layout_name.'"';
endif;

$file_content='
<?PHP
// WebPage Design Layout
$layout="'.$layout.'";
'.$layout_name.';
$box_fx="";
?>';
$handle = fopen($filename, 'a');
if(fwrite($handle, $file_content)==false):
	$globvars['warnings']='Unable to write file:'.$filename;
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
endif;
fclose($handle);
};

function save_settings_ums($globvars){
include($globvars['local_root'].'update_db/user_groups_setup.php');
if(isset($_POST['no_ums'])):
	// without UMS the main menu has to be static
	$file_content='
	<?PHP
	// UMS general config
	$ug_type="static";
	?>';
else:
	$file_content='
	<?PHP
	// UMS general config
	$ug_type="dynamic";
	?>';
endif;
$filename=$globvars['site']['directory'].'kernel/settings/ums.php';
if (file_exists($filename)):
	unlink($filename);
endif;
$handle = fopen($filename, 'a');
if(fwrite($handle, $file_content)==false):
	$globvars['warnings']='Unable to write file:'.$filename;
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
endif;
fclose($handle);

};

function save_settings_menu($globvars){
include($globvars['site']['directory'].'kernel/staticvars.php');
if(isset($_POST['dm'])):
	@mkdir($globvars['site']['directory'].'layout/menu');
	copyr($globvars['local_root'].'copyfiles/advanced/layout/menu',$globvars['site']['directory'].'/layout/menu',$globvars);
	$file_content='
	<?PHP
	// Menu general config
	$menu_type="dynamic";
	?>';
elseif(isset($_POST['sm'])):
	$file_content='
	<?PHP
	// Menu general config
	$menu_type="static";
	?>';
	$msg='Static Menu selected';
else:
	$file_content='
	<?PHP
	// Menu general config
	$menu_type="disabled";
	?>';
	$msg='Menu Disabled';
endif;
$filename=$globvars['site']['directory'].'kernel/settings/menu.php';
if (file_exists($filename)):
	unlink($filename);
endif;
!$handle = fopen($filename, 'a');
if(fwrite($handle, $file_content)==false):
	$globvars['warnings']='Unable to write file:'.$filename;
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
endif;
fclose($handle);
if(isset($_POST['nm'])):
	$query=$db->getquery("SHOW TABLES LIKE 'menu'");
	if ($query[0][0]<>''):
		$db->setquery("drop table menu, menu_layout");
	endif;
	if (is_dir($absolute_path.'/layout/menu')):
		delr($absolute_path.'/layout/menu',$globvars);
	endif;
	$menu_type='static';		
	$db->setquery("delete from module where link='menu/menu.php'");
	$file_content='
	<?PHP
	// Menu general config
	$menu_type="static";
	?>';
	$filename=$globvars['site']['directory'].'kernel/settings/menu.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
	$file_content='
	<?PHP
	echo "'.$msg.'";
	?>';
	$filename=$globvars['site']['directory'].'layout/menu/menu.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $file_content)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);
endif;

if(isset($_POST['dm']) or isset($_POST['sm'])):
	$link=mysql_connect($db->host, $db->user, $db->password);
	if (!$link):
	   echo 'Could not connect to mysql (setup menu) !';
	   exit;
	endif;
	$result=mysql_select_db($db->name);
	if (!$result):
		$globvars['warnings']='Could not select DB <'.$db->name.'>';
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=false; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			sleep(1);
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	if(!mysql_query("SHOW TABLES like 'menu'")):
		mysql_query("CREATE TABLE `menu` (
		  `cod_menu` int(11) NOT NULL auto_increment,
		  `cod_sub_menu` int(11) NOT NULL default '0',
		  `cod_user_type` int(11) NOT NULL default '0',
		  `cod_module` int(11) NOT NULL default '0',
		  `active` char(1) NOT NULL default 's',
		  `name` varchar(50) NOT NULL default '',
		  `link` varchar(255) NOT NULL default 'N/A',
		  `aditional_params` varchar(255) NOT NULL default 'N/A',
		  `display_name` varchar(255) NOT NULL default '',
		  `priority` int(11) NOT NULL default '30000',
		  PRIMARY KEY  (`cod_menu`)
		) ENGINE=MyISAM AUTO_INCREMENT=1");
		if (mysql_error()):
			mysql_close($link);
			$globvars['warnings']='Could not CREATE TABLE <`menu`>';
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				sleep(1);
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit;
			endif;
		endif;
	
		mysql_query("CREATE TABLE `menu_layout` (
		  `cod_menu_layout` int(11) NOT NULL auto_increment,
		  `ficheiro` varchar(255) NOT NULL default '',
		  `nome` varchar(100) NOT NULL default '',
		  `active` char(1) NOT NULL default 'n',
		  PRIMARY KEY  (`cod_menu_layout`)
		) ENGINE=MyISAM AUTO_INCREMENT=1");
		if (mysql_error()):
			mysql_close($link);
			$globvars['warnings']='Could not CREATE TABLE <`menu_layout`>';
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				sleep(1);
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit;
			endif;
		endif;
		mysql_close($link);
	
		if(isset($_POST['dm'])):
			$default_code=$db->getquery("select cod_user_type from user_type where name='Default'");
			if ($default_code[0][0]<>''):
				$default_code=$default_code[0][0];
			else:
				$default_code=-1;
			endif;
		else:
			$default_code=-1;
		endif;
		$module="('Menu', 'en=menu||pt=menu', 'menu/menu.php', 's', ".$default_code.", 'no', 'N/A', -1, 0)";
		$db->setquery("INSERT INTO `module` (`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`) VALUES ".$module);
		copyr($globvars['local_root'].'copyfiles/advanced/layout/menu',$globvars['site']['directory'].'/layout/menu',$globvars);
		$menu_type='dynamic';
	endif;
endif;
};
?>
