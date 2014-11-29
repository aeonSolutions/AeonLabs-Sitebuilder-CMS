<?php
function rebuild_id_file($staticvars){
$dir=glob($staticvars['local_root']."modules/congressos/webpages/*",GLOB_ONLYDIR);
if ($dir[0]<>''):
	if (is_file($staticvars['local_root'].'modules/congressos/system/id_file.php')):
		include($staticvars['local_root'].'modules/congressos/system/id_file.php');
		$k=count($file_id);
		$update=true;
		$file_content='<?PHP'.chr(13).'// Integrated Webpage File System - Installed webpages'.chr(13);
		$new_file_id=array(count($file_id));
		for ($j=0;$j<count($file_id);$j++):
			for($i=0;$i<count($dir);$i++):
				$dirX=explode("/",$dir[$i]);
				if ($dirX[count($dirX)-1]==$file_id[$j]):
					$file_content.='$file_id['.$j.']="'.$file_id[$j].'";'.chr(13);
					$new_file_id[$j]=$file_id[$j];
					break;
				else:
					$new_file_id[$j]='Xempty_file_id';
				endif;
			endfor;
		endfor;
		$file_id=$new_file_id;
	else:
		$file_content='<?PHP'.chr(13).'// Integrated Webpage File System - Installed webpages'.chr(13);
		$update=false;
		$k=0;
	endif;

	for($i=0;$i<count($dir);$i++):
		$dirX=explode("/",$dir[$i]);
		if ($update):
			if (array_search($dirX[count($dirX)-1],$file_id)===false):
				if (array_search('Xempty_file_id',$file_id)===true):
					$empty=array_search('Xempty_file_id',$file_id);
					$file_content.='$file_id['.$empty.']="'.$dirX[count($dirX)-1].'";'.chr(13);
				else:			
					$file_content.='$file_id['.$k.']="'.$dirX[count($dirX)-1].'";'.chr(13);
					$k++;		
				endif;
			endif;
		else:
				$file_content.='$file_id['.$k.']="'.$dirX[count($dirX)-1].'";'.chr(13);
				$k++;		
		endif;
	endfor;
	$file_content.='?>'.chr(13);

	$filename=$staticvars['local_root'].'modules/congressos/system/id_file.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	$handle = fopen($filename, 'a');
	fwrite($handle, $file_content);
	fclose($handle);
endif;
};
?>