<?
$files_to_copy = explode("|",@$_SESSION['files_to_copy']);
if(count($files_to_copy) == 0 || (count($files_to_copy) == 1 && empty($files_to_copy[0])) )
	$files_to_copy = explode("|",@$_SESSION['files_to_cut']);
?>