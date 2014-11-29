<?php 
/**
 * The frame that contains the image to be edited.
 * @author $Author: ray $
 * @version $Id: editorFrame.php 677 2007-01-19 22:24:36Z ray $
 * @package ImageManager
 */

require_once('config.inc.php');
require_once('classes/ImageManager.php');
require_once('classes/ImageEditor.php');

$manager = new ImageManager($IMConfig);
$editor = new ImageEditor($manager);
$imageInfo = $editor->processImage();

if($editor->filesaved == 1) {
	echo "<script>
	parent.document.getElementById('save_filename').value='".basename($imageInfo['saveFile'])."';
	alert('Image \"".basename($imageInfo['saveFile'])."\" successfully saved!');
	
	var isMSIE = (navigator.appName == 'Microsoft Internet Explorer');
	var openerWindow = isMSIE ? parent.window.parent : parent.window.opener;
	if(openerWindow) {
		parent.window.opener.document.getElementById('filelistForm').action.value = 'refresh';
		parent.window.opener.document.getElementById('filelistForm').submit();
	}
	</script>";
}elseif($editor->filesaved == -1)
	echo "<script>alert('ERROR: Image \"".basename($imageInfo['saveFile'])."\" not saved! \nTry Again!');</script>";

?>

<html>
<head>
	<title></title>
<script type="text/javascript">
_backend_url = "<?php print $IMConfig['backend_url']; ?>";
</script>

<link href="<?php print $IMConfig['base_url'];?>styles/editorFrame.css" rel="stylesheet" type="text/css" />	
<script type="text/javascript" src="<?php print $IMConfig['base_url'];?>scripts/wz_jsgraphics.js"></script>
<script type="text/javascript" src="<?php print $IMConfig['base_url'];?>scripts/EditorContent.js"></script>
<script type="text/javascript">
var currentImageFile = "<?php if(count($imageInfo)>0) echo rawurlencode($imageInfo['file']); ?>";
</script>
<script type="text/javascript" src="<?php print $IMConfig['base_url'];?>scripts/editorFrame.js"></script>
</head>

<body>
<div id="status"></div>
<div id="ant" class="selection" style="visibility:hidden"><img src="<?php print $IMConfig['base_url'];?>img/spacer.gif" width="0" height="0" border="0" alt="" id="cropContent"></div>
<?php if ($editor->isGDEditable() == -1) { ?>
	<div style="text-align:center; padding:10px;"><span class="error"><!--GIF format is not supported, image editing not supported.--></span></div>
<?php } ?>
<table height="100%" width="100%">
	<tr>
		<td>
<?php if(count($imageInfo) > 0 && is_file($imageInfo['fullpath'])) { ?>
	<span id="imgCanvas" class="crop"><img src="<?php echo $imageInfo['src']; ?>" <?php echo $imageInfo['dimensions']; ?> alt="" id="theImage" name="theImage"></span>
<?php } else { ?>
	<span class="error">No Image Available</span>
<?php } ?>
		</td>
	</tr>
</table>
<div id="loadingbar"><div id="subloadingbar">Loading ...</div></div>
</body>
</html>