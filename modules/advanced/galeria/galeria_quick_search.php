<?php
$address=return_id('galeria_main.php');
$advanced_search=return_id('galeria_adv_search.php');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/galeria/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/galeria/language/pt.php');
else:
	include($staticvars['local_root'].'modules/galeria/language/'.$lang.'.php');
endif;
?>
<form action="<?=session($staticvars,'index.php?id='.$address);?>" enctype="multipart/form-data" method="post">
<hr size="1" color="#006633" />
<input type="text" class="body_text" name="quick_search" size="10" />&nbsp;<input type="submit" value="<?=$pqs[0];?>" class="form_submit" /><br>
<a style="text-decoration:none" href="<?=session($staticvars,'index.php?id='.$advanced_search);?>"><?=$pqs[1];?></a>
<hr size="1" color="#006633" />
</form>
