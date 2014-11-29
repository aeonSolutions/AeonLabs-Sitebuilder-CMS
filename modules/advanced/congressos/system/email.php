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
<?php
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
$art= isset($_GET['abs']) ? mysql_escape_string($_GET['abs']) : 0 ;
$contents='';
$query=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc from congress_abstracts where cod_abstract='".$art."'");
if($query[0][0]<>''):// results found
	$th=$db->getquery("select name, translations from congress_themes where cod_theme='".$query[0][2]."'");
	if($th[0][1]<>''):// there are translations
		$pipes=explode("||",$th[0][1]);
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
		$display_name=$th[0][0];
	endif;
	$theme=$display_name;
	$title=$query[0][4];
	$authors=$query[0][6];
	$keywords=$query[0][5];
	$abstract=$query[0][7];
	$contents.='<div style="font-family:\'Times New Roman\', Times, serif;font-size:medium">';
	$contents.='<div align="center"><h2>'.$title.'</h2><br><font style="font-size:small">'.$authors.'</font><br>'.$cl[0].': '.$theme.'</div>';
	$contents.='</div><hr size="1">';
	$contents.='<div align="justify" style="font-family:\'Times New Roman\', Times, serif"><strong>'.$cl[1].'</strong><br>'.$abstract.'<br><br><br><font style="font-size:small"><strong>'.$cl[2].':</strong>'.$keywords.'</font><hr size="1"></div>';
	if(isset($_POST['email'])):
		$email_to=mysql_escape_string($_POST['email']);
		include_once($staticvars['local_root']."/email/email_engine.php");
		$email = new email_engine_class;
		$email->to=$email_to;
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		$email->subject=$staticvars['name'].': '.$query[0][4];
		$email->preview=false;
		if(is_file($staticvars['local_root'].'modules/congresssos/templates/emails/congress_listings/'.$lang.'/print_abs.html')):
			$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/congress_listings/'.$lang.'/';
			$email->template='print_abs.html';
		else:
			$email->template_location=$staticvars['local_root'].'modules/congressos/templates/emails/congress_listings/en/';
			$email->template='print_abs.html';
		endif;
		$email->message=$contents;
		$message=$email->send_email($staticvars);
		echo '<font> <font color="#FF0000">'.$cl[18].'</font></font>';
		$_SESSION['update']= 'Registo no site efectuado com sucesso';	
	endif;
else:
	echo $cl[16];
endif;

?>
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
<form class="form" action="" method="post" enctype="multipart/form-data">
<h3>Endereço de email:</h3>
<input class="text" name="email" type="text" size="30" maxlength="255" />&nbsp;<input class="button" name="send_email" type="submit" value="Enviar" />
</form>
<br />
<?=$contents;?>
    <p class="fl">&copy; Todos os direitos reservados <?=$staticvars['name'];?> - <?=$staticvars['site_path'];?></p>
</body>
</html>
