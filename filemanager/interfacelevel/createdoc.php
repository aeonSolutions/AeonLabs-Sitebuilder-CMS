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
<title>Create document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/buttons.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/dialog.css" rel="stylesheet" type="text/css" media="all" />

<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/createdoc.js"></script>
</head>

<body onload="init();">
<?
require_once($globvars['local_root']."filemanager/logiclevel/createdoc_ll.php");
?>
<form id="createdoc" name="createdoc" method="post" action="createdoc.php?path=<?=$_GET['path']."&".$url_vars;?>" onsubmit="return validateForm(this);">
<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle">Create document</div>
				<div class="mcHeaderTitleText">Fill in the form to create a new document from a template.</div>
			</div>

			<div class="mcHeaderRight">&nbsp;</div>
			<br style="clear: both" />
		</div>
	</div>
</div>
<div class="mcContent">
	<table border="0" cellspacing="4" cellpadding="0" width="100%">
		<tr>
			<td valign="top">
				<table border="0" cellspacing="0" cellpadding="4" width="100%">
				  <tr>
					<td>Template: </td>
					<td>
						<select name="template" style="width: 200px" onchange="preview(this.options[this.selectedIndex].value);">
						  <option value="" selected>-- Select template --</option>
						  <? for($i = 0; $i < count($templates); ++$i) {
						  		echo "<option value=\"".$templates[$i][3]."/".$templates[$i][0]."\" >".$templates[$i][0]."</option>";
						  } ?>
						</select>
					</td>
				  </tr>
				  <tr>
					<td nowrap="nowrap">Filename:&nbsp;&nbsp;</td>
					<td><input name="docname" type="text" class="inputText" id="docname" maxlength="100" style="width: 200px" value="" /><font class="mandatoryfield">*</font></td>
				  </tr>
				  <tr>
					<td>Create in:</td>
					<td><span title="/"><? echo $path;?>/</span></td>
				  </tr>
				</table>
			</td>

			<td rowspan="2" valign="right">
				<iframe id="previewNewDocIframe" name="previewNewDocIframe" unselectable="true" atomicselection="true" width="200" height="200" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" frameborder="0" border="0" style="margin-top: 4px; margin-left: 8px; border: 1px solid gray; background-color: white"></iframe>
			</td>
		</tr>
	</table>
	<input type="hidden" name="path" value="<? echo $path;?>" />
	<input type="hidden" name="selected_action" value="createdoc" />	
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