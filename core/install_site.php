<?php
/*
File revision date: 16-jan-2008
*/

// implement security measures for direct file access!
$address_root=$_SERVER['HTTP_HOST'];
if ($address_root=='localhost'):
	$address_root='http://'.$address_root.$_SERVER['REQUEST_URI'];
else:
	$address_root=$_SERVER['REQUEST_URI'];
endif;
$path=explode("/",$address_root);
$local=$path[0];
for ($i=1;$i<count($path);$i++):
	if (strtolower($path[$i])=='setup'):
		break;
	else:
		$local=$local.'/'.$path[$i];
	endif;
endfor;
$address_root=$local;
$link=$address_root.'.php';

if (file_exists($local_root.'general/staticvars.php')):
	include($local_root.'general/staticvars.php');
	$link=mysql_connect($db->host, $db->user, $db->password);
	if (mysql_select_db($db->name)):
		mysql_close($link);
		header("Location: ".$address_root.".php");
		echo 'StartUp file and DataBase is present ! (Install Site-53)';
		exit;
	else:
		$link=$address_root.'.php';
	endif;
else:
	$link=$address_root.'.php';
endif;
if (isset($_POST['create_tables'])):
	create_tables($local_root);
	echo "<font class='body_text' color='#FF0000'>Database created sucessfully.</font>";
	$link=$address_root.'.php';
elseif(isset($_POST['meta_description'])):
	if ($_POST['smtp_password']==$_POST['smtp_password2']):
		if ($_POST['db_password']==$_POST['db_password2']):
			if ($handle = fopen($local_root.'classes/DB_Class.php', 'r')):
				fclose($handle);
				load_text($local_root);
				unset($_POST['meta_description']);
				unset($_POST['smtp_password']);
				unset($_POST['db_password']);
				if (create_tables($local_root)<>-1):
					echo "<font class='body_text' color='#FF0000'>StaticVars and Database created sucessfully.</font>";
				endif;
			else:
				echo "<font class='body_text' color='#FF0000'>Invalid absolute path!</font>";
			endif;
		else:
			echo "<font class='body_text' color='#FF0000'>Diferent Database Passwords typed!</font>";
		endif;
	else:
		echo "<font class='body_text' color='#FF0000'>Diferent SMTP passwords typed!</font>";
	endif;
endif;
if (!isset($_GET['id'])):
	?>
	<!DOCTYPE HTML var "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<title>Site Builder - Install Site</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		.body_text{
				color: #000000;
				font-size : 12px;
				font-weight:normal;
				font:Arial, Helvetica, sans-serif;
				TEXT-DECORATION: none;
		}
		.header_text_1{
				color: #000000;
				font-size : 14px;
				font-weight : bolder;
				font:Arial, Helvetica, sans-serif;
				TEXT-DECORATION: none;
		}
		.visBtn3 {
			PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: bold; FONT-SIZE: 6pt; PADDING-BOTTOM: 1px;
			BORDER-LEFT: #666600 1px solid; WIDTH: 85px; PADDING-TOP: 1px; FONT-FAMILY: Verdana;
			BACKGROUND-COLOR: orange; TEXT-ALIGN: center}
		
		.copyright { MARGIN-TOP: 0px; FONT-SIZE: 8pt; COLOR: gray; FONT-FAMILY: Arial; TEXT-ALIGN: center}
		#bottomBtnBar {	BORDER-TOP: #990000 1px solid; MARGIN-TOP: 20px	}
	</style>
	</head>
	
	<body>
<?=$address_root.'-m';?>
	
	<table width="890" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
			  <TR>
				<TD vAlign=top width=10><IMG height=50 src="<?=$address_root;?>/core/layout/top-logo.png" width=250 border=0>
				<TD style="VERTICAL-ALIGN: bottom" vAlign=bottom align=left>
				<TD width=500 align=right vAlign=top class=hash>
			  </TR>
			</TBODY>
		  </TABLE>
		  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
			  <TR>
				<TD style="BACKGROUND-COLOR: #434E59" align=right>
				<TABLE id=nlTopBtnBar cellSpacing=0 cellPadding=0 align="left" border=0>
					<TBODY>
					  <TR>
						<TD class="visBtn3" id=btnDefault>::&nbsp;Install Site</TD>
					  </TR>
					</TBODY>
				</TABLE>
				</TD>
			  </TR>
			</TBODY>
		  </TABLE>
		  
		</td>
	  </tr>
	  <tr>
		<td>
	<?
	endif;
	?>	
		<form action="<?=$link;?>" enctype="multipart/form-data" method="post">
		<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style=" border-left-color:#000000; border-left-width:1px; border-left-style:solid; border-right-color:#000000; border-right-width:1px;border-right-style:solid;">
		  <tr>
			<td width="15">&nbsp;</td>
			<td colspan="2">
			  <span class="body_text">
			  <?php
			$no_tables='';
			if (!file_exists($local_root.'general/staticvars.php')):
				echo '<font color="FF0000">You need to SETUP Static Variables environment</font>';
				if (isset($_POST['site_name'])):
					$meta__keywords=$_POST['meta_keywords'];
					$meta__description=$_POST['meta_description'];
					
					$smtp__host=$_POST['smtp_host'];
					$smtp__password=$_POST['smtp_password'];
					$smtp__password2=$_POST['smtp_password'];
					$smtp__username=$_POST['smtp_username'];
					$admin__mail=$_POST['admin_mail'];
					
					$site__name=$_POST['site_name'];
					$site__path=$_POST['site_path'];
					$absolute__path=$_POST['absolute_path'];
			
					$upload__dir__name=$_POST['upload_dir_name'];
			
					$page__title=$_POST['page_title'];
					$site__version=$_POST['site_version'];
					
					$db_host=$_POST['db_host'];
					$db_user=$_POST['db_user'];
					$db_password=$_POST['db_password'];
					$db_password2=$_POST['db_password'];
					$db_name=$_POST['db_name'];
					$db_type=$_POST['db_type'];
					
					$main__language=$_POST['main_language'];
					$session__id=$_POST['session_id'];
					$cookies__enabled=$_POST['cookies_enabled'];
					$cookie__expire=$_POST['cookie_expire'];
					$cookie__path=$_POST['cookie_path'];
				else:
					$site__path=$address_root;
					$path=explode("/",__FILE__);
					$local=$path[0];
					for ($i=1;$i<count($path);$i++):
						if (strtolower($path[$i])=='setup'):
							break;
						else:
							$local=$local.'/'.$path[$i];
						endif;
					endfor;
					$absolute__path=$local.'/';
	
					$no_tables="staticvars";
					$session__id=md5( uniqid( rand () ) );
					$cookies__enabled=true;
					$cookie__expire="60*60*24*15";
					$cookie__path='/';
					$smtp__host="localhost";
					$smtp__username="smtpusr";
					$db_host="localhost";
					$db_user="root";
					$site__version='1.0';
				endif;
			else:
				include($local_root.'general/staticvars.php');
				$meta__keywords=$meta_keywords;
				$meta__description=$meta_description;
				
				$smtp__host=$smtp_host;
				$smtp__password=$smtp_password;
				$smtp__password2=$smtp_password;
				$smtp__username=$smtp_username;
				$admin__mail=$admin_mail;
				
				$site__name=$site_name;
				$site__path=$site_path;
				$absolute__path=$absolute_path;
				$absolute__path=str_replace("/",'<>',$absolute__path);
				$absolute__path=str_replace("<","/",$absolute__path);
				$absolute__path=str_replace(">","/",$absolute__path);
		
				$upload__dir__name=$upload_dir_name;
		
				$page__title=$page_title;
				$site__version=$version;
				
				$db_host=$db->host;
				$db_user=$db->user;
				$db_password=$db->password;
				$db_password2=$db->password;
				$db_name=$db->name;
				$db_type=$db->type;
				
				$main__language=$main_language;
				
				$cookies__enabled=$cookies_enabled;
				$cookie__expire=$COOKIE_EXPIRE;
				$cookie__path=$COOKIE_PATH;
				
				$session__id=$session_id;
				
				$link=mysql_connect($db->host, $db->user, $db->password);
				$no_tables="tables";
				if (!mysql_select_db($db->name)):
				   echo '<br><font color="FF0000">You need to build database primary tables!</font>';
				   $no_tables="missing tables";
				endif;
				mysql_close($link);
			endif; 
			?>
			  </span>	</td>
			<td width="15">&nbsp;</td>
		  </tr>
		<?php
		if ($no_tables=="missing tables"):
			?>
			  <tr>
				<td width="15">&nbsp;</td>
				<td colspan="2">
					<font class="body_text">Click here to build primary tables in the database .&nbsp;&nbsp;&nbsp;</font>
					<input type="image" src="<?=$address_root;?>/images/buttons/pt/ok.gif">
				<input type="hidden" name="create_tables" value="ok">		</td>
				<td width="15">&nbsp;</td>
			  </tr>
			<?php
		elseif($no_tables=="tables"):
			?>
			  <tr>
				<td width="15">&nbsp;</td>
				<td colspan="2">
					<font class="body_text">Website created sucessfully. Click here to start configuring </font>
					<input type="image" src="<?=$address_root;?>/images/buttons/pt/ok.gif">
					<input type="hidden" name="return_setup" value="ok"></td>
				<td width="15">&nbsp;</td>
			  </tr>
			<?php
		endif;
		?>
		</table>
		</form>
		<form action="<?=$link;?>" enctype="multipart/form-data" method="post">
		<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style=" border-left-color:#000000; border-left-width:1px; border-left-style:solid; border-right-color:#000000; border-right-width:1px;border-right-style:solid;">
		  <tr>
			<td width="15">&nbsp;</td>
			<td colspan="2">
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250"><span class="header_text_1">Meta tags : </span></td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td colspan="2" align="left" valign="top"><span class="body_text">Keywords:<br>
			  <textarea name="meta_keywords" cols="80" rows="5" id="meta_keywords"><?=@$meta__keywords;?></textarea>
			</span></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td colspan="2" align="left" valign="top"><span class="body_text">Description:<br>
				<textarea name="meta_description" cols="80" rows="5" id="meta_description"><?=@$meta__description;?></textarea>
			</span></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" background="../images/dividers/horz_divider.gif">&nbsp;</td>
			</tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="left" valign="top"><span class="header_text_1">Site Location:</span></td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">Site name: </span></td>
			<td width="300"><input name="site_name" type="text" class="body_text" id="site_name" value="<?=@$site__name;?>" size="50"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">URL path: </span></td>
			<td width="300"><input name="site_path" type="text" class="body_text" id="site_path" value="<?=$site__path;?>" size="50"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align="right" valign="top">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align="right" valign="top"><span class="body_text">Absolute Path (Hard drive): </span></td>
			<td><input name="absolute_path" type="text" class="body_text" id="absolute_path" value="<?=@$absolute__path;?>" size="50"></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align="right" valign="top">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  
		  <tr>
			<td>&nbsp;</td>
			<td align="right" valign="top"><span class="body_text">Upload directory name : </span></td>
			<td><input name="upload_dir_name" type="text" class="body_text" id="upload_dir_name" value="<?=@$upload__dir__name;?>" size="50"></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" background="../images/dividers/horz_divider.gif">&nbsp;</td>
			</tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="left" valign="top"><span class="header_text_1">Page Layout and Styling: </span></td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">Page title: </span></td>
			<td width="300"><textarea name="page_title" cols="60" rows="3" class="body_text" id="page_title"><?=@$page__title;?></textarea></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">Site version: </span></td>
			<td width="300"><input name="site_version" type="text" class="body_text" id="site_version" value="<?=@$site__version;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" background="../images/dividers/horz_divider.gif">&nbsp;</td>
			</tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="left" valign="top"><span class="header_text_1">SMTP Mail Settings: </span></td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text"> Host: </span></td>
			<td width="300"><input name="smtp_host" type="text" class="body_text" id="smtp_host" value="<?=@$smtp__host;?>" size="35"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">User name: </span></td>
			<td width="300"><input name="smtp_username" type="text" class="body_text" id="smtp_username" value="<?=@$smtp__username;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">Password:</span></td>
			<td width="300"><input name="smtp_password" type="password" class="body_text" id="smtp_password" value="<?=@$smtp__password;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">repeat password: </span></td>
			<td width="300"><input name="smtp_password2" type="password" class="body_text" id="smtp_password2" value="<?=@$smtp__password2;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">Administrator mail: </span></td>
			<td width="300"><input name="admin_mail" type="text" class="body_text" id="admin_mail" value="<?=@$admin__mail;?>" size="35"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" background="../images/dividers/horz_divider.gif">&nbsp;</td>
			</tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="left" valign="top"><span class="header_text_1">Database configuration:</span></td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
			<tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">type : </span></td>
			<td width="300">
			<select size="1" name="db_type" class="form_input">
			<option value="mysql" <?php if (@$db_type=='mysql'){?>selected<?php } ?>>MySql Database</option>
			<option value="mssql" <?php if (@$db_type=='mssql'){?>selected<?php } ?>>MicroSoft Sql Database</option>
			</select>	</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		<tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">name: </span></td>
			<td width="300"><input name="db_name" type="text" class="body_text" id="db_name" value="<?=@$db_name;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">host:</span></td>
			<td width="300"><input name="db_host" type="text" class="body_text" id="db_host" value="<?=@$db_host;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">user:</span></td>
			<td width="300"><input name="db_user" type="text" class="body_text" id="db_user" value="<?=@$db_user;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">password:</span></td>
			<td width="300"><input name="db_password" type="password" class="body_text" id="db_password" value="<?=@$db_password;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">repeat password: </span></td>
			<td width="300"><input name="db_password2" type="password" class="body_text" id="db_password2" value="<?=@$db_password2;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" background="../images/dividers/horz_divider.gif">&nbsp;</td>
			</tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="left" valign="top"><span class="header_text_1">Language Settings:</span></td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
			<tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">main site language : </span></td>
			<td width="300">
			<select size="1" name="main_language" class="form_input">
			<option value="pt" <?php if (@$main__language=='pt'){?>selected<?php } ?>>[PT] - Portuguese</option>
			<option value="en" <?php if (@$main__language=='en'){?>selected<?php } ?>>[EN] - English</option>
			</select>	</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="4" background="../images/dividers/horz_divider.gif">&nbsp;</td>
			</tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="left" valign="top"><span class="header_text_1">Session ID &amp; Cookies: </span></td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
            <td>&nbsp;</td>
		    <td align="right" valign="top"><span class="body_text">Session ID: </span></td>
		    <td><input name="session_id" type="text" class="body_text" id="session_id" value="<?=@$session__id;?>" size="35" /></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
            <td>&nbsp;</td>
		    <td align="right" valign="top">&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
			<tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">enable cookies : </span></td>
			<td width="300">
			<select size="1" name="cookies_enabled" class="form_input">
			<option value="true" <?php if (@cokies__enabled){?>selected<?php } ?>>Yes</option>
			<option value="false" <?php if (@$cokies__enabled==false){?>selected<?php } ?>>No</option>
			</select>	</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">Cookie expire : </span></td>
			<td width="300"><input name="cookie_expire" type="text" class="body_text" id="smtp_host" value="<?=@$cookie__expire;?>" size="35"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top"><span class="body_text">Cookie path : </span></td>
			<td width="300"><input name="cookie_path" type="text" class="body_text" id="smtp_username" value="<?=@$cookie__path;?>"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300" align="right" class="body_text">Click Save to build staticvars environment  </td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300" align="right"><input type="image" src="../images/buttons/en/gravar.gif"></td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15">&nbsp;</td>
			<td width="250" align="right" valign="top">&nbsp;</td>
			<td width="300">&nbsp;</td>
			<td width="15">&nbsp;</td>
		  </tr>
		</table>
		</form>
<?php
if (!isset($_GET['id'])):
	?>
	</td>
  </tr>
  <tr valign="bottom">
    <td width="100%" height="5" align="center">
		<DIV class="copyright">Copyright © 2006 All rights reserved.</DIV>
	</td>
  </tr>
</table>

</body>
</html>
<?php
endif;

function load_text($header_root){
//$_POST['absolute_path']=str_replace("//",'/',$_POST['absolute_path']);


// falta retirar / no ultimo char de abs_path

$file_content='
<?PHP
// Meta tags Configuration
$meta_description="'.$_POST['meta_description'].'";
$meta_author="SiteBuilder 2008 - V4.1";
$meta_keywords="'.$_POST['meta_keywords'].'"; 
$meta_robots="nofollow, index";

// smtp configuration
	$smtp_host="'.$_POST['smtp_host'].'";
	$smtp_password="'.$_POST['smtp_password'].'";
	$smtp_username="'.$_POST['smtp_username'].'";
	
// Site Localization 
	$site_name="'.$_POST['site_name'].'";
	$site_path="'.$_POST['site_path'].'";
	$absolute_path = "'.$_POST['absolute_path'].'";	// No trailing slash

// site layout and styling
	$static_css=true;
	$page_title="'.$_POST['page_title'].'";
	$version="'.$_POST['site_version'].'";

//Upload Path
	$upload_dir_name="'.$_POST['upload_dir_name'].'";
	$upload_directory = $absolute_path."/".$upload_dir_name;
	$upload_path = $site_path."/".$upload_dir_name;

// temporary  files management
	$temporary_directory=$absolute_path."/tmp";
	$temporary_path=$site_path."/tmp";

//tamanho maximo do ficheiro em MB
	$max_file_size=7;
	
// Database configuration settings
	include_once("db_class.php");
	$db = new database_class;
	$db->host="'.$_POST['db_host'].'";
	$db->user="'.$_POST['db_user'].'";
	$db->password="'.$_POST['db_password'].'";
	$db->name="'.$_POST['db_name'].'";
	$db->type="'.$_POST['db_type'].'"; /* possible database types: mssql, mysql */

// mail settings
	$admin_mail="'.$_POST['admin_mail'].'";
	
// language settings
	/*
	language options:
		pt - for portuguese
		en - for english
	*/
	$main_language="'.$_POST['main_language'].'";

//Cookies Settings
	$cookies_enabled='.$_POST['cookies_enabled'].';
	$COOKIE_EXPIRE='.$_POST['cookie_expire'].';  //100 days by default
	$COOKIE_PATH="'.$_POST['cookie_path'].'";  //Available in whole domain

// Session Settings
	$session_id="'.$_POST['session_id'].'"
?>';
$filename=$header_root.'general/staticvars.php';
if (file_exists($filename)):
	unlink($filename);
endif;
if (!$handle = fopen($filename, 'a')):
	echo "<font class='body_text' color='#FF0000'>Cannot open file (".$filename.")</font>";
	exit;
endif;
if (fwrite($handle, $file_content) === FALSE):
	echo "<font class='body_text' color='#FF0000'>Cannot write to file (".$filename.")</font>";
	exit;
endif;
echo "<font class='body_text' color='#FF0000'>Success, Updates were changed!</font>";
fclose($handle);
// create  upload direcory
mkdir($_POST['absolute_path'].'/'.$_POST['upload_dir_name']);
};

function create_tables($local_root){
include($local_root.'general/staticvars.php');
$link=mysql_connect($db->host, $db->user, $db->password);
if (!$link):
   echo 'Could not connect to mysql - Error Creating tables';
   return -1;
endif;
$result=mysql_query("CREATE DATABASE ".$db->name);
mysql_close($link);
include($local_root.'update_db/install_db.php');
};