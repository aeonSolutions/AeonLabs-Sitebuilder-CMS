<?php
function build_page($globvars,$file){
	include($globvars['local_root'].'copyfiles/advanced/general/recursive_copy.php');
	delr($globvars,$globvars['local_root'].'tmp');
	@mkdir($globvars['local_root'].'tmp', 0755, true);

	include_once($globvars['local_root'].'copyfiles/advanced/general/pass_generator.php');
	$css_file_name=generate('5','No','Yes','No').'.css';
	$code=file_get_contents($globvars['local_root']."layouts/templates/".$file);
	$filename=explode("/",$file);
	$dir_name=$filename[0];
	$file2=$filename[1];	
	//update image links
	$code=str_replace('src="','src="'.$globvars['site_path'].'/layouts/templates/'.$dir_name.'/',$code);
	$code=str_replace("src='","src='".$globvars['site_path'].'/layouts/templates/'.$dir_name.'/',$code);
	// update background links
	$code=str_replace('background="','background="'.$globvars['site_path'].'/layouts/templates/'.$dir_name.'/',$code);
	$code=str_replace("background='","background='".$globvars['site_path'].'/layouts/templates/'.$dir_name.'/',$code);

	$code=str_replace("url('","url('".$globvars['site_path']."/layouts/templates/".$dir_name.'/',$code);
	$code=str_replace("url(","url(".$globvars['site_path']."/layouts/templates/".$dir_name.'/',$code);
	$code=str_replace('url("','url("'.$globvars['site_path']."/layouts/templates/".$dir_name.'/',$code);
	// update external stylesheet file - only one allowed
	if (strpos("-".$code,"<link")):
		$dirname=$filename[0];
		$init=strpos($code,"<link");
		$final=strpos($code,"/>",$init);
		$filename=substr($code,$init,$final-$init);
		$filename=explode("href",$filename);
		$filename=explode('"',$filename[1]);
		$img_dir=explode("/",$filename[1]);
		$img_dir=$img_dir[0];
		$file=$dir_name.'/'.$filename[1];
		$code = substr_replace($code,'<link rel="stylesheet" type="text/css" href="'.$globvars['site_path'].'/tmp/'.$css_file_name.'"',$init,$final-$init);
		$file_content=file_get_contents($globvars['local_root']."layouts/templates/".$file);
		//$file_content=str_replace($dirname.'/',$globvars['site_path'].'/layouts/templates/'.$dirname.'/',$file_content);
		$file_content=str_replace('background="','background="'.$globvars['site_path'].'/layouts/templates/',$file_content);

		//$file_content=str_replace("url('","#1475778#".$globvars['site_path']."/layouts/templates/".$dir_name."/",$file_content);
		//$file_content=str_replace("url(".$img_dir."/","#1475779#".$globvars['site_path']."/layouts/templates/".$dir_name."/",$file_content);

		$file_content=str_replace("url('","#1475777#".$globvars['site_path']."/layouts/templates/".$dir_name."/",$file_content);
		$file_content=str_replace('url("','#1475767#'.$globvars['site_path']."/layouts/templates/".$dir_name."/",$file_content);
		$file_content=str_replace("url(","url(".$globvars['site_path']."/layouts/templates/".$dir_name."/",$file_content);

		$file_content=str_replace("#1475777#","url('",$file_content);
		$file_content=str_replace("#1475778#","url('",$file_content);
		$file_content=str_replace("#1475779#","url(",$file_content);
		$file_content=str_replace("#1475767#",'url("',$file_content);

		$filename=$globvars['local_root'].'tmp/'.$css_file_name;
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
	$filename=$globvars['local_root'].'tmp/'.$file2;
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
	return $code;
};

?>