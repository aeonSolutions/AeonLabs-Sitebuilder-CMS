<?
include("./../logiclevel/init.php");
include("./../basiclevel/FileHeader.php");

$file_path = $path;
$file_header = FileHeader::getFileHeader($file_path);
$explode = explode("/",$file_header);

header('Content-type: '.$file_header);
if($explode[0] == "audio" || $explode[0] == "video" || $explode[0] == "application")
	header('Content-Disposition: attachment; filename="'.basename($file_path).'"');

readfile($file_path);
?>