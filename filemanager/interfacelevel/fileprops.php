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
<title>File/Directory properties</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/buttons.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/dialog.css" rel="stylesheet" type="text/css" media="all" />

<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/fileprops.js"></script>
</head>

<body onload="init();">
<?
require_once($globvars['local_root']."filemanager/logiclevel/fileprops_ll.php");

$disabled = $CONFIG['chmod_available'] ? "" : "disabled";
?>
<form name="fileprops" method="post" action="fileprops.php?path=<? echo $_GET['path']."&".$url_vars;?>" onsubmit="return validateForm(this);">
<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle">File/Directory properties</div>
				<div class="mcHeaderTitleText">Properties of the file/directory</div>
			</div>

			<div class="mcHeaderRight">&nbsp;</div>
			<br style="clear: both" />
		</div>
	</div>
</div>
<div class="mcContent">
	<table border="0" cellspacing="0" cellpadding="4">
	  <tr>
		<td nowrap="nowrap">Current Path:</td>
		<td><span title="/"><? echo dirname($path);?>/</span></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Name:</td>
		<td><input name="filename" id="filename" type="text" value="<? echo $filename;?>" class="inputText" size="20" maxlength="255" style="width: 140px" onchange="updateFileName(this);" /><font class="mandatoryfield">*</font></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Permissions:</td>
		<td><input id="perms_code" name="perms_code" type="text" value="<? echo $perms_code;?>" class="inputText" readonly="yes" size="20" style="width: 140px;"></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap" colspan="2" align="left">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td nowrap="nowrap" width="65px"></td>
					<td nowrap="nowrap" align="center" width="50px">Read</td>
					<td nowrap="nowrap" align="center" width="50px">Write</td>
					<td nowrap="nowrap" align="center" width="50px">Execute</td>
				</tr>
				<tr>
					<td nowrap="nowrap" align="right">&nbsp; &nbsp;Owner</td> 
					<td align="center"><input name="owner_read" id="owner_read" type="checkbox" value="1" class="inputText" <? if($owner_read)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('owner','read');" /></td>
					<td align="center"><input name="owner_write" id="owner_write" type="checkbox" value="1" class="inputText" <? if($owner_write)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('owner','write');" /></td>
					<td align="center"><input name="owner_execute" id="owner_execute" type="checkbox" value="1" class="inputText" <? if($owner_execute)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('owner','execute');" /></td>
				</tr>
				<tr>
					<td nowrap="nowrap" align="right">&nbsp; &nbsp;Group</td> 
					<td align="center"><input name="group_read" id="group_read" type="checkbox" value="1" class="inputText" <? if($group_read)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('group','read');" /></td>
					<td align="center"><input name="group_write" id="group_write" type="checkbox" value="1" class="inputText" <? if($group_write)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('group','write');" /></td>
					<td align="center"><input name="group_execute" id="group_execute" type="checkbox" value="1" class="inputText" <? if($group_execute)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('group','execute');" /></td>
				</tr>
				<tr>
					<td nowrap="nowrap" align="right">&nbsp; &nbsp;World</td> 
					<td align="center"><input name="world_read" id="world_read" type="checkbox" value="1" class="inputText" <? if($world_read)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('world','read');" /></td>
					<td align="center"><input name="world_write" id="world_write" type="checkbox" value="1" class="inputText" <? if($world_write)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('world','write');" /></td>
					<td align="center"><input name="world_execute" id="world_execute" type="checkbox" value="1" class="inputText" <? if($world_execute)echo 'checked';?> <? echo $disabled;?> onClick="updatePermsCode('world','execute');" /></td>
				</tr>
			</table>
		</td>
	  </tr>
	</table>

	<input type="hidden" name="path" value="<? echo $path;?>" />
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



