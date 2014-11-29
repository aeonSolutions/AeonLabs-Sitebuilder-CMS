<?
$dirname = dirname($path);
$filename = basename($path);
$perms = File::getPermsInformation($path);
$owner_read = $perms[0];
$owner_write = $perms[1];
$owner_execute = $perms[2];
$group_read = $perms[3];
$group_write = $perms[4];
$group_execute = $perms[5];
$world_read = $perms[6];
$world_write = $perms[7];
$world_execute = $perms[8];
$perms_code = File::getPerms($path,true);
if(empty($perms_code)) $perms_code = '0000';

if($_POST['Submit']) {
	$new_name = $_POST['filename'];
	if($new_name != $filename) {
		if($CONFIG['rename_permission']) {
			$full_new_name = $dirname != '.' && !empty($dirname) ? $dirname.'/'.$new_name : $new_name;
			
			require_once($globvars['local_root']."filemanager/config/config.file.php");
			if(CONFIGFILE::isValidAndNotHiddenFile($full_new_name)) {
				if($status = File::renameFile($path,$full_new_name))
					echo "<script>openerWindow.parent.parent.parent.frames['dirlist'].renameNode('".$path."','".File::cleanRootPath($root_path,$full_new_name)."');openerWindow.execFileCommand('refresh');top.close();</script>"; 
				else echo "<script>alert('ERROR: File not renamed! Try again!');</script>"; 
			}
			else echo "<script>alert('Sorry, file not renamed!\\nPossible reasons:\\n- File extension reserved.\\n- File name prefix reserved.\\n- File base name reserved.');</script>";
		}
		elseif($CONFIG['rename_permission_denied_message']) echo "<script>alert('".$CONFIG['rename_permission_denied_message']."');</script>"; 
	}
	
	if($CONFIG['chmod_available'])
		if(!$status = File::setPerms($root_path.$dirname.'/'.$new_name,$_POST['owner_read'],$_POST['owner_write'],$_POST['owner_execute'],$_POST['group_read'],$_POST['group_write'],$_POST['group_execute'],$_POST['world_read'],$_POST['world_write'],$_POST['world_execute']))
			echo "<script>alert('ERROR: Permissions of file not updated!');</script>";
}
?>
