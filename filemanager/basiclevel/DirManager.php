<?
require_once($globvars['local_root']."filemanager/basiclevel/File.php");
require_once($globvars['local_root']."filemanager/basiclevel/FileManager.php");
require_once($globvars['local_root']."filemanager/config/config.file.php");

class DirManager
{
	function createFile($file_name) {
		 if(!empty($file_name) && !file_exists($file_name))
			return mkdir($file_name);
		return true;
	}
	
	function renameFile($file_name,$new_name) {
		return File::renameFile($file_name,$new_name);
	}
	
	function copyFile($source_file,$destination_file,$overwrite) {
		$status = true;
		if(!empty($source_file) && is_dir($source_file)) {
			if($source_file == $destination_file)
				return true;
			else {
				if(file_exists($destination_file) && !$overwrite)
					return false;
				else {
					if(File::deleteFile($destination_file) && DirManager::createFile($destination_file)) {
						$source_file = File::configureFileName($source_file);
						$destination_file = File::configureFileName($destination_file);
						
						$sub_files = DirManager::getDirFiles($source_file);
						for($i = 0; $i < count($sub_files); ++$i) {
							$file = $sub_files[$i][0];
							if(is_dir($source_file.$file))
								$status = DirManager::copyFile($source_file.$file,$destination_file.$file,$overwrite);
							elseif(!FileManager::copyFile($source_file.$file,$destination_file.$file,$overwrite))
								$status = false;
						}
					}
				}
			}
		}
		return $status;
	}
	
	function moveFile($source_file,$destination_file,$overwrite) {
		if(!empty($source_file) && file_exists($source_file)) {
			if($source_file == $destination_file)
				return true;
			else {
				if(file_exists($destination_file)) {
					if($overwrite) {
						if(File::deleteFile($destination_file))
							return DirManager::renameFile($source_file,$destination_file);
					}else return false;
				}
				else
					return DirManager::renameFile($source_file,$destination_file);
			}
		}
		return false;
	}
	
	function deleteFile($file_name) {
		$status = true;
		if(!empty($file_name) && is_dir($file_name))
		{
			$file_name = File::configureFileName($file_name);
			
			$sub_files = DirManager::getDirFiles($file_name,true);
			for($i = 0; $i < count($sub_files); ++$i) {
				$file = $sub_files[$i][0];
				if(is_dir($file_name.$file))
					$status = DirManager::deleteFile($file_name.$file);
				elseif(!File::deleteFile($file_name.$file))
					$status = false;
			}
			if($status && !rmdir($file_name)) {
				chmod($file_name,0755);
				$status = rmdir($file_name);
			}
		}
		return $status;
	}
	
	function searchFiles($file_name,$search_subfolders,$search_file_name,$case_sensitive) {
		$found_files = array();
		if(!empty($search_file_name)) {
			if(empty($case_sensitive)) $search_file_name = strtolower($search_file_name);
			$file_name = File::configureFileName($file_name);
			
			$files = File::getDirFiles($file_name);
			for($i=0; $i < count($files); ++$i)
				if(!empty($files[$i][0])) {
					$file_name_i = empty($case_sensitive) ? strtolower($files[$i][0]) : $files[$i][0];
					
					$pos = strpos($file_name_i,$search_file_name);
					if(is_numeric($pos) && $pos >= 0)
						$found_files[count($found_files)] = $files[$i];
	
					if(!empty($search_subfolders)) {
						$found_sub_files = DirManager::searchFiles($file_name.$files[$i][0],$search_subfolders,$search_file_name,$case_sensitive);
						$found_files = array_merge($found_files,$found_sub_files);
					}
				}
		}
		return $found_files;
	}
	
	function searchWordInFiles($file_name,$search_subfolders,$search_file_word,$case_sensitive) {
		$found_files = array();
		if(!empty($search_file_word)) {
		
			if(empty($case_sensitive)) $search_file_word = strtolower($search_file_word);
			$file_name = File::configureFileName($file_name);
			
			$files = File::getDirFiles($file_name);
			for($i=0; $i < count($files); ++$i)
				if(!empty($files[$i][0])) {
					if($files[$i][1] != "dir") {
						$file_cont = File::readFile($file_name.$files[$i][0]);
						$file_cont = empty($case_sensitive) ? strtolower($file_cont) : $file_cont;
						
						$pos = strpos($file_cont,$search_file_word);
						if(is_numeric($pos) && $pos >= 0)
							$found_files[count($found_files)] = $files[$i];
					}
					if(!empty($search_subfolders)) {
						$found_sub_files = DirManager::searchWordInFiles($file_name.$files[$i][0],$search_subfolders,$search_file_word,$case_sensitive);
						$found_files = array_merge($found_files,$found_sub_files);
					}
				}
		}
		return $found_files;
	}
	
	function getDirFiles($file_name,$list_all=false) {
		$sub_files = array();
		if (is_dir($file_name) && ($dir = opendir($file_name)) ) 
		{
			$file_name = File::configureFileName($file_name);
			
		    while( ($file = readdir($dir)) != false)
				if( (!$list_all && DirManager::isValidFileName($file_name.$file)) || ($list_all && $file != "." && $file != "..") )
					$sub_files[count($sub_files)] = File::getFileInformation($file_name.$file);
			closedir($dir);
		}
		return $sub_files;
	}
	
	function getDirInformation($file_name) {	
		if (is_dir($file_name) && ($dir = opendir($file_name)) ) 
		{
			$size = 0;
			$num_sub_dirs = 0;
			$num_sub_files = 0;
			
			if(!empty($file_name) && substr($file_name,strlen($file_name)-1) != "/")
				$file_name .= "/";
			
		    while( ($file = readdir($dir)) != false) 
				if(DirManager::isValidFileName($file_name.$file)){
					if(is_dir($file_name.$file)) ++$num_sub_dirs;
					else ++$num_sub_files;
					
					$size += filesize($file_name.$file);
				}
	       closedir($dir);
		}
		return array(File::getBytesConverted($size),$num_sub_dirs,$num_sub_files);
	}
	
	function isValidFileName($file) {
		return CONFIGFILE::isValid($file);
	}
}
?>