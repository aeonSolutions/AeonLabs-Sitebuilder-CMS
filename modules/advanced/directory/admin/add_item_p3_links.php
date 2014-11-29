<?php
/*
File revision date: 22-Set-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (add item p3 links)';
	exit;
endif;
include_once($staticvars['local_root'].'modules/directory/system/dir_functions.php');
$extensions=$db->getquery("select extensions_allowed from items_types where cod_items_types='".mysql_escape_string($type)."'");
$address=strip_address($staticvars['local_root'],'type',$_SERVER['REQUEST_URI']);
$address=strip_address($staticvars['local_root'],'cod',$address);
$address=strip_address($staticvars['local_root'],'step',$address);
if ($message<>''):
	$message='&nbsp;&nbsp;<img src="'.$staticvars['site_path'].'/modules/directory/images/lite_warning.gif" width="15" height="16" border="0" />&nbsp;'.$message;
endif;
?>
<table border="0" align="left" >
	<tr>
	 <td>
	   <table border="0">
		 <tr>
		   <td width="23" height="23"><a href="<?=$address.'&step=1';?>"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" alt="1º Passo" width="23" height="23" border="0" /></a></td>
		   <td width="23" height="23"><a href="<?=$address.'&step=2';?>"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" alt="2º Passo" width="23" height="23" border="0" /></a></td>
		   <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_completed.jpg" alt="3º Passo" width="23" height="23" border="0" /></td>
	     </tr>
	   </table>
	  </td>
	</tr>
	<tr>
	<td ><div class="bxthdr">3 - Adicionar <?=$type_name;?>&nbsp;<font color="#FFFF00"><?=$message;?></font></div></td>
	</tr>
  <tr>
	<td>

		<table  border="0"  width="100%" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td colspan="2"><div align="left"><font class="form_title">Os campos marcados com <font size="1" color="#FF0000">&#8226;</font> s&atilde;o obrigatórios</font></div></td>
		  </tr>
		  <tr height="15">
			<td colspan="2"></td>
		  </tr>
		  <tr>
		    <td colspan="2" align="left"><font class="header_text_1">&nbsp; 1- Categoria </font><font size="3" color="#FF0000">&#8226;</font></td>
	      </tr>
		  <tr>
			<td width="4%" align="left"><br></td>
		    <td width="96%" align="left"><table border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php
			directory_listing($staticvars['local_root'],$type);
			?></td>
              </tr>
            </table></td>
		  </tr>
	  </table>
		<form action="<?=$address.'&cod='.$cod.'&type='.$type;?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_file_size*1000000;?>">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
		  <tr>
            <td colspan="2"><div align="left"><font class="header_text_1">&nbsp; 2- Nome / T&iacute;tulo</font><font size="3" color="#FF0000">&#8226;</font></div></td>
	      </tr>
		  <tr>
            <td width="4%">&nbsp;</td>
	        <td width="96%"><input type="text"  size="50" maxlength="255" name="titulo" value="<?=@$_POST['titulo'];?>" /></td>
		  </tr>
		  <tr>
		    <td align="left">&nbsp;</td>
	        <td align="left">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2" align="left">
			<font class="header_text_1">&nbsp; 3 - Endere&ccedil;o da P&aacute;gina externa </font><font size="3" color="#FF0000">&#8226;</font></td>
		  </tr>
		  <tr height="10">
			<td colspan="2"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		    <td><font class="body_text">Colocar o nome de endere&ccedil;o exacto (ex.: http://www.mysite.com) </font></td>
		  </tr>
		  <tr height="10">
			<td colspan="2"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		    <td><input type="text"  size="50" maxlength="255" name="link" value="<?=@$_POST['link'];?>" /></td>
		  </tr>
		  <tr height="10">
            <td colspan="2"></td>
	      </tr>
		  
		  <tr height="10">
            <td colspan="2"></td>
	      </tr>
		  
		  <tr>
            <td><div align="left"></div></td>
	        <td>&nbsp;</td>
		  </tr>
		  <tr>
            <td colspan="2"><div align="left"><font class="header_text_1">&nbsp; 4- Informa&ccedil;&atilde;o Opcional</font></div></td>
	      </tr>
		  <tr height="10">
            <td colspan="2"></td>
	      </tr>
		  <tr>
            <td><div align="left"><font class="body_text">&nbsp;</font></div></td>
	        <td><font class="body_text"> Escolha uma imagem que melhor descreva o recurso que deseja partilhar,e n&atilde;o se esque&ccedil;a de fazer uma breve descri&ccedil;&atilde;o.</font></td>
		  </tr>
		  <tr>
            <td><div align="left"></div></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
            <td align="left" class="body_text">&nbsp;</td>
	        <td align="left" class="body_text"><strong>Descri&ccedil;&atilde;o / Notas </strong></td>
		  </tr>
		  <tr>
            <td>&nbsp;</td>
	        <td><textarea name="descricao" cols="50" rows="5"><?=@$_POST['descricao'];?>
            </textarea></td>
		  </tr>
		  <tr>
            <td><div align="left"></div></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
			<td align="left">&nbsp;</td>
		    <td align="left"><font class="body_text"><strong>Imagem ilustrativa</strong>(<font color="#FF0000"> Jpeg</font>)</font></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		    <td><input type="file"  name="imagem" size="50" value="<?=@$_FILES['imagem']['name'];?>" /></td>
		  </tr>
		  <tr height="10">
			<td colspan="2"></td>
		  </tr>
		  <tr>
			<td colspan="2" align="right"><input type="hidden" value="<?=@$_POST['user_group'];?>" name="user_group" /><input type="image" src="<?=$staticvars['site_path'].'/images/buttons/'.$lang.'/';?>adicionar.gif" name="form_cat"></td>
		  </tr>
		</table>
		</form>
  </tr>
  <tr>
	<td height="15"></td>
  </tr>
</table>
