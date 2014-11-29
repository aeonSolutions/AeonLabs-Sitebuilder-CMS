<?php
/*
File revision date: 11-set-2008
*/


$tree=build_menu($staticvars);
$menu_name='';
if (count($tree)<>0):
		for($i=0; $i<count($tree); $i++):
			if ($tree[$i]['flag']=='title'):
				echo '<dd><a href="'.$tree[$i]['link'].'">'.$tree[$i]['name'].'</a></dd>';
			endif;
		endfor;
else:
		echo 'no modes found to draw menu!';
endif;
?>
