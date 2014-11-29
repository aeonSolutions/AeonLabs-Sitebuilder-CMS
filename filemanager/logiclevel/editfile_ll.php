<?
if($_POST['Submit']):

	if($CONFIG['file_edit_permission']):
		if (get_magic_quotes_gpc()):
			$filecontents = stripslashes($_POST['filecontents']);
		else:
			$filecontents = str_replace('\"','"',$_POST['filecontents']);
		endif;
	$status = File::writeFile($path,$filecontents);
		if($status):
			$new_name = dirname($path) != "." ? dirname($path)."/".$_POST['newname'] : $_POST['newname'];
			if($path != $new_name):
				if($CONFIG['rename_permission']):
					if($status = File::renameFile($path,$root_path.$new_name)):
						$path = $new_name;
					else:
						echo "<script>alert('ERROR: File not renamed! Try again!');</script>"; 
					endif;
				elseif($CONFIG['rename_permission_denied_message']):
					 echo "<script>alert('".$CONFIG['rename_permission_denied_message']."');</script>"; 
				endif;
			endif;
			echo "<script>openerWindow.execFileCommand('refresh');</script>"; 
		endif;

		if($status):
			echo "<script>alert('File sucessfully saved!');</script>"; 
		else: 
			echo "<script>alert('ERROR: File not saved! Try again!');</script>"; 
		endif;
	elseif($CONFIG['file_edit_permission_denied_message']):
		 echo "<script>alert('".$CONFIG['file_edit_permission_denied_message']."');</script>"; 
	endif;
endif;

$filecontents = File::readFile($path);
?>
