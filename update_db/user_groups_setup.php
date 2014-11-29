<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
include($globvars['site']['directory'].'kernel/staticvars.php');
$menu=isset($_GET['mod']) ? $_GET['mod'] : '';
if (isset($_POST['add_username'])):
	$query=$db->setquery("insert into user_type set name='".mysql_escape_string($_POST['add_username'])."',
	cod_user_group='".mysql_escape_string($_POST['add_user_groups'])."'");
	echo '<font class="body_text"> <font color="#FF0000">Grupo de utilizadores adicionado</font></font>';
elseif (isset($_POST['del_usertype'])):
	$query=$db->setquery("delete from user_type where cod_user_type='".$menu."'");
	echo '<font class="body_text"> <font color="#FF0000">Grupo de utilizadores apagado</font></font>';
elseif (isset($_POST['mod_user_name'])):
	$query=$db->setquery("update user_type set name='".mysql_escape_string($_POST['mod_user_name'])."',
	cod_user_group='".mysql_escape_string($_POST['mod_user_groups'])."' where cod_user_type='".$menu."'");
	echo '<font class="body_text"> <font color="#FF0000">Grupo de utilizadores editado</font></font>';
elseif (isset($_POST['ums']) or isset($_POST['no_ums']))://alterar tipo de  ums
	if (isset($_POST['no_ums']))://desactivar ums
		$query=$db->getquery("SHOW TABLES LIKE 'users'");
		if ($query[0][0]<>''):
			$db->setquery("drop table users, user_type");
		endif;
		if (is_dir($globvars['site']['directory'].'modules/authoring')):
			delr($globvars['site']['directory'].'modules/authoring',$globvars);
			@rmdir($globvars['site']['directory'].'modules/authoring');
		endif;
		if (is_dir($globvars['site']['directory'].'modules/admin_panel')):
			delr($globvars['site']['directory'].'modules/admin_panel',$globvars);
			@rmdir($globvars['site']['directory'].'modules/admin_panel');
		endif;
		$ug_type='static';		
		$db->setquery("delete from module where link='admin_panel/ap_main.php'");
		$db->setquery("delete from module where link='authoring/login.php' or link='authoring/lost_pass.php' or link='new_register.php'
		or link='authoring/profile_edit.php' or link='authoring/lateral_login.php' or link='authoring/login_requiered' or link='authoring/profile_info.php'");
		echo '<font class="body_text"> <font color="#FF0000">Sem grupos de utilizadores seleccionado.</font></font>';
	elseif (isset($_POST['ums'])):// activar ums
		$link=mysql_connect($db->host, $db->user, $db->password);
		if (!$link):
			$globvars['warnings']='Could not connect to Database Server: Bad Root username/password?';
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				sleep(1);
				echo $globvars['warnings'];
				header("Location: ".$_SERVER['REQUEST_URI']);
			endif;
		endif;
		if(!$result=mysql_select_db($db->name)):
			$globvars['warnings']='Could not select DB <'.$_SESSION['database']['name'].'>';
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

		if(!mysql_query("SHOW TABLES like 'users'")):
			mysql_query("CREATE TABLE `users` (
			  `cod_user` int(11) NOT NULL auto_increment,
			  `cod_user_type` int(11) NOT NULL default '0',
			  `cod_css` int(11) NOT NULL default '0',
			  `nome` varchar(200) NOT NULL default '',
			  `email` varchar(200) NOT NULL default '',
			  `data` timestamp(6) NOT NULL,
			  `nick` varchar(25) NOT NULL default '',
			  `password` varchar(25) NOT NULL default '',
			  `active` char(1) NOT NULL default 'n',
			  `cod_skin` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`cod_user`)
			) ENGINE=MyISAM AUTO_INCREMENT=1");
			if(mysql_error()):
				$globvars['warnings']='Could not install table < users > :'.mysql_error();
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
			mysql_query("INSERT INTO `users` VALUES (1, 1, 1, 'Miguel Silva', 'contact@boxvenue.net', 20050706183407, 'admin', '', 's', 4)");
			mysql_query("INSERT INTO `users` VALUES (1, 5, 1, 'Gestao', 'nomail@boxvenue.net, 20050706183407, 'gestao', PASSWORD('12345'), '1', 4)");
		endif; // users table
		if(!mysql_query("SHOW TABLES like 'sessions'")):
			mysql_query("CREATE TABLE `sessions` (
			  `session_id` varchar(32) NOT NULL default '',
			  `cod_user` bigint(20) NOT NULL default '0',
			  `data` timestamp NOT NULL) ENGINE=MyISAM");
		endif;	
		if(!mysql_query("SHOW TABLES like 'user_type'")):	
			mysql_query("CREATE TABLE `user_type` (
			  `cod_user_type` int(11) NOT NULL auto_increment,
			  `name` varchar(30) NOT NULL default '',
			  `cod_user_group` bigint(20) NOT NULL default '0',
			  PRIMARY KEY  (`cod_user_type`)
			) ENGINE=MyISAM AUTO_INCREMENT=2");
		
			mysql_query("INSERT INTO `user_type` VALUES (1, 'Administrators', 0)");
			mysql_query("INSERT INTO `user_type` VALUES (2, 'Guests', 0)");
			mysql_query("INSERT INTO `user_type` VALUES (3, 'Default', 0)");
			mysql_query("INSERT INTO `user_type` VALUES (4, 'Authenticated Users', 0)");
			mysql_query("INSERT INTO `user_type` VALUES (5, 'Content Management', 0)");

			$default_code=3;
			$guest_code=2;
			$auth_code=4;
			$default_box_code=-1;
			$admin_code=1;

			$module="
			('Autentica&ccedil;&atilde;o no site', 'en=User Login||pt=Autentica&ccedil;&atilde;o no site', 'authoring/login.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
			('Recupera&ccedil;&atilde;o da password', 'en=Retrieve password||pt=recupera&ccedil;&atilde;o da password', 'authoring/lost_pass.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
			('Criar nova conta no site', 'en=create an account||pt=criar nova conta', 'authoring/new_register.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
			('Edi&ccedil;&atilde;o do perfil de utilizador', 'en=Edit profile||pt=Editar perfil utilizador', 'authoring/profile_edit.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
			('Login Lateral', 'en=Site Autentication||pt=Area Reservada', 'authoring/lateral_login.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
			('Necessita de autentica&ccedil;&atilde;o', 'en=Login Requiered||pt=Necessita de autentica&ccedil;&atilde;o', 'authoring/login_requiered.php', 's',".$guest_code." , 'no', 'N/A', ".$default_box_code.", 0),
			('Informa&ccedil;&atilde;o da conta de utilizador', 'en=Profile info||pt=A minha conta', 'authoring/profile_info.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0)
			";
			$db->setquery("INSERT INTO `module` (`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`) VALUES ".$module);
	
			$module="
			('Painel Administra&ccedil;&atilde;o', 'en=Admin Panel||pt=Painel Administra&ccedil;&atilde;o', 'admin_panel/ap_main.php', 's', ".$admin_code.", 'no', 'N/A', ".$default_box_code.", 0)";
			$db->setquery("INSERT INTO `module` (`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`) VALUES ".$module);

		endif;
		copyr($globvars['local_root'].'/modules/advanced/authoring',$globvars['site']['directory'].'/modules/authoring');
		copyr($globvars['local_root'].'/modules/advanced/admin_panel',$globvars['site']['directory'].'/modules/admin_panel');
		
		$ug_type='dynamic';
		echo '<font class="body_text"> <font color="#FF0000">Configurado a gest&atilde;o de grupos de utilizadores no site.</font></font>';
	endif;
	if (isset($ug_type)):
		$file_content='
		<?PHP
		// User Groups general config
		$ug_type="'.$ug_type.'";
		?>';
		$filename=$globvars['site']['directory'].'kernel/settings/ums.php';
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
	endif;
endif;
?>