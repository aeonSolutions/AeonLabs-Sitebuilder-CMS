<?php
if (isset($_POST['email'])):
	include($staticvars['local_root'].'modules/newsletters/update_db/management.php');
endif;
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/newsletters/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/newsletters/language/pt.php');
else:
	include($staticvars['local_root'].'modules/newsletters/language/'.$lang.'.php');
endif;
?>
<form class="form" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" method="post">
quero receber a newsletter periódica<br>
email:<input name="email" class="text" type="text" size="20" >&nbsp;<input type="button" value="Ok" class="button">
</form>