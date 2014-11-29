<?
$zip_file_name = $_GET['zip_file_name'];
$zip_name = empty($path) ? $root_path.$zip_file_name : $path."/".$zip_file_name;
$zip_type = File::getFileExtension($zip_name);
$files_list = getElements($zip_type,$zip_name);

if($_POST['submitBtn']) {

	if($CONFIG['unzip_permission']) {
		echo "<script>
				openerWindow.showLoadingBar();
				showLoadingBar();
			</script>"; 
	
		$main_folder_name = $_POST['mainfoldername'];
		$overwrite = $_POST['overwrite'];
		$selected_files = getSelectedFiles($files_list);
		$status = unzipFile($root_path,$path,$zip_type,$zip_name,$main_folder_name,$overwrite,$selected_files);
		if(is_array($status) && count($status) == 0) {
			updateDirlist($root_path,$path,$main_folder_name,$selected_files,$files_list);
			echo "<script>
				openerWindow.cleanSearchedUrlVarsFromFilelistFormAction();
				openerWindow.execFileCommand('refresh');
				top.close();
			</script>"; 
		}else {
			$error_msg = "ERROR: The following files weren\'t unziped:\\n- ".implode("\\n- ",$status);
			echo "<script>
				openerWindow.hideLoadingBar();
				hideLoadingBar();
				alert('".$error_msg."');
			</script>";
		}
	}
	elseif($CONFIG['unzip_permission_denied_message']) echo "<script>alert('".$CONFIG['unzip_permission_denied_message']."');</script>"; 
}



function getElements($zip_type,$zip_name) {
	$files_list = array();

	if($zip_type == "zip") {
		$zip_object = new Archive_Zip($zip_name);
		$files_list = $zip_object->listContent();
	}
	elseif($zip_type == "gz" || $zip_type == "tgz") {
		$gz_object = new Archive_Tar($zip_name,'gz');
		$gz_object->setErrorHandling(PEAR_ERROR_PRINT);
		$files_list = $gz_object->listContent();
	}
	elseif($zip_type == "tar") {
		$tar_object = new Archive_Tar($zip_name);
		$tar_object->setErrorHandling(PEAR_ERROR_PRINT);
		$files_list = $tar_object->listContent();
	}
	
	return $files_list;
}

function unzipFile($root_path,$path,$zip_type,$zip_name,$main_folder_name,$overwrite,$selected_files) {
	$zip_name = basename($zip_name);
	$tmp_dir_name = $path.'/.__unzip'.$zip_name.$_GET['PHPSESSID'];
	File::deleteFile($tmp_dir_name);
	
	if(File::createFile($tmp_dir_name,'dir'))
		if(File::unzipFile($zip_type,$path.'/'.$zip_name,$selected_files,$tmp_dir_name.'/'.$main_folder_name)) {
			$files_error = array();
			if(!empty($main_folder_name)) {
				if(!File::moveFile($tmp_dir_name.'/'.$main_folder_name,$path.'/'.$main_folder_name,$overwrite))
					$files_error = array($path.'/'.$main_folder_name);
			}
			else {
				$files_list = File::getDirFiles($tmp_dir_name);
				for($i = 0; $i < count($files_list); ++$i)
					if(!File::moveFile($files_list[$i][7],$path.'/'.$files_list[$i][0],$overwrite))
						$files_error[] = $files_list[$i][0];
			}
			File::deleteFile($tmp_dir_name);
			return $files_error;
		}
	return false;
}

function getSelectedFiles($files_list) {
	$selected_files = array();

	$prefix = "file_";
	$post = array_keys($_POST);
	for($i = 0; $i < count($post); ++$i) {
		$index = strpos($post[$i],$prefix);
		$num = substr( $post[$i], strlen($prefix));
		if(is_numeric($index) && $index == 0 && is_numeric($num)) {
			$value = $_POST[$post[$i]];
			for($j = 0; $j < count($files_list); ++$j) {
				$file_name = $files_list[$j]['filename'];
				$index = strpos($file_name,$value);
				if(is_numeric($index) && $index == 0)
					$selected_files[] = $file_name;
			}
		}
	}
	
	return $selected_files;
}

function getBytesConverted($size) {
	return File::getBytesConverted($size);
}

function updateDirlist($root_path,$path,$main_folder_name,$selected_files,$files_list) {
	$zip_dirname = empty($path) ? $root_path : $path."/";
	
	if(empty($main_folder_name)) {
		if(count($selected_files) > 0) {
			$repeated_files = array();
			for($i = 0; $i < count($selected_files); ++$i) {
				$file_name = getRootDir($selected_files[$i]);
				$index = array_search($file_name,$repeated_files);
				if(!is_numeric($index)) {
					$repeated_files[] = $file_name;
					if(is_dir($zip_dirname.$file_name))
						echo "<script>openerWindow.parent.parent.parent.frames['dirlist'].addNode('".$path."','".File::cleanRootPath($root_path,$zip_dirname.$file_name)."','".$file_name."');</script>";
				}
			}				
		}
		else if(count($files_list) > 0) {
			$repeated_files = array();
			for($i = 0; $i < count($files_list); ++$i) {
				$file_name = getRootDir($files_list[$i]['filename']);
				$index = array_search($file_name,$repeated_files);
				if(!is_numeric($index)) {
					$repeated_files[] = $file_name;
					if(is_dir($zip_dirname.$file_name))
						echo "<script>openerWindow.parent.parent.parent.frames['dirlist'].addNode('".$path."','".File::cleanRootPath($root_path,$zip_dirname.$file_name)."','".$file_name."');</script>";
				}
			}				
		}
	}
	else echo "<script>openerWindow.parent.parent.parent.frames['dirlist'].addNode('".$path."','".File::cleanRootPath($root_path,$zip_dirname.$main_folder_name)."','".$main_folder_name."');</script>";
}

function getRootDir($file_name) {
	if(substr($file_name,0,1) == "/") $file_name = substr($file_name,1,strlen($file_name));
	
	$index = strpos($file_name,"/");
	$root_dir = $index > 0 ? substr($file_name,0,$index) : $file_name;
	return $root_dir;
}
?>
