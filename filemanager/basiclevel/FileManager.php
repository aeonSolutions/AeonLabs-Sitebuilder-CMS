<?
require_once($globvars['local_root']."filemanager/basiclevel/File.php");

class FileManager
{
	function upload($field_name,$uploaddir,$new_name,$overwrite,$upload_max_size_in_bytes = false) {
		$file_size = $_FILES[$field_name]['size'];
		if(is_numeric($file_size) && $file_size > 0 && is_numeric($upload_max_size_in_bytes) && $file_size > $upload_max_size_in_bytes)
			return false;
		
		//set_time_limit(1800);
		if(!empty($uploaddir) && substr($uploaddir,strlen($uploaddir)-1) != "/")
			$uploaddir .= "/";
		
		$file_name = $_FILES[$field_name]['name'];
		if(!empty($new_name)) $uploadfile = $uploaddir.$new_name.'.'.File::getFileExtension($file_name);
		else $uploadfile = $uploaddir.basename($file_name);

		//echo $_FILES[$field_name]['tmp_name'].'-'.$uploadfile;
		if(!$overwrite && file_exists($uploadfile))
			return false;
		elseif(move_uploaded_file($_FILES[$field_name]['tmp_name'], $uploadfile)) {
			//unlink($_FILES[$field_name]['tmp_name']);
			//chmod($uploadfile,0777);
			return true;
		}
		return false;
	}
	
	function uploadType($field_name,$uploaddir,$new_name,$overwrite,$file_type,$upload_max_size_in_bytes = false) {
		if(File::isFileType(basename($_FILES[$field_name]['name']),$file_type))
			return FileManager::upload($field_name,$uploaddir,$new_name,$overwrite,$upload_max_size_in_bytes);
		return false;
	}
	
	function createFile($file_name)	{
		 if(!empty($file_name) && !file_exists($file_name))	 {
			if($file = fopen($file_name,"w+"))
				fclose($file);
			return $file;
		}
		return true;
	}
	
	function renameFile($file_name,$new_name) {
		return File::renameFile($file_name,$new_name);
	}
	
	function copyFile($source_file,$destination_file,$overwrite) {
		if(!empty($source_file) && file_exists($source_file)) {
			if($source_file == $destination_file)
				return true;
			else {
				if(file_exists($destination_file)) {
					if($overwrite) {
						if(File::deleteFile($destination_file) && copy($source_file,$destination_file)) {
							touch($destination_file, filemtime($source_file));
							return true;
						}
					}else return false;
				}
				elseif(copy($source_file,$destination_file)) {
					touch($destination_file, filemtime($source_file));
					return true;
				}
			}
		}
		return false;
	}
	
	function moveFile($source_file,$destination_file,$overwrite) {
		if(!empty($source_file) && file_exists($source_file)) {
			if($source_file == $destination_file)
				return true;
			else {
				if(file_exists($destination_file)) {
					if($overwrite) {
						if(File::deleteFile($destination_file))
							return FileManager::renameFile($source_file,$destination_file);
					}else return false;
				}
				else return FileManager::renameFile($source_file,$destination_file);
			}
		}
		return false;
	}

	function deleteFile($file_name)	{
		if(!empty($file_name) && file_exists($file_name))
			return unlink($file_name) or die('');
		return true;
	}
	
	function searchFiles($file_name,$search_subfolders,$search_file_name,$case_sensitive) {
		$file_base_name = basename($file_name);
		
		if(empty($case_sensitive)) {
			$search_file_name = strtolower($search_file_name);
			$file_base_name = strtolower($file_base_name);
		}
		
		$pos = strpos($file_base_name,$search_file_name);
		if(is_numeric($pos) && $pos >= 0)
			return array(File::getFileInformation($file_name));
		
		return array();
	}
	
	function searchWordInFiles($file_name,$search_subfolders,$search_file_word,$case_sensitive) {
		$file_cont = File::readFile($file_name);
		
		if(empty($case_sensitive)) {
			$search_file_word = strtolower($search_file_word);
			$file_cont = strtolower($file_cont);
		}
		
		$pos = strpos($file_cont,$search_file_word);
		if(is_numeric($pos) && $pos >= 0)
			return array(File::getFileInformation($file_name));
		
		return array();
	}
	
	function getImageFileInformation($file_name) {
		if(!empty($file_name) && file_exists($file_name) && File::isFileType($file_name,'image')) {
			return getimagesize($file_name);
		}
	}
	
	function readFile($file_name) {
		$cont = FileManager::parseFile($file_name);
		return implode("",$cont);
	}
	
	function parseFile($file_name) {
		if(!empty($file_name) && file_exists($file_name) && $file = fopen($file_name,"r")) {
			while(!feof($file))
				$cont[] = fgets($file);
			fclose($file);
		}
		return $cont;
	}
	
	function writeFile($file_name,$cont) {
		$status=0;
		if(!empty($file_name) && file_exists($file_name) && $file = fopen($file_name,"w")):
			$status = $cont ? fwrite($file,$cont) : true;
			fclose($file);
		endif;


		return $status;
	}
}
?>