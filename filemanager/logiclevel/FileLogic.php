<?
require_once($globvars['local_root']."filemanager/basiclevel/Matriz.php");
require_once($globvars['local_root']."filemanager/basiclevel/File.php");
		
class FileLogic {

	function executeFileActionFromFileIcon($root_path,$path,$CONFIG) {
		if(@$_GET['imageaction'] && ($action = $_GET['selected_action']) && ($filename = $_GET['filename']) ) {
			$filename = !empty($path) ? $path.'/'.$filename : $filename;
		
			if($action == 'delete') {
			
				if($CONFIG['delete_permission']) {
					if(File::deleteFile($root_path.$filename)) {
						$_SESSION['files_to_copy'] = FileLogic::clearDeletedFileFromCopiedFiles($filename,$_SESSION['files_to_copy']);
						$_SESSION['files_to_cut'] = FileLogic::clearDeletedFileFromCopiedFiles($filename,$_SESSION['files_to_cut']);
						
						if(!empty($_SESSION['files_to_copy'])) echo "<script>updateCutedAndCopiedFiles('".$_SESSION['files_to_copy']."');</script>";
						else echo "<script>updateCutedAndCopiedFiles('".$_SESSION['files_to_cut']."');</script>";
						
						echo "<script>parent.parent.parent.frames['dirlist'].deleteNode('".$filename."');</script>";
					}
					else
						echo "<script>alert('ERROR: File ".$filename." not deleted! Try Again!');</script>";
				}
				elseif($CONFIG['delete_permission_denied_message']) 
					echo "<script>alert('".$CONFIG['delete_permission_denied_message']."');</script>"; 
					
			}elseif($action == 'copy') {
			
				if($CONFIG['copy_permission']) {
					$_SESSION['files_to_copy'] = $filename;
					$_SESSION['files_to_cut'] = false;
					echo "<script>updateCutedAndCopiedFiles('".$filename."');</script>";
				}
				elseif($CONFIG['copy_permission_denied_message']) 
					echo "<script>alert('".$CONFIG['copy_permission_denied_message']."');</script>"; 
					
			}elseif($action == 'cut') {
			
				if($CONFIG['cut_permission']) {
					$_SESSION['files_to_copy'] = false;
					$_SESSION['files_to_cut'] = $filename;
					echo "<script>updateCutedAndCopiedFiles('".$filename."');</script>";
				}
				elseif($CONFIG['cut_permission_denied_message']) 
					echo "<script>alert('".$CONFIG['cut_permission_denied_message']."');</script>"; 
					
			}
		} 
	}
	
	function executeFileActionFromGeneralIcon($root_path,$path,$CONFIG) {
		if($action = @$_POST['selected_action']) {
			$error_files = array();
			$selected_files = array();
			$num_of_items = $_POST['num_of_items'];
			
			for($i=0; $i < $num_of_items; ++$i):
				if(isset($_POST['dir_'.$i])):
					$selected_files[count($selected_files)] = $_POST['dir_'.$i];
				elseif(isset($_POST['file_'.$i])):
					$selected_files[count($selected_files)] = $_POST['file_'.$i];
				endif;
			endfor;
				
			if($action == "copy") {
			
				if($CONFIG['copy_permission']) {
					$_SESSION['files_to_copy'] = implode("|",$selected_files);
					$_SESSION['files_to_cut'] = false;
					echo "<script>updateCutedAndCopiedFiles('".$_SESSION['files_to_copy']."');</script>";
				}
				elseif($CONFIG['copy_permission_denied_message']) 
					echo "<script>alert('".$CONFIG['copy_permission_denied_message']."');</script>"; 
					
			}elseif($action == "cut") {
			
				if($CONFIG['cut_permission']) {
					$_SESSION['files_to_copy'] = false;
					$_SESSION['files_to_cut'] = implode("|",$selected_files);
					echo "<script>updateCutedAndCopiedFiles('".$_SESSION['files_to_cut']."');</script>";
				}
				elseif($CONFIG['cut_permission_denied_message']) 
					echo "<script>alert('".$CONFIG['cut_permission_denied_message']."');</script>"; 
					
			}elseif($action == "paste") {
				
				if($CONFIG['copy_permission'] || $CONFIG['cut_permission']) {
					if(!empty($_SESSION['files_to_copy'])) { 
						$selected_files = explode('|',$_SESSION['files_to_copy']);
						$action_to_paste = 'copy';
					}elseif(!empty($_SESSION['files_to_cut'])){
						$selected_files = explode('|',$_SESSION['files_to_cut']);
						$action_to_paste = 'move';
					}
					else $selected_files = array();
					
					$path_aux = empty($path) ? $root_path : $path.'/';
					for($i=0; $i < count($selected_files); ++$i)
						$selected_files[$i] = $root_path.$selected_files[$i].' => '.$path_aux.basename($selected_files[$i]);
			
					$error_files = File::execute($selected_files,$action_to_paste);
					if($action_to_paste == "move") {
						for($i=0; $i < count($selected_files); ++$i) {
							$index = array_search($selected_files[$i],$error_files);
							if(!is_numeric($index) || $index < 0) {
								$explode = explode(' => ',$selected_files[$i]);
								$source_file = File::cleanRootPath($root_path,$explode[0]);
								$destiny_file = File::cleanRootPath($root_path,$explode[1]);
								$_SESSION['files_to_cut'] = FileLogic::clearDeletedFileFromCopiedFiles($source_file,$_SESSION['files_to_cut']);
								
								if(is_dir($destiny_file)) {
									$destiny_dirname = dirname($destiny_file);
									if($destiny_dirname == "." || $destiny_dirname == "\\")
										$destiny_dirname = "";
									
									echo "<script>
										parent.parent.parent.frames['dirlist'].deleteNode('".$source_file."');
										parent.parent.parent.frames['dirlist'].addNode('".$destiny_dirname."','".$destiny_file."','".basename($destiny_file)."');
									</script>";
								}
							}
						}
						echo "<script>updateCutedAndCopiedFiles('".$_SESSION['files_to_cut']."');</script>";
					}
				}
				elseif($CONFIG['paste_permission_denied_message']) 
					echo "<script>alert('".$CONFIG['paste_permission_denied_message']."');</script>"; 
				
			}
			elseif($action == "delete") {
				
				if($CONFIG['delete_permission']) {
					for($i=0; $i < count($selected_files); ++$i)
						$selected_files[$i] = $root_path.$selected_files[$i];
						
					$selected_dir_files = array();
					for($i=0; $i < count($selected_files); ++$i)
						if(is_dir($selected_files[$i]))
							$selected_dir_files[] = $selected_files[$i];
				
					$error_files = File::execute($selected_files,$action);
					
					for($i=0; $i < count($selected_files); ++$i) {
						$index = array_search($selected_files[$i],$error_files);
						if(!is_numeric($index) || $index < 0) {
							$selected_file = File::cleanRootPath($root_path,$selected_files[$i]);
							$_SESSION['files_to_copy'] = FileLogic::clearDeletedFileFromCopiedFiles($selected_file,$_SESSION['files_to_copy']);
							$_SESSION['files_to_cut'] = FileLogic::clearDeletedFileFromCopiedFiles($selected_file,$_SESSION['files_to_cut']);
						}
					}
					if(!empty($_SESSION['files_to_copy'])) echo "<script>updateCutedAndCopiedFiles('".$_SESSION['files_to_copy']."');</script>";
					else echo "<script>updateCutedAndCopiedFiles('".$_SESSION['files_to_cut']."');</script>";
					
					for($i=0; $i < count($selected_dir_files); ++$i) {
						$index = array_search($selected_dir_files[$i],$error_files);
						if(empty($index) || !is_numeric($index) || $index < 0)
							echo "<script>parent.parent.parent.frames['dirlist'].deleteNode('".File::cleanRootPath($root_path,$selected_dir_files[$i])."');</script>";
					}
				}
				elseif($CONFIG['delete_permission_denied_message']) 
					echo "<script>alert('".$CONFIG['delete_permission_denied_message']."');</script>"; 
					
			}
			else
				$error_files = File::execute($selected_files,$action);
			
			if(count($error_files) > 0) {
				echo "<script>alert('Cannot ".$action." the following file(s):";
				for($i=0; $i < count($error_files); ++$i) {
					$explode = explode(" => ",$error_files[$i]);
					echo "\\n- \"".File::cleanRootPath($root_path,$explode[0])."\" to \"".File::cleanRootPath($root_path,$explode[1])."\"";
				}
				if($action == "paste")
					echo "\\n\\nMaybe the file(s) already exists or was/were previously renamed!');</script>";
			}
		}
	}
	
	function searchFiles($root_path,$path) {
		$search_indexes = $_GET['search_indexes'];
		$search_file_location = $_GET['search_file_location'];
		$search_subfolders = $_GET['search_subfolders'];
		$search_file_names = array();
		$search_file_words = array();
		
		$search_url_vars = "&search=1&search_indexes=".$search_indexes."&search_file_location=".$search_file_location."&search_subfolders=".$search_subfolders;
		
		$search_indexes = explode(",",$search_indexes);
		for($i=0; $i < count($search_indexes); ++$i) {
			$index = trim($search_indexes[$i]);
			if(is_numeric($index)) {
				$search_file_name = $_GET['search_file_name_'.$index];
				$search_file_word = $_GET['search_file_word_'.$index];
				$case_sensitive = $_GET['case_sensitive_'.$index] ? true : false;
	
				if(!empty($search_file_name))
					$search_file_names[count($search_file_names)] = array($search_file_name,$case_sensitive);
				if(!empty($search_file_word))
					$search_file_words[count($search_file_words)] = array($search_file_word,$case_sensitive);
				
				$search_url_vars .= "&search_file_name_".$index."=".$search_file_name."&search_file_word_".$index."=".$search_file_word."&case_sensitive_".$index."=".$case_sensitive;
			}
		}

		$files_1 = File::searchFiles($root_path.$search_file_location,$search_subfolders,$search_file_names);
		$files_2 = File::searchWordInFiles($root_path.$search_file_location,$search_subfolders,$search_file_words);
		$files = array_merge($files_1,$files_2);
		
		for($i = 0; $i < count($files); ++$i)
			for($j = $i+1; $j < count($files); ++$j)
				if($files[$i][7] == $files[$j][7])
					$files[$i] = false;
		$files = Matriz::retificaArray($files);
		
		return array($files,$search_url_vars);
	}
	
	function clearDeletedFileFromCopiedFiles($file_name,$str) {
		$files = explode('|',$str);
		$files_aux = array();
		for($i = 0; $i < count($files); ++$i) {
			if($files[$i] != $file_name) {
				$files_aux[] = $files[$i];
			}
			else $exists = true;
		}
		if($exists)
			$str = implode('|',$files_aux);
				
		return $str;
	}
}
?>