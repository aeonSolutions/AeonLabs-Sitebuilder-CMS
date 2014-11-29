<?php
// returns a matrix n*3:
//  1 column -> flags: title or option
//  2 column -> name
//  3 column -> link

function build_menu($staticvars){
	include('kernel/staticvars.php');
	$query=$db->getquery("select cod_menu, name, link, cod_module,aditional_params,display_name from menu where active='s' and cod_user_type='".$staticvars['users']['type']."' and cod_sub_menu='0' order by priority ASC");    
   	if ($query[0][0]==''):
    		return; //no entries found for thew current user
    endif;
	if (isset($_GET['lang'])):
		$lang=$_GET['lang']; 
		if ($lang<>'pt' and $lang<>'en' and $lang<>'fr'):
			$lang=$staticvars['language']['main'];
		endif;
	else:
		$lang=$staticvars['language']['main'];
	endif;
	$i=0;
	$k=0;
    while ($i<count($query)):
		// draw title of the menu
		if($query[$i][5]<>'' and $query[$i][5]<>'N/A'):
			$pipes=explode("||",$query[$i][5]);
			$display_name='';
			for($l=0; $l<count($pipes);$l++):
				$names=explode("=",$pipes[$l]);
				if ($lang==$names[0]):
					$display_name=$names[1];
				endif;
			endfor;
			if ($display_name==''):
				$display_name=" - - ";
			endif;
		else:
			$display_name=$query[$i][1];
		endif;
		$tree[$k]['flag']='title';
		$tree[$k]['name']=normalize_chars($display_name);
			if ($query[$i][2]<>'N/A'): // link found (not module)
				if (strpos("-".$query[$i][2],"index.php")):
					$link=session($staticvars,$query[$i][2]);// - inside site link, ie, it has the for index.php?id=
				else:
	        		$link=$query[$i][2];//outside side link, ie, it doesn't have the form index.php?id=
				endif;
				if ($query[$i][2]<>''): 
					$tree[$k]['link']=$link;
				else:
					$tree[$k]['link']=session($staticvars,'');
				endif;
			else:// module found
				if ($query[$i][3]<>'0'):
					if ($query[$i][4]<>'N/A'):
						$locate=strpos("-".$query[$i][4],"&");
						if ($locate==1):
							$locate=$query[$i][4];
						else:
							$locate="&".$query[$i][4];
						endif;
						$tree[$k]['link']=session($staticvars,'index.php?id='.$query[$i][3].$locate);
					else:
						$tree[$k]['link']=session($staticvars,'index.php?id='.$query[$i][3]);
					endif;						
				else:
					$tree[$k]['link']=session($staticvars,'');
				endif;
			endif;
		// draw submenus of the menu
	    $query2=$db->getquery("select cod_module, link,name, aditional_params,display_name from menu where active='s' and cod_sub_menu='".$query[$i][0]."'");    
		$j=0;
		$k++;
		if ($query2[0][0]<>''):
			while ($j<count($query2)):
				if($query2[$j][4]<>'' and $query2[$j][4]<>'N/A'):
					$pipes=explode("||",$query2[$j][4]);
					$display_name='';
					for($l=0; $l<count($pipes);$l++):
						$names=explode("=",$pipes[$l]);
						if ($lang==$names[0]):
							$display_name=$names[1];
						endif;
					endfor;
					if ($display_name==''):
						$display_name=" - - ";
					endif;
				else:
					$display_name=$query2[$j][2];
				endif;
				$tree[$k]['flag']='option';
				$tree[$k]['name']=normalize_chars($display_name);
				if ($query2[$j][0]<>'0' and $query2[$j][0]<>''): // module
					$locate=strpos("-".$query[$j][3],"&");
					if ($locate==1):
						$locate=$query2[$j][3];
					else:
						$locate="&".$query2[$j][3];
					endif;
					$tree[$k]['link']=session($staticvars,'index.php?id='.$query2[$j][0].$locate);
				elseif ($query2[$j][0]<>''): // link
					if (strpos("-".$query2[$j][1],"index.php")):
						$link=session($staticvars,$query2[$j][1]);
					else:
						if ($query2[$j][1]=='N/A'):
							$link=session($staticvars,'');
						else:
							$link=$query2[$j][1];
						endif;
					endif;
					if ($link<>''):
						$tree[$k]['link']=$link;
					else:
						$tree[$k]['link']=session($staticvars,'');
					endif;
				endif;
				$j++;
				$k++;
			endwhile;
		endif;
		$i++;
	endwhile;
return $tree;
};
?>

