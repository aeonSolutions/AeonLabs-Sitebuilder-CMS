<?php
/*
File revision date: 15-jan-2008
*/


function update_status($local_root,$update_to){
	if (is_file($local_root.'core/status.php')):
		include($local_root.'core/status.php');
		if ($status=='finished' and $status<>0):
			return;
		endif;
	endif;
	$file_content='
	<?PHP
	// WebPage wizard status
	$status="'.$update_to.'";
	?>';
	$filename=$local_root.'core/status.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);

};

function session_setup($globvars,$url){
$dim=array("&SID=","?SID=","&amp;SID=","&#63;SID=");
$text = str_replace($dim, "", $url);

if (isset($_SESSION['user'])): // user logged in SID must be present
	$sid=$_GET['SID'];
	if (strpos("-".$url,"?") or strpos("-".$url,"&#63;")):
		$url.= "&SID=".$sid;
	else:
		$url.= "?SID=".$sid;
	endif;
endif;
$lang=$globvars['language']['main'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang'];
	$lg=explode(";",$globvars['language']['available']);
	if (in_array($lang,$lg)===false):
		$lang=$globvars['language']['main'];
	endif;
endif;
if (strpos("-".$url,"?") or strpos("-".$url,"&#63;")):
	$url.= "&lang=".$lang;
else:
	$url.= "?lang=".$lang;
endif;


return $url;
};


?>