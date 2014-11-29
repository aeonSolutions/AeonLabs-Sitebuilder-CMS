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
      <TD colspan="2" vAlign=top class="header-bk"><H3>Gest&atilde;o de Cursos de Forma&ccedil;&atilde;o</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/formacao/images/puzzle-pieces.gif" alt="" width="32" height="26"><BR></TD>
      <TD vAlign=bottom>&nbsp;</TD>
    </TR>
  </TBODY>
</TABLE>
<br>
<?php
if(isset($_POST['produto_submit'])):
		include($staticvars['local_root'].'modules/formacao/update_db/db_management.php');
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
	$test3=$db->getquery("select cod_categoria from formacao_categorias");
	if ( $test3[0][0]<>''):
		add_new_product($staticvars['local_root']);
	else:
		if ($test3[0][0]==''):
			$flags[0]='Adicionar categorias';
		else:
			$flags[0]='';
		endif;
		warnings($staticvars,$flags);
	endif;
endif;

function warnings($staticvars,$flags){
?>
<table width="100%" border="0">
  <tr valign="top">
    <td width="40"><img src="<?=$staticvars['site_path'];?>/modules/formacao/images/warning.png" alt="warning" />&nbsp;</td>
    <td><p>Para poder adicionar um curso &agrave; base de dados, tem primeiro que:</p>
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
$query=$db->getquery("select cod_categoria, nome,cod_sub_cat from formacao_categorias where active='s' order by nome");
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
</select>&nbsp;<input type="submit" value="Ver" name="ver" class="form_submit" /></div>
<hr size="1" />
</form>
<?php
if($cat<>0):
	$prods=$db->getquery("select cod_curso, titulo, descricao from formacao_curso where cod_categoria='".$cat."'");
	if($prods[0][0]<>''):
		echo '<table width="100%" border="0">'.chr(13);
			for ($jy=0;$jy<count($prods);$jy++):
					echo'<tr><td><font class="header_text_1"><a href="'.$address.'&edit=prod&cod='.$prods[$jy][0].'">'.$prods[$jy][1].'</a></font><br></td>
							</tr><tr><td><font class="body_text">'.$prods[$jy][2].'</font></td></tr>';	
			endfor;
		echo'</table>';
	else:
		?>
		<table border="0" align="center">
		  <tr valign="top">
			<td width="40"><img src="<?=$staticvars['site_path'];?>/modules/formacao/images/info.gif" alt="info" />&nbsp;</td>
			<td valign="middle"><p>Não há Cursos nesta categoria</p>
			</td>
		  </tr>
	  </table>
		<?php
	endif;
else:
	?>
	<table border="0" align="center">
	  <tr valign="top">
		<td width="40"><img src="<?=$staticvars['site_path'];?>/modules/formacao/images/info.gif" alt="info" />&nbsp;</td>
		<td valign="middle"><p>Seleccione uma categoria para poder listar os cursos</p>
	    </td>
	  </tr>
  </table>
	<?php
endif;
};

function publish_product($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$prod=$db->getquery("select cod_curso, titulo, descricao from formacao_curso where active='?'");
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
	put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
	if ($up > ($total-1)):
		$up=($total-1);
	endif;
	for ($i=($lower-1);$i<=$up;$i++):
		?>
		<form action="<?=$address.'&update=9&cod='.$prod[$i][0];?>" enctype="multipart/form-data" method="post">
		<table width="100%" border="0">
		  <tr>
			<td width="91%"><?=$prod[$i][1];?></td>
		  </tr>
		  <tr>
			<td align="justify"><div align="justify">
			  <?=$prod[$i][2];?>
			</div></td>
		  </tr>
		  
		  <tr>
		  <td align="right">
		<input type="hidden" name="produto_submit" value="true">
		 <input class="form_submit" name="publish_product" type="submit" value=" Activar ">&nbsp;&nbsp;
		 <input class="form_submit" name="del_product" type="submit" value=" Apagar ">&nbsp;&nbsp;
        </td></tr>
		</table>
  </form><hr size="1" />
		<?php
	endfor;
	put_previous_next_page($lower,$upper,$total,session($staticvars,'index.php?type='.$type.'&id='.$task));
	?>
	</td></tr></table>
	<?php
else:
	echo '<table width="500" border="0"><tr><td>Todos os cursos encontram-se publicados.</td></tr></table>';
endif;
};


function add_new_product($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$email_options='';
if(isset($_GET['cod'])):
	$prod=$db->getquery("select titulo, descricao, objectivos, conteudos, regalias, destinatarios, idade, data_inicio, horario, duracao, local, habilitacoes, cod_categoria, active from formacao_curso where cod_curso='".mysql_escape_string($_GET['cod'])."'");
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

$query=$db->getquery("select cod_categoria, nome,cod_sub_cat from formacao_categorias where active='s' order by nome");
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
  if (form.descricao.value == "") {
    document.getElementById('fdescricao').style.color="#FF0000";
	form.descricao.focus();
    return false;
  }
  if (form.objectivos.value == "") {
    document.getElementById('fobjectivos').style.color="#FF0000";
	form.objectivos.focus();
    return false;
  }
  if (form.conteudos.value == "") {
    document.getElementById('fconteudos').style.color="#FF0000";
	form.conteudos.focus();
    return false;
  }
  if (form.regalias.value == "") {
    document.getElementById('fregalias').style.color="#FF0000";
	form.regalias.focus();
    return false;
  }
  if (form.destinatarios.value == "") {
    document.getElementById('fdestinatarios').style.color="#FF0000";
	form.destinatarios.focus();
    return false;
  }
  if (form.idade.value == "") {
    document.getElementById('fidade').style.color="#FF0000";
	form.idade.focus();
    return false;
  }
  if (form.data_inicio.value == "") {
    document.getElementById('fdata_inicio').style.color="#FF0000";
	form.data_inicio.focus();
    return false;
  }
  if (form.horario.value == "") {
    document.getElementById('fhorario').style.color="#FF0000";
	form.horario.focus();
    return false;
  }
  if (form.duracao.value == "") {
    document.getElementById('fduracao').style.color="#FF0000";
	form.duracao.focus();
    return false;
  }
  if (form.categoria.options[form.categoria.selectedIndex].value== "0") {
    document.getElementById('fcategoria').style.color="#FF0000";
	form.categoria.focus();
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
      <td width="12%">&nbsp;</td>
      <td width="88%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><font id="ftitulo">T&iacute;tulo&nbsp;</font></td>
      <td><label>
        <input class="body_text" name="titulo" type="text" id="titulo" size="30" maxlength="255" value="<?=$prod[0][0];?>">
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top"><font id="fdescricao">Breve Descri&ccedil;&atilde;o</font></td>
      <td><textarea class="body_text" name="descricao" cols="50" rows="3" id="descricao"><?=$prod[0][1];?></textarea></td>
    </tr>
    <tr>
      <td align="right" valign="top"><font id="fobjectivos">Objectivos&nbsp;</font></td>
      <td><label>
        <textarea class="body_text"  name="objectivos" cols="50" rows="6" id="objectivos"><?=$prod[0][2];?></textarea>
      </label></td>
    </tr>
    
    <tr>
      <td align="right" valign="top"><font id="fconteudos">Conte&uacute;dos program&aacute;ticos</font></td>
      <td><label>
        <textarea class="body_text" name="conteudos" cols="50" rows="6" wrap="virtual" id="conteudos"><?=$prod[0][3];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top"><font id="fregalias">Regalias</font></td>
      <td align="left"><textarea name="regalias" cols="50" rows="3" class="body_text" id="regalias"><?=$prod[0][4];?></textarea></td>
    </tr>
    <tr>
      <td align="right" valign="top"><font id="fdestinatarios">Destinat&aacute;rios&nbsp;</font></td>
      <td align="left"><textarea name="destinatarios" cols="50" rows="3" class="body_text" id="destinatarios"><?=$prod[0][5];?></textarea>
        <br /></td>
    </tr>
    <tr>
      <td align="right"><font id="fidade">Idade m&iacute;nima&nbsp;</font></td>
      <td align="left"><input name="idade" type="text" id="idade" size="4" maxlength="10" class='body_text' value="<?=$prod[0][6];?>" /></td>
    </tr>
    <tr>
      <td align="right"><font id="fdata_inicio">Data Inicio&nbsp;</font></td>
      <td align="left"><input name="data_inicio" type="text" id="data_inicio" size="30" maxlength="255" class='body_text' value="<?=$prod[0][7];?>"  /></td>
    </tr>
    
    <tr>
      <td align="right" valign="top"><font id="fhorario">Hor&aacute;rio</font></td>
      <td align="left"><textarea name="horario" cols="50" rows="3" class="body_text" id="horario"><?=$prod[0][8];?></textarea></td>
    </tr>
    <tr>
      <td align="right"><font id="fduracao">Dura&ccedil;&atilde;o</font></td>
      <td align="left"><input name="duracao" type="text" id="duracao" size="30" maxlength="255" class='body_text' value="<?=$prod[0][9];?>"  /></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Local</td>
      <td align="left"><select name="local" id="local" class="body_text" >
        <option <?php if ($prod[0][10]=='Av.Liberdade'){?>selected="selected"<?php } ?> value="Av.Liberdade" >Av.Liberdade</option>
        <option <?php if ($prod[0][10]=='Rua 31 de Janeiro'){?>selected="selected"<?php } ?> value="Rua 31 de Janeiro" >Rua 31 de Janeiro</option>
      </select></td>
    </tr>
    <tr>
      <td align="right">habilita&ccedil;&otilde;es</td>
      <td align="left"><select name="habilitacoes" id="habilitacoes"  class="body_text" >
        <option <?php if ($prod[0][11]=='6º Ano'){?>selected="selected"<?php } ?> value="6º Ano" >6º Ano</option>
        <option <?php if ($prod[0][11]=='9º Ano'){?>selected="selected"<?php } ?> value="9º Ano" >9º Ano</option>
        <option <?php if ($prod[0][11]=='12º Ano'){?>selected="selected"<?php } ?> value="12º Ano" >12º Ano</option>
        <option <?php if ($prod[0][11]=='Bacharelato'){?>selected="selected"<?php } ?> value="Bacharelato" >Bacharelato</option>
        <option <?php if ($prod[0][11]=='Licenciatura'){?>selected="selected"<?php } ?> value="Licenciatura" >Licenciatura</option>
      </select></td>
    </tr>
    <tr>
      <td align="right"><font id="fcategoria">Categoria&nbsp;</font></td>
      <td align="left"><label>
        <select name="categoria" id="categoria" class="body_text" >
			<?php
            for ($i=0 ; $i<count($cat_option); $i++):
                 if ($cat_option[$i][2]=='optgroup'):
                 ?>
                    <optgroup label="<?=$cat_option[$i][1];?>"></optgroup>
                    <option <?php if ($cat_option[$i][0]==$prod[0][12]){?>selected<?php } ?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
                 <?php
                 else:
                    ?>
                    <option <?php if ($cat_option[$i][0]==$prod[0][12]){?>selected<?php } ?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
                <?php
                endif;
            endfor; ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
    
    <tr>
      <td align="right"><label>
        <input type="checkbox" name="active" id="active" />
      </label></td>
      <td>Activar o curso de imediato</td>
    </tr>
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
