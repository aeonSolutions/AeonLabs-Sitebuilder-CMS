<?php
/*
File revision date: 22-fev-2011
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

$skin=@$_GET['mod'];
if (isset($_POST['skin_code'])): // activar / desactivar skins
	if ($_POST['skin_code']=='publish'):
		$db->setquery("update skin set active='s' where cod_skin='".$skin."'");
		echo '<font class="body_text"> <font color="#FF0000">Skin publicado</font></font>';
	elseif($_POST['skin_code']=='unpublish'):
		$db->setquery("update skin set active='n' where cod_skin='".$skin."'");
		echo '<font class="body_text"> <font color="#FF0000">Skin desactivado</font></font>';
	endif;
elseif (isset($_POST['del_skin'])): // apagar skins
	$skin_name=$db->getquery("select ficheiro from skin where cod_skin='".$skin."'");
	$name=explode(".",$skin_name[0][0]);
	@unlink($globvars['site']['directory'].'layout/templates/'.$skin_name[0][0]);
	if (is_dir($globvars['site']['directory'].'layout/templates/'.$name[0])):
		delr($globvars,$globvars['site']['directory'].'layout/templates/'.$name[0]);
		delr($globvars,$globvars['site']['directory'].'layout/templates/'.$name[0]);		
	endif;
	$db->setquery("delete from skin where cod_skin='".$skin."'");
	$db->setquery("delete from skin_layout where cod_skin='".$skin."'");
	echo '<font class="body_text"> <font color="#FF0000">Skin apagado</font></font>';
elseif (isset($_POST['skin_cell']))://editar skin
	$db->setquery("update skin set ficheiro='".mysql_escape_string($_POST['skin_name'])."' where cod_skin='".$skin."'");
	echo '<font class="body_text"> <font color="#FF0000">Skin editado com sucesso</font></font>';
elseif (isset($_FILES['add_template'])and $_FILES['add_template']['error']<>4)://adicionar template ao directorio via web
	include_once($globvars['local_root'].'copyfiles/advanced/general/pass_generator.php');
	$name=normalize($_FILES['add_template']['name']);
	if (check_files($globvars['temp'],$name)):
		$tmp=explode(".",$name);
		$tmp[0].=generate('5','No','Yes','No');
		$extension=$tmp[1];
		$tmp1[1]=$tmp[0].'.'.$tmp[1];
		$zip_path=$globvars['temp'].'/'.$tmp1[1];
	else:
		$zip_path=$globvars['temp'].'/'.$name;					
	endif;
	if ($message==''):
		if (!move_uploaded_file($_FILES['add_template']['tmp_name'], $zip_path)):
			$message='Upload Error. Please try again.';
		endif;
	endif;
	$tmp=explode(".",$name);	
	$dir_path = $globvars['local_root'].'layouts/templates/'.$tmp[0].'/';
	if (!is_dir(dirname($dir_path))):
		mkdir(dirname($dir_path), 0755, true);
	endif;
	
	if (($link = zip_open($zip_path))):
		$message=0;
		while ($zip_entry = zip_read($link)):
			if (zip_entry_open($link, $zip_entry, "r")):
				$data = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
				$dir_name = dirname(zip_entry_name($zip_entry));
				$extracted_file = zip_entry_name($zip_entry);
				$extracted_file=normalize($extracted_file);
				$path=dirname($dir_path.$extracted_file);
				if (!is_dir(dirname($dir_path.$extracted_file))):
					mkdir(dirname($dir_path.$extracted_file), 0755, true);
				endif;
				$stream = fopen($dir_path.$extracted_file, "w");
				fwrite($stream, $data);
				zip_entry_close($zip_entry);
			else:
				$message='Error locating template file';
			endif;
		endwhile;
		echo '<font class="body_text"> <font color="#FF0000">Template sucessfully installed</font></font>';		
		zip_close($link);  
	else:
		$message = "Error unpacking file.";
	endif;
	exit;
elseif (isset($_POST['add_skin_name']))://instalar skin (ja existente no directorio de templates)
	include($globvars['site']['directory'].'kernel/staticvars.php');
	include($globvars['site']['directory'].'kernel/settings/layout.php');
	if($layout=='dynamic'):
		$query=$db->getquery("select cod_skin, ficheiro from skin");
		if ($query[0][0]<>''):
			$step="active='n'";
		else:
			$step="active='s'";
		endif;
		$skin_dir=mysql_escape_string($_POST['add_skin_name']);
		if (is_dir($globvars['local_root'].'layouts/templates/'.$skin_dir)):
			copyr($globvars['local_root'].'layouts/templates/'.$skin_dir,$globvars['site']['directory'].'layout/templates/'.$skin_dir,$globvars);
			$skins=array_merge(glob($globvars['local_root'].'layouts/templates/'.$skin_dir.'/*.html'),glob($globvars['local_root'].'layouts/templates/'.$skin_dir.'/*.htm'),glob($globvars['local_root'].'layouts/templates/'.$skin_dir.'/*.php'));				
			$css=true;
			for($i=0;$i<count($skins);$i++):
				$name=explode("/",$skins[$i]);
				$tmp=$name[count($name)-1];
				$tmp=explode(".",$tmp);
				$name=$skin_dir.'/'.$name[count($name)-1];
				$new_name=explode(".",$name);
				$new_name=$new_name[0].'.php';
				if($tmp[0]=='main' or $tmp[0]=='index'):
					$db->setquery("update skin set active='n'");
					$step="active='s'";
				endif;
				$db->setquery("insert into skin set ficheiro='".$new_name."', ".$step);
				if ($step=="active='s'"):
					$step="active='n'";
				endif;
				build_skin($globvars,$name,$css);
				$css= $css==true ? false :false;
			endfor;
		endif;
		$file_content='<?PHP
		// WebPage Design Layout
		$layout="'.$layout.'";
		$layout_name="dynamic";
		?>';
		$filename=$globvars['site']['directory'].'kernel/settings/layout.php';
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
		echo '<font class="body_text"> <font color="#FF0000">Success. Settings Saved.</font></font><br />';
	else://static
		$name=explode(".",mysql_escape_string($_POST['add_skin_name']));
		if (is_dir($globvars['site']['directory'].'layout/templates')):
			delr($globvars,$globvars['site']['directory'].'layout/templates', 0755, true);
			@mkdir($globvars['site']['directory'].'layout/templates', 0755, true);
		else:
			mkdir($globvars['site']['directory'].'layout/templates');
		endif;
		
		$skin_dir=mysql_escape_string($_POST['add_skin_name']);
		if (is_dir($globvars['local_root'].'layouts/templates/'.$skin_dir)):
			copyr($globvars['local_root'].'layouts/templates/'.$skin_dir,$globvars['site']['directory'].'layout/templates/'.$skin_dir,$globvars);
			$skins=array_merge(glob($globvars['local_root'].'layouts/templates/'.$skin_dir.'/*.html'),glob($globvars['local_root'].'layouts/templates/'.$skin_dir.'/*.htm'),glob($globvars['local_root'].'layouts/templates/'.$skin_dir.'/*.php'));				
			$css=true;
			for($i=0;$i<count($skins);$i++):
				$name=explode("/",$skins[$i]);
				$tmp=$name[count($name)-1];
				$tmp=explode(".",$tmp);
				$name=$skin_dir.'/'.$name[count($name)-1];
				$new_name=explode(".",$name);
				$new_name=$new_name[0].'.php';
				build_skin($globvars,$name,$css);
				$css= $css==true ? false :false;
			endfor;
		endif;

		$file_content='<?PHP
		// WebPage Design Layout
		$layout="static";
		$layout_name="'.$skin_dir.'/main.php";
		$box_fx="'.$box_fx.'";
		?>';
		$filename=$globvars['site']['directory'].'kernel/settings/layout.php';
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
		echo '<font class="body_text"> <font color="#FF0000">Success. Settings Saved.</font></font><br />';
	endif;
	if (is_dir($globvars['local_root'].'layouts/templates/'.$name[0])):
		copyr($globvars['local_root'].'layouts/templates/'.$name[0],$globvars['site']['directory'].'layout/templates/'.$name[0],$globvars);
	endif;
	echo '<font class="body_text"> <font color="#FF0000">Skin adicionado</font></font>';
endif;

function build_skin($globvars,$file, $process_css){
	
	$code=file_get_contents($globvars['local_root']."layouts/templates/".$file);
	if($code==false):
	$globvars['warnings']='Unable to get layout file contents:'.$file;
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
	if($globvars['error']['critical']):
		$_SESSION['cerr']=true;
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
	endif;
	include($globvars['site']['directory'].'kernel/staticvars.php');

	$filename=explode("/",$file);
	$dir_name=$filename[0];
	$file=$filename[1];
	//update image links
	$code=str_replace('src="','src="'.$staticvars['site_path'].'/layout/templates/'.$dir_name.'/',$code);
	$code=str_replace("src='","src='".$staticvars['site_path'].'/layout/templates/'.$dir_name.'/',$code);
	// update background links
	$code=str_replace('background="','background="'.$staticvars['site_path'].'/layout/templates/'.$dir_name.'/',$code);
	$code=str_replace("background='","background='".$staticvars['site_path'].'/layout/templates/'.$dir_name.'/',$code);

	$code=str_replace("url('","#1475777#".$staticvars['site_path']."/layout/templates/".$dir_name.'/',$code);
	$code=str_replace('url("',"#1475778#".$staticvars['site_path']."/layout/templates/".$dir_name.'/',$code);
	$code=str_replace("url(","url(".$staticvars['site_path']."/layout/templates/".$dir_name.'/',$code);
	$code=str_replace("#1475777#","url('",$code);
	$code=str_replace("#1475778#",'url("',$code);


	// update external stylesheet files
	if (strpos("-".$code,"<link")):
		$ok=true;
		$init=0;
		$final=0;
		while($ok):
			// retrieve css file name
			$init=strpos($code,"<link",$final);
			if($init===false):
				$ok=false;
			else:
				$final=strpos($code,"/>",$init);
			
				//retrieve css filename
				$filename=substr($code,$init,$final-$init);
				$filename=explode("href",$filename);
				$filename=explode('"',$filename[1]);
				$css_file=$filename[1];		
				$css_dir_name=explode("/",$css_file);
				$css_dir_name=$css_dir_name[0];
				$init=$final;
				// replace in the layout file the css filename path
				$code=str_replace($css_file,$staticvars['site_path'].'/layout/templates/'.$dir_name.'/'.$css_file,$code);

				if($process_css==true):
					// update links in the css file
					$file_content=file_get_contents($globvars['site']['directory']."layout/templates/".$dir_name."/".$css_file);
					$file_content=str_replace('("','(',$file_content);
					$file_content=str_replace("('","(",$file_content);
					$file_content=str_replace('")',')',$file_content);
					$file_content=str_replace("')",")",$file_content);
					$replace="url(".$staticvars['site_path']."/layout/templates/".$dir_name."/";
					$file_content=str_replace("url(",$replace,$file_content);
			
					$filename=$globvars['site']['directory']."layout/templates/".$dir_name."/".$css_file;
					if (file_exists($filename)):
						unlink($filename);
					endif;
					if (!$handle = fopen($filename, 'a')):
						echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
						exit;
					endif;
					if (fwrite($handle, $file_content) === FALSE):
						echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
						exit;
					endif;
					fclose($handle);
				endif;
			endif;
		endwhile;
	endif;
	// replace {main} tag
	$tmp="<?php 
		"."$"."cell=0;
		include("."$"."staticvars['local_root'].'layout/main_code.php');
		?>";
	$code=str_replace("{main}",$tmp,$code);
	// replace {menu} tag
	$tmp="<?php 
		"."$"."cell=-1;
		include("."$"."staticvars['local_root'].'layout/main_code.php');
		?>";
	$code=str_replace("{menu}",$tmp,$code);
	$head=strpos($code,"<head>")+8;
	//Meta tags
	if (strpos("-".strtolower($code),'meta name="keywords"')):
		$code=str_replace('<meta name="keywords" content="','<meta name="keywords" content="<?='.'$'.'staticvars["meta"]["keywords"];?>" />',$code);
	else:
		$code=str_replace('<head>','<head>'.chr(13).'<meta name="keywords" content="<?='.'$'.'staticvars["meta"]["keywords"];?>" />',$code);
	endif;
	if (strpos("-".strtolower($code),'meta name="description"')):
		$code=str_replace('<meta name="description" content="','<meta name="description" content="<?='.'$'.'staticvars["meta"]["description"];?>" />',$code);
	else:
		$code=str_replace('<head>','<head>'.chr(13).'<meta name="description" content="<?='.'$'.'staticvars["meta"]["description"];?>" />',$code);
	endif;
	if (strpos("-".strtolower($code),'meta name="author"')):
		$code=str_replace('<meta name="author" content="','<meta name="author" content="<?='.'$'.'staticvars["meta"]["author"];?>" />',$code);
	else:
		$code=str_replace('<head>','<head>'.chr(13).'<meta name="auhtor" content="<?='.'$'.'staticvars["meta"]["author"];?>" />',$code);
	endif;
	if (strpos("-".strtolower($code),'meta name="robots"')):
		$code=str_replace('<meta name="robots" content="','<meta name="robots" content="<?='.'$'.'staticvars["meta"]["robots"];?>" />',$code);
	else:
		$code=str_replace('<head>','<head>'.chr(13).'<meta name="robots" content="<?='.'$'.'staticvars["meta"]["robots"];?>" />',$code);
	endif;
	if (strpos("-".strtolower($code),'title"')):
		$code=str_replace('<title>','<title>"<?='.'$'.'staticvars["meta"]["page_title"];?>',$code);
	endif;


// other tags
	$code=str_replace("{date}",'<?=date("l, dS F Y ");?>',$code);
	$code=str_replace("{title}",$staticvars['meta']['page_title'],$code);
	$code=str_replace("{site_name}",$staticvars['name'],$code);

	// insert default stylesheet for modules 
	$code=str_replace("</title>",'</title>'.chr(13).'<link rel="stylesheet" type="text/css" href="'.$staticvars['site_path'].'/layout/css/default.css" />',$code);


	// replace {cell-x} tags
	$nums=substr_count($code,"{cell-");
	if ($nums>0):
		for ($i=1;$i<=$nums;$i++):
			$tmp="<?php 
				"."$"."cell=".$i.";
				include("."$"."staticvars['local_root'].'layout/main_code.php');
				?>";
			$code=str_replace("{cell-".$i."}",$tmp,$code);
		endfor;
	endif;
	// delete the old file
	if (file_exists($globvars['site']['directory'].'layout/templates/'.$dir_name.'/'.$file)):
		unlink($globvars['site']['directory'].'layout/templates/'.$dir_name.'/'.$file);
	endif;
	$filename=explode(".",$file);
	$filename=$globvars['site']['directory'].'layout/templates/'.$dir_name.'/'.$filename[0].'.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	if(fwrite($handle, $code)==false):
		$globvars['warnings']='Unable to write file:'.$filename;
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='prohibited';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			header("Location: ".$_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	fclose($handle);	
};
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