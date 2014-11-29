<?
require_once($globvars['local_root']."filemanager/logiclevel/FileLogic.php");

FileLogic::executeFileActionFromFileIcon($root_path,$path,$CONFIG);
FileLogic::executeFileActionFromGeneralIcon($root_path,$path,$CONFIG);
if(@$_GET['search']) {

	if($CONFIG['search_permission']) {
		$founded_files = FileLogic::searchFiles($root_path,$path);
		$files = $founded_files[0];
		$search_url_vars = $founded_files[1];
		$is_search = true;
	}
	elseif($CONFIG['search_permission_denied_message']) {
		echo "<script>alert('".$CONFIG['search_permission_denied_message']."');</script>"; 
		$files = array();
		$search_url_vars = false;
		$is_search = true;
	}
}
else
	$files = File::getDirFiles($path);
	
$hasCreateFolderPermission = $CONFIG['create_folder_permission'] ? "true" : "false";
$hasCreateDocPermission = $CONFIG['create_doc_permission'] ? "true" : "false";
$hasUploadPermission = $CONFIG['upload_permission'] ? "true" : "false";
$hasCutPermission = $CONFIG['cut_permission'] ? "true" : "false";
$hasCopyPermission = $CONFIG['copy_permission'] ? "true" : "false";
$hasDeletePermission = $CONFIG['delete_permission'] ? "true" : "false";
$hasRenamePermission = $CONFIG['rename_permission'] ? "true" : "false";
$hasZipPermission = $CONFIG['zip_permission'] ? "true" : "false";
$hasUnzipPermission = $CONFIG['unzip_permission'] ? "true" : "false";
$hasFileEditPermission = $CONFIG['file_edit_permission'] ? "true" : "false";
$hasImageEditPermission = $CONFIG['image_edit_permission'] ? "true" : "false";
$hasSearchPermission = $CONFIG['search_permission'] ? "true" : "false";
$hasPasteAccess = (!empty($_SESSION['files_to_copy']) || !empty($_SESSION['files_to_cut'])) ? "true" : "false";

$permission_classes = array();
$permission_classes['show_tools_without_perms'] = $CONFIG['show_tools_without_perms'];
$permission_classes['hasCutPermission'] = array($CONFIG['cut_permission'], $CONFIG['cut_permission'] ? "mceButtonNormal" : "mceButtonDisabled");
$permission_classes['hasCopyPermission'] = array($CONFIG['copy_permission'], $CONFIG['copy_permission'] ? "mceButtonNormal" : "mceButtonDisabled");
$permission_classes['hasDeletePermission'] = array($CONFIG['delete_permission'], $CONFIG['delete_permission'] ? "mceButtonNormal" : "mceButtonDisabled");
$permission_classes['hasRenamePermission'] = array($CONFIG['rename_permission'], $CONFIG['rename_permission'] ? "mceButtonNormal" : "mceButtonDisabled");
$permission_classes['hasFileEditPermission'] = array($CONFIG['file_edit_permission'], $CONFIG['file_edit_permission'] ? "mceButtonNormal" : "mceButtonDisabled");
$permission_classes['hasImageEditPermission'] = array($CONFIG['image_edit_permission'], $CONFIG['image_edit_permission'] ? "mceButtonNormal" : "mceButtonDisabled");
$permission_classes['hasFileDownloadPermission'] = array($CONFIG['file_download_permission'], $CONFIG['file_download_permission'] ? "mceButtonNormal" : "mceButtonDisabled");

require_once($globvars['local_root']."filemanager/logiclevel/paging_ll.php");
?>