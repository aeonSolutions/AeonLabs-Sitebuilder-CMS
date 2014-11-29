<?php
function session($staticvars,$url){

if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
if (strpos("-".$url,"?")):
	$url.= "&lang=".$lang;
else:
	$url.= "?lang=".$lang;
endif;

return $url;
};

function add_flags($nav,$lang,$type){
if ($nav<>'none'):
	$link='index.php?navigate='.$nav.'&lang=';
else:
	$link='index.php?lang=';
endif;
if ($type=='image'):
	$code='<table width="1%" border="0" cellspacing="0" cellpadding="0"><tr><td>';
	if ($lang<>'pt'):
		$code.= '<A title="Escolha a sua língua" href="'.$link.'pt"><IMG height=15 src="kernel/images/flags/pt.gif" width=20 border=0></A></td>';
	endif;
	if ($lang<>'es'):
		$code .='<td><A title="Escoja su idioma" href="'.$link.'es"><IMG height=15 src="kernel/images/flags/es.gif" width=20 border=0></A></td>';
	endif;
	if ($lang<>'en'):
		$code.='<td><A title="Choose your language" href="'.$link.'en"><IMG height=15 src="kernel/images/flags/en.gif" width=20 border=0></A></td>';
	endif;
	$code.='</tr></table>';
elseif($type=='text'):
	$code='| ';
	if ($lang<>'pt'):
		$code.= '<A title="Escolha a sua língua" href="'.$link.'pt">Português</A> | ';
	endif;
	if ($lang<>'es'):
		$code .='<A title="Escoja su idioma" href="'.$link.'es">Español</A> | ';
	endif;
	if ($lang<>'en'):
		$code.='<A title="Choose your language" href="'.$link.'en">English</A> | ';
	endif;
endif;
echo $code;
};
?>