<?php
/*
File revision date: 22-Set-2006
*/

function directory_listing($staticvars,$type){
include($staticvars['local_root'].'kernel/staticvars.php');
$cod=@$_GET['cod'];
$task=@$_GET['id'];
$directory_browsing=return_id("directory_browsing.php");
echo '<font class="header_text_1">';
if (!isset($_GET['cod'])):
	$cod=0;
	echo '<strong>Raíz</strong></font>';
  	return;
elseif ($cod==''):
	$cod=0;
	echo '<strong>Raíz</strong></font>';
  	return;
endif;
$address=strip_address('cod',$_SERVER['REQUEST_URI']);
$address=strip_address('id',$address);
if ($type<>''):
	$address=strip_address('type',$address);
	$address.='&type='.$type;
endif;

$ct=$cod;
$i=0;
$res[0][0]='';
$query=$db->getquery("select cod_category, name, cod_sub_cat from category where cod_category=".$ct);
 // colocar a catedoria onde esta actualmente
if ($cod<>0):
	echo '<a href="'.$address.'&cod=0&id='.$directory_browsing.'">Directório</a> <img src="'.$staticvars['site_path'].'/modules/directory/images/seta.gif" width="5" height="11">';
endif;
while ($query[0][0]<>'0' and $query[0][0]<>''):
	$query=$db->getquery("select cod_category, name, cod_sub_cat from category where cod_category=".$ct);
	if ($query[0][0]<>'0' and $query[0][0]<>''):
		$res[$i]=$query[0];
		$ct=$query[0][2];
		$i++;
	endif;
endwhile;
if ($res[0][0]<>''):
	for ($i=count($res)-1; $i>=1;$i--):
		echo '<a href="'.$address.'&cod='.$res[$i][0].'&id='.$directory_browsing.'">'.$res[$i][1].'</a> <img src="images/seta.gif" width="5" height="11">';
	endfor;
	echo '<strong>'.$res[0][1].'</strong>';
endif;
echo '</font>';
};

function load_subcategories($staticvars,$type){
include('kernel/staticvars.php');
$cod=@$_GET['cod'];
$task=@$_GET['id'];
if (!isset($_GET['cod'])):
	$cod=0;
endif;
$cats=$db->getquery("select cod_category, name, display_name from category where cod_sub_cat='".mysql_escape_string($cod)."' order by name ASC");
$address=strip_address('cod',$_SERVER['REQUEST_URI']);
if ($type<>''):
	$address=strip_address('type',$address);
	$address.='&type='.$type;
endif;

if ($cats[0][0]<>''):
	if ($cats[0][0]==''):
		$m1=0;
		$m2=0;
	elseif (count($cats)>1):
		$m1=intval(count($cats)/2);
		$m2=count($cats)-$m1;
	else:
		$m1=1;
		$m2=0;
	endif;
	?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr><td colspan="2"><FONT color=#636363><B>CATEGORIAS (<?=count($cats);?>)</B></FONT></td></tr>
		<tr><td colspan="2" height="1"><HR noShade SIZE=1></tr></td>
		<tr>
			<td width="50%"><ul>
			<? 
			if ($m1>0):
				for($i=1;$i<=$m1;$i++):
					$ct=$db->getquery("select count(*) from items where cod_category='".$cats[$i-1][0]."'");
					$ct2=$db->getquery("select count(*) from category  where cod_sub_cat='".$cats[$i-1][0]."'");
					if ($ct2[0][0]<>'' and $ct2[0][0]<>'0'):
						$ct2='<font size="-2">'.$ct2[0][0].' subcategorias</font>';
					else:
						$ct2='';
					endif;
					echo '<li><a href="'.$address.'&cod='.$cats[$i-1][0].'"><b>'.$cats[$i-1][1].'</b></a>&nbsp;('.$ct[0][0].') '.$ct2.'</li>';
				endfor;
			endif;
			?>
			</ul></td>
			<td width="50%"><ul>
			<? 
			if ($m2>0):
				for($i=$m1+1;$i<=count($cats);$i++):
					$ct=$db->getquery("select count(*) from items where cod_category='".$cats[$i-1][0]."'");
					$ct2=$db->getquery("select count(*) from category  where cod_sub_cat='".$cats[$i-1][0]."'");
					if ($ct2[0][0]<>'' and $ct2[0][0]<>'0'):
						$ct2='<font size="-2">'.$ct2[0][0].' subcategorias</font>';
					else:
						$ct2='';
					endif;
					echo '<li><a href="'.$address.'&cod='.$cats[$i-1][0].'"><b>'.$cats[$i-1][1].'</b></a>&nbsp;('.$ct[0][0].') '.$ct2.'</li>';
				endfor;
			endif;
			?>
			</ul></td>
		</tr>
	</table>
	<?
endif;
};


function load_search_listings($staticvars,$type){
	function normalize($text){
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


include($staticvars['local_root'].'kernel/staticvars.php');
$ds_files=return_id('ds_files.php');
$ds_webpages=return_id('ds_webpages.php');
if (isset($_POST['busca']) ):
	$search_query=$_POST['busca'];
elseif (isset($_GET['spider']) ):
	$search_query=$_GET['spider'];
else:
	$search_query='';
endif;
if (isset($_POST['where'])):
	$where=$_POST['where'];
else:
	$where='0';
endif;

$time1 = microtime();
$res=$db->getquery("select cod_item, titulo, descricao, content,cod_items_types, cod_category from items where active='s'");
$searching[0][0]='';
if ($res[0][0]<>''):
	// efectuar as pesquisa no directorio
	for($k=0;$k<count($res);$k++): // for each query entry
		$j=1;
		$t=0;
		while($j<4): // for each field table until the first find
			$isit='';
			$isit=@strpos(normalize($res[$k][$j]),normalize($search_query));
			if ($isit <> ''): // string match found
				$searching[$t][0]=$res[$k][0];//cod_item
				$searching[$t][1]=$res[$k][1];//titulo
				$searching[$t][2]=$res[$k][2];//descricao
				$searching[$t][3]=$res[$k][3];//content
				$searching[$t][4]=$res[$k][4];//cod_items_types
				$t++;
				$j=100;
			endif;
			$j++;
		endwhile;
	endfor;
endif;
$time2 = microtime();
$time=round($time2-$time1,3);
if ($searching[0][0]<>''): // found search matches
	?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
		<td><FONT color=#636363><B>Resultados (<?=count($searching);?>)</B></FONT></td>
		<td><div align="right"><FONT color=#636363>esta pesquisa demorou <?=$time;?> segundos</FONT></div></td>
		</tr>
		<tr>
		<td height="1" colspan="2"><HR noShade SIZE=1></td>
		</tr>
	<?php
	for($i=0;$i<count($searching);$i++):
		$item_type=$db->getquery("select tipos from items_types where cod_items_types='".$searching[$i][4]."'");
		?>
		<tr>
			<td colspan="2" width="100%"><ul>
			<? 
			if ($item_type[$i][0]=='linkexterno'):
				// $searching[$i][3] tem que ser do tipo: http://www.civiltek.com
				echo '<li><a href="'.$searching[$i][3].'" target="_blank"><b>'.$searching[$i][1].'</b></a> - '.$searching[$i][2];
			elseif($searching[$i][0]=='webpage'):
				echo '<li><a href="'.session($staticvars,'index.php?id='.$ds_webpages.'&cod='.$searching[$i][0]).'"><b>'.$searching[0][1].'</b></a> - '.$searching[0][2];
			elseif($searching[$i][0]=='modulo'):
				// $searching[$i][3] tem que ser do tipo: 12&code=4&request=optional
				echo '<li><a href="'.$session($staticvars,'index.php?id='.$searching[$i][3]).'"><b>'.$searching[$i][1].'</b></a> - '.$searching[$i][2];
			else:
				echo '<li><a href="'.session($staticvars,'index.php?id='.$ds_files.'&cod='.$searching[$i][0]).'"><b>'.$searching[0][1].'</b></a> - '.$searching[0][2];
			endif;
			?>
			</ul></td>
			</tr>
			<?
	endfor;
	?>
	</table>
	<?php
else:
	?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
		<td><FONT color=#636363><B> 0 Resultados Encontrados</B></FONT></td>
		<td><div align="right"><FONT color=#636363>esta pesquisa demorou <?=$time;?> segundos</FONT></div></td>
		</tr>
		<tr>
		<td height="1" colspan="2"><HR noShade SIZE=1></td>
		</tr>
	</table>
	<?php
endif;

};

function load_site_listings($staticvars,$type){
include('kernel/staticvars.php');
$doc_soft_code=return_id('ds_files.php');
$cod=@$_GET['cod'];
$task=@$_GET['id'];
if (!isset($_GET['cod'])):
	$cod=0;
endif;
$searching=$db->getquery("select cod_item, titulo, descricao, content,cod_items_types from items where active='s' and cod_category='".mysql_escape_string($cod)."'");
if ($searching[0][0]<>''):
	if (isset($_SESSION['user'])):
		$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
		if ($admin_code[0][0]<>''):
			$admin_code=$admin_code[0][0];
		else:
			$admin_code=-1;
		endif;
		$user=$db->getquery("select cod_user, cod_user_type from users where nick='".$_SESSION['user']."'");
		if ($user[0][1]==$admin_code):
			$publish=return_id('ds_my_items.php');
			$admin=1;
		else:
			$admin='';
		endif;
	else:
		$admin='';
	endif;
	?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr><td><FONT color=#636363><B>LISTAGEM DE ENTRADAS (<?=count($searching);?>)</B></FONT></td></tr>
		<tr><td height="1"><HR noShade SIZE=1></td></tr>
	<?php
	for($i=0;$i<count($searching);$i++):
		$item_type=$db->getquery("select tipos from items_types where cod_items_types='".$searching[$i][4]."'");
		?>
		<tr>
			<td colspan="2" width="100%"><ul>
			<? 
			if ($item_type[0][0]=='linkexterno'):
				// $searching[$i][3] tem que ser do tipo: http://www.civiltek.com
				echo '<li><a href="'.$searching[$i][3].'" target="_blank"><b>'.$searching[$i][1].'</b></a> - '.$searching[$i][2];
			elseif($item_type[0][0]=='webpage'):
				echo '<li><a href="'.session($staticvars,'index.php?id='.$ds_webpages.'&cod='.$searching[$i][0]).'"><b>'.$searching[$i][1].'</b></a> - '.$searching[$i][2];
			elseif($item_type[0][0]=='modulo'):
				// $searching[$i][3] tem que ser do tipo: 12&code=4&request=optional
				echo '<li><a href="'.session($staticvars,'index.php?id='.$searching[$i][3]).'"><b>'.$searching[$i][1].'</b></a> - '.$searching[$i][2];
			elseif($item_type[0][0]=='zip' or $item_type[$i][0]=='audio' or $item_type[$i][0]=='video' or $item_type[$i][0]=='image' or $item_type[$i][0]=='docs'):
				$admin='';
				if ($admin<>''):
					include_once($staticvars['local_root'].'general/initialize_download.php');
					$location=initialize_download('items/'.$cats[$i][3]);// no initial splash / in the string returns link if file found
					$admin='
					<form action="'.session($staticvars,'index.php?id='.$publish.'&type='.$item_type[$i][0].'&code='.$searching[$i][0]).'" enctype="multipart/form-data" method="post">
					<input type="hidden" name="mod_code" value="'.$searching[$i][0].'">
					<input type="submit" name="form_apagar" value="Apagar" class="form_submit">
					&nbsp;&nbsp;<input type="submit" name="form_editar" value="Editar" class="form_submit">&nbsp;&nbsp;
					'.$location.'</form>';
				endif;
				echo '<li><a href="'.session($staticvars,'index.php?id='.$doc_soft_code.'&cod='.$searching[$i][0]).'"><b>'.$searching[$i][1].'</b></a> - '.$searching[$i][2].'&nbsp;'.$admin;
			endif;
			?>
			</ul></td>
			</tr>
			<?
	endfor;
	?>
	</table>
	<?php
endif;
};	
?>
