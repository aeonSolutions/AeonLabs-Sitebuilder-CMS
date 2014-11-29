<?php
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$ref=$_SERVER['HTTP_REFERER'];
if ($ref==''):
	header("Location: ".session($staticvars,'index.php'));
	echo 'should not be here - check form success register';
	exit;
endif;
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
$_SESSION['goback']=array();
unset($_SESSION['goback']);
?> 
<h1><img src="<?=$staticvars['site_path'].'/modules/authoring/images/email.gif';?>" border="0" height="20" /><?=$nr[20];?></h1>
<p><?=$nr[18];?></p>

<p><img src="<?=$staticvars['site_path'].'/modules/authoring/images/warning.gif';?>" border="0" />&nbsp;<?=$nr[19];?></p>
