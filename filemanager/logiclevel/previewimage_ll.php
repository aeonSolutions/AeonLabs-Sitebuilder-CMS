<?
require_once($globvars['local_root']."filemanager/logiclevel/FileLogic.php");

if($_GET['search']) {

	if($CONFIG['search_permission']) {
		$founded_files = FileLogic::searchFiles($root_path,$path);
		$files = $founded_files[0];
	}
	elseif($CONFIG['search_permission_denied_message']) {
		echo "<script>alert('".$CONFIG['search_permission_denied_message']."');</script>"; 
		$files = array();
	}
}
else
	$files = File::getDirFiles($path);


$selected_image_path = $_GET['imagePath'];
$counter = 0;
$selected_index = 0;

for($i = 0; $i < count($files); ++$i) {
	$file_path = $files[$i][7];
	if(File::isFileType($file_path,"image")) {
		$image_path = $files[$i][7];
		$image_information = File::getImageFileInformation($image_path);
		
		$images_path .= "'".File::cleanRootPath($root_path,$image_path)."'";
		$images_size .= "'".$files[$i][4]."'";
		$images_width .= "'".$image_information[0]."'";
		$images_height .= "'".$image_information[1]."'";

		if($image_path == $root_path.$selected_image_path) {
			$selected_index = $counter+1;
			$selected_image_name = $files[$i][0];
			$selected_image_width = $image_information[0];
			$selected_image_height = $image_information[1];
			$selected_image_size = $files[$i][4];
		}
		++$counter;
	}
}

$images_path = str_replace("''","','",$images_path);
$images_size = str_replace("''","','",$images_size);
$images_width = str_replace("''","','",$images_width);
$images_height = str_replace("''","','",$images_height);

?>
