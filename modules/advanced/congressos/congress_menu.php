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
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
$cat=$db->getquery("select cod_category, nome, translations from congress_category");
$module=$db->getquery("select cod_module, name, link, display_name from module order by link");
$menu=$db->getquery("select cod_menu, title, cod_category, cod_module from congress_menu order by priority ASC");
if($menu[0][0]<>''):
	$id=return_id('congress_main.php');
	echo '<ul id="navlist">';
	for($i=0;$i<count($menu);$i++):
		if($menu[$i][1]==''):
			if($menu[$i][2]<>0):
				for($j=0;$j<count($cat);$j++):
					if($menu[$i][2]==$cat[$j][0]):
						$th[0][0]=$cat[$j][1];
						$th[0][1]=$cat[$j][2];
						$tit=translate($th,$lang);
						break;
					endif;
				endfor;
				include($staticvars['local_root'].'modules/congressos/system/settings.php');
				$tmp=explode("/",$sa);
				$sa_ano=$tmp[2];
				$sa_mes=$tmp[1];
				$sa_dia=$tmp[0];
				$tmp=explode("/",$na);
				$na_ano=$tmp[2];
				$na_mes=$tmp[1];
				$na_dia=$tmp[0];
				$tmp=explode("/",$sp);
				$sp_ano=$tmp[2];
				$sp_mes=$tmp[1];
				$sp_dia=$tmp[0];
				$tmp=explode("/",$np);
				$np_ano=$tmp[2];
				$np_mes=$tmp[1];
				$np_dia=$tmp[0];
				$tmp=explode("/",$rp);
				$rp_ano=$tmp[2];
				$rp_mes=$tmp[1];
				$rp_dia=$tmp[0];

				$current=time();
				$sa=mktime(0,0,0,$sa_mes,$sa_dia,$sa_ano);
				$ps=mktime(0,0,0,$ps_mes,$ps_dia,$ps_ano);
				$na=mktime(0,0,0,$na_mes,$na_dia,$na_ano);
				$np=mktime(0,0,0,$np_mes,$np_dia,$np_ano);
				if($th[0][0]=='Accepted Abstracts'):
					if($time>=$na):
						echo '<li class="cat-item"><a href="'.session($staticvars,'index.php?id='.$id.'&mnu='.$menu[$i][0]).'">'.$tit.'</a></li>';
					endif;
				elseif($th[0][0]=='Accepted Papers'):
					if($time>$np):
						echo '<li class="cat-item"><a href="'.session($staticvars,'index.php?id='.$id.'&mnu='.$menu[$i][0]).'">'.$tit.'</a></li>';
					endif;
				else:
					echo '<li class="cat-item"><a href="'.session($staticvars,'index.php?id='.$id.'&mnu='.$menu[$i][0]).'">'.$tit.'</a></li>';
				endif;
			else:// module defined
				$tit='';
				for($j=0;$j<count($module);$j++):
					if($menu[$i][3]==$module[$j][0]):
						$th[0][0]=$module[$j][1];
						$th[0][1]=$module[$j][3];
						$tit=translate($th,$lang);
						break;
					endif;
				endfor;
				if ($tit==''):
					$tit='[Error Module]';
				endif;
				echo '<li class="cat-item"><a href="'.session($staticvars,'index.php?id='.$id.'&mnu='.$menu[$i][0]).'">'.$tit.'</a></li>';
			endif;
		else: // title defined
			if($menu[$i][1]=='[white space]'):
				echo '</ul><p>&nbsp;<p><ul>';
			else:
				if(strpos('-'.$menu[$i][1],'||')):
					$th[0][0]=$menu[$i][1];
					$th[0][1]=$menu[$i][1];
					$tit=translate($th,$lang);
				else:
					$tit=$menu[$i][1];
				endif;
			echo '</ul><h3>'.$tit.'</h3><ul>';
			endif;
		endif;
	endfor;
	echo '</ul>';
else:
	echo $c[1];
endif;

function translate($th,$lang){
	if($th[0][1]<>''):// there are translations
		$pipes=explode("||",$th[0][1]);
		$display_name='';
		for($l=0; $l<count($pipes);$l++):
			$names=explode("=",$pipes[$l]);
			if ($lang==$names[0]):
				$display_name=$names[1];
			endif;
		endfor;
		if ($display_name==''):
			$display_name=" - - ";
		endif;
	else:
		$display_name=$th[0][0];
	endif;
	return $display_name;
};
?>

