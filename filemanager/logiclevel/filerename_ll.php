<?
$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
include($globvars['local_root'].'core/globvars.php');
require_once($globvars['local_root']."filemanager/logiclevel/init.php");

$dirname = dirname($path);
$filename = basename($path);

if($_GET['submitfilerename']) {
	$new_name = $_GET['filename'];
	if($new_name != $filename):
		if($CONFIG['rename_permission']):
			$full_new_name = $dirname != '.' && !empty($dirname) ? $dirname.'/'.$new_name : $new_name;
			require_once($globvars['local_root']."filemanager/config/config.file.php");
			if(CONFIGFILE::isValidAndNotHiddenFile($full_new_name)):
				if($status = File::renameFile($path,$full_new_name)):
					echo "1"; 
				else:
					echo "2";
				endif; 
			else:
				echo "Sorry, file not renamed!\nPossible reasons:\n- File extension reserved.\n- File name prefix reserved.\n- File base name reserved.";
			endif;
		endif;
	elseif($CONFIG['rename_permission_denied_message']):
		echo "3";
	endif;
}
?>
