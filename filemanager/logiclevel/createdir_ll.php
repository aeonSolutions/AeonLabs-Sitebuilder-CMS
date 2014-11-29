<? 
if($_POST['Submit']) {

	if($CONFIG['create_folder_permission']) {
	
		echo "<script>openerWindow.showLoadingBar();</script>"; 
	
		echo 'mts::'.$path.'-';
		$dir = !empty($path) ? $path.'/'.$_POST['dirname'] : $_POST['dirname'];
		if(!file_exists($dir)) {
			$template = $_POST['template'];
			$full_dir_path = $dir;
			echo 'MIGS:'.$full_dir_path;
			$script = "<script>
				openerWindow.parent.parent.parent.frames['dirlist'].addNode('".$path."','".$dir."','".basename($dir)."');
				openerWindow.cleanSearchedUrlVarsFromFilelistFormAction();
				openerWindow.execFileCommand('refresh');
				top.close();
			</script>";
			
			if(empty($template) && $status = File::createFile($full_dir_path,'dir'))
				echo $script; 
			elseif(!empty($template) && file_exists($template) && $status = File::copyFile($template,$full_dir_path,1) )
				echo $script; 			
			else {
				echo "<script>openerWindow.hideLoadingBar();</script>"; 
				echo "<script>alert('ERROR: Directory not created! Try again!');</script>"; 
			}
		}else {
			echo "<script>openerWindow.hideLoadingBar();</script>"; 
			echo "<script>alert('Directory \"".$dir."\" already exist!');</script>"; 
		}
	}
	elseif($CONFIG['create_folder_permission_denied_message']) echo "<script>alert('".$CONFIG['create_folder_permission_denied_message']."');</script>"; 
}

$templates = File::getDirFiles($CONFIG['dir_templates_path']);
for($i = 0; $i < count($templates); ++$i)
	$templates[$i][3] = File::cleanRootPath($root_path,$templates[$i][3]);
?>