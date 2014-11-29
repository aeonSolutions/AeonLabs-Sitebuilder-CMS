<?php
/*
File revision date: 16-sept-2009
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

if(isset($_GET['selection'])):
	$sel=$_GET['selection'];
	if($sel=='authors' or $sel=='revisors'):
		include($staticvars['local_root'].'modules/congressos/system/congress_listings_users.php');	
	elseif($sel=='submissions'):
		include($staticvars['local_root'].'modules/congressos/system/congress_submissions.php');	
	else:
		echo 'invalid selection!';
	endif;
else:
?>
<h2>Listings</h2>
<form name="form1" method="post" action="">
  Search Name / Title 
  <input type="text" name="search" id="search">
  <input type="submit" name="search_btn" id="search_btn" value="Go">
</form>
<blockquote>
  <p><a href="<?=strip_address("selection",$_SERVER['REQUEST_URI']).'&selection=authors';?>">Authors</a></p>
  <p><a href="<?=strip_address("selection",$_SERVER['REQUEST_URI']).'&selection=revisors';?>">Reviwers</a></p>
  <p><a href="<?=strip_address("selection",$_SERVER['REQUEST_URI']).'&selection=submissions';?>">Submissions</a></p>
</blockquote>
  <?php
endif;
?>
