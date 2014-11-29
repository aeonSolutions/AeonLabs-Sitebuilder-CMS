<?php
/*
File revision date: 30-set-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
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
<h1><img src="<?=$staticvars['site_path'].'modules/authoring/images/email.gif';?>" border="0" /><?=$nr[20];?></h1>
<p><?=$nr[18];?></p>

<p><img src="<?=$staticvars['site_path'].'modules/authoring/images/warning.gif';?>" border="0" /><?=$nr[19];?></p>
