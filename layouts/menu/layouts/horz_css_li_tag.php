<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$tree=build_menu($staticvars);
$menu_name='';
if (count($tree)<>0):
		for($i=0; $i<count($tree); $i++):
			if ($tree[$i]['flag']=='title'):
				echo '<li><a href="'.$tree[$i]['link'].'">'.$tree[$i]['name'].'</a></li>';
			endif;
		endfor;
else:
		echo 'no modes found to draw menu!';
endif;
?>
