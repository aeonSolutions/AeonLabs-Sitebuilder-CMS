<?
require_once($globvars['local_root']."filemanager/logiclevel/init.php");
$file_path = $path;
$file_extension = File::getFileExtension($file_path);
if(empty($file_extension))
	$file_extension = "*";

header('Content-type: application/'.$file_extension);
header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
readfile($file_path);
?>