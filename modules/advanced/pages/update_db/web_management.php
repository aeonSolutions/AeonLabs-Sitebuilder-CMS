<?php
/*
File revision date: 22-Mar-2007
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (Integrated WebPage File System)';
	exit;
endif;

$skin=@$_GET['mod'];
if(isset($_POST['del_pages'])):
elseif(isset($_POST['save'])):// editor save
	$file_content=$_POST['elm1'];
	$filename=$staticvars['local_root'].'modules/pages/webpages/'.$_GET['dir'].'/'.$_GET['idioma'].'/'.$_GET['see'].'.php';
	if (file_exists($filename)):
		echo '<font class="body_text"> <font color="#FF0000">Alterações Gravadas.</font></font><br>';
		unlink($filename);		
	else:
		echo '<font class="body_text"> <font color="#FF0000">Novo ficheiro gravado.</font></font><br>';		
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);


elseif(isset($_POST['gravar_detalhes'])):
	$file_content="<!-- ".$_POST['titulo']."-->";
	$filename=$staticvars['local_root'].'modules/pages/webpages/'.$_POST['categoria'].'/'.$_POST['idioma'].'/'.$_POST['nome'].'.php';
	$title=file_get_contents($filename);
	if (preg_match("/<!--/", $title)):
		$init=strpos($title,"!--")+3;
		$final=strpos($title,"--",$init)-4;
		$title=substr_replace($title,$_POST['titulo'],$init,$final-init);
	else:
		$title='<!-- '.$_POST['titulo'].' -->'.chr(13).$title;
	endif;
	$file_content=$title;
	if (file_exists($filename)):
		echo '<font class="body_text"> <font color="#FF0000">Alterações Gravadas.</font></font><br>';
		unlink($filename);		
	else:
		echo '<font class="body_text"> <font color="#FF0000">Novo ficheiro gravado.</font></font><br>';		
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
elseif(isset($_POST['gravar_novo'])):
	$file_content="<!-- ".$_POST['novo_nome']."-->".chr(13);
	$filename=$staticvars['local_root'].'modules/pages/webpages/'.$_POST['categoria'].'/'.$_POST['idioma'].'/'.$_POST['novo_nome'].'.php';
	if (file_exists($filename)):
		echo '<font class="body_text"> <font color="#FF0000">Nome de ficheiro já existe.Escolha outro nome</font></font><br>';		
	else:
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		echo '<font class="body_text"> <font color="#FF0000">Novo ficheiro gravado.</font></font><br>';		
	endif;
elseif(isset($_POST['insert_cat'])):
	if (is_dir($staticvars['local_root'].'modules/pages/webpages/'.$_POST['cat_name'])):
		delr($staticvars['local_root'].'modules/pages/webpages/'.$_POST['cat_name']);
	endif;
	mkdir($staticvars['local_root'].'modules/pages/webpages/'.$_POST['cat_name']);
	$lang=explode(";",$staticvars['language']['available']);
	for($i=0;$i<count($lang);$i++):
		mkdir($staticvars['local_root'].'modules/pages/webpages/'.$_POST['cat_name'].'/'.$lang[$i]);		
	endfor;
	echo '<font class="body_text"> <font color="#FF0000">Nova categoria Criada.</font></font><br>';		
elseif (isset($_FILES['add_template'])and $_FILES['add_template']['error']<>4)://adicionar template ao directorio
	include_once($staticvars['local_root'].'general/pass_generator.php');
	$name=normalize($_FILES['add_template']['name']);
	$only_dir_name=$name;
	$only_dir_name=explode(".",$only_dir_name);	
	$only_dir_name=$only_dir_name[0];	
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
	if ($message==''):
		if (!move_uploaded_file($_FILES['add_template']['tmp_name'], $location)):
			$message='Erro no Upload. Por favor tente de novo.';
		endif;
	endif;
	if (!is_dir($absolute_path.'/modules/pages/webpages/'.$only_dir_name)):
			echo '<font class="body_text"> <font color="#FF0000">Directory created:'.$only_dir_name.'</font></font><br>';		
		mkdir($absolute_path.'/modules/pages/webpages/'.$only_dir_name);
	endif;

	$dir_path = $absolute_path.'/modules/pages/webpages/'.$only_dir_name.'/';
	$zip_path = $location;
	
	if (($link = zip_open($zip_path))):
		$message=0;
		while ($zip_entry = zip_read($link)):
			if (zip_entry_open($link, $zip_entry, "r")):
				$data = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
				$dir_name = dirname(zip_entry_name($zip_entry));
				$name = zip_entry_name($zip_entry);
				$name=normalize($name);
				$error=false;
				if (check_files($upload_directory,$name)):
					$tmp=explode(".",$name);
					$tmp[0].=generate('5','No','Yes','No');
					$extension=$tmp[1];
					if (!preg_match ("# $extension #", str_replace(";"," ",$ext_allowed[0][0])) ):
						$message=$message+1;
						$error=true;
					endif;
					$tmp1[1]=$tmp[0].'.'.$tmp[1];
					$location=$dir_path.$tmp1[1];
				else:
					$location=$dir_path.$name;					
					$tmp1[1]=$name;
				endif;
				$tmp=explode("/",$location);
				if (!is_dir($dir_path.$tmp[count($tmp)-2])):
					mkdir($dir_path.$tmp[count($tmp)-2]);
				endif;
				if (!$error):
					$stream = fopen($location, "w");
					fwrite($stream, $data);
					$tmp=explode(".",$tmp[count($tmp)-1]);
					if ($tmp[1]=='html' or $tmp[1]=='htm' or $tmp[1]=='php'):
						echo '<font class="body_text"> <font color="#FF0000">Code Rebuild:'.$tmp[0].'.'.$tmp[1].'</font></font><br>';		
						rebuild_code($staticvars['local_root'],$location,$only_dir_name);
					endif;
					zip_entry_close($zip_entry);
				endif;
			else:
				$message='Erro ao localizar o ficheiro.';
			endif;
		endwhile;
		if ($message<>0):
			echo 'Foram encontrados '.$message.' ficheiros inv&aacute;lidos (tipo inv&aacute;lido).';
		else:
			echo '<font class="body_text"> <font color="#FF0000">P&aacute;gina copiada com sucesso.</font></font>';		
		endif;
		zip_close($link);  
		// alterar as tags de todas as paginas htm html e php
	
	else:
		$message = "Erro ao descompactar o ficheiro.";
	endif;
endif;

function rebuild_code($staticvars,$file,$only_dir_name){
	include($staticvars['local_root'].'kernel/staticvars.php');
	include_once($staticvars['local_root'].'general/return_module_id.php');
	$code=file_get_contents($file);
	//update image links
	$code=str_replace('<?='.$staticvars['site_path'].';?>"',$staticvars['site_path'],$code);
	$code=str_replace('src="http','rc_external_link',$code);
	//$code=str_replace('src="','src="'.$staticvars['site_path'].'/modules/pages/webpages/'.$only_dir_name.'/',$code);
	//$code=str_replace('rc_external_link','src="http',$code);
	// update links
	$code=str_replace('href="','href="'.$staticvars['site_path'].'/index.php?id='.return_id('main_iwfs.php').'&dirname='.$only_dir_name.'&goto=',$code);

	// update background links
	$code=str_replace('background="','background="'.$staticvars['site_path'].'/modules/pages/webpages/'.$only_dir_name.'/',$code);
	$code=str_replace("url('","url('".$staticvars['site_path'].'/modules/pages/webpages/'.$only_dir_name.'/',$code);
	$code=str_ireplace("url('","url('".$staticvars['site_path'].'/modules/pages/webpages/'.$only_dir_name.'/',$code);
	// stylesheets
	$code = str_replace('<link rel="stylesheet" type="text/css" href="','<link rel="stylesheet" type="text/css" href="'.$staticvars['site_path'].'/modules/pages/webpages/'.$only_dir_name.'/',$code);


	$code=str_replace("</html>","",$code);
	$code=str_replace("</body>","",$code);
	$code=str_replace("<body>","",$code);
	$code=str_replace("</head>","",$code);
	$code=str_replace("<head>","",$code);

	$initial_search_string="<!DOCTYPE";
	$tmp1=strpos($code,$initial_search_string);
	if ($tmp1 === false):
		$initial_search_string="<!doctype";
		$tmp1=strpos($code,$initial_search_string);
	endif;
	if ($tmp1 === true):
		$tmp2=strpos($code,'>',$tmp1+strlen($initial_search_string));
		$code = substr_replace($code,'', $tmp1,($tmp2)-($tmp1));
	endif;

	$initial_search_string="<html";
	$tmp1=strpos($code,$initial_search_string);
	if ($tmp1 === false):
		$initial_search_string="<HTML";
		$tmp1=strpos($code,$initial_search_string);
	endif;
	if ($tmp1 === true):
		$tmp2=strpos($code,'>',$tmp1+strlen($initial_search_string));
		$code = substr_replace($code,'', $tmp1,($tmp2)-($tmp1));
	endif;

	$initial_search_string="<meta";
	$tmp1=strpos($code,$initial_search_string);
	if ($tmp1 === false):
		$initial_search_string="<META";
		$tmp1=strpos($code,$initial_search_string);
	endif;
	if ($tmp1 === true):
		$tmp2=strpos($code,'>',$tmp1+strlen($initial_search_string));
		$code = substr_replace($code,'', $tmp1,($tmp2)-($tmp1));
	endif;

	$initial_search_string="<title";
	$tmp1=strpos($code,$initial_search_string);
	if ($tmp1 === false):
		$initial_search_string="<TITLE";
		$tmp1=strpos($code,$initial_search_string);
	endif;
	if ($tmp1 === true):
		$tmp2=strpos($code,'>',$tmp1+strlen($initial_search_string));
		$code = substr_replace($code,'', $tmp1,($tmp2)-($tmp1));
	endif;


	$filename=$file;
	if (file_exists($filename)):
		@unlink($filename);
	endif;
	if (!$handle = fopen($filename, 'w')):
		echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
		exit;
	endif;
	if (fwrite($handle, $code) === FALSE):
		echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
		exit;
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