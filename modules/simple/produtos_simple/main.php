<?php
if (isset($_GET['navigate'])):
	$page_to_open=$staticvars['local_root'].'modules/produtos/'.$_GET['navigate'].'/main.php';
	if(!is_file($page_to_open)):
		$page_to_open='';
	endif;
else:
	$page_to_open='';
endif;
if ($page_to_open<>''):
	include($page_to_open);
else:
?>
Produtos
<?php
endif;
?>