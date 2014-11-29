<?
require_once($globvars['local_root']."filemanager/basiclevel/DirManager.php");
require_once($globvars['local_root']."filemanager/basiclevel/FileManager.php");
require_once($globvars['local_root']."filemanager/basiclevel/Zip.php");
require_once($globvars['local_root']."filemanager/basiclevel/Tar.php");

class File
{
	function execute($selected_files,$action) {
		$error_files = array();
		if($action == 'create' || $action == 'rename' || $action == 'move' || $action == 'copy' || $action == 'paste' || $action == 'delete' || $action == 'upload' || $action == 'uploadimage') {
			for($i=0; $i < count($selected_files); ++$i) {
				$selected_files[$i] = trim($selected_files[$i]);
				
				if($action == 'rename' || $action == 'copy' || $action == 'move') {
					$explode = explode(' => ',$selected_files[$i]);
					$source_file = $explode[0];
					$destination_file = $explode[1];
				}
				
				switch($action) {
					case 'create': $status = File::createFile($selected_files[$i]); break;
					case 'rename': $status = File::renameFile($source_file,$destination_file); break;
					case 'copy': $status = File::copyFile($source_file,$destination_file,false); break;
					case 'move': $status = File::moveFile($source_file,$destination_file,false); break;
					case 'delete': $status = File::deleteFile($selected_files[$i]); break;
					case 'upload': $status = File::upload($source_file,$destination_file,false,true); break;
					case 'uploadimage': $status = File::uploadType($source_file,$destination_file,false,true,'image'); break;
					default: $status = true;
				}	

				if(!$status && !empty($selected_files[$i]))
					$error_files[count($error_files)] = $selected_files[$i];
			}
		}
		return $error_files;
	}
	
	function configureFileName($file_name) {
		if(!empty($file_name) && substr($file_name,strlen($file_name)-1) != "/")
			$file_name .= "/";
		return $file_name;
	}
	
	function clearFilesCache() {
		clearstatcache();
	}
	
	function upload($field_name,$uploaddir,$new_name,$overwrite,$upload_max_size_in_bytes = false) {
		$status = FileManager::upload($field_name,$uploaddir,$new_name,$overwrite,$upload_max_size_in_bytes);
		File::clearFilesCache();
		return $status;
	}
	
	function uploadType($field_name,$uploaddir,$new_name,$overwrite,$file_type,$upload_max_size_in_bytes = false) {
		$status = FileManager::uploadType($field_name,$uploaddir,$new_name,$overwrite,$file_type,$upload_max_size_in_bytes);
		File::clearFilesCache();
		return $status;
	}
	
	function createFile($file_name, $type = '') {
		if(strtolower($type) == 'dir')
			$status = DirManager::createFile($file_name);
		else $status = FileManager::createFile($file_name);

		File::clearFilesCache();
		return $status;
	}

	function renameFile($file_name,$new_name) {
		if(!empty($file_name) && $file_name != $new_name && file_exists($file_name) && !file_exists($new_name)) {
			$status = rename($file_name,$new_name);
			File::clearFilesCache();
			return $status;
		}
		return false;
	}
	
	function copyFile($source_file,$destination_file,$overwrite) {
		if(is_dir($source_file))
			$status = DirManager::copyFile($source_file,$destination_file,$overwrite);
		else $status = FileManager::copyFile($source_file,$destination_file,$overwrite);

		File::clearFilesCache();
		return $status;
	}
	
	function moveFile($source_file,$destination_file,$overwrite) {
		if(is_dir($source_file))
			$status = DirManager::moveFile($source_file,$destination_file,$overwrite);
		else $status = FileManager::moveFile($source_file,$destination_file,$overwrite);

		File::clearFilesCache();
		return $status;
	}
	
	function deleteFile($file_name) {
		if(is_dir($file_name))
			$status = DirManager::deleteFile($file_name);
		else $status = FileManager::deleteFile($file_name);

		File::clearFilesCache();
		return $status;
	}
	
	function zipFile($zip_type,$zip_name,$files=array(),$main_folder_name='',$remove_path='') {
		$status = false;
		$remove_path = empty($remove_path) && dirname($zip_name) != "." ? dirname($zip_name) : $remove_path;
	
		if($zip_type == "zip") {
  			$zip_object = new Archive_Zip($zip_name.".zip");
  			$p_params['add_path'] = $main_folder_name;
			$p_params['remove_path'] = $remove_path;
			$status = $zip_object->create($files,$p_params);
		}
		elseif($zip_type == "gz" || $zip_type == "tgz") {
			$gz_object = new Archive_Tar($zip_name.".tar.gz",'gz');
			$gz_object->setErrorHandling(PEAR_ERROR_PRINT);
			$status = $gz_object->create($files,$main_folder_name,$remove_path);
			if($status && $zip_type == "tgz")
				File::renameFile($zip_name.".tar.gz",$zip_name.".tgz");
		}
		elseif($zip_type == "tar") {
			$tar_object = new Archive_Tar($zip_name.".tar");
			$tar_object->setErrorHandling(PEAR_ERROR_PRINT);
			$status = $tar_object->create($files,$main_folder_name,$remove_path);
		}
		elseif($zip_type == "tar.gz") {
			if(File::zipFile("tar",$zip_name,$files,$main_folder_name,$remove_path)) {
				$v_list = array($zip_name.".tar");
				$status = File::zipFile("gz",$zip_name,$v_list);
				File::deleteFile($zip_name.".tar");
			}
		}
		File::clearFilesCache();
		return $status;
	}
	
	function unzipFile($zip_type,$zip_name,$files=array(),$main_folder_name='',$remove_path='') {
		$status = false;
		
		if($zip_type == "zip") {
  			$zip_object = new Archive_Zip($zip_name);
			$p_params['add_path'] = $main_folder_name;
			$p_params['remove_path'] = $remove_path;
  			$p_params['by_name'] = count($files) > 0 ? $files : false;
			$status = $zip_object->extract($p_params);
		}
		elseif($zip_type == "gz" || $zip_type == "tgz") {
			$gz_object = new Archive_Tar($zip_name,'gz');
			$gz_object->setErrorHandling(PEAR_ERROR_PRINT);
			$p_filelist = count($files) > 0 ? $files : false;
			$status = $gz_object->extract($main_folder_name,$remove_path,$p_filelist);
		}
		elseif($zip_type == "tar") {
			$tar_object = new Archive_Tar($zip_name);
			$tar_object->setErrorHandling(PEAR_ERROR_PRINT);
			$p_filelist = count($files) > 0 ? $files : false;
			$status = $tar_object->extract($main_folder_name,$remove_path,$p_filelist);
		}
		elseif($zip_type == "tar.gz") {
			if($status = File::unzipFile("gz",$zip_name,$files,$main_folder_name,$remove_path)) {
				$gz_object = new Archive_Tar($zip_name,'gz');
				$v_list = $gz_object->listContent();
				
				for($i = 0; $i < count($v_list); ++$i) {
					$file_name = $v_list[$i]['filename'];
					if(File::getFileExtension($file_name) == "tar") {
						if(File::unzipFile("tar",$file_name))
							File::deleteFile($file_name);
						else $status = false;
					}
				}
			}
		}
		File::clearFilesCache();
		return $status;
	}
	
	function searchFiles($file_name,$search_subfolders,$search_file_names) {
		$found_files = array();
		
		for($i = 0; $i < count($search_file_names); ++$i) {
			$search_file_name = $search_file_names[$i][0];
			$case_sensitive = $search_file_names[$i][1];
			
			if(is_dir($file_name))
				$found_files_i = DirManager::searchFiles($file_name,$search_subfolders,$search_file_name,$case_sensitive);
			else $found_files_i = FileManager::searchFiles($file_name,$search_subfolders,$search_file_name,$case_sensitive);
			
			$found_files = array_merge($found_files,$found_files_i);
		}
		return $found_files;
	}
	
	function searchWordInFiles($file_name,$search_subfolders,$search_file_words) {
		$found_files = array();
		
		for($i = 0; $i < count($search_file_words); ++$i) {
			$search_file_word = $search_file_words[$i][0];
			$case_sensitive = $search_file_words[$i][1];
			
			if(is_dir($file_name))
				$found_files_i = DirManager::searchWordInFiles($file_name,$search_subfolders,$search_file_word,$case_sensitive);
			else $found_files_i = FileManager::searchWordInFiles($file_name,$search_subfolders,$search_file_word,$case_sensitive);
			
			$found_files = array_merge($found_files,$found_files_i);
		}
		return $found_files;
	}
	
	function getDirFiles($file_name) {
		File::clearFilesCache();
		return DirManager::getDirFiles($file_name);
	}
	
	function getDirInformation($file_name)	{	
		File::clearFilesCache();
		return DirManager::getDirInformation($file_name);
	}
	
	function getFileInformation($file_name) {
		File::clearFilesCache();
		
		$data = array();
		if(!empty($file_name) && file_exists($file_name)) {
			$data[0] = File::getFileName($file_name);
			$data[1] = filetype($file_name);
			$data[2] = File::getFileExtension($file_name);
			$data[3] = File::getFileDirName($file_name);
			$data[4] = File::getStrFileSize($file_name);
			$data[5] = File::getModifiedDate($file_name);
			$data[6] = File::getCreatedDate($file_name);
			$data[7] = $data[3]."/".$data[0];//full path
		}
		return $data;
	}
	
	function getImageFileInformation($file_name) {
		File::clearFilesCache();
		return Filemanager::getImageFileInformation($file_name);
	}
	
	function getFileExtension($file_name) {
		if(!empty($file_name) && !is_dir($file_name)) {
			$pos = strrpos(basename($file_name),".");
			if(is_numeric($pos) && $pos > 0) 
				return substr(basename($file_name),$pos+1);
		} 
		else return 'dir';
	}
	
	function getFileSize($file_name) {
		File::clearFilesCache();
		if(!empty($file_name) && file_exists($file_name))
			return filesize($file_name);
		else return false;
	}
	
	function getStrFileSize($file_name) {
		if($size = File::getFileSize($file_name))
			return File::getBytesConverted($size);
		else return false;
	}
	
	function getBytesConverted($size) {
		if($size > 0) {
			if($size >= 1073741824) $size = round($size/1073741824,3)." GB";
			elseif($size >= 1048576) $size = round($size/1048576,2)." MB";
			elseif($size >= 1024) $size = round($size/1024,1)." KB";
			else $size .= " Bytes";
		} 
		return $size;
	}
	
	function getCreatedDate($file_name)	{
		File::clearFilesCache();
		return date("Y-m-d H:i",filectime($file_name));
	}
	
	function getModifiedDate($file_name) {
		File::clearFilesCache();
		return date("Y-m-d H:i",filemtime($file_name));
	}
	
	function getFileDirName($file_name)	{
		$strrpos_index = strrpos($file_name,"/");
		if(is_numeric($strrpos_index) && $strrpos_index == strlen(trim($file_name))-1)
			$file_name = substr($file_name,0,strlen($file_name)-1);
	
		return dirname($file_name);
	}
	
	function getFileName($file_name) {
		return basename($file_name);
	}
	
	function getFileNameWithoutExtension($file_name) {
		if(!empty($file_name) && !is_dir($file_name)) {
			$base_name = basename($file_name);
			$pos = strrpos($base_name,".");
			if(is_numeric($pos) && $pos > 0) 
				return substr($base_name,0,$pos);
		} 
		else return $file_name;
	}
	
	function cleanRootPath($root_path,$path) {
		if($path."/" == $root_path) {
			return "";
		}
		
		$index = strpos($path,$root_path);
		if(is_numeric($index) && $index == 0) {
			$length = strlen($root_path);
			$path = substr($path,$length);
		}
		return $path;
	}
	
	function setPerms($file_name,$owner_read,$owner_write,$owner_execute,$group_read,$group_write,$group_execute,$world_read,$world_write,$world_execute) {
		if(!empty($file_name) && file_exists($file_name)) {
			File::clearFilesCache();
		
			$owner_perms = 0;
			$owner_perms += $owner_read ? 4 : 0;
			$owner_perms += $owner_write ? 2 : 0;
			$owner_perms += $owner_execute ? 1 : 0;
			
			$group_perms = 0;
			$group_perms += $group_read ? 4 : 0;
			$group_perms += $group_write ? 2 : 0;
			$group_perms += $group_execute ? 1 : 0;
			
			$world_perms = 0;
			$world_perms += $world_read ? 4 : 0;
			$world_perms += $world_write ? 2 : 0;
			$world_perms += $world_execute ? 1 : 0;
			
			$mode = '0'.$owner_perms.$group_perms.$world_perms;
			return chmod($file_name,$mode);
		}
	}
	
	function getPerms($file_name, $octal = false) 	{
		if(!file_exists($file_name)) return false;
		
		clearstatcache();
		$perms = fileperms($file_name);
	
		$cut = $octal ? 2 : 3;
		$octperms = decoct($perms);
		if($cut) return substr($octperms,strlen($octperms)-4);
		return substr($octperms,strlen($octperms)-3);
	}

	function getPermsInformation($file_name) {
		$perms = File::getPerms($file_name, true); // true=0777 false=777
		$first = substr($perms,1,1);
		$second = substr($perms,2,1);
		$third = substr($perms,3,1);
		
		if($first > 0) {
			$owner_read = ($first >= 4) ? true : false;
			$owner_write = ($first == 2 || $first == 3 || $first == 6 || $first == 7) ? true : false;
			$owner_execute = ($first == 1 || $first == 3 || $first == 5 || $first == 7) ? true : false;
		}
		if($second > 0) {
			$group_read = ($second >= 4) ? true : false;
			$group_write = ($second == 2 || $second == 3 || $second == 6 || $second == 7) ? true : false;
			$group_execute = ($second == 1 || $second == 3 || $second == 5 || $second == 7) ? true : false;
		}
		if($third > 0) {
			$world_read = ($third >= 4) ? true : false;
			$world_write = ($third == 2 || $third == 3 || $third == 6 || $third == 7) ? true : false;
			$world_execute = ($third == 1 || $third == 3 || $third == 5 || $third == 7) ? true : false;
		}
		return array($owner_read,$owner_write,$owner_execute,$group_read,$group_write,$group_execute,$world_read,$world_write,$world_execute);
	}
	
	function getPermsLetters($file_name) {
		$perms = File::getPermsInformation($file_name);
		
		$letters = '-';
		$letters .= $perms[0] ? 'r' : '-';
		$letters .= $perms[1] ? 'w' : '-';
		$letters .= $perms[2] ? 'e' : '-';
		$letters .= $perms[3] ? 'r' : '-';
		$letters .= $perms[4] ? 'w' : '-';
		$letters .= $perms[5] ? 'e' : '-';
		$letters .= $perms[6] ? 'r' : '-';
		$letters .= $perms[7] ? 'w' : '-';
		$letters .= $perms[8] ? 'e' : '-';
		
		return $letters;
	}
	
	function isFileType($file_name,$file_type) {
		$file_type = strtolower($file_type);
		$extension = strtolower(File::getFileExtension($file_name));
		
		if($file_type == $extension) 
			return $extension;
		elseif( ($file_type == 'image' && File::isImage($extension))
			|| ($file_type == 'word' && $extension == "doc")
		  	|| ($file_type == 'excel' && $extension == "xsl")
		  	|| ($file_type == 'powerpoint' && $extension == "ppt") )
				return $extension;
		return false;
	}
	
	function isImage($extension) {
		$images_extension = array("jpg","jpeg","jpe","png","gif","bmp","tif","tiff","raw","psd","xbm","xpm","ief","rgb","g3f","xwd","pict","ppm","pgm","pbm","pnm","ras","pcd","cgm","fif","dsf","cmx","wi","dwg","dxf","svf");
		$index = array_search($extension,$images_extension);
		return (is_numeric($index) && $index >= 0);
	}
	
	function readFile($file_name) {
		return FileManager::readFile($file_name);
	}
	
	function parseFile($file_name) {
		return FileManager::parseFile($file_name);
	}
	
	function writeFile($file_name,$cont) {
		return FileManager::writeFile($file_name,$cont);
	}
}
?>