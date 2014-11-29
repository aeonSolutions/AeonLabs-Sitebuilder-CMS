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
	<title>Create directory</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/buttons.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/dialog.css" rel="stylesheet" type="text/css" media="all" />
	
	<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
	<script language="javascript" type="text/javascript" src="jscripts/createdir.js"></script>
</head>
<body onload="init();">
<?
require_once($globvars['local_root']."filemanager/logiclevel/createdir_ll.php");
?>
<form name="createdir" method="post" action="createdir.php?path=<?=$_GET['path']."&".$url_vars;?>" onsubmit="return verifyForm();">

<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle">Create directory</div>
				<div class="mcHeaderTitleText">Insert a name for the directory you wish to create.</div>
			</div>
			<div class="mcHeaderRight">&nbsp;</div>

			<br style="clear: both" />
		</div>
	</div>
</div>
<div class="mcContent">
	<table border="0" cellspacing="0" cellpadding="4" width="100">
		<tr>
			<td valign="top">
				<table border="0" cellspacing="0" cellpadding="4" width="100%">
				  <tr>
					<td nowrap="nowrap">Template:</td>
					<td>
			
					<select name="template" style="width: 190px" onchange="preview(this.options[this.selectedIndex].value);">
						<option value="" selected>-- Select template --</option>
						  <? for($i = 0; $i < count($templates); ++$i) {
								echo "<option value=\"".$templates[$i][3]."/".$templates[$i][0]."\" >".$templates[$i][0]."</option>";
						  } ?>
					</select></td>
				  </tr>
				  <tr>
			
					<td nowrap="nowrap">Directory name:</td>
					<td nowrap="nowrap"><input id="dirname" name="dirname" type="text" class="inputText" maxlength="100" style="width: 190px" value="" /><font class="mandatoryfield">*</font></td>
				  </tr>
				  <tr>
					<td nowrap="nowrap">Create in:</td>
					<td><span title="/"><? echo $path.'/';?></span></td>
				  </tr>
				</table>
			</td>

			<td rowspan="2" valign="right">
				<iframe id="previewNewDirIframe" name="previewNewDirIframe" unselectable="true" atomicselection="true" width="200" height="200" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" frameborder="0" border="0" style="margin-top: 4px; margin-left: 8px; border: 1px solid gray; background-color: white"></iframe>
			</td>
		</tr>
	</table>
	<input type="hidden" name="path" value="<? echo $path;?>" />
	<input type="hidden" name="selected_action" value="createdir" />
</div>
<div class="mcFooter mcBorderTopBlack">
	<div class="mcBorderTopWhite">
		<div class="mcWrapper">
			<div class="mcFooterLeft"><input type="submit" name="Submit" value="Create" class="button" /></div>
			<div class="mcFooterRight"><input type="button" name="Cancel" value="Cancel" class="button" onclick="top.close();" /></div>
			<br style="clear: both" />

		</div>
	</div>
</div>
</form>
</body>

</html>

