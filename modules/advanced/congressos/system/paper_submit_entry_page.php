<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
?>
<h1><?=$ps[6];?></h1>
<?=$ps[7];?> <a href="<?=session($staticvars,'index.php?id='.return_id('congress_listings.php').'&selection=user');?>"><strong><?=$ps[8];?></strong></a> <?=$ps[9];?><br />
<br />
<br />
<?=$ps[10];?>
<div align="right">
<form class="form" action="" method="post" enctype="multipart/form-data">
<input type="submit" class="button" name="submit_paper" value="<?=$ps[11];?>" />
</form>
</div>
