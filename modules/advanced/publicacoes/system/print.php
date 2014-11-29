<?php
/*
File revision date: 9-jan-2009
*/
header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
$local_root = __FILE__ ;
$local_root = ''.substr( $local_root, 0, strpos( $local_root, "modules" ) ) ;
include($local_root.'general/db_class.php');
include($local_root.'kernel/staticvars.php');
include($staticvars['local_root'].'kernel/functions.php'); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
<meta name="robots" content="<?=$staticvars["meta"]["robots"];?>" />
<meta name="auhtor" content="<?=$staticvars["meta"]["author"];?>" />
<meta name="description" content="<?=$staticvars["meta"]["description"];?>" />
<meta name="keywords" content="<?=$staticvars["meta"]["keywords"];?>" />
<title><?=$staticvars["meta"]["page_title"];?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="<?=$staticvars['site_path'];?>/modules/publicacoes/system/print.css" media="all" />
</head>
<body>

<script language="javascript" type="text/javascript">
window.print() ;
</script>

<style>
/*Author Text*/
.header {
	font: normal small-caps 11px/12px "Lucida Sans", Lucida, Verdana, sans-serif;
	color: #666;
	text-transform: uppercase;
}
/*Last Updated Text*/
.modifydate {
	font: normal small-caps 11px/12px "Lucida Sans", Lucida, Verdana, sans-serif;
	color: #666;
	text-transform: uppercase;
}
</style>
<?php
$art= isset($_GET['article']) ? mysql_escape_string($_GET['article']) : 0 ;
$group=$db->getquery("select cod_user_type, name from user_type where cod_user_type='".$staticvars['users']['group']."'");
if($group[0][1]=='revisor' or $staticvars['users']['group']==$staticvars['users']['user_type']['admin']):
	$pubs='';
else:
	$pubs="and active='s'";
endif;
$query=$db->getquery("select cod_publicacao,cod_categoria, cod_user, title, texto, UNIX_timestamp(data_publicacao) as fld_unixtimestamp, lida, UNIX_timestamp(data) as fld_unixtimestamp2, num_votos, votacao from publicacoes where cod_publicacao='".$art."' ".$pubs);
if($query[0][0]<>''):// results found
	include_once($staticvars['local_root'].'modules/publicacoes/system/functions.php');
	$cats=$db->getquery("select cod_categoria, cod_sub_cat, nome from publicacoes_categorias");
	$user=$db->getquery("select nome from users where cod_user='".$query[0][2]."'");
	$user=explode(" ",$user[0][0]);
	$user=$user[0].' '.$user[count($user)-1];
	for($i=0;$i<count($cats);$i++):
		$cat_cod[$i]=$cats[$i][0];
		$cat_sub[$i]=$cats[$i][1];
		$cat_nome[$i]=$cats[$i][2];
	endfor;
	$pos=sweap($query[0][1],$cat_cod);
	$k=0;
	while (is_numeric($pos)):
		$cat_tree[$k]=$pos;
		$k++;	
		$pos=sweap($cat_sub[$pos],$cat_cod);
	endwhile;
	echo '<h2>'.$query[0][3].'</h2>';// titulo
	echo 'Categoria:&nbsp;';
	for($k=count($cat_tree)-1;$k>=0;$k--):
		$tmp= $k==0 ? ' ' : '>';
		echo $cat_nome[$cat_tree[$k]].$tmp;
	endfor;
	echo'<br />';
	setlocale(LC_CTYPE, 'portuguese');
	setlocale(LC_TIME, 'portuguese');
	echo '<br><span class="header">Escrito por '.$user.'<br>'.strftime('%A, %d %B %Y',$query[0][5]).'</span><br><br>';
	$article=$query[0][4];
	$up=str_replace($staticvars['site_path'].'/',"",$staticvars['upload_path']);
	$article=str_replace('src="'.$up.'/publicacoes/images/','src="'.$staticvars['upload_path'].'/publicacoes/images/',$article);
	echo $article;
	echo '<br><br><font style="font-size:smaller">&Uacute;ltima actualiza&ccedil;&atilde;o ('.strftime('%A, %d %B %Y',$query[0][7]).')</font>';
	echo '<br><br>'.$page_selection.chr(13);
else:
	echo 'Artigo nao encontrado!';
endif;
?>
    <p class="fl">&copy; Todos os direitos reservados <?=$staticvars['name'];?> - <?=$staticvars['site_path'];?></p>
</body>
</html>