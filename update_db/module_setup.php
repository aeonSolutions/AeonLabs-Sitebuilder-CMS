<?php
/*
File revision date: 24-apr-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

$mod=@$_GET['mod'];
$type=@$_GET['type'];
$view=@$_GET['view'];
$link=session_setup($globvars,'../../index.php?id='.$task.'&view='.$view);	
if ($type==1): // publish, edit or delete module entry
	if(isset($_POST['publish'])):
		$db->setquery("update module set published='s' where cod_module='".$mod."'");
		echo '<font class="body_text"> <font color="#FF0000">Modulo publicado</font></font>';
	elseif(isset($_POST['unpublish'])):
		$db->setquery("update module set published='n' where cod_module='".$mod."'");
		echo '<font class="body_text"> <font color="#FF0000">Modulo desactivado</font></font>';
	elseif(isset($_POST['mod_del'])):
		$db->setquery("delete from module where cod_module=".$mod);
		echo '<font class="body_text"> <font color="#FF0000">Modulo Apagado</font></font>';
	elseif(isset($_POST['mod_modify']) and isset($_POST['mod_self_skin']) and isset($_POST['mod_nome']) and isset($_POST['mod_link'])):
		$db->setquery("update module set name='".mysql_escape_string($_POST['mod_nome'])."',
		 link='".mysql_escape_string($_POST['mod_link'])."',
		  cod_user_type='".mysql_escape_string(@$_POST['mod_user_type'])."',
		   self_skin='".mysql_escape_string($_POST['mod_self_skin'])."',
		   display_name='".mysql_escape_string($_POST['mod_disp_name'])."',
		    box_code='".mysql_escape_string(@$_POST['mod_box_fx'])."', 
			cod_skin='".mysql_escape_string($_POST['skin'])."'
			 where cod_module='".$mod."'");
		echo '<font class="body_text"> <font color="#FF0000">Modulo Editado.</font></font>';
	endif;
elseif ($type==2): // add new module
	if (isset($_POST['add_mod']) and isset($_POST['mod_self_skin']) and isset($_POST['mod_link']) and isset($_POST['mod_nome']) and $_POST['mod_user_type']<>'none'):
		$db->setquery("insert into module set published='s', link='".mysql_escape_string($_POST['mod_link'])."',
		 cod_user_type='".mysql_escape_string($_POST['mod_user_type'])."',
		  name='".mysql_escape_string($_POST['mod_nome'])."',
		   self_skin='".mysql_escape_string($_POST['mod_self_skin'])."',
		   display_name='".mysql_escape_string($_POST['mod_disp_name'])."',
			cod_skin='".mysql_escape_string($_POST['skin'])."',
		   box_code='".mysql_escape_string($_POST['mod_box_fx'])."'");
		// search for the install file
		// returns the current hard drive directory not the root directory of the module being installed
		$module__path=str_replace("/",'<>',mysql_escape_string($_POST['mod_link']));
		$module__path=str_replace("<","/",$module__path);
		$module__path=str_replace(">","/",$module__path);
		$path=explode("/",$absolute_path.'/modules/'.$module__path);
		$local=$path[0];
		for ($i=1;$i<count($path)-2;$i++):
			$local=$local.'/'.$path[$i];
		endfor;
		$local=$local.'/install_module/';
		if (file_exists($local.'install_mod_XK543.php')):
			include($globvars['local_root'].'general/recursive_copy.php');
			include($local.'install_mod_XK543.php');
			delr($absolute_path.'/modules/'.$module__path);
		endif;		
		echo '<font class="body_text"> <font color="#FF0000">Novo Modulo Adicionado.</font></font>';
	elseif($_POST['mod_user_type']=='none'):
		echo '<font class="body_text"> <font color="#FF0000">Tem que escolher um grupo de utilizadores.</font></font>';
	endif;
elseif ($type==6): // add manually new module 
	if (isset($_POST['add_mod']) and isset($_POST['mod_self_skin']) and isset($_POST['mod_link']) and isset($_POST['mod_nome']) and $_POST['mod_user_type']<>'none'):
		$db->setquery("insert into module set published='s', link='".mysql_escape_string($_POST['mod_link'])."',
		 cod_user_type='".mysql_escape_string($_POST['mod_user_type'])."',
		  name='".mysql_escape_string($_POST['mod_nome'])."',
		   self_skin='".mysql_escape_string($_POST['mod_self_skin'])."',
		   display_name='".mysql_escape_string($_POST['mod_disp_name'])."',
			cod_skin='".mysql_escape_string($_POST['skin'])."',
		   box_code='".mysql_escape_string($_POST['mod_box_fx'])."'");
		echo '<font class="body_text"> <font color="#FF0000">Novo Modulo Adicionado.</font></font>';
	elseif($_POST['mod_user_type']=='none'):
		echo '<font class="body_text"> <font color="#FF0000">Tem que escolher um grupo de utilizadores.</font></font>';
	endif;
elseif(isset($_POST['auto_delete'])):// automatic delete
	include_once($globvars['local_root'].'copyfiles/advanced/general/recursive_copy.php');
	$dir=glob($globvars['site']['directory']."modules/*",GLOB_ONLYDIR);
	if ($dir[0]<>''):
		echo '<font class="body_text"> <font color="#FF0000">Eliminação de Modulos:';
		for($i=0;$i<count($dir);$i++):
			$dirX=explode("/",$dir[$i]);
			if (isset($_POST[$dirX[count($dirX)-1]])):
				unset($_POST[$dirX[count($dirX)-1]]);
				delr($globvars['site']['directory'].'modules/'.$dirX[count($dirX)-1]);
				@rmdir($globvars['site']['directory'].'modules/'.$dirX[count($dirX)-1]);
				$query=$db->getquery("select cod_module from module where link regexp '".$dirX[count($dirX)-1]."'");
				if($query[0][0]<>''):
					for($j=0;$j<count($query);$j++):
						$db->getquery("delete from skin_layout where cod_module='".$query[0][0]."'");
					endfor;
				endif;
				$db->setquery("delete from module where link regexp '".$dirX[count($dirX)-1]."'");
			endif;
		endfor;
		echo '</font></font>';
	else:
		echo "n&atilde;o ha módulos no directorio!";
	endif;
	header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;

elseif(isset($_POST['auto_install'])):// automatic install
	include($globvars['site']['directory'].'kernel/settings/ums.php');
	include($globvars['site']['directory'].'kernel/staticvars.php');
	include($globvars['site']['directory'].'kernel/settings/layout.php');
	if ($ug_type=='static'):
		$admin_code=-1;
		$guest_code=-1;
		$default_code=-1;
		$auth_code=-1;
		$content_management=-1;
	else:
		$content_management=$db->getquery("select cod_user_type from user_type where name='Content Management'");
		if ($content_management[0][0]<>''):
			$content_management=$content_management[0][0];
		else:
			$content_management=-1;
		endif;
		$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
		if ($admin_code[0][0]<>''):
			$admin_code=$admin_code[0][0];
		else:
			$admin_code=-1;
		endif;
		$guest_code=$db->getquery("select cod_user_type from user_type where name='Guests'");
		if ($guest_code[0][0]<>''):
			$guest_code=$guest_code[0][0];
		else:
			$guest_code=-1;
		endif;
		$default_code=$db->getquery("select cod_user_type from user_type where name='Default'");
		if ($default_code[0][0]<>''):
			$default_code=$default_code[0][0];
		else:
			$default_code=-1;
		endif;
		$authenticated_code=$db->getquery("select cod_user_type from user_type where name='Authenticated Users'");
		if ($authenticated_code[0][0]<>''):
			$auth_code=$authenticated_code[0][0];
		else:
			$auth_code=-1;
		endif;
	endif;
	if($box_fx==''):
		$default_box_code=-1;
	else:
		$default_box_code=$db->getquery("select box_code from box_effects where active='s'");
		if ($default_box_code[0][0]<>''):
			$default_box_code=$default_box_code[0][0];
		else:
			$default_box_code=-1;
		endif;
	endif;
	$dir=glob($globvars['local_root']."/modules/advanced/*",GLOB_ONLYDIR);
	if ($dir[0]<>''):
		echo '<font color="#FF0000">Instala&ccedil;&atilde;o Autom&aacute;tica de Modulos:';
		$install=false;
		for($i=0;$i<count($dir);$i++):
			$dirX=explode("/",$dir[$i]);
			if (isset($_POST[$dirX[count($dirX)-1]])):
				unset($_POST[$dirX[count($dirX)-1]]);
				copyr($globvars['local_root'].'/modules/advanced/'.$dirX[count($dirX)-1],$globvars['site']['directory'].'/modules/'.$dirX[count($dirX)-1],$globvars);
				if (file_exists($globvars['local_root'].'/modules/advanced/'.$dirX[count($dirX)-1].'/install_module/auto_install.php')):
					include_once($globvars['local_root'].'/modules/advanced/'.$dirX[count($dirX)-1].'/install_module/auto_install.php');
					if ($module<>''):
						$db->setquery("INSERT INTO `module` (`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`) VALUES ".$module);
					endif;
					echo $dirX[count($dirX)-1].';';
				endif;		
				// search for the install file
				if (file_exists($globvars['local_root'].'/modules/advanced/'.$dirX[count($dirX)-1].'/install_module/install_mod_XK543.php')):
					include_once($globvars['local_root'].'/modules/advanced/'.$dirX[count($dirX)-1].'/install_module/install_mod_XK543.php');
					delr($globvars['site']['directory'].'/modules/'.$dirX[count($dirX)-1].'/install_module');
					@rmdir($globvars['site']['directory'].'/modules/'.$dirX[count($dirX)-1].'/install_module');
				endif;
				$install=true;
				if (file_exists($globvars['local_root'].'/modules/advanced/'.$dirX[count($dirX)-1].'/install_module/require.php')):
					include($globvars['local_root'].'/modules/advanced/'.$dirX[count($dirX)-1].'/install_module/require.php');
					if (!isset($editor_enabled)):
						$editor_enabled=false;
					endif;
					if ($editor_enabled==true):
						copyr($globvars['local_root'].'/copyfiles/editor',$globvars['site']['directory'].'/editor',$globvars);
						if (!is_dir($staticvars['upload'].'/editor/images')):
							@mkdir($staticvars['upload'].'/editor/images');
						endif;
					endif;
				endif;
			endif;
		endfor;
		echo '</font>';
	else:
		echo "n&atilde;o ha módulos no directorio!";
	endif;
elseif ($type==4): // change to default box-fx in all modules
		$code=$db->getquery("select box_code from box_effects where link='default.php'");
		if($code[0][0]<>''):
			$db->setquery("update module set box_code='".$code[0][0]."'");
			echo '<font class="body_text"> <font color="#FF0000">Foi configurado o Default Box-Fx em todos os módulos.</font></font>';
		else:
			echo '<font class="body_text"> <font color="#FF0000">Erro ao configurar o Default Box-Fx em todos os módulos.(default box-fx nao encontrado)</font></font>';
		endif;
elseif (isset($_FILES['module_upload'])and $_FILES['module_upload']['error']<>4)://adicionar template ao directorio via web
	include_once($globvars['local_root'].'general/pass_generator.php');
	$name=normalize($_FILES['module_upload']['name']);
	if (check_files($temporary_directory,$name)):
		$tmp=explode(".",$name);
		$tmp[0].=generate('5','No','Yes','No');
		$extension=$tmp[1];
		$tmp1[1]=$tmp[0].'.'.$tmp[1];
		$location=$temporary_directory.'/'.$tmp1[1];
	else:
		$location=$temporary_directory.'/'.$name;					
		$tmp1[1]=$name;
	endif;
	if (!move_uploaded_file($_FILES['module_upload']['tmp_name'], $location)):
		echo '<font class="body_text"> <font color="#FF0000">Upload error. Try again.</font></font>';		
	else:
		$zip_path = $location;
		$module_name=explode(".",$name);
		$module_name=$module_name[0];
		if (!is_dir($absolute_path.'/modules/'.$module_name)):
			mkdir($absolute_path.'/modules/'.$module_name);
		endif;
		if (($link = zip_open($zip_path))):
			$message=0;
			while ($zip_entry = zip_read($link)):
				if (zip_entry_open($link, $zip_entry, "r")):
					$data = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
					$dir_name = dirname(zip_entry_name($zip_entry));
					$name = zip_entry_name($zip_entry);
					$name=normalize($name);
					if (check_files($upload_directory,$name)):
						$tmp=explode(".",$name);
						$tmp[0].=generate('5','No','Yes','No');
						$tmp1[1]=$tmp[0].'.'.$tmp[1];
						$location=$absolute_path.'/modules/'.$module_name.'/'.$tmp1[1];
					else:
						$location=$absolute_path.'/modules/'.$module_name.'/'.$name;					
						$tmp1[1]=$name;
					endif;
					$tmp=explode("/",$location);
					if (!is_dir($absolute_path.'/modules/'.$module_name.'/'.$tmp[count($tmp)-2])):
						mkdir($absolute_path.'/modules/'.$module_name.'/'.$tmp[count($tmp)-2]);
					endif;
					if (@$stream = fopen($location, "w")):
						fwrite($stream, $data);
						zip_entry_close($zip_entry);
					endif;
				else:
					$message='Erro ao localizar o ficheiro.';
				endif;
			endwhile;
			if ($message<>0):
				echo 'Foram encontrados '.$message.' ficheiros inv&aacute;lidos (tipo inv&aacute;lido).';
			else:
				echo '<font class="body_text"> <font color="#FF0000">Módulo Gravado com sucesso.</font></font>';		
			endif;
			zip_close($link);  
		else:
			$message = "Erro ao descompactar o ficheiro.";
		endif;
	endif;
endif;
echo '<br>';

function normalize($text){
// eliminates special characters and convert to lower case a text string
	$dim=array("&ccedil;","&ccedil;");
	$text = str_replace($dim, "c", $text);

	$dim=array("&atilde;","&aacute;","à","â","&atilde;","&aacute;","À","Â");
	$text = str_replace($dim, "a", $text);

	$dim=array("é","ê","Ê","É");
	$text = str_replace($dim, "e", $text);

	$dim=array("í","Í");
	$text = str_replace($dim, "i", $text);

	$dim=array("&otilde;","ó","ô","&otilde;","Ó","Ô");
	$text = str_replace($dim, "o", $text);

	$text=strtolower($text);
	$text =str_replace(" ","",$text);
return $text;
};
function check_files($dir,$filename){
$filename=$dir.'/'.$filename;
$files = glob($dir."/*.*");
$tmp=false;
for($i = 0; $i < count($files); $i++):
	if ($files[$i]==$filename):
		$tmp=true;
	endif;
endfor;
return $tmp;
};
?>
