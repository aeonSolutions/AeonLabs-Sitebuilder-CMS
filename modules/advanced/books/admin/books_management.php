<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
?>
<div id="module-border">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Gest&atilde;o de Livros</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/dictionary/images/puzzle-pieces.gif" alt="" width="32" height="26"><BR></TD>
      <TD vAlign=bottom>&nbsp;</TD>
    </TR>
  </TBODY>
</TABLE>
<br>
<?php
if(isset($_POST['book_submit'])):
	include($staticvars['local_root'].'modules/books/update_db/db_management.php');
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);	
endif;
if(isset($_GET['edit'])):
	if($_GET['edit']=='edit'):
		show_db_books($staticvars);
	elseif($_GET['edit']=='publish'):
		publish_book($staticvars);
	else:
		add_new_book($staticvars);
	endif;
else:
	add_new_book($staticvars);
endif;



function show_db_books($staticvars){

include($staticvars['local_root'].'kernel/staticvars.php');
$address=strip_address("cod",$_SERVER['REQUEST_URI']);
$address=strip_address("edit",$address);

$books=$db->getquery("select cod_dic, termo, definicao, imagem from dictionary where active='s' order by termo ASC");
$letter='0';
$delta=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$sr='';
for ($i=0;$i<count($delta);$i++):
	$sr .= '<a href="#'.$delta[$i].'">'.$delta[$i].'</a>&nbsp;&nbsp;';
endfor;
echo $sr.'<br>';

echo '<table width="100%" border="0">'.chr(13);
for ($iy=0;$iy<count($delta);$iy++):
	echo '<tr>
			<td><h1 class="ABC">'.$delta[$iy].'<a name="'.$delta[$iy].'"></a></h1></td>
			<td>&nbsp;</td>
		  </tr>';
	for ($jy=0;$jy<count($books);$jy++):
		if (ord($books[$jy][1]{0})==10):
			$tmp=normalize_chars($books[$jy][1]{1});
		else:
			$tmp=normalize_chars($books[$jy][1]{0});
		endif;
		if ($tmp==$delta[$iy]):
			if ($books[$jy][3]==''):	
				$image='';
			else:
				$image='<img src="'.$upload_path.'/dictionary/'.$books[$jy][3].'" border="0">';
			endif;
			echo'<tr>
					<td><font class="header_text_1"><a href="'.$address.'&edit='.$delta[$iy].'&cod='.$books[$jy][0].'">'.$books[$jy][1].'</a></font><br>'.$image.'</td>
					<td><font class="body_text">'.$books[$jy][2].'</font></td>
				  </tr>';	
		endif;
	endfor;
endfor;
echo'</table>';
};

function publish_book($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$books=$db->getquery("select cod_livro, titulo, descricao, editora, editora_link,preco, imagem from livros where active='?'");
$address=strip_address("cod",$_SERVER['REQUEST_URI']);
if (@$books[0][0]<>''):
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
		<form action="<?=$address.'&cod='.$books[$i][0];?>" enctype="multipart/form-data" method="post">
		<table width="100%" border="0">
		  <tr>
			<td width="9%" rowspan="4" valign="top"><img src="<?=$img;?>" border="0" width="100" /><br />
			  Preço:<?=$books[$i][5];?> &euro;</td>
			<td width="91%"><?=$books[$i][1];?></td>
		  </tr>
		  <tr>
			<td align="justify"><div align="justify">
			  <?=$books[$i][2];?>
			</div></td>
		  </tr>
		  <tr>
			<td>Editora:&nbsp;<a href="<?=$books[$i][4];?>" target="_blank"><?=$books[$i][3];?></a></td>
		  </tr>
		  <tr>
		  <td align="right">
		<input type="hidden" name="book_submit" value="true">
		 <input class="form_submit" name="publish" type="submit" value=" Activar ">&nbsp;&nbsp;
		 <input class="form_submit" name="del_book" type="submit" value=" Apagar ">&nbsp;&nbsp;
		<?php
		if($query4[$i][3]<>''):
		?>
		 <input type="hidden" name="send_email" value="<?=$books[$i][3];?>">
        <?php
		endif;
        ?>
		 </td></tr>
		 <tr><td height="5"></td></tr>
		</table></form><hr size="1" />
		<?php
	endfor;
	put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?type='.$type.'&id='.$task));
	?>
	</td></tr></table>
	<?php
else:
	echo '<table width="500" border="0"><tr><td>De momento n&atilde;o h&aacute; Livros dispon&iacute;veis. Tente mais tarde.</td></tr></table>';
endif;
};


function add_new_book($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$email_options='';
if(isset($_GET['cod'])):
	$book=$db->getquery("select titulo, descricao, active, imagem, email,preco,editora,editora_link from livros where cod_livro'".mysql_escape_string($_GET['cod'])."'");
	if($book[0][0]<>''):
		if($book[0][2]=='s'):
			$publish='Não publicar';
			$pubcode='unpublish';
		else:
			$publish='Publicar';
			$pubcode='publish';
		endif;
		$add_buttons='<input type="submit" name="'.$pubcode.'_book" value="'.$publish.'" class="form_submit">&nbsp;<input type="submit" name="del_book" id="del_book" value="Apagar" class="form_submit">&nbsp;<input type="submit" name="edit_book" id="add_book" value="Gravar alterações" class="form_submit">';
		if ($book[0][4]<>''):
			$email_options='Submetido por: '.$book[0][4].'<br>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="send_email">enviar email de publicação';
		endif;
	else:
		$book[0][1]='';
		$book[0][2]='';
		$book[0][3]='';
		$book[0][4]='';
		$book[0][5]='';
		$book[0][6]='';
		$book[0][7]='';
		$add_buttons='<input type="submit" name="add_book" id="add_book" value="Submeter livro" class="form_submit">';
	endif;
else:
	$book[0][1]='';
	$book[0][2]='';
	$book[0][3]='';
	$book[0][4]='';
	$book[0][5]='';
	$book[0][6]='';
	$book[0][7]='';
	$add_buttons='<input type="submit" name="add_book" id="add_book" value="Submeter livro" class="form_submit">';
endif;

$address=strip_address('type',$_SERVER['REQUEST_URI']);
$address=strip_address('cod',$address);
?>
<form method="post" action="<?=$_SERVER['REQUEST_URI'].'&update=15';?>" enctype="multipart/form-data">
  <table width="100%" border="0">
    <tr>
      <td width="10%">&nbsp;</td>
      <td width="90%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">T&iacute;tulo&nbsp;</td>
      <td><label>
        <input name="titulo" type="text" id="titulo" size="30" maxlength="255" value="<?=$book[0][0];?>">
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Descri&ccedil;&atilde;o&nbsp;</td>
      <td><label>
        <textarea name="descricao" cols="50" rows="3" wrap="virtual" id="descricao"><?=$book[0][1];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td>Pre&ccedil;o</td>
      <td align="left"><input name="preco" type="text" id="preco" size="5" maxlength="255" class='body_text' value="<?=$book[0][5];?>" /> 
      &euro;</td>
    </tr>
    <tr>
      <td valign="top">Editora</td>
      <td align="left"><input name="editora" type="text" id="editora" size="30" maxlength="255" class='body_text' value="<?=$book[0][6];?>" />
        <br />
      endere&ccedil;o web:<br />
        <input name="editora_link" type="text" id="editora_link" size="30" maxlength="255" class='body_text' value="<?=$book[0][7];?>"  /></td>
    </tr>
    <tr>
      <td>Capa do livro</td>
      <td align="left"><label><input type="file" name="imagem" id="imagem" /></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><?=$email_options;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right"><?=$add_buttons;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
<input type="hidden" name="book_submit" value="true">
</form>
<?php
};

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
</div>
