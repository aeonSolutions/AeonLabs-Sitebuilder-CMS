<?
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
	$tree=build_menu($staticvars);
	if (count($tree)<>0):
		for($i=0; $i<count($tree); $i++):
			if ($tree[$i]['flag']=='title'):
				echo '<tr><td background="modules/menu/menu_op2.gif" height="19">';
				if ($tree[$i]['link']<>''):
					echo "<a href=".$tree[$i]['link']." target='_top'><div class='header_1'>".$tree[$i]['name']."</div></a>";
				else:
					echo "<div class='header_1' align='right'>".$tree[$i]['name']."</div>";
				endif;
			elseif($tree[$i]['flag']=='option'):
				echo '<tr><td height="5">';
				$image=$site_path.'/images/bola.gif';    		
				if ($tree[$i]['link']<>''):
					echo "&nbsp;&nbsp;<img src='default/bola.gif' width='7' heigth='7'></img><a href='".$tree[$i]['link']."' target='_top' class='linkmodule' >&nbsp;".$tree[$i]['name']."</a>";
				else:
					echo "&nbsp;&nbsp;<img src='default/bola.gif' width='7' heigth='7'></img>&nbsp;".$tree[$i]['name'];
				endif;
			endif;
			echo '</td></tr>';
		endfor;
	else:
		echo '<tr><td height="5">';
		echo 'no menu defined!';
		echo '</td></tr>';	
	endif;
echo '</table>';
?>
