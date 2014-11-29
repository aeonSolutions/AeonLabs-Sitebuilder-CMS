<?php
/*
File revision date: 09-set-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['revabs']) or isset($_POST['submit_revabs'])):
	include($staticvars['local_root'].'modules/congressos/system/review_abs.php');
elseif(isset($_POST['revpaper']) or isset($_POST['submit_revpaper'])):
	include($staticvars['local_root'].'modules/congressos/system/review_paper.php');
else:
	echo 'You should not be here! Bug?';
endif;
?>