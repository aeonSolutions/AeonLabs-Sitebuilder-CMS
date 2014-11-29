<?
$file_information = File::getFileInformation($root_path);
$file_name = $file_information[0];
$file_type = $file_information[1];
$file_extension = $file_information[2];
$file_size = empty($file_information[4]) ? 0 : $file_information[4];
$last_modify_date = $file_information[5];
$creation_date = $file_information[6];

$file_perms_letters = File::getPermsLetters($path);

$is_image = File::isFileType($path,'image') ? true : false;

if($file_type == "dir") {
	$dir_information = File::getDirInformation($path);
	$dir_size = empty($dir_information[0]) ? 0 : $dir_information[0];
	$num_sub_dirs = $dir_information[1];
	$num_sub_files = $dir_information[2];
}

$show_file_name = $file_name == basename($CONFIG['root_path']) ? $CONFIG['root_path_name'] : $file_name;
?>
