<?php
/*
File revision date: 22-set-2008
*/
if(!include($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$main_max_posts=3;
endif;
include_once($staticvars['local_root'].'modules/congressos/system/functions.php');
$pub_list=return_id('congressos_list.php');
$query=$db->getquery("select cod_congresso, cod_categoria, title, short_description from congressos order by data DESC");
if($query[0][0]<>''):// results found
	$cats=$db->getquery("select cod_categoria, cod_sub_cat, nome from congressos_categorias");
	for($i=0;$i<count($cats);$i++):
		$cat_cod[$i]=$cats[$i][0];
		$cat_sub[$i]=$cats[$i][1];
		$cat_nome[$i]=$cats[$i][2];
	endfor;
	$total=(count($query)-1)>$main_max_posts ? intval(count($query)/$main_max_posts): (count($query)-1);// main_max_posts  posts per page
	if(isset($_GET['page'])):
		$page= is_numeric($_GET['page'])? $_GET['page'] : 1;
	else:
		$page=1;
	endif;
	$page_selection=select_page($page,$total,$_SERVER['REQUEST_URI']);// page starts at 1 not at 0
	$page--;
	$lower=$page*$main_max_posts;
	$uper=($lower+$main_max_posts)>(count($query)-1)? count($query)-1 : ($lower+$main_max_posts);
	for($i=$lower;$i<=$uper;$i++):
		$pos=sweap($query[$i][1],$cat_cod);
		$k=0;
		while (is_numeric($pos)):
			$cat_tree[$k]=$pos;
			$k++;	
			$pos=sweap($cat_sub[$pos],$cat_cod);
		endwhile;
		echo '<h2>'.$query[$i][2].'</h2><br />';// titulo
		for($k=count($cat_tree)-1;$k>=0;$k--):
			$tmp= $k==0 ? ' ' : '>';
			echo '<a href="'.session($staticvars,'index.php?id='.$pub_list.'&cat='.$cat_cod[$cat_tree[$k]]).'">'.$cat_nome[$cat_tree[$k]].'</a>'.$tmp;
		endfor;
        echo '<br /><div align="justify">'.$query[$i][3].'</div></p><p></p>'; // pequena descricao
	endfor;
	echo $page_selection;
else:
	echo 'N&atilde;o existem Publica&ccedil;&otilde;es';
endif;


?>