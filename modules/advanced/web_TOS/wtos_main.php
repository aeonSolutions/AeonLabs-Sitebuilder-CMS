<?php
if (isset($_GET['navigate'])):
	$file_to_load=$_GET['navigate'].'.php'; 
else:
	$file_to_load="TOS.php";
endif;


/*
***********************do not touch anything bellow this line ***********************************************************
*/
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
$local=$staticvars['local_root'].'modules/web_TOS/';
if (file_exists($local.$lang.'/'.$file_to_load)):
	include($local.$lang.'/'.$file_to_load);
else:
		$_SESSION['erro']='The requested page in unavailable!';
		$link=session($staticvars,'index.php?id=error');
		header("location: ".$link);
		?>
		<script language="javascript">parent.location="<?=$link;?>"	</script>
		<?php
endif;
?>