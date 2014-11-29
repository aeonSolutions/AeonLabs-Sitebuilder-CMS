<?php
/*
File revision date: 10-Fev-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$id=return_id('new_register.php');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/authoring/language/pt.php');
else:
	include($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php');
endif;
?>
<div align="center"><a href="<?=session($staticvars,'index.php?id='.$id);?>"><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/registe_se.jpg" alt="Register" border="0"></a></div>
