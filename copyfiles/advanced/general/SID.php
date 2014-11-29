<?php
function session($url){
$path=explode("/",__FILE__);
$local=$path[0];
for ($i=1;$i<count($path)-1;$i++):
	$local=$local.'/'.$path[$i];
endfor;
$local=$local.'/';
include($local.'staticvars.php');
$dim=array("&SID=","?SID=");
$text = str_replace($dim, "", $url);

if (isset($_SESSION['user'])): // user logged in SID must be present
	$sid=$_GET['SID'];
	if (strpos("-".$url,"?")):
		$url.= "&SID=".$sid;
	else:
		$url.= "?SID=".$sid;
	endif;
endif;
if (isset($_GET['lang'])):
	$lang=$_GET['lang'];
	if ($lang==''):
		$lang=$main_language;
	endif;
else:
	$lang=$main_language;
endif;
	if (strpos("-".$url,"?")):
		$url.= "&lang=".$lang;
	else:
		$url.= "?lang=".$lang;
	endif;

return $url;
};
?>