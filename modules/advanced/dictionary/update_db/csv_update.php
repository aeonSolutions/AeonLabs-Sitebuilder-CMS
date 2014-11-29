<?php
if(isset($_FILES['csv'])):
	$path=explode("/",__FILE__);
	
	$local=$path[0];
	for ($i=1;$i<count($path);$i++):
		if (strtolower($path[$i])=='setup'):
			break;
		else:
			$local=$local.'/'.$path[$i];
		endif;
	endfor;
	$staticvars['local_root']=$local.'/';
	include_once($staticvars['local_root'].'kernel/staticvars.php');
	$filename=explode(".",$_FILES['csv']['name']);
	if ($filename[1]=='csv'):
		$location=$temporary_directory.'/'.$_FILES['csv']['name'];
		if (!move_uploaded_file($_FILES['csv']['tmp_name'], $location)):
			echo 'Erro no Upload. Por favor tente de novo.'.$_FILES['csv']['error'];
		else:
			$code=file_get_contents($location);
			$code=explode(chr(13),$code);
			for($i=0;$i<count($code);$i++):
				$code2code=explode(";",$code[$i]);
				$code2code[0]=mysql_escape_string(str_replace("'","\'",$code2code[0]));
				$code2code[1]=mysql_escape_string(str_replace("'","\'",$code2code[1]));
				$db->setquery( "insert into dictionary set termo='".$code2code[0]."', definicao='".$code2code[1]."'");
			endfor;
			echo 'file processed';
		endif;
	endif;
else:
?>
<form action="<?=$_SERVER['../../dicionary/update_db/REQUEST_URI'];?>" method="post" enctype="multipart/form-data" name="csv_dict" target="_self">
File:<input name="csv" type="file" size="30"><input type="submit" name="colocar" value="Upload"></form>
<?php
endif;
?>