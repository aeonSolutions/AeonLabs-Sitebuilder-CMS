<?
require_once($globvars['local_root']."filemanager/logiclevel/init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Create zip</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/buttons.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/dialog.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/loading.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/zip.js"></script>
</head>

<body onload="init();">

<div id="loadingbar"><div id="subloadingbar">Loading ...</div></div>

<?
require_once($globvars['local_root']."filemanager/logiclevel/zip_ll.php");
?>
<form id="files" name="createzip" method="post" action="zip.php?path=<? echo $path."&".$url_vars;?>" onsubmit="return validateForm(this);">
<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle">Create zip</div>
				<div class="mcHeaderTitleText">Insert the name of the zip file you wish to create.</div>
			</div>

			<div class="mcHeaderRight">&nbsp;</div>
			<br style="clear: both" />
		</div>
	</div>
</div>
<div class="mcContent">
	<table border="0" cellspacing="0" cellpadding="4">
	  <tr>
		<td nowrap="nowrap">Zip will be created in:</td>

		<td><span title="/"><? echo $path.'/';?></span></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Compression Type:</td>
		<td><select name="compressiontype" id="compressiontype" class="inputText" style="width: 150px">
			<option value="zip">ZIP</option>
			<option value="gz">GZ</option>
			<option value="tar">TAR</option>
			<option value="tar.gz">TAR.GZ</option>
			<option value="tgz">TGZ</option>
		</select></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Name:</td>
		<td><input name="filename" id="filename" type="text" value="" class="inputText" size="35" maxlength="255" style="width: 150px" onchange="updateFileName(this);" /><font class="mandatoryfield">*</font></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Main Folder Name:</td>
		<td><input name="mainfoldername" id="mainfoldername" type="text" value="" class="inputText" size="35" maxlength="255" style="width: 150px" /></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Overwrite:</td>
		<td><input name="overwrite" id="overwrite" type="checkbox" value="1" class="inputText" checked /></td>
	  </tr>
	</table>

	<input type="hidden" name="path" value="<? echo $path;?>" />
	<input type="hidden" name="submitted" value="true" />

	<div id="files"></div>
</div>
<div class="mcFooter mcBorderTopBlack">
	<div class="mcBorderTopWhite">
		<div class="mcWrapper">
			<div class="mcFooterLeft"><input type="submit" id="submitBtn" name="submitBtn" value="Create" class="button" /></div>
			<div class="mcFooterRight"><input type="button" name="Cancel" value="Cancel" class="button" onclick="top.close();" /></div>

			<br style="clear: both" />
		</div>
	</div>
</div>
</form>
</body>

</html>


