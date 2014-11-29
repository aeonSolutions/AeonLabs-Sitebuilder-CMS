<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
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
$cats=$db->getquery("select cod_categoria, nome from publicacoes_categorias where active='s' and cod_sub_cat='0'");
$j=1;
if ($cats[0][0]<>''):
	if (isset($_GET['lang'])):
		$lang=$_GET['lang']; 
		if ($lang<>'pt' and $lang<>'en'):
			$lang=$staticvars['language']['main'];
		endif;
	else:
		$lang=$staticvars['language']['main'];
	endif;

	echo '<h3>'.$c[0].'</h3>';
	echo '<ul>';
    echo '<link rel="stylesheet" href="'.$staticvars['site_path'].'/modules/publicacoes/system/featured_post.css" type="text/css" media="screen" />';
	for($i=0; $i<count($cats);$i++):
		$display_name=$cats[$i][1];
		$id=return_id('publicacoes_list.php');
	echo '<li class="cat-item"><a href="'.session($staticvars,'index.php?id='.$id.'&cat='.$cats[$i][0]).'">'.$display_name.'</a></li>';
		$j++;
		$subcats=$db->getquery("select cod_categoria, nome from publicacoes_categorias where active='s' and cod_sub_cat='".$cats[$i][0]."'");			
		if ($subcats[0][0]<>''):
		echo '<blockquote><ul>';
			for($k=0;$k<count($subcats);$k++):
				echo '<li class="cat-item"><a href="'.session($staticvars,'index.php?id='.$id.'&cat='.$subcats[$k][0]).'">'.$subcats[$k][1].'</a></li>';
			endfor;
		echo '</ul></blockquote>';
			$j=$j+count($subcats);
		endif;
	endfor;
	echo '</ul>';
else:
	echo $c[1];
endif;
?>