<?php
/*
File revision date: 23-Ago-2006
*/
if (isset($_GET['lang'])):
	$lang=$_GET['lang'];
	if ($lang<>'pt' and $lang<>'en'):
		$lang='pt';
	endif;
else:
	$lang=$main_language;
endif;
$address=explode('/',$_SERVER['REQUEST_URI']);
$address=$address[count($address)-1];
$address=str_replace('&lang='.$lang,'',$address);
$address=str_replace('?lang='.$lang,'',$address);
if (strpos("-".$address,"?")):
	$link= $address."&lang=";
else:
	$link= $address."?lang=";
endif;
?>
<form action="" method="get" enctype="application/x-www-form-urlencoded">
<select name="lang" size="1" class="body_text" onChange="window.location='<?=$link;?>'+this.value+''">
<option value="pt" <?php if ($lang=='pt'){?>selected<?php } ?>>Português</option>
<option value="en" <?php if ($lang=='en'){?>selected<?php } ?>>English</option>
</select>
</form>
