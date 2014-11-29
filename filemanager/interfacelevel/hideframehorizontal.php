<?php
$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
include($globvars['local_root'].'copyfiles/advanced/general/db_class.php');
include($globvars['local_root'].'core/globvars.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/framesettools.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/framesettoolshorizontal.js"></script>
<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/preloadimages.js"></script>
</head>

<body class="body_horizontal" onLoad="MM_preloadImages('<?=$globvars['site_path'];?>/filemanager/interfacelevel/images/tool_frame_bottom_on.png','<?=$globvars['site_path'];?>/filemanager/interfacelevel/images/tool_frame_top_on.png');">
<?
$direction = $_GET['direction'];
if(empty($direction)) $direction = 'bottom';
?>
<div id="img_frame_id" class="tool_frame_horizontal tool_frame_<? echo $direction;?>"
 onmouseover="this.className='tool_frame_horizontal tool_frame_<? echo $direction;?>_on';" 
 onmouseout="this.className='tool_frame_horizontal tool_frame_<? echo $direction;?>';" 
 onclick="displayInternalFrame('<? echo $_GET['frame_name'];?>'); resizeFileListTable(); changeFramesetImage('img_frame_id','<? echo $_GET['frame_name'];?>','<? echo $direction;?>');">
</div>

</body>
</html>
