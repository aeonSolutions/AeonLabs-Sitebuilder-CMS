<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$archives=$db->getquery("SELECT DATE_FORMAT(FROM_UNIXTIME(date), '%m') as month, DATE_FORMAT(FROM_UNIXTIME(date), '%Y') as year, count(cod_publicacao) AS hits FROM publicacoes GROUP BY month ORDER BY year");
if($archives[0][0]):
	echo '<h3>Archives</h3>';
	echo '<ul>';
	for():
	  echo '<li><a href="">'.$archives[$i][0].' '.$archives[$i][1].'</a></li>';
	endfor;
	echo '</ul>';
else:
	echo 'nao ha publicacoes';
endif;

?>