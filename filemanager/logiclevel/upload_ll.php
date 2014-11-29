<?
require_once($globvars['local_root']."filemanager/config/config.file.php");

$uploadExtensions = $CONFIG['uploadExtensions'];
if(empty($uploadExtensions)) $uploadExtensions = 'ALL';
$validateExtensionFiles = ($uploadExtensions && $uploadExtensions != 'ALL') ? 'true' : 'false';

$forbidenUploadExtensions = $CONFIG['forbidenUploadExtensions'];
if(empty($forbidenUploadExtensions)) $forbidenUploadExtensions = 'NONE';
$validateForbidenExtensionFiles = ($forbidenUploadExtensions && $forbidenUploadExtensions != 'NONE') ? 'true' : 'false';

$maxuploadsize = $CONFIG['maxuploadsize_MB'];

if(@$_POST['SubmitBtn']) {

	if($CONFIG['upload_permission']) {
		if(!$out_frame_upload) echo "<script>openerWindow.showLoadingBar();</script>"; 
		
		$error_files = array();
		$upload_extensions = explode(",",$uploadExtensions);
		$forbiden_upload_extensions = explode(",",$forbidenUploadExtensions);
		
		$file_indexes = explode(",",$_POST['file_indexes']);
		for($i=0; $i < count($file_indexes); ++$i) {
			$index = trim($file_indexes[$i]);
			if(is_numeric($index)) {
				$file = $_FILES['file_'.$index]['name'];
				$filename = $_POST['filename_'.$index];
				$overwrite = $_POST['overwrite_'.$index] ? true : false;
				
				$is_valid = ($validateExtensionFiles == 'true' && !validateExtension($file,$upload_extensions)) ? false : true;
				$is_valid = ($validateForbidenExtensionFiles == 'true' && validateExtension($file,$forbiden_upload_extensions)) ? false : $is_valid;
				if($is_valid) {					
					if(!empty($file) && !empty($filename))
						if(!File::upload('file_'.$index,$root_path.$_POST['path'],$filename,$overwrite,CONFIGFILE::getUploadMaxSizeInBytes() ))
							$error_files[] = $filename;
				}
				else $error_files[] = $filename;
			}
		}
			
		if(count($error_files) > 0) {
			if(!$out_frame_upload) echo "<script>openerWindow.hideLoadingBar();</script>";
			
			echo "<script>
				alert('Cannot upload the followed files:";
				for($i=0; $i < count($error_files); ++$i)
					echo "\\n- ".$error_files[$i];
				echo "');
				refreshUpload('".$out_frame_upload."');
			</script>";
		}
		else echo "<script>refreshUpload('".$out_frame_upload."');</script>";
	}
	elseif($CONFIG['upload_permission_denied_message']) echo "<script>alert('".$CONFIG['upload_permission_denied_message']."');</script>"; 
}

function validateExtension($file,$upload_extensions) {
	$extension = File::getFileExtension($file);
	if(is_array($upload_extensions)) {
		$index = array_search($extension,$upload_extensions);
		return is_numeric($index) && $index >= 0;
	}
	return true;
}
?>
