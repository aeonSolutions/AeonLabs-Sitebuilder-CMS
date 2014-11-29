<?php
/*
File revision date: 18-Ago-2006
*/
?>
<style>
A.linkmenu:link {
	FONT-SIZE: 11px; COLOR: #808080; FONT-FAMILY: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A.linkmenu:visited {
	FONT-SIZE: 11px; COLOR: #808080; FONT-FAMILY: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A.linkmenu:hover {
	COLOR: #63b92e; TEXT-DECORATION: none

</style>
<?php
	echo '<font class="header_text_1">Menu</font><hr size=3 color="#000099">';
	echo '<table border="0" cellpadding="0" cellspacing="0" width="200" align="left">';
	$tree=build_menu();
	if (count($tree)<>0):
		for($i=0; $i<count($tree); $i++):
			if ($tree[$i]['flag']=='title'):
				echo '<tr><td background="" height="19">';
				if ($tree[$i]['link']<>''):
					echo "<a class='linkmenu' href=".$tree[$i]['link']." target='_top'><div class='header_1' align='left'>".$tree[$i]['name']."</div></a>";
				else:
					echo "<div class='header_1' align='left'>".$tree[$i]['name']."</div>";
				endif;
			elseif($tree[$i]['flag']=='option'):
				echo '<tr><td height="5">';
				if ($tree[$i]['link']<>''):
					 echo "<div align='left'><a class='linkmenu' href=".$tree[$i]['link']." target='_top'  >".$tree[$i]['name']."</a>&nbsp;&nbsp;</div>";
				else:
					 echo "<div align='left'>".$tree[$i]['name']."&nbsp;&nbsp;</div>";
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

