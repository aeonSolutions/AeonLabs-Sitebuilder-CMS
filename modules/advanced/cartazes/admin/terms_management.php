<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
?>
<div id="module-border">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Gest&atilde;o de Cartazes</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/cartazes/images/puzzle-pieces.gif" alt="" width="32" height="26"><BR></TD>
      <TD vAlign=bottom>&nbsp;</TD>
    </TR>
  </TBODY>
</TABLE>
<br>
<?php
if(isset($_POST['term_submit'])):
	include($staticvars['local_root'].'modules/dictionary/update_db/db_management.php');
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);	
endif;
if(isset($_GET['edit'])):
	if($_GET['edit']=='edit'):
		show_db_terms($staticvars);
	elseif($_GET['edit']=='publish'):
		publish_term($staticvars);
	else:
		add_new_term($staticvars);
	endif;
else:
	add_new_term($staticvars);
endif;



function show_db_terms($staticvars){

include($staticvars['local_root'].'kernel/staticvars.php');
$address=strip_address("cod",$_SERVER['REQUEST_URI']);
$address=strip_address("edit",$address);

$terms=$db->getquery("select cod_cartaz, termo, definicao, imagem from dictionary where active='s' order by termo ASC");
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
	for ($jy=0;$jy<count($terms);$jy++):
		if (ord($terms[$jy][1]{0})==10):
			$tmp=normalize_chars($terms[$jy][1]{1});
		else:
			$tmp=normalize_chars($terms[$jy][1]{0});
		endif;
		if ($tmp==$delta[$iy]):
			if ($terms[$jy][3]==''):	
				$image='';
			else:
				$image='<img src="'.$upload_path.'/dictionary/'.$terms[$jy][3].'" border="0">';
			endif;
			echo'<tr>
					<td><font class="header_text_1"><a href="'.$address.'&edit='.$delta[$iy].'&cod='.$terms[$jy][0].'">'.$terms[$jy][1].'</a></font><br>'.$image.'</td>
					<td><font class="body_text">'.$terms[$jy][2].'</font></td>
				  </tr>';	
		endif;
	endfor;
endfor;
echo'</table>';
};

function publish_term($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$query4=$db->getquery("select cod_cartaz, termo, definicao,email from dictionary where active='?'");
$address=strip_address("cod",$_SERVER['REQUEST_URI']);
if (@$query4[0][1]<>''):
	?>
	<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr><td colspan="2">
	<?php
	$total=count($query4);
	$lower=@$_GET['lower'];
	$upper=@$_GET['upper'];
	if ($lower==''):
		$lower=1;
	endif;
	if ($upper==''):
		$upper=15;
	endif;
	$up=$upper;
	put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
	if ($up > ($total-1)):
		$up=($total-1);
	endif;
	for ($i=($lower-1);$i<=$up;$i++):
		?>
		<form action="<?=$address.'&cod='.$query4[$i][0];?>" enctype="multipart/form-data" method="post">
		<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td align="left">
		  <font class="body_text">&nbsp;&nbsp;T&iacute;tulo: <b><?=$query4[$i][1];?></b><br>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$query4[$i][2];?><br></font>
		  </td>
		  <td align="center">
		<input type="hidden" name="term_submit" value="true">
		 <input class="form_submit" name="publish" type="submit" value=" Activar ">&nbsp;&nbsp;
		 <input class="form_submit" name="del_term" type="submit" value=" Apagar ">&nbsp;&nbsp;
		<?php
		if($query4[$i][3]<>''):
		?>
		 <input type="hidden" name="send_email" value="<?=$query4[$i][3];?>">
        <?php
		endif;
        ?>
		 </td></tr>
		 <tr><td colspan="2" height="5">
		 </td></tr>
		</table></form>
		<?php
	endfor;
	put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?type='.$type.'&id='.$task));
	?>
	</td></tr></table>
	<?php
else:
	echo 'n&atilde;o existem Cartazes a publicar';
endif;
};


function add_new_term($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$email_options='';
if(isset($_GET['cod'])):
	$term=$db->getquery("select termo, definicao, active, imagem, email from dictionary where cod_cartaz='".mysql_escape_string($_GET['cod'])."'");
	if($term[0][0]<>''):
		if($term[0][2]=='s'):
			$publish='Não publicar';
			$pubcode='unpublish';
		else:
			$publish='Publicar';
			$pubcode='publish';
		endif;
		$add_buttons='<input type="submit" name="'.$pubcode.'_term" value="'.$publish.'" class="form_submit">&nbsp;<input type="submit" name="del_term" id="del_term" value="Apagar" class="form_submit">&nbsp;<input type="submit" name="edit_term" id="add_term" value="Gravar alterações" class="form_submit">';
		if ($term[0][4]<>''):
			$email_options='Submetido por: '.$term[0][4].'<br>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="send_email">enviar email de publicação';
		endif;
	else:
		$term[0][1]='';
		$term[0][2]='';
		$term[0][3]='';
		$term[0][4]='';
		$term[0][5]='';
		$add_buttons='<input type="submit" name="add_term" id="add_term" value="Submeter Cartaz" class="form_submit">';
	endif;
else:
	$term[0][1]='';
	$term[0][2]='';
	$term[0][3]='';
	$term[0][4]='';
	$term[0][5]='';
	$add_buttons='<input type="submit" name="add_term" id="add_term" value="Submeter Cartaz" class="form_submit">';
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
        <input name="termo" type="text" id="termo" size="30" maxlength="255" value="<?=$term[0][0];?>">
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Descri&ccedil;&atilde;o&nbsp;</td>
      <td><label>
        <textarea name="definicao" cols="50" rows="3" wrap="virtual" id="definicao"><?=$term[0][1];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="right">Imagem do Cartaz</td>
      <td align="left" valign="top"><input name="image" type="file" size="40" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><?=$email_options;?></td>
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
<input type="hidden" name="term_submit" value="true">
</form>
<?php
};

function put_previous_next_page($lower,$upper,$total,$link){
if ($lower==1 ):
  	$p_antes='<font class="body_text" ><font color="#999999">P&aacute;g. Anterior</font></font>';
endif;
if ($lower<>1):
  	$lower_a=$lower-15;
  	if ($lower_a<1):
		$lower_a=1;
	endif;
	$upper_a=$upper-15;
	if ($upper_a<1):
		$upper_a=$upper-$upper_a;
	endif;
	if ($upper_a==1 && $lower_a==1):
		$upper_a=15;
	endif;
  	$p_antes='<font class="body_text"><a href="'.$link.'&lower='.$lower_a.'&upper='.$upper_a.'"><font color="#000000">P&aacute;g. Anterior</font></a></font>';
endif;
if ($upper>=$total ):
	$p_depois='<font class="body_text" ><font color="#999999">P&aacute;g. seguinte</font></font>';
endif;
if ($upper<$total):
	$lower_d=$lower+15;
	$upper_d=$upper+15;
	if ($upper_d>$total):
		$upper_d=$total;
	endif;
	$p_depois='<font class="body_text"><a href="'.$link.'&lower='.$lower_d.'&upper='.$upper_d.'"><font color="#000000">P&aacute;g. seguinte</font></a></font>';
endif;
echo '<div align="right">'.$p_antes.'<font class="body_text" color="#000000"> | </font>'.$p_depois.'</div>';
};

?>
</div>
