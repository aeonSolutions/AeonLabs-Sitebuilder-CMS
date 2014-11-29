<?
$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
include($globvars['local_root'].'copyfiles/advanced/general/db_class.php');
include($globvars['local_root'].'core/globvars.php');
require_once($globvars['local_root']."filemanager/logiclevel/init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Browser</title>
<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/thumbnails.css" rel="stylesheet" media="screen" type="text/css" />
<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/toolbar.css" rel="stylesheet" type="text/css" />
<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/loading.css" rel="stylesheet" type="text/css" />
<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/buttons.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/paginglist.css" rel="stylesheet" type="text/css" />
<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/filetypes.css" rel="stylesheet" type="text/css" />
<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/ajax.js"></script>
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/preloadimages.js"></script>
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/generallist.js"></script>
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/general.js"></script>
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/thumbnails.js"></script>
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/paginglist.js"></script>
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/toolbar.js"></script>
<script>
	var path = "<? echo $path; ?>";
	var urlVars = "<? echo $url_vars; ?>";
</script>
<? 
require_once($globvars['local_root']."filemanager/logiclevel/filelist_ll.php");
require_once($globvars['local_root']."filemanager/interfacelevel/FileInterface.php");

$php_file_name = "thumbnails.php";

echo '<script language="javascript" type="text/javascript">
	var disabledTools = "";
	
	var hasCreateFolderPermission = '.$hasCreateFolderPermission.';
	var hasCreateDocPermission = '.$hasCreateDocPermission.';
	var hasUploadPermission = '.$hasUploadPermission.';
	var hasCutPermission = '.$hasCutPermission.';
	var hasCopyPermission = '.$hasCopyPermission.';
	var hasDeletePermission = '.$hasDeletePermission.';
	var hasRenamePermission = '.$hasRenamePermission.';
	var hasZipPermission = '.$hasZipPermission.';
	var hasUnzipPermission = '.$hasUnzipPermission.';
	var hasFileEditPermission = '.$hasFileEditPermission.';
	var hasImageEditPermission = '.$hasImageEditPermission.';
	var hasSearchPermission = '.$hasSearchPermission.';
	var hasPasteAccess = '.$hasPasteAccess.';

	urlVars += "&'.@$search_url_vars.'";
</script>';
?>
</head>

<body onload="init('<?=@$is_search;?>');MM_preloadImages('<?=$globvars['site_path'];?>/filemanager/interfacelevel/images/toolbaritems/selectedtoolbaritems/toggleall.gif','images/toolbaritems/selectedtoolbaritems/rename.gif','images/toolbaritems/selectedtoolbaritems/copy.gif','images/toolbaritems/selectedtoolbaritems/cut.gif','images/toolbaritems/selectedtoolbaritems/edit.gif','images/toolbaritems/selectedtoolbaritems/filemanager.gif','images/toolbaritems/selectedtoolbaritems/paste.gif','images/toolbaritems/selectedtoolbaritems/props.gif','images/toolbaritems/selectedtoolbaritems/refresh.gif','images/toolbaritems/selectedtoolbaritems/trash.gif','images/toolbaritems/selectedtoolbaritems/unzip.gif','images/toolbaritems/selectedtoolbaritems/upload.gif','images/toolbaritems/selectedtoolbaritems/delete.gif','images/toolbaritems/selectedtoolbaritems/zip.gif','images/toolbaritems/selectedtoolbaritems/createdir.gif','images/toolbaritems/selectedtoolbaritems/createdoc.gif','images/toolbaritems/selectedtoolbaritems/search.gif','images/toolbaritems/selectedtoolbaritems/preview.gif','images/toolbaritems/selectedtoolbaritems/help.gif','images/toolbaritems/selectedtoolbaritems/info.gif','images/toolbaritems/selectedtoolbaritems/upfolder.gif','images/toolbaritems/selectedtoolbaritems/zoom_out.gif','images/toolbaritems/selectedtoolbaritems/zoom_in.gif','images/toolbaritems/selectedtoolbaritems/download.gif','images/im.gif');"> 

<div class="imageinfo" id="imginfo"> 
  <div style="margin: 5px;"> 
    <div id="loadinfo">Loading info...</div> 
    <div id="infowrap" class="infowrap"> 
      <div>Width:</div> 
      <div id="img_width">&nbsp;</div> 
      <div>Height:</div> 
      <div id="img_height">&nbsp;</div> 
      <div>Type:</div> 
      <div id="img_type">&nbsp;</div> 
      <div>Size:</div> 
      <div id="img_size">&nbsp;</div> 
      <div>Scale:</div> 
      <div id="img_scale">&nbsp;</div> 
      <br style="clear: both;" /> 
    </div> 
  </div> 
</div> 

<div class="imageinfo" id="fileinfo"> 
  <div style="margin: 5px;"> 
    <div id="fileloadinfo">Loading info...</div> 
    <div id="fileinfowrap" class="infowrap"> 
      <div>Type:</div> 
      <div id="file_type">&nbsp;</div> 
      <div>Size:</div> 
      <div id="file_size">&nbsp;</div> 
      <br style="clear: both;" /> 
    </div> 
  </div> 
</div> 

<? 
include("./toolbar.php");
?>

<div id="thwrapperdiv" class="thwrapper"> 
  <div class="thwrapperwrapper"> 
  <form id="filelistForm" name="filelistForm" method="post" action="thumbnails.php?<? echo $_SERVER['QUERY_STRING'];?>"> 
<?
	for($i = $begin_index; $i < $end_index; ++$i)
		echo FileInterface::getHtmlFileThumbnails($root_path,$i,$files[$i],$url_vars,$permission_classes);
?>
		<input type="hidden" name="num_of_items" value="<? echo count($files);?>" /> 
		<input type="hidden" name="selected_action" value="" /> 
		<input type="hidden" name="path" value="<? echo $path;?>" /> 
	</form>
  </div> 
</div> 

<? 
include("./paginglist.php");
?>

</body>
</html>