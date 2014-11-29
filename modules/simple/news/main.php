<div style="PADDING-RIGHT: 3px;PADDING-LEFT: 3px;	padding-bottom:3px;padding-top:3px;" align="justify">
<?
if(is_file($staticvars['local_root'].'modules/news/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/news/language/'.$lang.'.php');
	
	if (is_array($news)):
		for($i=0;$i<count($news);$i++):

			echo '<hr size="1"><a href="'.$news[$i][1].'" ><strong>'.$news[$i][0].'</strong></a><br /><div align="left" class="text_font">'.$news[$i][2].'</div>';
		endfor;
		echo '<hr size="1">';
	endif;
endif;
?>
</div>