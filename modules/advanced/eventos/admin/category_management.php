<?php
/*
File revision date: 1-Set-2006
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
$cod_categoria=0;
if(isset($_POST['cat_name']) or isset($_POST['add_cat_name']) or isset($_POST['cat_code']) or isset($_POST['del_cat'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
	include($staticvars['local_root'].'modules/eventos/update_db/category_management.php');
endif;
$query=$db->getquery("select cod_categoria, nome from eventos_categorias where cod_categoria='".$cod_categoria."'");
if ($query[0][0]<>''):
	$cat_name=$query[0][1];
else:
	$cat_name='raiz';
endif;
?>
<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/core/java/dtree.css" type="text/css" />
<br />
<h3><img src="<?=$staticvars['site_path'].'/modules/eventos';?>/images/icone_gestao.gif" width="24" height="24" />Manuten&ccedil;&atilde;o de Categorias de eventos</h3>
<br />
<br />
<TABLE width="100%" height="500" border="0" cellPadding="0" cellSpacing="0">
  <tr valign="top" height="10">
	<td align="center">
		<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
		Categoria em que se encontra actualmente: <strong><?=$cat_name;?></strong>
        <hr class="gradient">
		<font class="body_text">Ver Categorias existentes:&nbsp;</font><select size="1" name="cat" class="form_input">
			<?php
			$query=$db->getquery("select cod_categoria, nome from eventos_categorias where cod_sub_cat='".$cod_categoria."'");
			$option[0][0]='';
			$option[0][1]='-----------------';
			if($query[0][0]<>''):
				for ($i=0;$i<count($query);$i++):
					$option[$i+1][0]=$query[$i][0];
					$option[$i+1][1]=$query[$i][1];
				endfor;
			endif;
			for ($i=0 ; $i<count($option); $i++):
				?>
				<option value="<?php echo $option[$i][0];?>" ><?=$option[$i][1];?></option>
				<?php
			endfor; ?>
		</select>&nbsp;<input type="submit" value="Ver" class="form_submit" name="user_input">
		<br />
		<br />
		<img src="<?=$staticvars['site_path'];?>/modules/eventos/images/add.gif" width="24" height="22" /><a class="body_text" href="<?=$_SERVER['REQUEST_URI'].'&type=add&cat='.$cod_categoria;?>" >Adicionar nova categoria dentro desta categoria</a>
		<hr class="gradient">
		</form>
	</td>
  </tr>
  <tr>
	<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$staticvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
  </tr>
  <tr valign="top" height="100%">
	<td>
	<?php
	if ($cod_categoria<>''):
		$query=$db->getquery("select cod_categoria from eventos_categorias where cod_categoria='".$cod_categoria."'");
		if (isset($_GET['type'])):
			if($_GET['type']=='add'):
				add_field($staticvars,$cod_categoria);
				//echo '<br /><br /><strong>Categorias Existentes</strong><br />';
				//put_files($staticvars['local_root'],$cod_categoria);
			else:
				no_code($staticvars,$cod_categoria);
			endif;
		elseif ($query[0][0]<>''):
			edit_field(mysql_escape_string($_GET['mod'],$staticvars);
		else:
			no_code($staticvars,$cod_categoria);
		endif;
	else:
		no_code($staticvars,$cod_categoria);
	endif;
	  ?>
	</td>
  </tr>
</table>

<?php
function no_code($staticvars,$mod){
include($staticvars['local_root'].'kernel/staticvars.php');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" height="50">
	<font class="body_text">Seleccione uma op&ccedil;&atilde;o na DropBox acima de modo a poder visualizar as SubCategorias</font>
	</td>
  </tr>
  <tr>
    <td align="center">
	<?php
		//put_files($staticvars['local_root'],$mod);
	?>
	</td>
  </tr>
</table>
<?php
};

function edit_field($mod,$staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;

$query_a=$db->getquery("select cod_categoria, active,nome,descricao from eventos_categorias where cod_categoria='".$mod."'");
if($query_a[0][1]=='s'):
	$pub='Sim';
	$name='Desactivar';
	$value='nao_publicar';
else:
	$name='Activar';
	$value='publicar';
	$pub='N&atilde;o';
endif;
$address=str_replace("&mod=".$mod,"",$_SERVER['REQUEST_URI']);
?>
	<strong>Editar Categoria</strong>
    <form method="post" action="<?=$address.'&mod='.$mod;?>"  enctype="multipart/form-data">
      <table border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$staticvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
      </tr>
        <tr>
          <td  align="center"><font class="body_text"><strong>C&oacute;digo da categoria:
            <?=$query_a[0][0];?>
            ,&nbsp;Categoria activa:
            <?=$pub;?>
          </strong></font> </td>
        </tr>
        <tr>
          <td height="15" ></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><font class="body_text">Nome </font>&nbsp;&nbsp;&nbsp;
              <input type="text" name="cat_name" class="body_text" value="<?=$query_a[0][2];?>" maxlength="23" size="23" />&nbsp;(Max 23 letras)</td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
<?php
/*
        <tr>
          <td colspan="2"><font class="body_text">Traduções:</font>&nbsp;&nbsp;&nbsp;
              <input type="text" name="cat_disp_name" value="<?=$query_a[0][3];?>" maxlength="255" size="40" />
              <br />
            ex.: en=calendar||pt=calend&aacute;rio </td>
        </tr>
		*/
		?>
        <tr>
          <td align="right" valign="bottom"><input name="estado" type="submit" class="form_submit" value="<?=$name;?>"/>
            <input type="hidden" name="cat_code" value="<?=$name;?>" />
            <input name="apagar" type="submit" class="form_submit" value="Apagar"/>
            <input type="hidden" name="del_cat" value="<?=$query_a[0][1];?>" />
            <input name="add_sub_menu2" type="submit" value="Gravar" class="form_submit" />          </td>
        </tr>
      <tr>
        <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$staticvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
      </tr>
      </table>
</form>
<br />
<?php	
//put_files($staticvars['local_root'],$mod);
};

function add_field($staticvars,$mod){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
$address=str_replace("&mod=".$mod,"",$_SERVER['REQUEST_URI']);
?>
<strong>Adicionar Categoria</strong>
<form method="post" action="<?=$address.'&mod='.$mod;?>"  enctype="multipart/form-data">
  <div align="center"><font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
    <input type="text" name="add_cat_name" value="" size="23" maxlength="23">
    &nbsp;(Max 23 letras)&nbsp;&nbsp;
    <input name="add_sub_menu" type="submit" value="Adicionar" class="form_submit">
  </div>
</form>

<?php
};

function put_files($staticvars,$mod){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (!isset($_GET['id'])):
	$task=-1;
endif;
$address=str_replace("&cat=".$mod,"",$_SERVER['REQUEST_URI']);
$address=strip_address("type",$address);
?>
<table border="0" height="50" align="center">
  <tr>
    <td style="BORDER-RIGHT: lightsteelblue 1px solid; BORDER-TOP: lightsteelblue 1px solid; MARGIN: 0px; OVERFLOW: hidden; BORDER-LEFT: lightsteelblue 1px solid; BORDER-BOTTOM: lightsteelblue 1px solid;">
	<div align="left"><font size="1" font="verdana" color="#2c4563">[+] <a href="<?=$address.'&cat=0';?>">Raiz</a></font></div>
	<?php
	if ($mod<>''):
		$ct=$mod;
		$i=0;
		$res[0][0]='';
		$query=$db->getquery("select cod_categoria, nome, cod_sub_cat from eventos_categorias where cod_categoria=".$ct);
		while ($query[0][0]<>'0' and $query[0][0]<>''):
			$query=$db->getquery("select cod_categoria, nome, cod_sub_cat from eventos_categorias where cod_categoria=".$ct);
			if ($query[0][0]<>'0' and $query[0][0]<>''):
				$res[$i]=$query[0];
				$ct=$query[0][2];
				$i++;
			endif;
		endwhile;
		if ($res[0][0]<>''):
			$idt='&nbsp;&nbsp;&nbsp;';
			for ($i=count($res)-1; $i>=0;$i--):
				echo '<div align="left"><font size="1" font="verdana" color="#2c4563">'.$idt.'[+] <a href="'.$address.'&cat='.$res[$i][0].'">'.$res[$i][1].'</a></font></div>';
				$idt=$idt.'&nbsp;&nbsp;&nbsp;';
			endfor;
		endif;
	endif;
	?>
	</td>
    <td style="BORDER-RIGHT: lightsteelblue 1px solid; BORDER-TOP: lightsteelblue 1px solid; MARGIN: 0px; OVERFLOW: hidden; BORDER-LEFT: lightsteelblue 1px solid; BORDER-BOTTOM: lightsteelblue 1px solid;">
	<?php
	$query=$db->getquery("select cod_categoria, nome from eventos_categorias where cod_sub_cat='".$mod."' order by nome");
	if ($query[0][0]==''):
		?>
		<table align="center"valign="top"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" class="body_text"><strong>N&atilde;o existem subcategorias</strong></td>
		  </tr>
		</table>
		<?php
	else:
		?>
		<table align="center" valign="top" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" class="body_text"><strong>Clique numa categoria para editar</strong></td>
		  </tr>
		<?php
		$j=1;
		$i=0;
		while ($i<count($query)):
			?>
			<tr>
			  <td width="50%"><div align="left"><a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: smaller; font-weight:bold;" href="<?=$address.'&cat='.$query[$i][0];?>"><?=$query[$i][1];?></a></div></td>
				<? if (isset($query[$i+1])): ?>
				  <td width="50%"><div align="left"><a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: smaller; font-weight:bold;" href="<?=$address.'&cat='.$query[$i+1][0];?>"><?=$query[$i+1][1];?></a></div></td>
				<? else:?>
				  <td width="50%"></td>
				<? endif;?>
			</tr>
			<tr>
			  <td colspan="2" height="5">
			  </td>
			</tr>
			<tr>
			<?php
			$query2=$db->getquery("select cod_categoria, nome from eventos_categorias where cod_sub_cat='".$query[$i][0]."' order by nome asc limit 0,7");
			if ($query2[0][0]<>''):
				?>
				<td align="center" valign="top" width="50%"><div align="left">
				<?php
				for($k=0;$k<count($query2);$k++):
					?>
					<a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: xx-small; font-weight:normal;" href="<?=$address.'&cat='.$query2[$k][0];?>"><?=$query2[$k][1];?></a>
					<?php
				endfor;
				?>
				<font style="font:arial; color:#0033ff; fontosize:xx-small; ">...</font></div></td>
				<?php
			else:
				?>
				<td width="50%"><div align="left"></div></td>
				<?php
			endif;
			if (isset($query[$i+1])):
				$query3=$db->getquery("select cod_categoria, nome from eventos_categorias where cod_sub_cat='".$query[$i+1][0]."' order by nome asc limit 0,7");
				if ($query3[0][0]<>''):
					?>
					<td align="center" valign="top" width="50%"><div align="left">
					<?php
					for($k=0;$k<count($query3);$k++):
						if ($k==count($query3)-1):
							?>
							<a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: xx-small; font-weight: normal;" href="<?=$address.'&cat='.$query3[$k][0];?>"><?=$query3[$k][1];?></a>
							<?php
						else:
							?>
							<a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: xx-small; font-weight: normal;" href="<?=$address.'&cat='.$query3[$k][0];?>"><?=$query3[$k][1];?>,</a>&nbsp;
							<?php
						endif;
					endfor;
					?>
					<font style="font:arial; color:#0033ff; fontosize:xx-small; ">...</font></div></td>
					<?php
				else:
					?>
					<td width="50%"><div align="left"></div></td>
					<?php
				endif;
			else:
				?>
				<td width="50%"><div align="left"></div></td>
				<?php
			endif;
			?>
			</tr>
			<?php
			$i=$i+2;
			?>
			<tr>
			  <td height="10"></td>
		  </tr>
			<?php
		endwhile;
		?>
		</table>
		<?php
	endif;
?>
	</td>
  </tr>
</table>
<?php
};
?>
