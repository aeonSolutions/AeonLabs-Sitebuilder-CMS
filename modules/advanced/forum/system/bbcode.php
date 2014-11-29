<?php

function load_txt($text){
	$path=explode("/",__FILE__);
	$local_pd=$path[0];
	for ($i=1;$i<count($path)-1;$i++):
		$local_pd=$local_pd.'/'.$path[$i];
	endfor;
	$local=__FILE__;
	$local = ''.substr( $local, 0, strpos( $local, "modules" ) ) ;
	$local_pd=$local;
	include($local_pd.'/kernel/staticvars.php');
	$text = str_replace('<?php', '', $text);
	$text = str_replace('<?', '', $text);
	$text = str_replace('?>', '', $text);
	$text = str_replace('<', '&lt;', $text);
	$text = str_replace('>', '&gt;', $text);

	$text = str_replace(":oops:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_redface.gif'>", $text);
	$text = str_replace(":o", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_surprised.gif' border='0'>", $text);
	$text = str_replace(":D", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_biggrin.gif'>", $text);
	$text = str_replace(":)", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_smile.gif'>", $text);
	$text = str_replace(":(", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_sad.gif'>", $text);
	$text = str_replace(":shock:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_eek.gif'>", $text);
	$text = str_replace(":?:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_question.gif'>", $text);
	$text = str_replace(":?", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_confused.gif'>", $text);
	$text = str_replace("8)", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_cool.gif'>", $text);
	$text = str_replace(":lol:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_lol.gif'>", $text);
	$text = str_replace(":x", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_mad.gif'>", $text);
	$text = str_replace(":P", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_razz.gif'>", $text);
	$text = str_replace(":cry:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_cry.gif'>", $text);
	$text = str_replace(":evil:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_evil.gif'>", $text);
	$text = str_replace(":twisted:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_twisted.gif'>", $text);
	$text = str_replace(":roll:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_rolleyes.gif'>", $text);
	$text = str_replace(":wink:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_wink.gif'>", $text);
	$text = str_replace(":!:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_exclaim.gif'>", $text);
	$text = str_replace(":idea:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_idea.gif'>", $text);
	$text = str_replace(":arrow:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_arrow.gif'>", $text);
	$text = str_replace(":|", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_neutral.gif'>", $text);
	$text = str_replace(":mrgreen:", "<img src='".$staticvars['site_path']."/modules/forum/images/smiles/icon_mrgreen.gif'>", $text);

	
	$text = str_replace("[b]", '<font style="font-weight:bold">', $text);
	$text = str_replace("[/b]", "</font>", $text);

	$text = str_replace("[i]", "<em>", $text);
	$text = str_replace("[/i]", "</em>", $text);

	$text = str_replace("[code]", "", $text);
	$text = str_replace("[/code]", "", $text);

	$text = str_replace("[u]", "<font style='text-decoration:underline'>", $text);
	$text = str_replace("[/u]", "</font>", $text);

	$text = str_replace("[quote]", "&quot;", $text);
	$text = str_replace("[/quote]", "&quot;", $text);

	$text = str_replace("[img]", "<img src='", $text);
	$text = str_replace("[/img]", "' border='0'>", $text);

	$text = str_replace("[size=7]", '<font style="font-size:7px">', $text);
	$text = str_replace("[size=9]", '<font style="font-size:9px">', $text);
	$text = str_replace("[size=12]", '<font style="font-size:12px">', $text);
	$text = str_replace("[size=18]", '<font style="font-size:18px">', $text);
	$text = str_replace("[size=24]", '<font style="font-size:24px">', $text);
	$text = str_replace("[/size]", "</font>", $text);

	$text = str_replace('[color=darkred]', '<font color="#8B0000"', $text);
	$text = str_replace('[color=red]', '<font color="#FF0000"', $text);
	$text = str_replace('[color=orange]', '<font color="#FFA500"', $text);
	$text = str_replace('[color=brown]', '<font color="#A52A2A"', $text);
	$text = str_replace('[color=yellow]', '<font color="#FFFF00"', $text);
	$text = str_replace('[color=green]', '<font color="#008000"', $text);
	$text = str_replace('[color=olive]', '<font color="#808000"', $text);
	$text = str_replace('[color=cyan]', '<font color="#00FFFF"', $text);
	$text = str_replace('[color=blue]', '<font color="#0000FF"', $text);
	$text = str_replace('[color=darkblue]', '<font color="#00008B"', $text);
	$text = str_replace('[color=indigo]', '<font color="#4B0082"', $text);
	$text = str_replace('[color=violet]', '<font color="#EE82EE"', $text);
	$text = str_replace('[color=white]', '<font color="#FFFFFF"', $text);
	$text = str_replace('[color=black]', '<font color="#000000"', $text);



	$ok=true;
	while ($ok):
		$init_pos=strpos($text,"[url]");
		if ($init_pos === false):
			$ok=false;
		else:
			$final_pos=$final_pos=strpos($text,"]",$init_pos);
			if ($final_pos === false):
				$ok=false;
			endif;
		endif;
		if ($ok==true):
			$final_pos=strpos($text,"[/url]");
			$get_text=substr($text,$init_pos+5,($final_pos)-($init_pos+5));
			$text = substr_replace($text, "<a href='", $init_pos,5);
			$tmp2=strpos($text,"[/url]");
			$text = substr_replace($text, "' target='_blank'>".$get_text."</a>", $final_pos,6);
		endif;
	endwhile;

	$ok=true;
	while ($ok):
		$init_pos=strpos($text,"[url=");
		if ($init_pos === false):
			$ok=false;
		else:
			$final_pos=$final_pos=strpos($text,"]",$init_pos);
			if ($final_pos === false):
				$ok=false;
			endif;
		endif;
		if ($ok==true):
			$final_pos=strpos($text,"]",$init_pos);
			$get_url=substr($text,$init_pos+5,($final_pos)-($init_pos+5));
			$text = substr_replace($text, '<a href="'.$get_url.'" target="_blank">', $init_pos,$final_pos-$init_pos+1);
			$init_pos=strpos($text,'<a href="'.$get_url.'" target="_blank">')+strlen('<a href="'.$get_url.'" target="_blank">');
			$final_pos=strpos($text,"[/url]",$init_pos);
			$get_text_url=substr($text,$init_pos,($final_pos)-($init_pos));
			$text =substr_replace($text,$get_text_url.'</a>',$init_pos,$final_pos+5-$init_pos+1);
		endif;
	endwhile;

	$ok=true;
	while ($ok):
		$init_pos=strpos($text,"[list]");
		if ($init_pos === false):
			$ok=false;
		else:
			$final_pos=strpos($text,"[/list]",$init_pos);
			if ($final_pos === false):
				$ok=false;
			endif;
		endif;
		if ($ok==true):
			$final_pos=strpos($text,"[/list]");
			$get_text=substr($text,$init_pos+6,($final_pos)-($init_pos+6));
			$old_text=$get_text;
			$get_text=explode(";",$get_text);
			$tmp4='<ul>';
			if ($get_text<>false and $get_text<>$old_text):
				for ($i=0;$i<count($get_text);$i++):
					$tmp4.='<li>'.$get_text[$i];
				endfor;
			endif;
			$text = substr_replace($text,$tmp4, $init_pos,$final_pos-$init_pos);
		endif;
	endwhile;
	$text = str_replace("[/list]", "</ul>", $text);
	
	$text = str_replace(chr(13), "<br>", $text);

return $text;
};

?>