<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$archives=$db->getquery("SELECT DATE_FORMAT(data_publicacao, '%m') as month, DATE_FORMAT(data_publicacao, '%Y') as year, UNIX_timestamp(data_publicacao), cod_publicacao FROM publicacoes GROUP BY month ORDER BY year");
if($archives[0][0]):
	if(isset($_GET['lang'])):
		$lang=$_GET['lang'];
	else:
		$lang=$staticvars['language']['main'];
	endif;
	$language['pt']='portuguese';
	$language['en']='english';
	
	setlocale(LC_CTYPE, $language[$lang]);
	setlocale(LC_TIME, $language[$lang]);
	if(!is_file($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php')):
		include($staticvars['local_root'].'modules/publicacoes/language/pt.php');
	else:
		include($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php');
	endif;
	$pl=return_id('archives.php');
	echo '<h3>'.$al[0].'</h3>';
	echo '<ul>';
	$top= (count($archives))<7 ? count($archives) : 7;
	for($i=0;$i<$top;$i++):
	  echo '<li><a href="'.session($staticvars,'index.php?id='.$pl.'&year='.$archives[$i][1].'&month='.$archives[$i][0]).'">'.strftime('%B %Y',$archives[$i][2]).'</a></li>';
	endfor;
	echo '</ul>';
else:
	echo $al[1];
endif;
?>