<?php
/*
File revision date: 11-jul-2007
*/
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
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
$code=mysql_escape_string(@$_GET['ut']);
if (isset($_POST['ut'])):
	$code=mysql_escape_string($_POST['ut']);
else:
	$code=mysql_escape_string(@$_GET['ut']);
endif;
if(isset($_POST['desc_valor']) or isset($_POST['del'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
	include($staticvars['local_root'].'modules/produtos/update_db/descontos_management.php');
endif;
$address=strip_address("type",$_SERVER['REQUEST_URI']);
$txt='<a href="'.$address.'&type=add" >Adicionar </a>';
?>
<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/core/java/dtree.css" type="text/css" />
      <DIV class="main-box">
      	<DIV class="main-box-title">Gest&atilde;o de Descontos</DIV>
		<DIV class="main-box-data">
			<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0" height="350">
			  <tr valign="top">
			    <td align="center">
				<br>
					<form method="post" action="<?=$address;?>" enctype="multipart/form-data">
					<select size="1" name="ut" class="form_input">
						<?php
							$query=$db->getquery("select cod_desconto, valor, descricao from produtos_desconto");
							$selected=0;
							$option[0][0]='';
							$option[0][1]='-----------------';
							if($query[0][0]<>''):
								for ($i=0;$i<count($query);$i++):
									$option[$i+1][0]=$query[$i][0];
									$option[$i+1][1]=$query[$i][2];
									if ($query[$i][0]==$user):
										$selected=$i;
									endif;
								endfor;
							endif;

						for ($i=0 ; $i<count($option); $i++):
							?>
							<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
							<?=$option[$i][1];?></option>
							<?php
						endfor; ?>
					</select>&nbsp;&nbsp; 
					<input class="form_submit" value=" ver " type="submit" name="user_input">
					</form>
				<hr class="gradient">
				<div class="dtree"><?=$txt;?></div>
				<hr class="gradient">
				</td>
			  </tr>
			  <tr>
			    <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$staticvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
		      </tr>
			  <tr valign="top">
			    <td>
				<?php
				if ($code<>''):
					$query=$db->getquery("select cod_desconto, valor, descricao from produtos_desconto where cod_desconto='".$code."'");
					if ($query[0][0]<>''):
						edit_field($code,$staticvars);
					endif;
				else:
					if (isset($_GET['type'])):
						if($_GET['type']=='add'):
							add_field($staticvars);
						endif;
					endif;
				endif;
				  ?>
				</td>
			  </tr>
			</table>
		</DIV>
	  </DIV>

<?php

function edit_field($mod,$staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$query_a=$db->getquery("select cod_desconto, valor, descricao from produtos_desconto where cod_desconto='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
	return;
endif;
$address=strip_address("mod",$_SERVER['REQUEST_URI']);
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form method="post" action="<?=$address.'&mod='.$mod;?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código Desconto: <?=$query_a[0][0];?></strong></font>		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Descri&ccedil;&atilde;o</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="desc_descricao" value="<?=$query_a[0][2];?>" maxlength="255" size="40">		</td>
	  </tr>
	  <tr>
		<td height="15" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Valor (% ou &euro;)</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="desc_valor" value="<?=$query_a[0][1];?>" maxlength="255" size="40">		</td>
	  </tr>
	  <tr>
	    <td align="right">&nbsp;</td>
	    </tr>
	  <tr>
		<td align="right">
		  <input name="edit" type="submit" class="form_submit" value="Gravar">		</td>
	  </tr>
	  </table>
	  </form>    </td>
    <td valign="bottom" align="left">
		<form method="post" action="<?=$address.'&mod='.$mod;?>"  enctype="multipart/form-data">
		  &nbsp;&nbsp;<input type="hidden" name="del_desc" value="<?=$query_a[0][0];?>">
			<input name="del" type="submit" class="form_submit" value="Apagar">
		</form>
    </td>
  </tr>
</table>
<?php	
};

function add_field($staticvars){
$address=strip_address("mod",$_SERVER['REQUEST_URI']);
?>
	<form method="post" action="<?=$address;?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Descrição</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="desc_descricao" maxlength="255" value="" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Valor (% ou &euro;)</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="desc_valor" maxlength="255" value="%" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
			<input name="add" type="submit" class="form_submit" value="Adicionar">
		</td>
	  </tr>
	  </table>
	  </form>

<?php
};

?>
