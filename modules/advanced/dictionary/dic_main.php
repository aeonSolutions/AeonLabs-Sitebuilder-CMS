<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$task=@$_GET['id'];
?>
<style type="text/css">
<!--
.ABC {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FF9933;
}
-->
</style>

<?php
function norm($text){
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

	$text=strtoupper($text);
return $text;
};



$terms=$db->getquery("select cod_dic, termo, definicao, imagem from dictionary where active='s' order by termo ASC");
$letter='0';
$delta=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$sr='';
for ($i=0;$i<count($delta);$i++):
	$sr .= '<a href="#'.$delta[$i].'">'.$delta[$i].'</a>&nbsp;&nbsp;';
endfor;
echo $sr.'<br>';

echo '<table width="100%" border="0">'.chr(13);
for ($i=0;$i<count($delta);$i++):
	echo '<tr>
			<td><h1 class="ABC">'.$delta[$i].'<a name="'.$delta[$i].'"></a></h1></td>
			<td>&nbsp;</td>
		  </tr>';
	for ($j=0;$j<count($terms);$j++):
		if (ord($terms[$j][1]{0})==10):
			$tmp=norm($terms[$j][1]{1});
		else:
			$tmp=norm($terms[$j][1]{0});
		endif;
		if ($tmp==$delta[$i]):
			if ($terms[$j][3]==''):	
				$image='';
			else:
				$image='<img src="'.$upload_path.'/dictionary/'.$terms[$j][3].'" border="0">';
			endif;
			echo'<tr>
					<td><font class="header_text_1">'.$terms[$j][1].'</font><br>'.$image.'</td>
					<td><font class="body_text">'.$terms[$j][2].'</font></td>
				  </tr>';	
		endif;
	endfor;
endfor;
echo'</table>';

?>