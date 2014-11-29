<?php
/*
File revision date: 18-Ago-2006
*/
?>
<SCRIPT language="JavaScript" src="<?=$staticvars['site_path'];?>/layout/menu/layouts/horz_fire/menu_builder.js"></SCRIPT>
<?php
// para configurar a font do text ver mais abaixo no css

$sub_menu_bk='#EBEBEB';
$sub_menu_highlight='#DADADA';
$sub_menu_txt='#000000';
$sub_menu_txt_highlight='#000000';
$sub_menu_border='#989898';
$tree=build_menu($staticvars);
$menu_name='';
if (count($tree)<>0):
	include_once($staticvars['local_root'].'general/pass_generator.php');
	$k=0;
	$menu='';
	for($i=0; $i<count($tree); $i++):
		if ($tree[$i]['flag']=='title'):
			$tmp=generate('5','No','Yes','No');
			$menu_name[$k]['id']='mn_'.$tmp;
			$menu_name[$k]['name']='menu_'.$tmp;
			$menu_name[$k]['pos']=$i;
			if ($i>0):
				if($tree[$i-1]['flag']=='title'):
					$menu_name[$k-1]['type']='no menu';
				else:
					$menu_name[$k-1]['type']='menu';
				endif;
			endif;                                                                                                           //submenu txt,menu txt, azul escuro,cinza claro
			$menu .= 'window.'.$menu_name[$k]['name'].' = new Menu("root",210,30,"Verdana, Arial, Helvetica, sans-serif",11,"'.$sub_menu_txt.'","'.$sub_menu_txt_highlight.'","'.$sub_menu_bk.'","'.$sub_menu_highlight.'","left","middle",5,0,1000,-5,7,true,true,true,0,true,false);';
			$menu.='
			';
			$menu .= $menu_name[$k]['name'].'.fontWeight="normal";';
			$menu.='
			';
			$menu .= $menu_name[$k]['name'].'.hideOnMouseOut=true;';
			$menu.='
			';
			$menu .= $menu_name[$k]['name'].'.bgColor="'.$sub_menu_bk.'";';
			$menu.='
			';
			$menu .= $menu_name[$k]['name'].'.menuBorder=1;';
			$menu.='
			';
			$menu .= $menu_name[$k]['name'].'.menuLiteBgColor="'.$sub_menu_bk.'";';
			$menu.='
			';
			$menu .= $menu_name[$k]['name'].'.menuBorderBgColor="'.$sub_menu_border.'";';
			$menu.='
			';
			$k++;
		elseif($tree[$i]['flag']=='option'):
			$menu .= $menu_name[$k-1]['name'].'.addMenuItem("'.normalize_chars($tree[$i]['name']).'","location=\''.$staticvars['site_path'].'/'.$tree[$i]['link'].'\'");';
			$menu.='
			';
		endif;
	endfor;
	if($tree[count($tree)-1]['flag']=='title'):
		$menu_name[$k-1]['type']='no menu';
	else:
		$menu_name[$k-1]['type']='menu';
	endif;

	?>

	<SCRIPT language="javascript">
	
	function mmLoadMenus() {
		if (window.<?=$menu_name[0]['name'];?>) return;
		<?=$menu;?>
		writeMenus();
		
	} // mmLoadMenus()
	mmLoadMenus();
	//-->
	</SCRIPT>
	<style>
	.menu_links{
	
	font-family:Arial, Helvetica, sans-serif;
	color:<?=$sub_menu_txt;?>;
	text-decoration:none;
	font-size:12px;
	text-transform:capitalize;
	font-weight:bold;
	}
	
	</style>
	<?
	// Link example type:
	//  <A class=menu1 id="mn_noticias" onmouseover="MM_showMenu(window.mm_menu_0309132629_0,138,-1,null,'mn_noticias')" 
	//  onmouseout=MM_startTimeout(); href="http://www.pme.online.pt/noticias/?tipo=1" name="mn_noticias">Notícias</A>
		echo '<table border="0" cellpadding="0" cellspacing="0" align="left">
		';
		echo '<tr height="25" valign="center">
		';
		if ($menu_name<>''):
			for($i=0; $i<count($menu_name); $i++):
				echo '<td>
				';
				if ($menu_name[$i]['type']=='menu'):
					echo '<a class="menu_links" id="'.$menu_name[$i]['id'].'" href="'.$tree[$menu_name[$i]['pos']]['link'].'" target="_top"
					onmouseover=MM_showMenu(window.'.$menu_name[$i]['name'].',0,22,null,\''.$menu_name[$i]['id'].'\');
					onmouseout=MM_startTimeout(); name="'.$menu_name[$i]['id'].'">'.$tree[$menu_name[$i]['pos']]['name'].'</a>
					';
				else:
					echo '<a class="menu_links" id="'.$menu_name[$i]['id'].'" href="'.$tree[$menu_name[$i]['pos']]['link'].'" target="_top">'.$tree[$menu_name[$i]['pos']]['name'].'</a>
					';
				endif;
				echo '</td>
				';
			endfor;
			echo '</tr>
			';
		else:
			echo '<td height="5">
			';
			echo 'no menu defined!
			';
			echo '</td></tr>
			';	
		endif;
	echo '</table>
';
endif;

?>
