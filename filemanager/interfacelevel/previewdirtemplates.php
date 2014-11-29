<? 
$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
include($globvars['local_root'].'copyfiles/advanced/general/db_class.php');
include($globvars['local_root'].'core/globvars.php');
require_once($globvars['local_root']."filemanager/config/config.php");
$path = $_GET['path'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<title>Get File Content</title>
	<link href="tree/styles/reset.css" rel="stylesheet" />
	<link href="tree/styles/tree.css" rel="stylesheet" />
	<link href="tree/styles/tree-lines.css" rel="stylesheet" />
	<link href="tree/styles/dir-tree.css" rel="stylesheet" />
	<link href="css/dirlist.css" rel="stylesheet" />
	<style>
		#divrootline {
			top:25px;
			height:17px;
		}
	</style>
	
	<script language="javascript" type="text/javascript" src="jscripts/preloadimages.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/ajax.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree_creation.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree_update.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/loadConfiguration.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/functions.js"></script>
	<script language="javascript"  type="text/javascript" src="tree/scripts/tree_functions.js"></script>
	<script>
		var fileConfigURL = '../config/config_dirlist.xml';
		var fileDataURL = '../logiclevel/dirlist_ll.php?type=&folders_template=1';
		var mainTreeDivID = 'tree';
		
		var root_path = '';
		
		function goToPath(path) {
		
		}
	</script>
</head>

<body onLoad="MM_preloadImages('tree/themes/dir/windows/folder_open.gif','tree/img/plus.gif','tree/img/minus.gif');">
<? if(!empty($path)){ ?>
	<div id="divroot">
		<img src="images/minus.gif" id="minusroot"> 
		<img src="images/folder_open.gif" id="imgroot"> 
		<a id="aroot" href="#path=<? echo $CONFIG['dir_templates_path_name'];?>" onclick="goToPath('<? echo $path;?>');selectedLabelOfLi('labelroot');"> 
			<label id="labelroot"><? echo $CONFIG['dir_templates_path_name'];?></label>
		</a>
	</div>
	<div id="divrootline"></div>
	<div id="tree">
	<?
		require_once("./tree/phpcode/HtmlTree.php"); 
		$base_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
		$html_tree = new HtmlTree($base_url."/../config/config_dirlist.xml",$base_url."/../logiclevel/dirlist_ll.php?type=&id=".$path."&folders_template=1");
		$html_tree->createTreeByGetMethod();
		$html_tree->designTree();
	?>
	</div>
<? }?>
</body>

</html>