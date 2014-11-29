<?php
function prepare_layout($file,$globvars,$staticvars){
	$dir_name=explode("/",$file);
	$file=$dir_name[1];
	$code=file_get_contents($globvars['local_root'].'tmp/layout/'.$dir_name[0].'/'.$file);
	
	//update image links
	$from_url=substr($staticvars['site_path'],7).'/layout/templates/'.$dir_name[0];
	$to_url=substr($globvars['site_path'],7).'/tmp/layout/';
	$code=str_replace($from_url,$to_url,$code);
	$code=str_replace('include("'.$staticvars['local_root'].'layout/main_code.php")','include("'.$globvars['local_root'].'layouts/main_code.php")',$code);
	// for back compatibility only
	$code=str_replace("staticvars['local_root'].'layout/main_code.php'","globvars['local_root'].'layouts/main_code.php'",$code);
	if (strpos("-".$code,"<link")):
		$ok=true;
		$init=0;
		$final=0;
		while($ok):
			// retrieve css file name
			$init=strpos($code,"<link",$final);
			if($init===false):
				$ok=false;
			else:
				$final=strpos($code,"/>",$init);
				//retrieve css filename
				$filename=substr($code,$init,$final-$init);
				$filename=explode("href",$filename);
				$filename=explode('"',$filename[1]);
				$css_file=str_replace($globvars['site_path'].'/',"",$filename[1]);
				$init=explode("/",$css_file);
				if($init[count($init)-1]<>'default.css' and $init[count($init)-2]<>'css' and $init[count($init)-3]<>'layout'):
					// update links in the css file
					$file_content=file_get_contents($globvars['local_root'].$css_file);
					$from_url=substr($staticvars['site_path'],7).'/layout/templates/'.$dir_name;
					$to_url=substr($globvars['site_path'],7).'/tmp/layout/';
					$file_content=str_replace($from_url,$to_url,$file_content);
					$filename=$globvars['local_root'].$css_file;
					if (file_exists($filename)):
						unlink($filename);
					endif;
					if (!$handle = fopen($filename, 'a')):
						echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
						exit;
					endif;
					if (fwrite($handle, $file_content) === FALSE):
						echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
						exit;
					endif;
					fclose($handle);	
				endif;		
			endif;
		endwhile;
	endif;
	$filename=$globvars['local_root'].'tmp/layout/'.$dir_name[0].'/'.$file;
	
	if (file_exists($filename)):
		unlink($filename);
	endif;
	if (!$handle = fopen($filename, 'a')):
		echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
		exit;
	endif;
	if (fwrite($handle, $code) === FALSE):
		echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
		exit;
	endif;
	fclose($handle);
	return true;	
}
?>