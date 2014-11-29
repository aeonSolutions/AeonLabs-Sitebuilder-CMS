<?
require_once($globvars['local_root']."filemanager/config/useraccesscontrol/group1/config.php");
require_once($globvars['local_root']."filemanager/config/useraccesscontrol/group1/config.file.allowed.php");
require_once($globvars['local_root']."filemanager/config/useraccesscontrol/group1/config.file.hidden.php");
require_once($globvars['local_root']."filemanager/config/config.thumbnails.php");
require_once($globvars['local_root']."filemanager/ImageManager/config.aux.php");

define("READ_PERMISSION",$CONFIG['read_permission'],false);

class CONFIGFILE {
	
	function isValid($file) {
		if(!READ_PERMISSION)
			return false;
		
		$file_base_name = basename($file);
		$is_dir = is_dir($file);
		
		if(!$is_dir) {
			$allowed_files_ends_with = CONFIGFILEALLOWED::getAllowedFilesEndsWith();
			$size = count($allowed_files_ends_with);
			if($size > 0) {
				$is_valid = false;
				for($i = 0; $i < $size; ++$i) {
					if(!empty($allowed_files_ends_with[$i])) {
						$subs = substr($file_base_name,strlen($file_base_name)-strlen($allowed_files_ends_with[$i]));
						if($subs == $allowed_files_ends_with[$i]) {
							$is_valid = true;
							break;
						}
					}
				}
				if(!$is_valid) return false;
			}
		}
		
		return CONFIGFILE::isValidAndNotHiddenFile($file);
	}
	
	function isValidAndNotHiddenFile($file) {
		$file_base_name = basename($file);
		$is_dir = is_dir($file);
		
		if(CONFIGFILEHIDDEN::getHiddenDirFiles() && $is_dir)
			return false;
			
		if(CONFIGFILEHIDDEN::getHiddenAllFilesExceptDirs() && $is_dir)
			return false;
		
		$hidden_files_full_path = CONFIGFILEHIDDEN::getHiddenFilesWithTheFullPath();
		$size = count($hidden_files_full_path);
		for($i = 0; $i < $size; ++$i) {
			if(!empty($hidden_files_full_path[$i]) && $file == $hidden_files_full_path[$i])
				return false;
		}
		
		$hidden_files_base_name = CONFIGFILEHIDDEN::getHiddenFilesWithTheBaseName();
		$size = count($hidden_files_base_name);
		for($i = 0; $i < $size; ++$i) {
			if(!empty($hidden_files_base_name[$i]) && $file_base_name == $hidden_files_base_name[$i])
				return false;
		}
		
		$hidden_files_start_with = CONFIGFILEHIDDEN::getHiddenFilesStartWith();
		$hidden_files_start_with[] = CONFIGFILE::getTmpImgEditor();
		$hidden_files_start_with[] = CONFIGFILE::getTmpImgThumbnail();
		
		$size = count($hidden_files_start_with);
		for($i = 0; $i < $size; ++$i) 
			if(!empty($hidden_files_start_with[$i])) {
				$index = strpos($file_base_name,$hidden_files_start_with[$i]);
				if(is_numeric($index) && $index == 0)
					return false;
			}
		
		$hidden_files_ends_with = CONFIGFILEHIDDEN::getHiddenFilesEndsWith();
		$size = count($hidden_files_ends_with);
		for($i = 0; $i < $size; ++$i)
			if(!empty($hidden_files_ends_with[$i])) {
				$index = strrpos($file_base_name,$hidden_files_ends_with[$i]);
				if(is_numeric($index) && $index == strlen($file_base_name)-strlen($hidden_files_ends_with[$i]))
					return false;
			}
		
		return true;
	}
	
	/*If you don't wish to limit the upload size, this function should return false.*/
	function getUploadMaxSizeInBytes() {
		return 52428800;
	}
	
	function getTmpImgEditor() {
		return CONFIGIMAGEMANAGER::getTmpImgEditor();
	}
	
	function getTmpImgThumbnail() {
		$config = CONFIGTHUMBNAILS::getThumbnailsConfig();
		$dirname = dirname($config['prefix_name']);
		return $dirname != '.' && $dirname != '..' && !empty($dirname) ? $dirname : basename($config['prefix_name']);
	}
}
?>