<?php
function display_files($path,$type){
	$dir_files = glob($path."*.".$type);
	for($i=0; $i < count($dir_files); $i++):
		$fl=explode("/",$dir_files[$i]);
		$query=$db->getquery("select cod_css, ficheiro from css where ficheiro='".$fl[count($fl)-1]."'");
		if ($query[0][0]<>''): //file found on the db
			echo '<img src="../../../images/check_mark.gif">';
		else:
			echo '<img src="../../../images/cross_mark.gif">';
		endif;
		echo '<font class="body_text">'.$fl[count($fl)-1]. " (". filesize($dir_files[$i]) . " bytes)</font><br>";
	endfor;
	echo '<br><br>';
	echo '<img src="../../../images/check_mark.gif"><font class="body_text">Ficheiro instalado</font>&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<img src="../../../images/cross_mark.gif"><font class="body_text">Ficheiro n&atilde;o instalado</font>';
};
?>
