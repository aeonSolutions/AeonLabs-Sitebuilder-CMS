<?php
function general_news_lateral($task,$staticvars['local_root']){
include($staticvars['local_root'].'kernel/staticvars.php');
$query=$db->getquery("select texto, title, image, cod_news,data from news where active='s' order by data DESC LIMIT 0,3");
if ($query[0][0]<>''):
	include_once($staticvars['local_root'].'general/return_module_id.php');
	$task_id=return_id('news/main.php');
	include_once($staticvars['local_root'].'modules/news/system/bbcode_main.php'); 
	$header=strip_address('id',$_SERVER['REQUEST_URI']);
	$header=strip_address('news',$header);
	$header=strip_address('all',$header).'&id='.$task_id;
	for($i=0;$i<count($query);$i++):
		$news[0]=$header.'&news='.$query[$i][3];
		$news[1]=load_txt($query[$i][1]);
		$news[2]=$query[$i][0];
		echo '<hr size="1"><strong>'.$news[1].'</strong><br /><div align="" class="text_font">'.$news[2].'</div>';
	endfor;
	echo '<hr size="1">';
else:
?>
		  <tr>
		    <td  valign="bottom" class="body_text" align="left">Sem Informa&ccedil;&otilde;es relevantes de momento.</td>
		  </tr>
<?php
endif;
};
?>
