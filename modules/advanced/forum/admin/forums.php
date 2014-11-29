<?php
/*
File revision date: 2-Out-2006
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
if(isset($_POST['forum_nome']) or isset($_POST['add_forum_nome']) or isset($_POST['forum_code']) or isset($_POST['del_forum'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
	include($staticvars['local_root'].'modules/forum/update_db/forums_setup.php');
endif;
$query=$db->getquery("select cod_cat, titulo from forum_cats where active='s'");
if ($query[0][0]==''):
	echo '<font class="body_text">Tem que ter pelo menos uma categoria activa</font>';
else:
	$address=strip_address('type',$_SERVER['REQUEST_URI']);
	?>
	<TABLE width="100%" height="550" border="0" cellPadding="0" cellSpacing="0">
	  <TBODY>
	  <TR>
		<TD valign="top">
		  <DIV class="main-box">
			<DIV class="main-box-title">Configura&ccedil;&atilde;o dos Forums</DIV>
			<DIV class="main-box-data">
				<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
				  <tr valign="top">
					<td align="center">
					<br>
						<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
					<font class="body_text">Forum&nbsp;</font><select size="1" name="ut" class="body_text">
					<?php
					$query=$db->getquery("select cod_cat, titulo from forum_cats where active='s'");
					$k=0;
					$option[$k][0]='';
					$option[$k][1]='-----------------';
					$k=1;
					if($query[0][0]<>''):
						for ($i=0;$i<count($query);$i++):
							$query2=$db->getquery("select cod_forum, nome from forum_forum where active='s' and cod_cat='".$query[$i][0]."'");
							$option[$k][0]="optgroup";
							$option[$k][1]=$query[$i][1];
							$k++;
							for ($j=0;$j<count($query2);$j++):
								$option[$k][0]=$query2[$j][0];
								$option[$k][1]='&nbsp;&nbsp;&nbsp;'.$query2[$j][1];
								$k++;
							endfor;
						endfor;
					endif;
					for ($i=0 ; $i<count($option); $i++):
						 if ($option[$i][0]=='optgroup'):
						 ?>
							<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
						 <?php
						 else:
							?>
							<option value="<?=$option[$i][0];?>"><?=$option[$i][1]; ?></option>
						<?php
						endif;
					endfor; ?>
				</select>&nbsp;&nbsp; 
						<input type="image" src="<?=$staticvars['site_path'].'/images/buttons/'.$lang;?>/ver.gif" name="user_input">
						</form>
					<hr class="gradient">
					<div class="dtree">
						<a href="<?=$address.'&type=add';?>" >Adicionar </a>
					</div>
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
						$query=$db->getquery("select cod_forum, nome from forum_forum where cod_forum='".$code."'");
						if ($query[0][0]<>''):
							edit_field($code,$staticvars);
						endif;
					else:
						if (isset($_GET['type'])):
							if($_GET['type']=='add'):
								add_field($staticvars);
							else:
								no_code($staticvars);
							endif;
						else:
							no_code($staticvars);
						endif;
					endif;
					  ?>
					</td>
				  </tr>
				</table>
			
			</DIV>
		  </DIV>
		  </TD>
		</TR>
		</TBODY>
	</TABLE>
<?php
endif;

function no_code($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
?>
	<font class="body_text">Seleccione uma op&ccedil;&atilde;o na DropBox acima de modo a poder visualizar os detalhes</font>
<?php
};

function edit_field($mod,$staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
$query_a=$db->getquery("select nome, cod_forum, active,descricao,auto_pruning, remove_topics, check_topics,cod_cat from forum_forum where cod_forum='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
	return;
endif;
if($query_a[0][2]=='s'):
	$pub='Sim';
	$name='unpublish';
	$value='nao_varar';
else:
	$name='publish';
	$value='varar';
	$pub='N&atilde;o';
endif;
if ($query_a[0][4]=='s'):
	$auto_p='checked';
else:
	$auto_p='';
endif;
$address=strip_address('mod',$_SERVER['REQUEST_URI']);
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form method="post" action="<?=$address.'&mod='.$mod;?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código do forum: <?=$query_a[0][1];?>,&nbsp;forum activo: <?=$pub;?></strong></font>
		</td>
	  </tr>
	  <tr>
		<td height="15" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Categoria</font>&nbsp;&nbsp;&nbsp;
		<select size="1" name="forum_cat" class="form_input">
			<?php
			$query=$db->getquery("select cod_cat, titulo from forum_cats");
			$selected=0;
			if($query[0][0]<>''):
				for ($i=0;$i<count($query);$i++):
					$option[$i][0]=$query[$i][0];
					$option[$i][1]=$query[$i][1];
					if ($query[$i][0]==$query_a[0][7]):
						$selected=$i;
					endif;
				endfor;
			endif;
			for ($i=0 ; $i<count($option); $i++):
				 if ($option[$i][0]=='optgroup'):
				 ?>
					<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
				 <?php
				 else:
					?>
					<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
					<?php echo $option[$i][1]; ?></option>
				<?php
				endif;
			endfor; ?>
		</select>&nbsp;&nbsp; 
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="forum_nome" value="<?=$query_a[0][0];?>" maxlength="255" size="40" class="form_input">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Descri&ccedil;&atilde;o</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_forum_descricao" value="<?=$query_a[0][3];?>" maxlength="255" size="40" class="form_input">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<input type="checkbox" name="add_forum_pruning" class="form_input" <?=$auto_p;?>>
			&nbsp;<font class="body_text">Activar Auto Pruning</font>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Verificar tópicos a cada &nbsp;&nbsp;&nbsp;
			<input type="text" name="add_forum_check" maxlength="255" value="<?=$query_a[0][5];?>"  size="4" class="form_input">
			&nbsp;&nbsp;&nbsp;dias</font>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Remover tópicos com mais de &nbsp;&nbsp;&nbsp;
			<input type="text" name="add_forum_remove" value="<?=$query_a[0][6];?>" maxlength="255" size="4" class="form_input">
			&nbsp;&nbsp;&nbsp;dias</font>
		</td>
	  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$staticvars['site_path'];?>/images/buttons/pt/gravar.gif">
		</td>
	  </tr>
	  </table>
	  </form>
    </td>
    <td valign="bottom" align="center">
		<form method="POST" action="<?=$address.'&mod='.$mod;?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="forum_code" value="<?=$name;?>">
			<input name="apagar" src="<?=$staticvars['site_path'].'/images/buttons/pt/'.$value.'.gif';?>" type="image">
		</form>
	</td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=$address.'&mod='.$mod;?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="forum_del" value="<?=$query_a[0][1];?>">
			<input name="apagar" src="<?=$staticvars['site_path'];?>/images/buttons/pt/apagar.gif" type="image">
		</form>
    </td>
  </tr>
</table>
<?php	
};
function add_field($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
if (isset($_GET['file'])):
	$fil=@$_GET['file'];
	$nam=explode(".",$fil);
	$nam=$nam[0];
	$nam=str_replace("_"," ",$nam);
else:
	$fil='';
endif;
?>
	<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Categoria</font>&nbsp;&nbsp;&nbsp;
		<select size="1" name="add_forum_cat" class="form_input">
			<?php
			$query=$db->getquery("select cod_cat, titulo from forum_cats");
			$selected=0;
			if($query[0][0]<>''):
				for ($i=0;$i<count($query);$i++):
					$option[$i][0]=$query[$i][0];
					$option[$i][1]=$query[$i][1];
					if ($query[$i][0]==$user):
						$selected=$i;
					endif;
				endfor;
			endif;
			for ($i=0 ; $i<count($option); $i++):
				 if ($option[$i][0]=='optgroup'):
				 ?>
					<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
				 <?php
				 else:
					?>
					<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
					<?php echo $option[$i][1]; ?></option>
				<?php
				endif;
			endfor; ?>
		</select>&nbsp;&nbsp; 
		</td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_forum_nome" maxlength="255" size="40" class="form_input">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Descri&ccedil;&atilde;o</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_forum_descricao" maxlength="255" size="40" class="form_input">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<input type="checkbox" name="add_forum_active" class="form_input">
			&nbsp;<font class="body_text">Activar a nova categoria</font>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<input type="checkbox" name="add_forum_pruning" class="form_input">
			&nbsp;<font class="body_text">Activar Auto Pruning</font>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Verificar tópicos a cada &nbsp;&nbsp;&nbsp;
			<input type="text" name="add_forum_check" maxlength="255" size="4" class="form_input">
			&nbsp;&nbsp;&nbsp;dias</font>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Remover tópicos com mais de &nbsp;&nbsp;&nbsp;
			<input type="text" name="add_forum_remove" maxlength="255" size="4" class="form_input">
			&nbsp;&nbsp;&nbsp;dias</font>
		</td>
	  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$staticvars['site_path'];?>/images/buttons/pt/adicionar.gif">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  </table>
	  </form>
<?php
};

?>