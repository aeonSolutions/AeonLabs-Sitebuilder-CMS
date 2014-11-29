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
include('kernel/staticvars.php');
if(isset($_GET['id'])):
	$task=$_GET['id'];
else:
//erro
endif;
if(@$_POST['mod_cat_dropdown']<>''):
	$sub=$_POST['mod_cat_dropdown'];
else:
	if(isset($_GET['sub'])):
		$sub=$_GET['sub'];
	else:
		$sub=404;
	endif;
endif;
if(isset($_SESSION['code'])):
	$code=$_SESSION['code'];
	unset($_SESSION['code']);
endif;
$message='';
 // modify, publish /unpublish or delete category
if (isset($_SESSION['user'])):
	$user=$db->getquery("select cod_user, cod_user_type from users where nick='".$_SESSION['user']."'");
	$credentials['user']['code']=$user[0][0]; // cod_user
	$credentials['user']['cod_user_type']=$user[0][1]; // cod_user_type
else:
	$credentials['user']['code']=0; // cod_user : none
	$credentials['user']['cod_user_type']=$guest_code; // cod_user_type:guest
endif;

if (isset($_POST['form_gravar'])):
	if ($_POST['mod_titulo']<>'' and $_POST['mod_autor']<>'' and $_POST['mod_descricao']<>'' ):
		$query="update items set titulo='".mysql_escape_string($_POST['mod_titulo'])."',
				 descricao='".mysql_escape_string($_POST['mod_descricao'])."',
				  autor='".mysql_escape_string($_POST['mod_autor'])."'";
		if (isset($_POST['mod_alter_cat'])):
			$query.=", cod_category='".mysql_escape_string($_POST['mod_cat'])."'";
			$db->setquery("update category_items set cod_category='".mysql_escape_string($_POST['mod_cat'])."' where
			 cod_table='".mysql_escape_string($_POST['mod_code'])."' and tabela='items'");
		endif;
		$query.=" where cod_item='".mysql_escape_string($_POST['mod_code'])."'";
		$db->setquery($query);
		$message='Alteração efectuada com sucesso.';
	else:
		$message='Falta preencher os campos obrigatórios.';
	endif;

elseif (isset($_POST['form_apagar']) and $credentials['user']['cod_user_type']==$admin_code):
	$file=$db->getquery("select ficheiro, tipo from items where cod_item='".mysql_escape_string($_POST['mod_code'])."'");
	unlink($upload_directory.'/'.$file[0][1].'/'.$file[0][0]);
	$db->setquery("delete from category_items where cod_table='".mysql_escape_string($_POST['mod_code'])."'
		and tabela='items'");
	$db->setquery("delete from items where cod_item='".mysql_escape_string($_POST['mod_code'])."'");
	$message='Item apagado com sucesso da base de dados';	 
	?>
	<script language="javascript">
		window.alert("Item apagado com sucesso da base de dados!");
	</script>
	<?php			
	header("Location: ".$_SESSION['directory']);
endif;
 // modify, publish /unpublish or delete category
$query_a=$db->getquery("select cod_category, titulo, descricao, content from items where cod_item='".$code."'");
if ($query_a[0][0]==''):
	echo 'item not found!';
	echo '<a href="'.session($staticvars,'index.php').'">Go Back</a>';
else:
	$autor=$query_a[0][3];
	$titulo=$query_a[0][1];
	$descricao=$query_a[0][2];
	if (isset($_POST['form_gravar']) or isset($_POST['form_ver'])):
		if ($_POST['mod_titulo']<>$titulo):
			$titulo=$_POST['mod_titulo'];
		endif; 
		if($_POST['mod_autor']<>$autor):
			$autor=$_POST['mod_autor'];
		endif;
		if($_POST['mod_descricao']<>$descricao ):
			$descricao=$_POST['mod_descricao'];
		endif;
	endif;
	include($staticvars['local_root'].'general/initialize_download.php');
	$location=initialize_download('items/'.$query_a[0][3]);// no initial splash / in the string returns link if file found
?>
<script language="javascript">
function switch_box1()
{
  var cur_box = window.document.category_checkboxes.mod_current_cat;
  var alter_box = window.document.category_checkboxes.mod_alter_cat;
  var the_switch = "";
  if (cur_box.checked == false) {
		alter_box.checked=true;
  } else {
		alter_box.checked=false;
  }
}
function switch_box2()
{
  var cur_box = window.document.category_checkboxes.mod_current_cat;
  var alter_box = window.document.category_checkboxes.mod_alter_cat;
  var the_switch = "";
  if (alter_box.checked == false) {
		cur_box.checked=true;
  } else {
		cur_box.checked=false;
  }
}
</script>
<font class="header_text_3">Edi&ccedil;&atilde;o de Conte&uacute;dos   </font>
<br>
<table border="0" cellpadding="3" width="100%">
	 <tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/versele.gif" alt="vara&ccedil;&atilde;o de conte&uacute;dos" width="30" height="33" /></td>
		<td valign="bottom" class="header_text_1"><p>Caso a informa&ccedil;&atilde;o que introduziu j&aacute; n&atilde;o se encontra actualizada, pode aqui editar os conte&uacute;dos que tem publicados.</p></td>
	</tr>
</table>
<form name="category_checkboxes" action="<?=session($staticvars,'index.php?id='.$task.'&sub='.$sub.'&type='.$type.'&code='.$code);?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="mod_code" value="<?=$code;?>">
<input type="hidden" name="mod_cat" value="<?=$sub;?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td colspan="2"><div align="right"><font class="form_title">Os campos marcados com <font size="1" color="#FF0000">&#8226;</font> são obrigatórios</font></div></td>
  </tr>
  <tr>
	<td height="15" colspan="2" align="left"><font class="body_text"><font color="#FF0000"><?=$message;?></font></font></td>
  </tr>
  <tr>
	<td colspan="2" align="left"><font size="2" class="header_text_1">&nbsp; 1 - Categoria</font><font size="1" color="#FF0000">&#8226; </font></td>
  </tr>
  <tr>
	<td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="20" rowspan="5">&nbsp;</td>
		<td align="left"><font class="body_text">
		  <input name="mod_current_cat" type="checkbox" onClick="switch_box1();" <?php if (!isset($_POST['form_ver'])){?>checked="checked"<?php } ?>>
&nbsp; Categoria onde est&aacute; actualmente inserido </font></td>
		<td width="20" rowspan="5">&nbsp;</td>
	  </tr>
	  <tr>
		<td>
		  <?php
	$ct=$query_a[0][0];
	$i=0;
	$res[0][0]='';
	$query=$db->getquery("select cod_category, name, cod_sub_cat from category where cod_category=".$ct);
	while ($query[0][0]<>'0' and $query[0][0]<>''):
		$query=$db->getquery("select cod_category, name, cod_sub_cat from category where cod_category=".$ct);
		if ($query[0][0]<>'0' and $query[0][0]<>''):
			$res[$i]=$query[0];
			$ct=$query[0][2];
			$i++;
		endif;
	endwhile;
	if ($res[0][0]<>''):
		echo '<font size="1" font="verdana" color="#2c4563">';
		$idt='&nbsp;&nbsp;&nbsp;';
		for ($i=count($res)-1; $i>=0;$i--):	
			echo '<div>'.$idt.'[+] '.$res[$i][1].'</div>';
			$idt=$idt.'&nbsp;&nbsp;&nbsp;';
		endfor;
		echo '</font>';
	endif;
	?>		</td>
		</tr>
	  <tr>
		<td><?php
		$query2=$db->getquery("select cod_category, name, cod_sub_cat from category where cod_sub_cat=".$sub);
		$selected=0;
		$option[0][0]='';
		$option[0][1]='------------------------';
		if ($query2[0][0]<>''):
			for ($i=1;$i<=count($query2);$i++):
				$option[$i][0]=$query2[$i-1][0];
				$option[$i][1]=$query2[$i-1][1];
			endfor;
		endif;
	?></td>
		</tr>
	  <tr>
		<td align="left"><font class="header_text_1">
		  <input type="checkbox" name="mod_alter_cat" onClick="switch_box2();" <?php if (isset($_POST['form_ver'])){?>checked="checked"<?php } ?>>
		&nbsp;Alterar para a categoria:<br>&nbsp;&nbsp;&nbsp;
		  <?php
		if ($sub<>''):
			$ct=$sub;
			$i=0;
			unset($res);
			$res[0][0]='';
			$query=$db->getquery("select cod_category, name, cod_sub_cat from category where cod_category=".$ct);
			while ($query[0][0]<>'0' and $query[0][0]<>''):
				$query=$db->getquery("select cod_category, name, cod_sub_cat from category where cod_category=".$ct);
				if ($query[0][0]<>'0' and $query[0][0]<>''):
					$res[$i]=$query[0];
					$ct=$query[0][2];
					$i++;
				endif;
			endwhile;
			if ($res[0][0]<>''):
				echo '<font size="1" font="verdana" color="#2c4563">';
				$idt='&nbsp;&nbsp;&nbsp;';
				for ($i=count($res)-1; $i>=0;$i--):	
					echo '<div>'.$idt.'[+] <a href="'.session($staticvars,'index.php?id='.$task.'&type='.$type.'&sub='.$res[$i][0]).'&type='.$type.'&code='.$code.'">'.$res[$i][1].'</a></div>';
					$idt=$idt.'&nbsp;&nbsp;&nbsp;';
				endfor;
				echo '</font>';
			endif;
		endif;
	?>
	<br><div align="center">
	<select size="1" name="mod_cat_dropdown" class="body_text">
			<?php
			for ($i=0 ; $i<count($option); $i++):
				 if ($option[$i][0]=='optgroup'):
				 ?>
				<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
				<?php
				 else:
					?>
					<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>> <?php echo $option[$i][1]; ?></option>
					<?php
				endif;
			endfor; ?>
	</select>&nbsp;&nbsp;<input type="submit" class="form_submit" value=" Seleccionar " name="form_ver"></div>
		<br>
		</font></td>
		</tr>
	</table></td>
  </tr>
  <tr>
	<td height="10" colspan="2"></td>
  </tr>
  <tr>
	<td colspan="2" align="left"><font class="header_text_1">&nbsp; 2- Informação adicional</font><font size="1" color="#FF0000">&#8226; </font></td>
  </tr>
  <tr>
	<td height="10" colspan="2"></td>
  </tr>
  <tr>
	<td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="20" rowspan="16">&nbsp;</td>
		<td><div align="left"><font class="body_text">&nbsp; Escolha um t&iacute;tulo que melhor descreva o recurso que deseja compartilhar,e n&atilde;o se esque&ccedil;a de fazer uma breve descri&ccedil;&atilde;o.</font></div></td>
		<td width="20" rowspan="16">&nbsp;</td>
	  </tr>
	  <tr>
		<td height="5"></td>
		</tr>
	  <tr>
		<td><div align="left"><font size="2" class="body_text">&nbsp; T&iacute;tulo</font></div></td>
		</tr>
	  <tr>
		<td height="5"></td>
		</tr>
	  <tr>
		<td><input type="text" class="body_text" size="50" maxlength="50" name="mod_titulo" value="<?=$titulo?>"></td>
		</tr>
	  <tr>
		<td height="5"></td>
		</tr>
	  <tr>
		<td><div align="left"><font size="2" class="body_text">&nbsp; Descri&ccedil;&atilde;o</font></div></td>
		</tr>
	  <tr>
		<td height="5"></td>
		</tr>
	  <tr>
		<td><textarea class="body_text" name="mod_descricao" cols="50" rows="8"><?=$descricao;?>
		</textarea></td>
		</tr>
		<td height="5"></td>
		</tr>
	  <tr>
	  <tr>
		<td align="left" class="body_text"><b>Ficheiro:&nbsp;</b><?=$location;?></td>
		</tr>
	  <tr>
	  <tr>
		<td height="5"></td>
		</tr>
	  <tr>
	</table></td>
  </tr>
  <tr>
	<td width="50%" align="center"><input type="submit"  class="form_submit" value="Gravar" name="form_gravar"></td>
    <td width="50%" align="center">
	<?php if ($credentials['user']['cod_user_type']==$admin_code): ?>
	<input type="submit"  class="form_submit" value="Apagar" name="form_apagar" /><?php endif; ?></td>
  </tr>
  <tr>
    <td height="15" colspan="2"></td>
  </tr>
  <tr>
	<td height="10" colspan="2" align="right">
	<?php
	if (isset($_SESSION['varar_items'])):
		unset($_SESSION['varar_items']);
		include_once($staticvars['local_root'].'general/return_module_id.php');
		?>
		<a class="body_text" href="<?=session($staticvars,'index.php?id='.return_id('ds_publish.php').'&type='.$type_o);?>">[ Voltar a varar <?=$type;?> ]</a></td>
		<?php
	elseif (isset($_SESSION['directory'])):
		//unset($_SESSION['directory']);
		?>
		<a class="body_text" href="<?=$_SESSION['directory'];?>">[ Voltar ao directório ]</a></td>
		<?php	
	else:
		?>
		<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&type='.$type_o);?>">[ Voltar aos meus <?=$type;?> ]</a></td>
		<?php
	endif;
	?>
  </tr>
</table>
</form>
<?php
endif;
?>
