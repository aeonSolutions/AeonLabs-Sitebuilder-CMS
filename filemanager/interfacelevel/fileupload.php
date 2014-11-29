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
	<title>Upload</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/fileupload.css" rel="stylesheet" type="text/css" media="all" />
	
	<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/general.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/upload.js"></script>
<?
	$out_frame_upload = true;
	require_once($globvars['local_root']."filemanager/logiclevel/upload_ll.php");
	
	echo '<script language="javascript" type="text/javascript">
		// Setup extension check
		var filesystemInvalidExtensionMSG = "Error: The extension of the file is invalid.";
		var uploadExtensions = "'.$uploadExtensions.'";
		var validateExtensionFiles = '.$validateExtensionFiles.';
		var uploadInvalidExtensionMSG = "Error: Invalid extension: Valid extensions are: '.$uploadExtensions.'.";
		var forbidenUploadExtensions = "'.$forbidenUploadExtensions.'";
		var validateForbidenExtensionFiles = '.$validateForbidenExtensionFiles.';
		var uploadInvalidForbidenExtensionMSG = "Error: You cannot upload the following the files: '.$forbidenUploadExtensions.'.";
	
		var openerWindow = parent.document.getElementById(\'filelist\').contentWindow;
	</script>';
?>
</head>
<body onload="init(1);">
<table width="100%" height="100%"><tr><td align="center">
<form id="uploadForm" name="uploadForm" method="post" action="fileupload.php?path=<? echo $path."&".$url_vars;?>" enctype="multipart/form-data" onsubmit="return validateForm(this);">
	<div class="mcContent">
		<p/>
		<table id="row_0" border="0" cellspacing="0" cellpadding="4" style="text-align:left; ">
		  <tr>
			<td nowrap="nowrap">File to upload:</td>
			<td><input name="file_0" type="file" size="23" onchange="updateFileNameComplex(0, this);" value="" class="inputText" /></td>
			<td></td>
		  </tr>
		  <tr>
			<td nowrap="nowrap">As file name:</td>
			<td colspan="2"><input id="filename_0" name="filename_0" type="text" class="inputText" size="35" maxlength="255" style="width: 200px" value="" /></td>
		  </tr>
		  <tr>
			<td nowrap="nowrap">Overwrite if exists:</td>
			<td colspan="2"><input id="overwrite_0" name="overwrite_0" type="checkbox" class="inputText" value="1" title="Click on the checkbox to overwrite file." /></td>
		  </tr>
		</table>
		<div id="addPosition"></div>
		<input type="hidden" name="path" value="<? echo $path;?>" />
		<input type="hidden" name="file_indexes" value="" />
	</div>
	<div class="mcFooter mcBorderTopBlack">
		<div class="mcBorderTopWhite">
			<div class="mcWrapper">
				<div class="mcFooterLeft"><input type="submit" name="SubmitBtn" value="Upload" class="button" /></div>
				<div class="mcFooterRight"><input type="button" name="addupload" value="Add upload" class="button" onclick="addRow('addPosition', false);" /></div>
			</div>
		</div>
	</div>
</form>
</td></tr></table>
</body>

</html>
