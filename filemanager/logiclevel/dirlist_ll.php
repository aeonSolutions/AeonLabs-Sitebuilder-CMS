<?php
header("content-type: application/xhtml+xml;"); 
echo '<?xml version="1.0" encoding="iso-8859-1" ?>';
$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
include($globvars['local_root'].'copyfiles/advanced/general/db_class.php');
include($globvars['local_root'].'core/globvars.php');

require_once($globvars['local_root']."filemanager/basiclevel/File.php");
require_once($globvars['local_root']."filemanager/config/config.php");
$root_path = @$_GET['folders_template'] == 1 ? $CONFIG['dir_templates_path'] : @$_GET['root_path_empty'] == 1 ? "" : $CONFIG['root_path'];
if(!empty($root_path) && substr($root_path,strlen($root_path)-1) != "/")
	$root_path .= "/";

$path = $globvars['site']['directory'];
$type = isset($_GET['type']) ? $_GET['type'] : 'dirlist';
$max_level = 1;
designXML($type,$root_path,$path,$max_level);

function designXML($type,$root_path,$path,$max_level) {
	$filename = basename($path);
	
	if($max_level >= 0) {
		--$max_level;
		if(filetype($path) == "dir") {
			$tag = $max_level >= 0 && hasSubDirsFiles($path,$type) ? "complex" : "complex2";
			
			echo '<'.$tag.' id="'.$path.'">'.$filename;
			designXMLFiles($type,$root_path,$path,$max_level);
			echo '</'.$tag.'>';
		}
		else echo '<simple id="'.$path.'">'.$filename.'</simple>';
	}
}

function designXMLFiles($type,$root_path,$path,$max_level) {
	if($max_level >= 0) {
		$path = File::configureFileName($path);
		$files = File::getDirFiles($path);

		for($i = 0; $i < count($files); ++$i) {
			$url = $path.$files[$i][0];
			//$url = str_replace(' ','%20',$url);
			
			if($files[$i][1] == 'dir')
				designXML($type,$root_path,$url,$max_level);
			elseif($type != "dirlist") echo '<simple id="'.$url.'">'.$files[$i][0].'</simple>';
		}
	}
}

function hasSubDirsFiles($path,$type) {
	$sub_files = File::getDirFiles($path);
	for($i = 0; $i < count($sub_files); ++$i) {
		if($sub_files[$i][1] == 'dir' && $type == "dirlist")
			return true;
		elseif($type != "dirlist") return true;
	}
	return false;
}
?>