<?php
function initialize_download($staticvars,$filename,$type){
// Type: link;header
include($staticvars['local_root'].'kernel/staticvars.php');
$tmp=explode("/",$filename);
$copy_from = $staticvars['upload']."/".$filename;
$copy_to = $staticvars['temp'].'/'.$tmp[count($tmp)-1];
$files = glob($staticvars['temp']."/*.*");
for($i = 0; $i < count($files); $i++):
	if (check_date($files[$i])==false): //1 day old
		unlink($files[$i]);
	endif;
endfor;
$copy_from=str_replace("\\/","/",$copy_from);
$copy_to=str_replace("\\/","/",$copy_to);
if (!copy($copy_from, $copy_to)):
	return '<h2>No file found!</h2>';
else:
	if($type=='link'):
		return '<a href="'.$staticvars['site_path'].'/tmp/'.$tmp[count($tmp)-1].'">'.$tmp[count($tmp)-1].'</a>';
	else:
		header("location: ".$staticvars['site_path'].'/tmp/'.$tmp[count($tmp)-1]);
	endif;
endif;
};

function check_date($filename){
$current_date=explode(":",date("m:d:Y:H:i:s."));
$file_date=date ("m:d:Y:H:i:s.", filemtime($filename));
$file_date=explode(":",$file_date);
if ($file_date[1]<$current_date[1] and $file_date[0]==$current_date[0]): // check day
	return false;
elseif ($file_date[0]<$current_date[0]): // check month
	return false;
elseif ($file_date[2]<$current_date[2]): // check year
	return false;
else:
	return true;
endif;
};
?>
