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
$books=$db->getquery("select cod_livro, titulo, descricao, editora, editora_link,preco, imagem from livros where active='s' order by titulo ASC");
if($books[0][0]<>''):
	$total=count($books);
	$lower=@$_GET['lower'];
	$upper=@$_GET['upper'];
	if ($lower==''):
		$lower=1;
	endif;
	if ($upper==''):
		$upper=5;
	endif;
	$up=$upper;
	put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
	if ($up > ($total-1)):
		$up=($total-1);
	endif;
	for ($i=($lower-1);$i<=$up;$i++):
		if($books[$i][6]<>'' and $books[$i][6]<>'no_img.jpg'):
			$img=$upload_path.'/books/images/'.$books[$i][6];
		else:
			$img=$staticvars['site_path'].'/modules/books/images/no_img.jpg';
		endif;
		?>
		<table width="100%" border="0">
		  <tr>
			<td width="9%" rowspan="3" valign="top"><img src="<?=$img;?>" border="0" width="100" /><br />
			  <strong>Preço:</strong><?=$books[$i][5];?> &euro;</td>
			<td width="91%"><strong><?=$books[$i][1];?></strong></td>
		  </tr>
		  <tr>
			<td align="justify"><div align="justify">
			  <?=$books[$i][2];?>
			</div></td>
		  </tr>
		  <tr>
			<td><strong>Editora:</strong>&nbsp;<a href="<?=$books[$i][4];?>" target="_blank"><?=$books[$i][3];?></a></td>
		  </tr>
		</table>
        <hr size="1" />
	<?php
	endfor;
	put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
else:
	echo '<table width="500" border="0"><tr><td>De momento n&atilde;o h&aacute; Livros dispon&iacute;veis. Tente mais tarde.</td></tr></table>';
endif;


function put_previous_next_page($lower,$upper,$total,$link){
if ($lower==1 ):
  	$p_antes='<font class="body_text" ><font color="#999999">P&aacute;g. Anterior</font></font>';
endif;
if ($lower<>1):
  	$lower_a=$lower-5;
  	if ($lower_a<1):
		$lower_a=1;
	endif;
	$upper_a=$upper-5;
	if ($upper_a<1):
		$upper_a=$upper-$upper_a;
	endif;
	if ($upper_a==1 && $lower_a==1):
		$upper_a=5;
	endif;
  	$p_antes='<font class="body_text"><a href="'.$link.'&lower='.$lower_a.'&upper='.$upper_a.'"><font color="#000000">P&aacute;g. Anterior</font></a></font>';
endif;
if ($upper>=$total ):
	$p_depois='<font class="body_text" ><font color="#999999">P&aacute;g. seguinte</font></font>';
endif;
if ($upper<$total):
	$lower_d=$lower+5;
	$upper_d=$upper+5;
	if ($upper_d>$total):
		$upper_d=$total;
	endif;
	$p_depois='<font class="body_text"><a href="'.$link.'&lower='.$lower_d.'&upper='.$upper_d.'"><font color="#000000">P&aacute;g. seguinte</font></a></font>';
endif;
echo '<div align="right">'.$p_antes.'<font class="body_text" color="#000000"> | </font>'.$p_depois.'</div>';
};

?>
