<?
require_once("../logiclevel/sessionstart.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FileManager</title>

<? 
$file_text_field_id = $_GET['file_text_field_id'];
$filemanager_prefix_http_protocol = $_GET['filemanager_prefix_http_protocol'];
$filemanager_prefix_path = $_GET['filemanager_prefix_path'];
$strrpos_index = strrpos($filemanager_prefix_path,"/");
if($filemanager_prefix_path && is_numeric($strrpos_index) && $strrpos_index == strlen($filemanager_prefix_path)-1)
	$filemanager_prefix_path = substr($filemanager_prefix_path,0,strlen($filemanager_prefix_path)-1);

echo '
<script language="javascript" type="text/javascript">
var path = "readfile.php?path=";
var fileManagerPrefixPath = "'.$filemanager_prefix_path.'";
var fileManagerPrefixHttpProtocol = "'.$filemanager_prefix_http_protocol.'";
';

if($file_text_field_id != "")
	echo 'var fieldFileObj = parent && parent.document && parent.document.getElementById("'.$file_text_field_id.'") ? parent.document.getElementById("'.$file_text_field_id.'") : null;';
else echo " var fieldFileObj = null;
		if(window.opener && window.opener.tinyMCE) {
			var win = window.opener.tinyMCE.getWindowArg('win');
			var field_name = window.opener.tinyMCE.getWindowArg('field_name');
			if(win && field_name)
				fieldFileObj = win.document.getElementById(field_name);
		}";


echo 'function insertURL(url) {
	if(fieldFileObj)
		fieldFileObj.value = fileManagerPrefixHttpProtocol+fileManagerPrefixPath+"/filemanager/src/interfacelevel/"+path+url;
}
</script>';
?>
</head>
<frameset id="filemanager_frameset" rows="*" cols="200,*,300" framespacing="0px" subframesnames="dirlist,filelistmanager,preview">
	<frame id="dirlist" name="dirlist" src="dirlist.php?<? echo $_SERVER['QUERY_STRING'];?>&PHPSESSID=<? echo $_GET['PHPSESSID'];?>" frameborder="1px" scrolling="auto" marginwidth="0" marginheight="0" framecols="200" />
	<frame id="filelistmanager" name="filelistmanager" src="filelistmanager.php?<? echo $_SERVER['QUERY_STRING'];?>&PHPSESSID=<? echo $_GET['PHPSESSID'];?>" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" framecols="*" />
	<frame id="preview" name="preview" src="preview.php?<? echo $_SERVER['QUERY_STRING'];?>&PHPSESSID=<? echo $_GET['PHPSESSID'];?>" frameborder="1px" scrolling="auto" marginwidth="0" marginheight="0" framecols="300" />
</frameset>

<noframes><body></body></noframes>

</html>
