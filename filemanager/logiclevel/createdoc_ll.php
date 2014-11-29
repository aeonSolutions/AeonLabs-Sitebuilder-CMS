<? 
if($_POST['Submit']) {

	if($CONFIG['create_doc_permission']) {
	
		echo "<script>openerWindow.showLoadingBar();</script>"; 
	
		$file = !empty($path) ? $path.'/'.$_POST['docname'] : $_POST['docname'];
		if(!file_exists($file)) {
			$template = $_POST['template'];
			
			if(empty($template) && $status = File::createFile($file) )
				echo "<script>openerWindow.cleanSearchedUrlVarsFromFilelistFormAction();openerWindow.execFileCommand('refresh');top.close();</script>";
			elseif(!empty($template) && file_exists($template) && $status = File::copyFile($template,$file.".".File::getFileExtension($template),1) )
				echo "<script>openerWindow.execFileCommand('refresh');top.close();</script>";
			else {
				echo "<script>openerWindow.hideLoadingBar();</script>"; 
				echo "<script>alert('ERROR: File not created! Try again!');</script>";
			}
		}else {
			echo "<script>openerWindow.hideLoadingBar();</script>"; 
			echo "<script>alert('File \"".$file."\" already exist!');</script>";
		}
	}
	elseif($CONFIG['create_doc_permission_denied_message']) echo "<script>alert('".$CONFIG['create_doc_permission_denied_message']."');</script>"; 
}

$templates = File::getDirFiles($CONFIG['file_templates_path']);
?>