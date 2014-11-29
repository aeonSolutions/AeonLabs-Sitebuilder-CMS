<?php 
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

if(isset($_POST['skin_code']) or isset($_POST['del_skin']) or isset($_POST['skin_cell']) or isset($_FILES['add_template']) or isset($_POST['add_skin_name'])):
	include($globvars['local_root'].'update_db/skin_setup.php');	
	header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;
endif;

if (isset($_GET['type'])):
	if($_GET['type']=='view'):
		include($globvars['local_root'].'siteedit/advanced/layout/view_layout_details.php');
	elseif($_GET['type']=='templates'):
		include($globvars['local_root'].'siteedit/advanced/layout/view_layouts_db.php');
	elseif($_GET['type']=='add'):
		include($globvars['local_root'].'siteedit/advanced/layout/add_layout_db.php');
	elseif($_GET['type']=='installed'):
		include($globvars['local_root'].'siteedit/advanced/layout/edit_installed.php');
	else:
		include($globvars['local_root'].'siteedit/advanced/layout/layout_options.php');
	endif;
else:
	include($globvars['local_root'].'siteedit/advanced/layout/layout_options.php');
endif;    
?>