<?php
/*
File revision date: 17-jan-2009
*/
ob_start(); 
$time1 = microtime();

header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
$local_root = __FILE__ ;
$local_root = ''.substr( $local_root, 0, strpos( $local_root, "sitebuilder" ) ) ;
include($local_root.'sitebuilder/copyfiles/advanced/general/db_class.php');
include($local_root.'sitebuilder/core/globvars.php');
include($globvars['local_root'].'copyfiles/advanced/kernel/functions.php');
include($globvars['site']['directory'].'kernel/staticvars.php');
$address_root=$globvars['site_path'];
if(isset($_GET['file'])):
	$fil=$_GET['file'];
else:
	$fil='default.php';
endif;
if(isset($_GET['where'])):
	$where=$_GET['where'];
else:
	$where='header';
	$fil='default.php';
endif;
if($where=='css'):
	$css=$fil;
else:
	$css='default.css';
endif;
$css_e=$globvars['site_path'].'/layouts/css/'.$css;
$filee=$globvars['site_path'].'/layouts/'.$where.'/'.$fil;
if($where=='skin'):
	include($globvars['local_root'].'layouts/template_code.php');
	build_page($globvars,$fil);
	$fil=explode("/",$fil);
	include($globvars['local_root'].'tmp/'.$fil[1]);
elseif($where=='menu'):
	?>
	<!DOCTYPE html var "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>View</title>
	</head>
	<body>
	<div style="border:#000000; border:solid 1px; background-color:#FFFF99">
	<?php
	include($globvars['site']['directory'].'layout/menu/layouts/'.$fil);
	?>
	</div>
	</body>
	</html>
	<?php	
else:
?>
<!DOCTYPE html var "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View</title>
</head>
<body>
<?='<link href="'.$css_e.'" rel="stylesheet" type="text/css">'.chr(13);?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="body_text">Pre-visualizar <?=$where;?>: <?=$fil;?>&nbsp;&nbsp;&nbsp;StyleSheet:<?=$css;?></td>
  </tr>
  <tr>
    <td>
	<hr size="1" />CSS effects<hr size="1" />
	</td>
  </tr>
  <tr>
    <td>
        Efeitos de texto:<br />
        &nbsp;&nbsp;&nbsp;<font class="header_text_1">Header_text_1</font><br />
        &nbsp;&nbsp;&nbsp;<font class="header_text_2">Header_text_2</font><br />
        &nbsp;&nbsp;&nbsp;<font class="header_text_3">Header_text_3</font><br />
        &nbsp;&nbsp;&nbsp;<font class="header_text_4">Header_text_4</font><br />
        &nbsp;&nbsp;&nbsp;<font class="body_text">Body_text</font><br />
        &nbsp;&nbsp;&nbsp;<font class="lite_text">litle_text</font><br />
		<ul>
      	<li>list 1</li>
		<li>list 2 </li>
	    <li>...</li>
    </ul></td>
  </tr>
  <tr>
    <td class="body_text" align="center"></td>
  </tr>
</table>
</body>
</html>
<?php
endif;
ob_flush();

function build_menu(){
$tree[0]['flag']='title';
$tree[0]['name']='Menu 1';
$tree[0]['link']='';
$tree[1]['flag']='option';
$tree[1]['name']='Opt 1';
$tree[1]['link']='';
$tree[2]['flag']='option';
$tree[2]['name']='Opt 2';
$tree[2]['link']='';
$tree[3]['flag']='option';
$tree[3]['name']='Opt 3';
$tree[3]['link']='';

$tree[4]['flag']='title';
$tree[4]['name']='Menu 2';
$tree[4]['link']='';
$tree[5]['flag']='option';
$tree[5]['name']='Opt 1';
$tree[5]['link']='';
$tree[6]['flag']='option';
$tree[6]['name']='Opt 2';
$tree[6]['link']='';
$tree[7]['flag']='option';
$tree[7]['name']='Opt 3';
$tree[7]['link']='';

return $tree;
};
?>