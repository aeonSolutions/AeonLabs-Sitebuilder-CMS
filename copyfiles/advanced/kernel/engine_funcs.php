<?php
/*
File revision date: 7-Apr-2007
*/
function box_effects($module,$lang){
if($module[0][3]<>'' and $module[0][3]<>'N/A'):
	$pipes=explode("||",$module[0][3]);
	$be_titulo='';
	for($i=0; $i<count($pipes);$i++):
		$names=explode("=",$pipes[$i]);
		if ($lang==$names[0]):
			$be_titulo=$names[1];
		endif;
	endfor;
	if ($be_titulo==''):
		$be_titulo=" - - ";
	endif;
else:
	$be_titulo=$module[0][2];
endif;
return $be_titulo;
};

?>