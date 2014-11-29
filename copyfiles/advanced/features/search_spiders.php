<?php
// code for the search spiders look into the database
if (!isset($_GET['spider']) and (!eregi(str_replace("http://", "", $staticvars['site_path']),@$_SERVER['HTTP_REFERER'])) and (@$_SERVER['HTTP_REFERER']!="")):
	$keywords[0]=""; 
	$keywords[1]=""; 
	$month=date("m"); 
	$year=date("Y"); 
	$url=@$_SERVER['HTTP_REFERER']; 
	
	// Google, AllTheWeb, MSN, Freeserve, Altavista 
	if ((eregi("www\.google",$url)) or (eregi("www\.alltheweb",$url)) or (eregi("search\.msn",$url)) or (eregi("ifind\.freeserve",$url)) or (eregi("altavista\.com",$url))):
			 preg_match("'q=(.*?)(&| )'si", " $url ", $keywords); 
	endif;
	// HotBot, Lycos, Netscape, AOL 
	if ((eregi("www\.hotbot",$url)) or (eregi("search\.lycos",$url)) or (eregi("search\.netscape",$url)) or (eregi("aolsearch\.aol",$url))):
		preg_match("'query=(.*?)(&| )'si", " $url ", $keywords); 
	endif;
	// Yahoo 
		  if ((eregi("yahoo\.com",$url)) or (eregi("search\.yahoo",$url))):
			 preg_match("'p=(.*?)(&| )'si", " $url ", $keywords); 
	endif;
	// Looksmart 
	if (eregi("looksmart\.com",$url)):
			 preg_match("'key=(.*?)(&| )'si", " $url ", $keywords); 
	endif;
	// DMOZ 
	if (eregi("search\.dmoz",$url)):
		preg_match("'search=(.*?)(&| )'si", " $url ", $keywords); 
	endif;
	// Ask 
	if (eregi("ask\.co",$url)):
		preg_match("'ask=(.*?)(&| )'si", " $url ", $keywords); 
	endif;

	if (($keywords[1]!="") and ($keywords[1]!=" ")):
			 $keywords=preg_replace("/\+/"," ",$keywords[1]);    
			 $keywords=eregi_replace("%2B"," ",$keywords); 
			 $keywords=eregi_replace("%2E","\.",$keywords); 
			 $keywords=trim(eregi_replace("%22","\"",$keywords)); 
			
			// pesquisa na tabela items: software e documents
			$tables[0][0]='items';
			$tables[0][1]='cod_item';
			$extra_fields='autor, titulo, descricao';
			$cats=finder_sp($tables,$extra_fields,$keywords);
			if ($cats[0][0]<>''): // found search matches
				$meta_keywords .= str_replace(" ", ", ", $keywords);
				$check=$db->getquery("select number from search_spiders where keywords='".$keywords."' and month='".$month."' limit 1"); 
				if ($check[0][0]==''):
					$db->setquery("insert into search_spiders set number='1', keywords='".$keywords."', month='".$month."'"); 
				else:
					$db->setquery("update search_spiders set number='".($check[0][0]+1)."' where keywords='".$keywords."' and month='".$month."'"); 
				endif;
				//include($local_root.'general/return_module_id.php');
				$search_id=return_id('directory_search.php');
				header("Location: index.php?id=".$search_id.'&spider='.$keywords);
				echo 'sp-58';
				exit;
			endif;
			// pesquisa na tabela forum: software e documents
			unset($tables);
			unset($extra_fields);
			$tables[0][0]='forum_topic';
			$tables[0][1]='cod_topic';
			$extra_fields='assunto, mensagem';
			$cats=finder_sp($tables,$extra_fields,$keywords);
			if ($cats[0][0]<>''): // found search matches
				$meta_keywords .= str_replace(" ", ", ", $keywords);
				$check=$db->getquery("select number from search_spiders where keywords='".$keywords."' and month='".$month."' limit 1"); 
				if ($check[0][0]==''):
					$db->setquery("insert into search_spiders set number='1', keywords='".$keywords."', month='".$month."'"); 
				else:
					$db->setquery("update search_spiders set number='".($check[0][0]+1)."' where keywords='".$keywords."' and month='".$month."'"); 
				endif;
				//include($local_root.'general/return_module_id.php');
				$search_id=return_id('forum.php');
				header("Location: index.php?id=".$search_id.'&spider='.$keywords);
				echo 'sp-79';
				exit;
			endif;
	endif;
endif;


function finder_sp($tables,$field_vector,$text_to_find){

/* This function returns a matrix of the matches found:
		0 column holds the table name
		1 column holds the value of the primary key
		2 column holds the name of the primary key
		3 column holds the title of the table $i
		4 column holds the description of the table $i

	$tables must be a matrix:
		0 column must be the table name
		1 column must be the primary key field name
	$field_mat must be a vector
	$text_to_find is the search query

*/

include ('kernel/staticvars.php');
$fields=$field_vector;
$order[0][0]='';
$t=0;
for($i=0;$i<count($tables);$i++): // for each table
	$res=$db->getquery("select ".$fields.",".$tables[$i][1]." from ".$tables[$i][0]);
	if ($res[0][0]<>''):
		for($k=0;$k<count($res);$k++): // for each query entry
			$tr=explode(" ",$fields);
			$j=0;
			$trr=1;
			while($j<count($tr)): // for each field table until the first find
				$isit='';
				$isit=@strpos(normalized($res[$k][$j]),normalized($text_to_find));
				if ($isit <> ''): // string match found
					$order[$t][0]=$tables[$i][0];
					$order[$t][1]=$res[$k][count($tr)]; // storing value of primary key where the match was found
					$order[$t][2]=$tables[$i][1];
					$order[$t][3]=$res[$k][0];
					$order[$t][4]=$res[$k][1];
					$t++;
					$j=count($tr)+100;
				endif;
				$j++;
			endwhile;
		endfor;
	endif;
endfor;

return $order;
};

	function normalized($text){
	// eliminates special characters and convert to lower case a text string
		$dim=array("&ccedil;","&ccedil;");
		$text = str_replace($dim, "c", $text);
	
		$dim=array("&atilde;","&aacute;","à","â","&atilde;","&aacute;","À","Â");
		$text = str_replace($dim, "a", $text);
	
		$dim=array("é","ê","Ê","É");
		$text = str_replace($dim, "e", $text);
	
		$dim=array("í","Í");
		$text = str_replace($dim, "i", $text);
	
		$dim=array("&otilde;","ó","ô","&otilde;","Ó","Ô");
		$text = str_replace($dim, "o", $text);
	
		$text=strtolower($text);
	return $text;
	};

?>