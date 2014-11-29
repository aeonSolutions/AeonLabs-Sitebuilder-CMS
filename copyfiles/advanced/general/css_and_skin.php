<?php
$path=explode("/",$_SERVER['SCRIPT_NAME']);
// returns the current directory oif the lmc.php not the root directory
$local=$_SERVER['DOCUMENT_ROOT'];
for ($i=1;$i<count($path)-1;$i++):
	$local=$local.'/'.$path[$i];
	if ($handle = file_exists($local.'/general/staticvars.php')):
		break;
	endif;
endfor;
include($local.'/general/staticvars.php');
if ($static_css):
	$css=$db->getquery("select ficheiro from css where active='s'");
	$skin=$db->getquery("select ficheiro from skin where active='s'");
	//$css[0][0]='normal.css';
	//$skin[0][0]='normal.php';
else:
	if (isset($_SESSION['user'])):
		$tmp=$db->getquery("select cod_css, cod_skin from users where nick='".$_SESSION['user']."'");
		$css=$db->getquery("select ficheiro from css where cod_css='".$tmp[0][0]."'");
		if ($css[0][0]==''):
			$css=$db->getquery("select ficheiro from css where active='s'");
		endif;
		$skin=$db->getquery("select ficheiro from skin where cod_skin='".$tmp[0][1]."'");
		if ($skin[0][0]==''):
			$skin=$db->getquery("select ficheiro from skin where active='s'");
		endif;
	else:
		$css=$db->getquery("select ficheiro from css where active='s'");
		if ($css[0][0]==''):
			$css[0][0]='default.css';
		endif;
		$skin=$db->getquery("select ficheiro from skin where active='s'");
		if ($skin[0][0]==''):
			$skin[0][0]='default.php';
		endif;
	endif;
endif;
echo '<link href="'.$site_path.'/layout/css/'.$css[0][0].'" rel="stylesheet" type="text/css">';
?>
</head>
<body>
<DIV id=textInLoad style="Z-INDEX: 7; LEFT: 40%; VISIBILITY: visible; WIDTH: 200px; POSITION: absolute; TOP: 40%" name="textInLoad">
<DIV style='border:1px solid black;background-color:#DEEBF2;padding:10px;position:absolute;width:100%;font-family:verdana;font-size:12px'><center><font class="body_text">A carregar a p&aacute;gina...</font><br><img src="<?=$site_path;?>/images/loading.gif"></center></div>
</DIV>
<?php
include($local.'/layout/skin/'.$skin[0][0]);
?>