<?php
/*
File revision date: 12-Apr-2007
*/

$time1 = time() + microtime();
define('ON_SiTe', true);

if (isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;

?>