<?
if ( !defined('ON_SiTe')):
	$_SESSION['erro']='(Handler) N&atilde;o se encontra autorizado a aceder directamente a esta p&aacute;gina. Por favor navege a partir da p&aacute;gina inicial!';
	include_once('staticvars.php');	
	$it=$site_path."/index.php?id=error";
	header("Location: ".$it);
	?>
	<script>
		document.location.href="<?=$it;?>"
	</script>
	<?php
endif; 


?>