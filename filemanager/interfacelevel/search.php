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
	<title>Search Files</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/css/search.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/styles/tree.css" rel="stylesheet" />
	<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/styles/tree-lines.css" rel="stylesheet" />
	<link href="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/styles/dir-tree.css" rel="stylesheet" />

	<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/preloadimages.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/ajax.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/tree.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/tree_creation.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/tree_update.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/loadConfiguration.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/functions.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/scripts/tree_functions.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/general.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/jscripts/search.js"></script>
	<script>
		var fileConfigURL = '<?=$globvars['site_path'];?>/filemanager/config/config_filelist.xml';
		var fileDataURL = '<?=$globvars['site_path'];?>/filemanager/logiclevel/dirlist_ll.php?type=';
		var mainTreeDivID = 'tree';
		
		var root_path = '';
		
		var openerWindow = parent.parent.document.getElementById('filelistmanager').contentWindow.document.getElementById('filelist').contentWindow;
	</script>
</head>
<body onload="init(1);MM_preloadImages('<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/themes/dir/windows/folder_open.gif','<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/img/plus.gif','<?=$globvars['site_path'];?>/filemanager/interfacelevel/tree/img/minus.gif');">
<?
require_once($globvars['local_root']."filemanager/logiclevel/search_ll.php");
?>
<form id="searchfiles" name="searchfiles" method="post" action="?path=<?=$_GET['path']."&".$url_vars;?>" onsubmit="return validateForm(this);">
<div class="mcContent">
	<div id="searchfilenamelabel">All or part of the name:</div>
	<div id="searchfilename"><input id="search_file_name_0" name="search_file_name_0" type="text" size="35" class="inputText" value="<? echo @$search_file_name;?>" /></div>
	<div id="searchfilewordlabel">A word of phrase in the file:</div>
	<div id="searchfileword"><input id="search_file_word_0" name="search_file_word_0" type="text" size="35" class="inputText" value="<? echo @$search_file_word;?>" /></div>
	<div id="searchfilecasesensitivelabel">Case sensitive:</div>
	<div id="searchfilecasesensitive"><input type="checkbox" id="case_sensitive_0" name="case_sensitive_0" <? echo @$case_sensitive ? "checked" : "";?> /></div>
	
	<div id="searchfilesubfolderslabel">Search subfolders:</div>
	<div id="searchfilesubfolders"><input type="checkbox" id="search_subfolders" name="search_subfolders" <? echo @$search_subfolders ? "checked" : "";?>></div>
	<div id="searchfilelocationlabel">Look in:</div>
	<div id="searchfilelocation">
		<input id="search_file_location" name="search_file_location" type="text" class="inputText" size="32" value="<? echo $search_file_location;?>" />
		<div id="searchfilelocationimg"><img src="images/toolbaritems/tool_search.gif" onClick="showAndHideCont('searchlocationbrowser');"></div>
	</div>	
	<div id="searchlocationbrowser" style="display:none; ">
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
			$html_tree = new HtmlTree($globvars['local_root']."filemanager/config/config_filelist.xml",$globvars['local_root']."filemanager/logiclevel/dirlist_ll.php");
			$html_tree->createTreeByGetMethod();
			$html_tree->designTree();
		?>
		</div>
	</div>
	<div id="searchButton"><input type="submit" name="SubmitBtn" value="Search" class="button" /></div>
	<input type="hidden" name="path" value="<? echo $path;?>" />
	<input type="hidden" name="selected_action" value="search" />
	<input type="hidden" id="search_indexes" name="search_indexes" value="" />
</div>
</form>
</body>

</html>