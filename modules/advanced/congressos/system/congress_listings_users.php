<?php
/*
File revision date: 3-july-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
// build pdf & cvs files 
if($sel=='authors'):
	$auth=$db->getquery("select title, nome, affiliation, address1, address2, city, country, postal, phone, fax from congress_users");
	$contents='Name;Affiliation;Address;City;Country;Postal;Phone;Fax'.chr(13);
	for($i=0;$i<count($auth);$i++):
		$contents.=$auth[$i][0].' '.$auth[$i][1].';'.$auth[$i][2].';'.$auth[$i][3].' '.$auth[$i][4].';'.$auth[$i][5].';'.$auth[$i][6].';'.$auth[$i][7].';'.$auth[$i][8].';'.$auth[$i][9].';'.chr(13);
	endfor;
	$filename=$staticvars['upload'].'/congress/authors.csv';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	if (!$handle = fopen($filename, 'a')):
		echo '<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
	endif;
	if (fwrite($handle, $contents) === FALSE):
		echo '<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
	endif;

else://revisors

endif;

?>
<h2>Listing Authors</h2>
<a href="<?=$staticvars['upload_path'];?>/congress/authors.csv">Download CSV file</a>