<?
$zip_name = $_POST['filename'];
if($_POST['submitBtn'] && !empty($zip_name)) {

	if($CONFIG['zip_permission']) {
		echo "<script>
			openerWindow.showLoadingBar();
			showLoadingBar();
		</script>"; 
	
		$selected_files = array();
		$main_folder_name = $_POST['mainfoldername'];
		$zip_type = $_POST['compressiontype'];
		$overwrite = $_POST['overwrite'];
		
		$selFilesLength = $_POST['selFilesLength'];
		for($i=0; $i < $selFilesLength; ++$i)
			if($_POST['file_'.$i]) 
				$selected_files[count($selected_files)] = $root_path.$_POST['file_'.$i];
		
		$selDirsLength = $_POST['selDirsLength'];
		for($i=0; $i < $selDirsLength; ++$i)
			if($_POST['dir_'.$i])
				$selected_files[count($selected_files)] = $root_path.$_POST['dir_'.$i];
		
		if($status = zipFile($root_path,$path,$zip_type,$zip_name,$selected_files,$main_folder_name,$overwrite))
			echo "<script>alert('File successfully compressed!');openerWindow.cleanSearchedUrlVarsFromFilelistFormAction();openerWindow.execFileCommand('refresh');top.close();</script>"; 
		else
			echo "<script>
				openerWindow.hideLoadingBar();
				hideLoadingBar();
				alert('ERROR: File not zipped! Try again!');
			</script>";
	}
	elseif($CONFIG['zip_permission_denied_message']) echo "<script>alert('".$CONFIG['zip_permission_denied_message']."');</script>"; 
}


function zipFile($root_path,$path,$zip_type,$zip_name,$selected_files,$main_folder_name,$overwrite) {
	$tmp_dir_name = $path.'/.__zip_'.$zip_name.'_'.$zip_type.'_'.$_GET['PHPSESSID'];
	$zip_file_name = $zip_type == "gz" ? $zip_name.".tar.".$zip_type : $zip_name.".".$zip_type;
	
	if(File::createFile($tmp_dir_name,'dir'))
		if(File::zipFile($zip_type,$tmp_dir_name.'/'.$zip_name,$selected_files,$main_folder_name,$path))
			if(File::moveFile($tmp_dir_name.'/'.$zip_file_name,$path.'/'.$zip_file_name,$overwrite)) {
				File::deleteFile($tmp_dir_name);
				return true;
			}
	
	File::deleteFile($tmp_dir_name);
	return false;
}
?>
