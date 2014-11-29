<?php
/*
File revision date: 1-Set-2006
*/
if (isset($_GET['navigate'])):
	$navigate=$_GET['navigate']; 
else:
	$navigate="directory_main";
endif;

$file_to_load=$navigate.".php";

/*
***********************do not touch anything bellow this line ***********************************************************
*/
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
$local=__FILE__;
$local = ''.substr( $local, 0, strpos( $local, 'directory_main.php' ) ) ;

if (file_exists($local.$lang.'/'.$file_to_load)):
	include($local.$lang.'/'.$file_to_load);
else:
	if (file_exists($local.$staticvars['language']['main'].'/'.$file_to_load)):
		include($local.$staticvars['language']['main'].'/'.$file_to_load);
	else:	
		include_once($staticvars['local_root'].'general/return_module_id.php');
		$mod_name=$db->getquery("select cod_module, name from module where cod_module='".return_id($file_to_load)."'");
		if ($mod_name[0][0]<>''):
			$_SESSION['erro']='A file is missing for main Language!<br>
			Please reinstall the module '.$mod_name[0][1].'('.$mod_name[0][0].')';
			$link=session($staticvars,'index.php?id=error');
			header("location: ".$link);
			?>
			<script language="javascript">parent.location="<?=$link;?>"	</script>
			<?php
		else:
			$_SESSION['erro']='The requested page in unavailable!';
			$link=session($staticvars,'index.php?id=error');
			header("location: ".$link);
			?>
			<script language="javascript">parent.location="<?=$link;?>"	</script>
			<?php
		endif;
	endif;
endif;
?>
