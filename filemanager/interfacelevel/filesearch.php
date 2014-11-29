<?
require_once($globvars['local_root']."filemanager/logiclevel/init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Search Files</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/buttons.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/dialog.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/filesearch.css" rel="stylesheet" type="text/css" media="all" />
	<link href="tree/styles/tree.css" rel="stylesheet" />
	<link href="tree/styles/tree-lines.css" rel="stylesheet" />
	<link href="tree/styles/dir-tree.css" rel="stylesheet" />

	<script language="javascript" type="text/javascript" src="jscripts/preloadimages.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/ajax.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree_creation.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree_update.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/loadConfiguration.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/functions.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree_functions.js"></script>
	<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
	<script language="javascript" type="text/javascript" src="jscripts/search.js"></script>
	<script>
		var fileConfigURL = '../config/config_filelist.xml';
		var fileDataURL = '../logiclevel/dirlist_ll.php?type=';
		var mainTreeDivID = 'tree';
		
		var root_path = '';
	</script>
</head>
<body onload="init(1);MM_preloadImages('images/toolbaritems/tool_del.gif','tree/themes/dir/windows/folder_open.gif','tree/img/plus.gif','tree/img/minus.gif');">
<?
require_once($globvars['local_root']."filemanager/logiclevel/search_ll.php");
?>
<form id="searchfiles" name="searchfiles" method="post" action="?path=<? echo $path."&".$url_vars;?>" onsubmit="return validateForm(this);">
<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle">Search</div>
				<div class="mcHeaderTitleText">Use the form to search files.</div>
			</div>

			<div class="mcHeaderRight">&nbsp;</div>
			<br style="clear: both" />
		</div>
	</div>
</div>

<div class="mcContent">
	
	<table id="row_0" border="0" cellspacing="0" cellpadding="2">
	  <tr>
		<td nowrap="nowrap" width="135px">Search on subfolders:</td>
		<td><input type="checkbox" id="search_subfolders" name="search_subfolders" class="inputText" <? echo $search_subfolders ? "checked" : "";?>></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Look in:</td>
		<td><div id="searchfilelocation">
			<input id="search_file_location" name="search_file_location" type="text" class="inputText" size="60" value="<? echo $search_file_location;?>" />
			<div id="searchfilelocationimg"><img src="images/toolbaritems/tool_search.gif" onClick="showAndHideCont('searchlocationbrowser');"></div>
		</div></td>
	  </tr>
	</table>

	<div id="searchlocationbrowser">
		<div id="divroot">
			<img src="images/minus.gif" id="minusroot"> 
			<img src="images/folder_open.gif" id="imgroot"> 
			<a id="aroot" href="#path=<? echo $CONFIG['root_path_name'];?>" onclick="updateFileSearchLocation('');selectedLabelOfLi('labelroot');"> 
				<label id="labelroot"><? echo $CONFIG['root_path_name'];?></label>
			</a>
		</div>
		<div id="tree">
		<?
			require_once("./tree/phpcode/HtmlTree.php"); 
			$base_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
			$html_tree = new HtmlTree($base_url."/../config/config_filelist.xml",$base_url."/../logiclevel/dirlist_ll.php?type=");
			$html_tree->createTreeByGetMethod();
			$html_tree->designTree();
		?>
		</div>
	</div>
	
	<hr/>
	
	<table id="row_0" border="0" cellspacing="0" cellpadding="2">
	  <tr>
		<td nowrap="nowrap">All or part of the name:</td>
		<td><input id="search_file_name_0" name="search_file_name_0" type="text" size="60" class="inputText" value="<? echo $search_file_name;?>" /></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">A word of phrase in the file:</td>
		<td><input id="search_file_word_0" name="search_file_word_0" type="text" size="60" class="inputText" value="<? echo $search_file_word;?>" /></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Case sensitive:</td>
		<td><input id="case_sensitive_0" name="case_sensitive_0" type="checkbox" class="inputText" <? echo $case_sensitive ? "checked" : "";?> /></td>
	  </tr>
	</table>
	
	<div id="addPosition"></div>
	
	<input type="hidden" name="path" value="<? echo $path;?>" />
	<input type="hidden" name="selected_action" value="search" />
	<input type="hidden" id="search_indexes" name="search_indexes" value="" />
</div>
<div class="mcFooter mcBorderTopBlack">
	<div class="mcBorderTopWhite">
		<div class="mcWrapper">
			<div class="mcFooterLeft"><input type="submit" name="SubmitBtn" value="Search" class="button" />&nbsp;&nbsp;
			<input type="button" name="addupload" value="Add Search" class="button" onclick="addRow('addPosition', false);" /></div>
			<div class="mcFooterRight"><input type="button" name="Cancel" value="Cancel" class="button" onclick="top.close();" /></div>

			<br style="clear: both" />
		</div>
	</div>
</div>
</form>
</body>

</html>