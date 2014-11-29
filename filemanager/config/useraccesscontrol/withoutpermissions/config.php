<?
	$CONFIG['root_path'] = 'NULL';//This variable corresponds to the user files main directory, that will be showed by the filemanager application. Each action will be related with the subfiles of this folder. This path is relative to the "interfacelevel/" directory.
	
	$CONFIG['filemanager_homepage'] = 'http://www.jplpinto.com/apis/filemanager/';
	$CONFIG['php_log_path'] = '';
	$CONFIG['server_log_path'] = '';
	
	/**************** FILE PERMISSIONS **********************/
	$CONFIG['read_permission'] = false;
	$CONFIG['create_folder_permission'] = false;
	$CONFIG['create_doc_permission'] = false;
	$CONFIG['upload_permission'] = false;
	$CONFIG['cut_permission'] = false;
	$CONFIG['copy_permission'] = false;
	$CONFIG['delete_permission'] = false;
	$CONFIG['rename_permission'] = false;
	$CONFIG['chmod_available'] = false;
	
	$CONFIG['zip_permission'] = false;
	$CONFIG['unzip_permission'] = false;
	
	$CONFIG['file_edit_permission'] = false;
	$CONFIG['image_edit_permission'] = false;
	$CONFIG['search_permission'] = false;
	$CONFIG['file_download_permission'] = false;
	/********************************************************/
	
	
	/**************** FILE PERMISSION MESSAGES **********************/
	$CONFIG['read_permission_denied_message'] = 'Sorry You don\'t have Read Permission!';
	$CONFIG['create_folder_permission_denied_message'] = 'Sorry You don\'t permission to create folders!';
	$CONFIG['create_doc_permission_denied_message'] = 'Sorry You don\'t permission to create documents!';
	$CONFIG['upload_permission_denied_message'] = 'Sorry You don\'t permission to upload files!';
	$CONFIG['cut_permission_denied_message'] = 'Sorry You don\'t permission to cut and paste files!';
	$CONFIG['copy_permission_denied_message'] = 'Sorry You don\'t permission to copy and paste files!';
	$CONFIG['paste_permission_denied_message'] = 'Sorry You don\'t permission to paste files!';
	$CONFIG['delete_permission_denied_message'] = 'Sorry You don\'t permission to delete files!';
	$CONFIG['rename_permission_denied_message'] = 'Sorry You don\'t permission to rename files!';
	
	$CONFIG['zip_permission_denied_message'] = 'Sorry You don\'t permission to create archieves!';
	$CONFIG['unzip_permission_denied_message'] = 'Sorry You don\'t permission to extract archieves!';
	
	$CONFIG['file_edit_permission_denied_message'] = 'Sorry You don\'t permission to edit files!';
	$CONFIG['search_permission_denied_message'] = 'Sorry You don\'t permission to search files!';
	/********************************************************/
	
	$CONFIG['show_tools_without_perms'] = false;
?>