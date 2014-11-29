<?
require_once($globvars['local_root']."filemanager/logiclevel/init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Preview Image</title>
<link href="css/previewimage.css" rel="stylesheet" type="text/css" />
<link href="css/loading.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="jscripts/preloadimages.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/previewimage.js"></script>
<?
require_once($globvars['local_root']."filemanager/logiclevel/previewimage_ll.php");

echo '<script language="javascript" type="text/javascript">

	var root_path = "'.$root_path.'";

	var images_path = Array('.$images_path.');
	var images_size = Array('.$images_size.');
	var images_width = Array('.$images_width.');
	var images_height = Array('.$images_height.');

	var current_index = '.$selected_index.';
	var images_length = '.$counter.';
	
	var zoom_size = 0.20;
	
	var imageEditAccess = "'.$CONFIG['image_edit_permission'].'";
</script>';
?>
</head>
<body onLoad="init();MM_preloadImages('images/toolbaritems/bot.on.gif');" onkeypress="checkKey(event);" onkeydown="checkKey(event);">
	<div class="toolbar">
		<div class="toolbar_left">
			<div id="first_image_row" onClick="javascript:previewfirstimage();" title="Keyboard shortcut: PAGE UP"><img src="images/toolbaritems/first.gif" width="20" height="20" alt="First image" title="First image" border="0" /></div>
			<div id="previous_image_row" onClick="javascript:previewpreviousimage();" title="Keyboard shortcut: P,LEFTARROW"><img src="images/toolbaritems/previous.gif" width="20" height="20" alt="Previous image" title="Previous image" border="0" /></div>
			<div id="next_image_row" onClick="javascript:previewnextimage();" title="Keyboard shortcut: N,RIGHTARROW"><img src="images/toolbaritems/next.gif" width="20" height="20" alt="Next image" title="Next image" border="0" /></div>
			<div id="last_image_row" onClick="javascript:previewlastimage();" title="Keyboard shortcut: PAGE DOWN"><img src="images/toolbaritems/last.gif" width="20" height="20" alt="Last image" title="Last image" border="0" /></div>
		</div>
		<div class="toolbar_right">
			<img src="images/toolbaritems/separator.gif" width="1" height="20" class="mceSeparatorLine" />
			<div id="less_zoom" onClick="javascript:zoomMinus();"><img src="images/toolbaritems/zoom_out.gif" width="20" height="20" alt="Less zoom" title="Less zoom" border="0"/></div> 
			<div id="plus_zoom" onClick="javascript:zoomPlus();"><img src="images/toolbaritems/zoom_in.gif" width="20" height="20" alt="Plus zoom" title="Plus zoom" border="0" /></div> 
			<? 
			if($CONFIG['show_tools_without_perms'] || $CONFIG['image_edit_permission']) {
				$onclick = $CONFIG['image_edit_permission'] ? 'onClick="javascript:imageEditor();"' : "";
				echo '<div id="image_editor" '.$onclick.'><img src="images/toolbaritems/image_edit.gif" width="20" height="20" alt="Edit image" title="Edit image" border="0" /></div>';
			}
			?>
		</div>
	</div>
	<div id="imagecontainer" class="preview_container">
		<div id="imagesubcontainer" class="preview_image">
			<img id="imgObject" src="readfile.php?path=<? echo $selected_image_path;?>" alt="<? echo $selected_image_path;?>" title="<? echo $selected_image_name;?>" onerror="imageError();" image_width="<? echo $selected_image_width;?>" image_height="<? echo $selected_image_height;?>"  />
		</div>
	</div>

	<div id="loadingbar"><div id="subloadingbar">Loading ...</div></div>

</body>

</html>
