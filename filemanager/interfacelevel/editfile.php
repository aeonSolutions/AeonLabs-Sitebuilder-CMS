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
<title>File Editor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/buttons.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/dialog.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/editfile.css" rel="stylesheet" type="text/css" media="all" />
<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
</head>

<body>
<?
require_once($globvars['local_root']."filemanager/logiclevel/editfile_ll.php");
?>
<form name="fileeditor" method="post" action="<?='editfile.php?path='.$_GET['path']."&".$url_vars;?>">
<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle">File Editor</div>
				<div class="mcHeaderTitleText">Content of the file</div>
			</div>

			<div class="mcHeaderRight">&nbsp;</div>
			<br style="clear: both" />
		</div>
	</div>
</div>
<div class="mcContent">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	  <tr>
		<td width="80">File:</td>
		<td nowrap="nowrap" class="mcHeaderText">
			<? echo dirname($path)."/";
			if($CONFIG['rename_permission'])
				echo '<input type="text" name="newname" id="newname" class="inputText" value="'.basename($path).'" size="70"><font class="mandatoryfield">*</font>';
			else echo basename($path);
			?>
		</td>
	  </tr>
	  <tr>
		<td colspan="2">File Contents:</td>
	  </tr>
	  <tr>
		<td nowrap="nowrap" colspan="2" align="center">
			<textarea name="filecontents" id="filecontents" rows="20" cols="76" class="inputText"><? echo $filecontents;?></textarea>
		</td>
	  </tr>
	</table>
	<input type="hidden" name="path" value="<? echo basename($path);?>" />
	<input type="hidden" name="selected_action" value="editfile" />
	<input type="hidden" name="submitted" value="true" />
</div>
<div class="mcFooter mcBorderTopBlack">
	<div class="mcBorderTopWhite">
		<div class="mcWrapper">
			<div class="mcFooterLeft"><input type="submit" name="Submit" value="Save" class="button" /></div>
			<div class="mcFooterRight"><input type="button" name="Cancel" value="Cancel" class="button" onclick="top.close();" /></div>
			<br style="clear: both" />
		</div>
	</div>

</div>
</form>
</body>

</html>



