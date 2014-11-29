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
      <TD colspan="2" vAlign=top class="header-bk"><H3>Gest&atilde;o de galeria</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD width="36" vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/galeria/images/puzzle-pieces.gif" alt="" width="32" height="26" align="baseline"><BR></TD>
      <TD vAlign=top>Este m&oacute;dulo permite efectuar a gest&atilde;o de todo o stock de galeria da sua empresa. Aqui pode adicionar galeria na p&aacute;gina web, apagar, modificar assim como retirar tempor&aacute;riamente um produto.</TD>
    </TR>
  </TBODY>
</TABLE>
<br>
<?php
if(isset($_POST['produto_submit'])):
		include($staticvars['local_root'].'modules/galeria/update_db/db_management.php');
		$address=strip_address("update",$_SERVER['REQUEST_URI']);
		session_write_close();
		header("Location:".$address);	
endif;
if(isset($_GET['edit'])):
	if($_GET['edit']=='edit'):
		show_db_products($staticvars);
	elseif($_GET['edit']=='publish'):
		publish_product($staticvars);
	else:
		add_new_product($staticvars);
	endif;
else:
	$test=$db->getquery("select cod_iva from galeria_iva");
	$test2=$db->getquery("select cod_desconto from galeria_desconto");
	$test3=$db->getquery("select cod_categoria from galeria_categorias");
	if ($test[0][0]<>'' and $test2[0][0]<>'' and $test3[0][0]<>''):
		add_new_product($staticvars['local_root']);
	else:
		if ($test[0][0]==''):
			$flags[0]='Adicionar tipos de  I.V.A.';
		else:
			$flags[0]='';
		endif;
		if ($test2[0][0]==''):
			$flags[1]='Adicionar tipos de desconto';
		else:
			$flags[1]='';
		endif;
		if ($test3[0][0]==''):
			$flags[2]='Adicionar categorias';
		else:
			$flags[2]='';
		endif;
		warnings($staticvars['site_path'],$flags);
	endif;
endif;

function warnings($staticvars,$flags){
?>
<table width="100%" border="0">
  <tr valign="top">
    <td width="40"><img src="<?=$staticvars['site_path'];?>/modules/galeria/images/warning.png" alt="warning" />&nbsp;</td>
    <td><p>Para poder adicionar um produto &agrave; base de dados, tem primeiro que:</p>
      <ul>
      <?php
		for($i=0;$i<count($flags);$i++):
        	if ($flags[$i]<>''):
				echo '<li>'.$flags[$i].'</li>'.chr(13);
			endif;
		endfor;
		?>
        </ul>
      </td>
  </tr>
</table>

<?php
};

function show_db_products($staticvars){

include($staticvars['local_root'].'kernel/staticvars.php');
$address=strip_address("cod",$_SERVER['REQUEST_URI']);
$address=strip_address("edit",$address);
if(isset($_POST['ver'])):
	$cat=mysql_escape_string($_POST['categoria']);
else:
	$cat=0;
endif;
$query=$db->getquery("select cod_categoria, nome,cod_sub_cat from galeria_categorias where active='s' order by nome");
$k=1;
$cat_option[0][0]='0';
$cat_option[0][1]='--------------';
$cat_option[0][2]='';
for($i=0;$i<count($query);$i++):
	if($query[$i][2]==0):
		$cat_option[$k][0]=$query[$i][0];
		$cat_option[$k][1]=$query[$i][1];
		$cat_option[$k][2]='optgroup';
		$k++;
	else:
		for($j=0;$i<count($query);$j++):
			if($query[$j][2]==$query[$i][0]):
				$cat_option[$k][0]=$query[$j][0];
				$cat_option[$k][1]=$query[$j][1];
				$cat_option[$k][2]='';
				$k++;
			endif;
		endfor;
	endif;	
endfor;
?>
<form action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" method="post">
<hr size="1" /><div align="center">
Categoria:&nbsp;<select name="categoria" id="categoria" class="form_input">
    <?php
    for ($i=0 ; $i<count($cat_option); $i++):
         if ($cat_option[$i][2]=='optgroup'):
         ?>
            <optgroup label="<?=$cat_option[$i][1];?>"></optgroup>
            <option <? if ($cat_option[$i][0]==$cat){ echo 'selected="selected"';}?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
         <?php
         else:
            ?>
            <option <? if ($cat_option[$i][0]==$cat){ echo 'selected="selected"';}?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
        <?php
        endif;
    endfor; ?>
</select>&nbsp;<input type="submit" value=" Ver " name="ver" class="form_submit" />
</div>
<hr size="1" />
</form>
<?php
if($cat<>0):
	$prods=$db->getquery("select cod_galeria, titulo, short_descricao, imagem from galeria where cod_categoria='".$cat."'");
	if($prods[0][0]<>''):
		echo '<strong>Listagem dos galeria existentes nesta categoria</strong><br>';
		echo '<table width="100%" border="0">'.chr(13);
			for ($jy=0;$jy<count($prods);$jy++):
					if ($prods[$jy][3]=='' or $prods[$jy][3]=='no_img.jpg' or !is_file($upload_directory.'/galeria/images/'.$prod[$i][5])):	
						$image='<img src="'.$staticvars['site_path'].'/modules/galeria/images/no_img.jpg"  width="100" border="0">';
					else:
						$image='<img src="'.$upload_path.'/galeria/images/'.$prods[$jy][3].'" width="100" border="0">';
					endif;
					echo'<tr><td colspan="2" align="left"><font class="header_text_1"><a href="'.$address.'&edit=prod&cod='.$prods[$jy][0].'" alt="Editar">'.$prods[$jy][1].'</a></font><br></td></tr><tr>
							<td width="110" align="left">'.$image.'</td>
							<td valign="top" align="left"><font class="body_text"><strong>Breve descrição:</strong><br>'.$prods[$jy][2].'</font></td>
						  </tr><tr><td colspan="2"><hr size="1"></td></tr>';	
			endfor;
		echo'</table>';
	else:
		?>
		<table border="0" align="center">
		  <tr valign="top">
			<td width="40"><img src="<?=$staticvars['site_path'];?>/modules/galeria/images/info.gif" alt="info" />&nbsp;</td>
			<td valign="middle"><p>Não há galeria nesta categoria</p>
			</td>
		  </tr>
	  </table>
		<?php
	endif;
else:
	?>
	<table border="0" align="center">
	  <tr valign="top">
		<td width="40"><img src="<?=$staticvars['site_path'];?>/modules/galeria/images/info.gif" alt="info" />&nbsp;</td>
		<td valign="middle"><p>Seleccione uma categoria para poder listar os galeria</p>
	    </td>
	  </tr>
  </table>
	<?php
endif;
};

function publish_product($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$prod=$db->getquery("select cod_galeria, titulo, descricao, prazo_entrega, preco, imagem, cod_iva, cod_desconto from galeria where active='?' or active='n'");
$address=strip_address("cod",$_SERVER['REQUEST_URI']);
if (@$prod[0][0]<>''):
	$total=count($prod);
	$lower=@$_GET['lower'];
	$upper=@$_GET['upper'];
	if ($lower==''):
		$lower=1;
	endif;
	if ($upper==''):
		$upper=5;
	endif;
	$up=$upper;
	echo '<strong>Listagem dos galeria que não se encontram publicados</strong><br />';
	put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
	if ($up > ($total-1)):
		$up=($total-1);
	endif;
	for ($i=($lower-1);$i<=$up;$i++):
		if($prod[$i][5]<>'' or $prod[$i][5]<>'no_img.jpg' or !is_file($upload_directory.'/galeria/images/'.$prod[$i][5])):
			$img=$upload_path.'/galeria/images/'.$prod[$i][5];
		else:
			$img=$staticvars['site_path'].'/modules/galeria/images/no_img.jpg';
		endif;
		$desconto=$db->getquery("select valor from galeria_desconto where cod_desconto='".$prod[$i][7]."'");
		$iva=$db->getquery("select valor from galeria_iva where cod_iva='".$prod[$i][6]."'");
		?>
        <form action="<?=$address.'&cod='.$prod[$i][0];?>" enctype="multipart/form-data" method="post">
		<table width="100%" border="0">
		      <tr>
		        <td colspan="2" valign="top"><strong>
		          <?=$prod[$i][1];?>
		        </strong></td>
          </tr>
	      
		  <tr>
		    <td width="9%" rowspan="3" valign="top"><img src="<?=$img;?>" border="0" width="100" /><br />
		      Pre&ccedil;o:
    <?=$prod[$i][4];?>
  &euro;</td>
		    <td width="91%" align="justify"><div align="justify">
			  <strong>Descri&ccedil;&atilde;o:</strong><br />
			  <?=$prod[$i][2];?>
			</div></td>
		  </tr>
		  <tr>
		    <td>Desconto:&nbsp;<?=$desconto[0][0];?>
		    <br />			  &nbsp;I.V.A.&nbsp;<?=$iva[0][0];?></td>
		  </tr>
		  <tr>
		    <td align="right">
		<input type="hidden" name="produto_submit" value="true">
		 <input class="form_submit" name="publish_product" type="submit" value=" Activar ">&nbsp;&nbsp;
		 <input class="form_submit" name="del_product" type="submit" value=" Apagar ">&nbsp;&nbsp;
		<?php
		if($query4[$i][3]<>''):
		?>
		 <input type="hidden" name="send_email" value="<?=$prod[$i][3];?>">
        <?php
		endif;
        ?>		 </td>
		</table>
  </form><hr size="1" />
		<?php
	endfor;
	put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?type='.$type.'&id='.$task));
	?>
	</td></tr></table>
	<?php
else:
	echo '<table width="500" border="0"><tr><td align="center"><img src="'.$staticvars['site_path'].'/modules/galeria/images/warning.png" /><br>Todos os galeria encontram-se publicados.<br></td></tr></table>';
endif;
};


function add_new_product($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$email_options='';
if(isset($_GET['cod'])):
	$prod=$db->getquery("select titulo, descricao, short_descricao, imagem, preco, cod_desconto, cod_iva, stock, prazo_entrega, ref_produto, cod_categoria, active from galeria where cod_galeria='".mysql_escape_string($_GET['cod'])."'");
	if($prod[0][0]<>''):
		if($prod[0][11]=='s'):
			$publish='Não publicar';
			$pubcode='unpublish';
		else:
			$publish='Publicar';
			$pubcode='publish';
		endif;
		$add_buttons='<input type="submit" name="'.$pubcode.'_product" value="'.$publish.'" class="form_submit">&nbsp;<input type="submit" name="del_product" id="del_product" value="Apagar" class="form_submit">&nbsp;<input type="submit" name="edit_product" id="edit_product" value="Gravar alterações" class="form_submit">';
		if ($prod[0][4]<>''):
			$email_options='Submetido por: '.$prod[0][4].'<br>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="send_email">enviar email de publicação';
		endif;
	else:
		$prod[0][0]='';
		$prod[0][1]='';
		$prod[0][2]='';
		$prod[0][3]='';
		$prod[0][4]='';
		$prod[0][5]='';
		$prod[0][6]='';
		$prod[0][7]='';
		$prod[0][8]='';
		$prod[0][9]='';
		$prod[0][10]='';
		$prod[0][11]='';
		$add_buttons='<input type="submit" name="add_product" id="add_product" value="Submeter " class="form_submit">';
	endif;
else:
	$prod[0][0]='';
	$prod[0][1]='';
	$prod[0][2]='';
	$prod[0][3]='';
	$prod[0][4]='';
	$prod[0][5]='';
	$prod[0][6]='';
	$prod[0][7]='';
	$prod[0][8]='';
	$prod[0][9]='';
	$prod[0][10]='';
	$prod[0][11]='';
	$add_buttons='<input type="submit" name="add_product" id="add_product" value="Submeter " class="form_submit">';
endif;

$address=strip_address('type',$_SERVER['REQUEST_URI']);
$address=strip_address('cod',$address);

$query=$db->getquery("select cod_categoria, nome,cod_sub_cat from galeria_categorias where active='s' order by nome");
$k=1;
$cat_option[0][0]='0';
$cat_option[0][1]='--------------';
$cat_option[0][2]='';
for($i=0;$i<count($query);$i++):
	if($query[$i][2]==0):
		$cat_option[$k][0]=$query[$i][0];
		$cat_option[$k][1]=$query[$i][1];
		$cat_option[$k][2]='optgroup';
		$k++;
	else:
		for($j=0;$i<count($query);$j++):
			if($query[$j][2]==$query[$i][0]):
				$cat_option[$k][0]=$query[$j][0];
				$cat_option[$k][1]=$query[$j][1];
				$cat_option[$k][2]='';
				$k++;
			endif;
		endfor;
	endif;	
endfor;

?>
<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{
  if (form.titulo.value == "") {
    document.getElementById('ftitulo').style.color="#FF0000";
	form.titulo.focus();
    return false;
  }
  if (form.descricao2.value == "") {
    document.getElementById('fdescricao2').style.color="#FF0000";
	form.descricao2.focus();
    return false;
  }
  if (form.descricao.value == "") {
    document.getElementById('fdescricao').style.color="#FF0000";
	form.descricao.focus();
    return false;
  }
  if (form.preco.value == "") {
    document.getElementById('fpreco').style.color="#FF0000";
	form.preco.focus();
    return false;
  }
  if (form.stock.value == "") {
    document.getElementById('fstock').style.color="#FF0000";
	form.stock.focus();
    return false;
  }
  if (form.prazo_entrega.value == "") {
    document.getElementById('fprazo').style.color="#FF0000";
	form.prazo_entrega.focus();
    return false;
  }
  if (form.ref_produto.value == "") {
    document.getElementById('fref').style.color="#FF0000";
	form.ref_produto.focus();
    return false;
  }
  if (form.categoria.options[form.categoria.selectedIndex].value== "0") {
    document.getElementById('fcategoria').style.color="#FF0000";
	form.categoria.focus();
    return false;
  }
  if (form.iva.options[form.iva.selectedIndex].value== "0") {
    document.getElementById('fiva').style.color="#FF0000";
	form.iva.focus();
    return false;
  }
  if (form.desconto.options[form.desconto.selectedIndex].value== "null") {
    document.getElementById('fdesconto').style.color="#FF0000";
	form.desconto.focus();
    return false;
  }


  // ** END **
  return true;
}
//-->
</script>
<form name="form_management" method="post" onsubmit="return checkform(this)" action="<?=$_SERVER['REQUEST_URI'].'&update=15';?>" enctype="multipart/form-data" > 
  <table width="100%" border="0">
    <tr>
      <td width="10%">&nbsp;</td>
      <td width="90%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><font id="ftitulo">T&iacute;tulo&nbsp;</font></td>
      <td><label>
        <input name="titulo" type="text" id="titulo" size="30" maxlength="255" value="<?=$prod[0][0];?>">
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top"><font id="fdescricao2">Breve Descri&ccedil;&atilde;o&nbsp;</font></td>
      <td><label>
        <input name="descricao2" type="text" id="descricao2" value="<?=$prod[0][2];?>" size="50" maxlength="255" />
      </label></td>
    </tr>
    
    <tr>
      <td align="right" valign="top"><font id="fdescricao">Descri&ccedil;&atilde;o&nbsp;Detalhada</font></td>
      <td><label>
        <textarea name="descricao" cols="50" rows="3" wrap="virtual" id="descricao"><?=$prod[0][1];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="right"><font id="fpreco">Pre&ccedil;o&nbsp;</font></td>
      <td align="left"><input name="preco" type="text" id="preco" size="5" maxlength="255" class='body_text' value="<?=$prod[0][4];?>" /> 
      &euro;
      <input name="stock" type="hidden" id="stock" size="30" maxlength="255" class='body_text' value="no_stock" /></td>
    </tr>
    <?php
	/*
    <tr>
      <td align="right" valign="top"><font id="fstock">Stock&nbsp;</font></td>
      <td align="left"><input name="stock" type="text" id="stock" size="30" maxlength="255" class='body_text' value="<?=$prod[0][7];?>" />        <br /></td>
    </tr>
	*/
	?>
    <tr>
      <td align="right"><font id="fprazo">Prazo de entrega&nbsp;</font></td>
      <td align="left"><input name="prazo_entrega" type="text" id="prazo_entrega" size="4" maxlength="10" class='body_text' value="<?=$prod[0][8];?>" /> 
      (dias)</td>
    </tr>
    <tr>
      <td align="right"><font id="fref">Ref. Produto&nbsp;</font></td>
      <td align="left"><input name="ref_produto" type="text" id="ref_produto" size="30" maxlength="255" class='body_text' value="<?=$prod[0][9];?>"  /></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Imagem (Gif ou Jpg)&nbsp;</td>
      <td align="left"><label><input type="file" name="imagem" id="imagem" /></label></td>
    </tr>
    <tr>
      <td align="right">Cat&aacute;logo (pdf)</td>
      <td align="left"><label><input type="file" name="catalogo" id="catalogo" /></label></td>
    </tr>
    <tr>
      <td align="right"></td>
      <td align="left"></td>
    </tr>
      
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left"><font style="font-size:10px">Nota: tamanho m&aacute;ximo dos ficheiros (imagem e catalogo) &eacute; de 4Mb</font></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><font id="fcategoria">Categoria&nbsp;</font></td>
      <td align="left"><label>
        <select name="categoria" id="categoria" class="form_input">
			<?php
            for ($i=0 ; $i<count($cat_option); $i++):
                 if ($cat_option[$i][2]=='optgroup'):
                 ?>
                    <optgroup label="<?=$cat_option[$i][1];?>"></optgroup>
                    <option <?php if ($cat_option[$i][0]==$prod[0][10]){?>selected<?php } ?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
                 <?php
                 else:
                    ?>
                    <option <?php if ($cat_option[$i][0]==$prod[0][10]){?>selected<?php } ?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
                <?php
                endif;
            endfor; ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp; </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><font id="fiva">I.V.A.&nbsp;</font></td>
      <td><select name="iva" id="iva" class="form_input">
			<?php
			$query=$db->getquery("select cod_iva, descricao,valor from galeria_iva");
			$selected=0;
			$option[0][0]='0';
			$option[0][1]=' ';
			if($query[0][0]<>''):
				for ($j=0;$j<count($query);$j++):
					$option[$j+1][0]=$query[$j][0];
					$option[$j+1][1]=$query[$j][1];
					if ($query[$j][0]==$prod[0][6]):
						$selected=$j;
					endif;
				endfor;
			endif;
            for ($j=0 ; $j<count($option); $j++):
                ?>
                <option <?php if ($option[$j][0]==$prod[0][6]){?>selected<?php } ?> value="<?php echo $option[$j][0];?>" <?php if ($selected==$j){?>selected<?php } ?>><?=$option[$j][1];?></option>
                <?php
            endfor; ?>
        </select>&nbsp;&nbsp;&nbsp;<font id="fdesconto">Desconto</font>&nbsp;
    <select name="desconto" id="desconto" class="form_input">
      <?php
	  	$option=array();
        $query=$db->getquery("select cod_desconto, descricao,valor from galeria_desconto");
        $selected=0;
        $option[0][0]='null';
        $option[0][1]='-----------------';
        if($query[0][0]<>''):
            for ($j=0;$j<count($query);$j++):
                $option[$j+1][0]=$query[$j][0];
                $option[$j+1][1]=$query[$j][1];
                if ($query[$j][0]==$prod[0][5]):
                    $selected=$j;
                endif;
            endfor;
        endif;
        for ($j=0 ; $j<count($option); $j++):
			if($selected==0 and $option[$j][0]==0):
				$selected=$j;
			endif;
            ?>
      <option <?php if ($option[$j][0]==$prod[0][5]){?>selected<?php } ?> value="<?php echo $option[$j][0];?>" <?php if ($selected==$j){?>selected<?php } ?>><?=$option[$j][1];?>
        </option>
      <?php
        endfor; ?>
    </select></td>
    </tr>
	<?php
    if ($prod[0][0]==''):
    ?>
    <tr>
      <td align="right"><label>
        <input type="checkbox" name="active" id="active" />
      </label></td>
      <td>publicar o produto de imediato</td>
    </tr>
	<?php
    endif;
    ?>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right"><?=$add_buttons;?></td>
    </tr>
  </table>
<input type="hidden" name="produto_submit" value="true">
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
