<?php
function load_txt_admin($staticvars['local_root'],$text){
	include($staticvars['local_root'].'kernel/staticvars.php');
	$text = str_replace("<?php", "", $text);
	$text = str_replace("<?", "", $text);
	$text = str_replace("?>", "", $text);

	$text = str_replace(":oops:", "<img src='".$staticvars['site_path']."/images/smiles/icon_redface.gif'>", $text);
	$text = str_replace(":o", "<img src='".$staticvars['site_path']."/images/smiles/icon_surprised.gif' border='0'>", $text);
	$text = str_replace(":D", "<img src='".$staticvars['site_path']."/images/smiles/icon_biggrin.gif'>", $text);
	$text = str_replace(":)", "<img src='".$staticvars['site_path']."/images/smiles/icon_smile.gif'>", $text);
	$text = str_replace(":(", "<img src='".$staticvars['site_path']."/images/smiles/icon_sad.gif'>", $text);
	$text = str_replace(":shock:", "<img src='".$staticvars['site_path']."/images/smiles/icon_eek.gif'>", $text);
	$text = str_replace(":?:", "<img src='".$staticvars['site_path']."/images/smiles/icon_question.gif'>", $text);
	$text = str_replace(":?", "<img src='".$staticvars['site_path']."/images/smiles/icon_confused.gif'>", $text);
	$text = str_replace("8)", "<img src='".$staticvars['site_path']."/images/smiles/icon_cool.gif'>", $text);
	$text = str_replace(":lol:", "<img src='".$staticvars['site_path']."/images/smiles/icon_lol.gif'>", $text);
	$text = str_replace(":x", "<img src='".$staticvars['site_path']."/images/smiles/icon_mad.gif'>", $text);
	$text = str_replace(":P", "<img src='".$staticvars['site_path']."/images/smiles/icon_razz.gif'>", $text);
	$text = str_replace(":cry:", "<img src='".$staticvars['site_path']."/images/smiles/icon_cry.gif'>", $text);
	$text = str_replace(":evil:", "<img src='".$staticvars['site_path']."/images/smiles/icon_evil.gif'>", $text);
	$text = str_replace(":twisted:", "<img src='".$staticvars['site_path']."/images/smiles/icon_twisted.gif'>", $text);
	$text = str_replace(":roll:", "<img src='".$staticvars['site_path']."/images/smiles/icon_rolleyes.gif'>", $text);
	$text = str_replace(":wink:", "<img src='".$staticvars['site_path']."/images/smiles/icon_wink.gif'>", $text);
	$text = str_replace(":!:", "<img src='".$staticvars['site_path']."/images/smiles/icon_exclaim.gif'>", $text);
	$text = str_replace(":idea:", "<img src='".$staticvars['site_path']."/images/smiles/icon_idea.gif'>", $text);
	$text = str_replace(":arrow:", "<img src='".$staticvars['site_path']."/images/smiles/icon_arrow.gif'>", $text);
	$text = str_replace(":|", "<img src='".$staticvars['site_path']."/images/smiles/icon_neutral.gif'>", $text);
	$text = str_replace(":mrgreen:", "<img src='".$staticvars['site_path']."/images/smiles/icon_mrgreen.gif'>", $text);

	
	$text = str_replace("[b]", "<strong>", $text);
	$text = str_replace("[/b]", "</strong>", $text);

	$text = str_replace("[i]", "<em>", $text);
	$text = str_replace("[/i]", "</em>", $text);

	$text = str_replace("[u]", "<font style='text-decoration:underline'>", $text);
	$text = str_replace("[/u]", "</font>", $text);

	$text = str_replace("[quote]", "&quot;", $text);
	$text = str_replace("[/quote]", "&quot;", $text);

	$text = str_replace("[img]", "<img src='", $text);
	$text = str_replace("[/img]", "' border='0'>", $text);

	$text = str_replace("[size=7]", "<font size='7'>", $text);
	$text = str_replace("[size=9]", "<font size='9'>", $text);
	$text = str_replace("[size=12]", "<font size='12'>", $text);
	$text = str_replace("[size=18]", "<font size='18'>", $text);
	$text = str_replace("[size=24]", "<font size='24'>", $text);
	$text = str_replace("[/size]", "</font>", $text);

	$text = str_replace("[color=darkred]", "<font color='#8B0000'", $text);
	$text = str_replace("[color=red]", "<font color='#FF0000'", $text);
	$text = str_replace("[color=orange]", "<font color='#FFA500'", $text);
	$text = str_replace("[color=brown]", "<font color='#A52A2A'", $text);
	$text = str_replace("[color=yellow]", "<font color='#FFFF00'", $text);
	$text = str_replace("[color=green]", "<font color='#008000'", $text);
	$text = str_replace("[color=olive]", "<font color='#808000'", $text);
	$text = str_replace("[color=cyan]", "<font color='#00FFFF'", $text);
	$text = str_replace("[color=blue]", "<font color='#0000FF'", $text);
	$text = str_replace("[color=darkblue]", "<font color='#00008B'", $text);
	$text = str_replace("[color=indigo]", "<font color='#4B0082'", $text);
	$text = str_replace("[color=violet]", "<font color='#EE82EE'", $text);
	$text = str_replace("[color=white]", "<font color='#FFFFFF'", $text);
	$text = str_replace("[color=black]", "<font color='#000000'", $text);

	$ok=true;
	while ($ok):
		$tmp=strpos($text,"[url]");
		if ($tmp === false):
			$ok=false;
		else:
			$tmp2=strpos($text,"[/url]");
			$tmp3=substr($text,$tmp+5,($tmp2)-($tmp+5));
			$text = substr_replace($text, "<a href='", $tmp,5);
			$tmp2=strpos($text,"[/url]");
			$text = substr_replace($text, "' target='_blank'>".$tmp3."</a>", $tmp2,6);
		endif;
	endwhile;

	$ok=true;
	while ($ok):
		$tmp=strpos($text,"[list]");
		if ($tmp === false):
			$ok=false;
		else:
			$tmp2=strpos($text,"[/list]");
			$tmp3=substr($text,$tmp+6,($tmp2)-($tmp+6));
			$tmp3=explode(";",$tmp3);
			$tmp4='<ul>';
			for ($i=0;$i<count($tmp3);$i++):
				$tmp4.='<li>'.$tmp3[$i];
			endfor;
			$text = substr_replace($text,$tmp4, $tmp,6+($tmp2)-($tmp+6));
		endif;
	endwhile;
	$text = str_replace("[/list]", "</ul>", $text);

return $text;
};

?>