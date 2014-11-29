<?php
/*
File revision date: 18-jul-2008
*/
include($globvars['site']['directory'].'kernel/staticvars.php');


$code=mysql_escape_string(@$_GET['menu']);
$mod=mysql_escape_string(@$_GET['mod']);
if ($code<>''):
	$query=$db->getquery("select name, cod_user_type, cod_menu, link, active,cod_module,cod_sub_menu from menu where cod_menu='".$code."'");
	if ($query[0][0]<>''):
		list_module_details($globvars,$code);
	else:
		no_code();
	endif;
elseif ($mod<>''):
	edit_module($globvars,$mod);
else:
	no_code();	
endif;

function list_module_details($globvars,$code){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$globvars['language']['main'];
endif;

$query=$db->getquery("select name, cod_user_type, cod_menu, link, active,cod_module,cod_sub_menu,display_name from menu where cod_menu='".$code."'");
$query2=$db->getquery("select link from module where cod_module='".$query[0][5]."'");
include($globvars['site']['directory'].'kernel/settings/menu.php');
if ($menu_type=='dynamic'):
	$user=$db->getquery("select name from user_type where cod_user_type='".$query[0][1]."'");
else:
	$user[0][0]='Static menu selected';
endif;
if($query[0][4]=='s'):
	$t[0]='unpublish';
	$t[1]='nao_publicar';
else:
	$t[0]='publish';
	$t[1]='publicar';
endif;
if ($query[0][6]=='0'):
	$type='Menu';
	$menu[0][0]=' - - ';
else:
	$type='Submenu';
	$menu=$db->getquery("select name from menu where cod_menu='".$query[0][6]."'");
endif;
if($query[0][7]<>'' and $query[0][7]<>'N/A'):
	$pipes=explode("||",$query[0][7]);
	$display_name='';
	for($i=0; $i<count($pipes);$i++):
		$names=explode("=",$pipes[$i]);
		$display_name.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.$globvars['site_path'].'/images/flags/'.$names[0].'.gif"> '.$names[1].'<br>';
	endfor;
else:
	$display_name=$query[0][0];
endif;
?>
<table border="0" cellspacing="0" cellpadding="0" width="400" align="center">
  <tr>
    <td>
	<font class="header_text_1"><?=$type;?>:&nbsp;</font>
	<font class="body_text"><?=$query[0][0];?></font>
	</td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Código menu na DB:&nbsp;</font>
	<font class="body_text"><?=$code;?></font>
	</td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Menu Associado:&nbsp;</font>
	<font class="body_text"><?=$menu[0][0];?></font>
	</td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Tipo utilizador autorizado:&nbsp;</font>
	<font class="body_text"><?=$user[0][0];?></font>
	</td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Link:&nbsp;</font>
	<font class="body_text"><?=$query[0][3];?></font>
	</td>
  </tr>
  <tr>
    <td>
	<font class="header_text_1">Módulo:&nbsp;</font>
	<font class="body_text"><?=$query2[0][0];?> (<?=$query[0][5];?>)</font>
	</td>
  </tr>
  <tr>
    <td><font class="header_text_1">Display Names:&nbsp;</font><br><font class="body_text">
      <?=$display_name;?>
    </font> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">
	<table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
			<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$code.'&ut='.$query[0][1]);?>" target="_parent">
				<input type="hidden" name="mod_del" value="<?=$t[0];?>">
				<input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/en';?>/apagar.gif" type="image">
			</form>
		</td>
		<td>&nbsp;
		
		</td>
        <td>
			<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?type=editmenu&ut='.$query[0][1].'&id='.$task.'&mod='.$code);?>" target="_self">
				<input name="editar" src="<?=$globvars['site_path'].'/images/buttons/en';?>/editar.gif" type="image">
			</form>
		</td>
		<td>&nbsp;
		
		</td>
        <td>
			<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&type=editmenu&mod='.$code.'&ut='.$query[0][1]);?>" target="_parent">
				<input name="varacao" src="<?=$globvars['site_path'].'/images/buttons/en';?>/<?=$t[1];?>.gif" type="image">
				<input type="hidden" name="<?=$t[0];?>" value="<?=$t[0];?>">
			</form>
		</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<?php
};

function no_code(){
?>
<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center">
	<font class="body_text">Seleccione uma op&ccedil;&atilde;o no menu lateral de modo a poder visualizar os detalhes</font>
	</td>
  </tr>
</table>
<?php
};

function edit_module($globvars,$mod){
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
$query_a=$db->getquery("select name, cod_user_type, cod_menu, link, active,cod_module,cod_sub_menu,aditional_params,display_name from menu where cod_menu='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
else:
	if ($query_a[0][6]<>'0'):
		$add='submenu';
	else:
		$add='menu';
	endif;
endif;

if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;

?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<font class="header_text_1">Op&ccedil;&atilde;o Editar <?=$add;?></font>
	</td>
  </tr>
</table>
<form name="form_menu" id="form_menu" method="post" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>"  enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0" align="center">
<?php
$ut=$query_a[0][1];
include($globvars['site']['directory'].'kernel/settings/menu.php');
if ($add=='submenu'):
if ($menu_type=='dynamic'):
	$query=$db->getquery("select cod_user_type, name from user_type where cod_user_type='".$ut."'");
	$ut_type=$query[0][1];
	$query=$db->getquery("select cod_menu, name from menu where cod_sub_menu=0 and cod_user_type='".$ut."'");
else:
	$ut_type='Static menu selected';
	$query=$db->getquery("select cod_menu, name from menu where cod_sub_menu=0");
endif;
	$selected7=0;
	$option7[0][0]='none';
	$option7[0][1]='---------------------------------------';
	for ($i=0;$i<count($query);$i++):
		$option7[$i][0]=$query[$i][0];
		$option7[$i][1]=$query[$i][1];
		if ($query[$i][0]==$query_a[0][6]):
			$selected7=$i;
		endif;
	endfor;
	$query=$db->getquery("select cod_module, name, link from module order by link");
	// a query tem que ser sempre nesta forma senao da erro! : select cod_module, name, link from module
	$option1=build_drop_module($query,$task,$globvars['site_path']);
	$selected=0;
	for($i=0;$i<count($option1);$i++):
		if ($option1[$i][0]==$query_a[0][5]):
			$selected=$i;
		endif;
	endfor;
	?>
	  <tr>
		<td>
		<font class="body_text"><strong>Utilizador tipo: <?=$ut_type;?></strong></font>
		</td>
	  </tr>
	  <tr>
		<td height="15"></td>
	  </tr>
	<tr>
	<td align="center" valign="middle">
		<input type="hidden" name="edit_usertype" value="<?=$ut;?>">
		<font class="body_text">Pertence ao menu</font>&nbsp;&nbsp;&nbsp;
		<select size="1" name="edit_submenu_type" class="form_input">
			<?php
			for ($i=0 ; $i<count($option7); $i++):
				?>
				<option value="<?=$option7[$i][0];?>" <?php if ($selected7==$i){?>selected<?php } ?>>
				<?php echo $option7[$i][1]; ?></option>
				<?php
			endfor; ?>
		</select>
	</td>
	</tr>
	<?php	
elseif ($add='menu'):  // $add=='menu'
	if($menu_type=='dynamic'):
		$query=$db->getquery("select cod_user_type, name from user_type");
		$selected=0;
		$option5[0][0]='none';
		$option5[0][1]='---------------------------------------';
		for ($i=0;$i<count($query);$i++):
			$option5[$i][0]=$query[$i][0];
			$option5[$i][1]=$query[$i][1];
			if ($option5[$i][0]==$query_a[0][1]):
				$selected=$i;
			endif;
		endfor;
	else:
		$selected=0;
		$option5[0][0]='-1';
		$option5[0][1]='Static menu selected';
	endif;
	?>
	<tr>
	<td align="center" valign="middle">
		<font class="body_text">Visivel aos utilizadores do tipo</font>&nbsp;&nbsp;&nbsp;
		<select size="1" name="edit_usertype" class="form_input">
			<?php
			for ($i=0 ; $i<count($option5); $i++):
				?>
				<option value="<?=$option5[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
				<?php echo $option5[$i][1]; ?></option>
				<?php
			endfor; ?>
		</select>
	</td>
	</tr>
<?php
endif;
$query=$db->getquery("select cod_module, name, link from module order by link");
// a query tem que ser sempre nesta forma senao da erro! : select cod_module, name, link from module
$option1=build_drop_module($query,$task,$globvars['site_path']);
$selected=0;
for($i=0;$i<count($option1);$i++):
	if ($option1[$i][0]==$query_a[0][5]):
		$selected=$i;
	endif;
endfor;
?>
  <tr>
	<td height="10"></td>
  </tr>
  <tr>
	<td>
		<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
		<input type="text" name="edit_submenu_name" value="<?=$query_a[0][0];?>" maxlength="255" size="40">
	</td>
  </tr>
  <tr>
	<td height="10"></td>
  </tr>
  <tr>
	<td>
		<font class="body_text">Módulo</font>&nbsp;&nbsp;&nbsp;
		<select size="1" name="edit_submenu_module" class="form_input">
			<?php
			for ($i=0 ; $i<count($option1); $i++):
				 if ($option1[$i][0]=='optgroup'):
				 ?>
					<optgroup disabled label="<?=$option1[$i][1];?>"></optgroup>
				 <?php
				 else:
					?>
					<option value="<?php echo $option1[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
					<?php echo $option1[$i][1]; ?></option>
				<?php
				endif;
			endfor; ?>
		</select>
	</td>
  </tr>
  <tr>
	<td height="10"></td>
  </tr>
  <tr>
	<td>
		<font class="body_text">Parâmetros adicionais</font>&nbsp;&nbsp;&nbsp;
		<input type="text" name="edit_submenu_params" maxlength="255" size="40" value="<?=$query_a[0][7];?>">
	</td>
  </tr>
	  <tr>
		<td>
			<font class="body_text">Pré-definidos</font>&nbsp;&nbsp;&nbsp;
			<select name="pre_params" size="1" class="form_input"  onchange="document.form_menu.edit_submenu_params.value= document.form_menu.pre_params.options[document.form_menu.pre_params.selectedIndex].value">
			  <option value="&dirname&goto=">&amp;dirname=&amp;goto=</option>
			  <option selected="selected">Select one</option>
		      </select>
		</td>
	  </tr>
  <tr>
	<td height="10"></td>
  </tr>
  <tr>
	<td>
		<font class="body_text">Ou<br>
		Op&ccedil;&atilde;o Link</font>&nbsp;&nbsp;&nbsp;
		<input type="text" name="edit_submenu_link" value="<?=$query_a[0][3];?>" maxlength="255" size="40">
	</td>
  </tr>

	  <tr>
		<td>
			<font class="body_text">Pré-definidos</font>&nbsp;&nbsp;&nbsp;
			<select name="pre_links" size="1" class="form_input" onchange="document.form_menu.edit_submenu_link.value= document.form_menu.pre_links.options[document.form_menu.pre_links.selectedIndex].value">
			  <option value="index.php">index.php</option>
			  <option value="index.php?logout=-1">index.php?logout=-1</option>
			  <option>Select one</option>
          </select>
		</td>
	  </tr>
  <tr>
	<td height="10"></td>
  </tr>
  <tr>
	<td class="body_text" align="left">
		ex:pt=P&aacute;g.Inicial||en=Home<br>Display Name:
		<input type="text" name="edit_submenu_disp_name" value="<?=$query_a[0][8];?>" maxlength="255" size="40">
	</td>
  </tr>
  <tr>
	<td height="10"></td>
  </tr>
  <tr>
	<td align="right">
	  <input name="edit_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang;?>/gravar.gif">
	</td>
  </tr>
  </table>
  </form>
<?php
};

function build_drop_module($query,$task,$site_path){
// a query tem que ser sempre nesta forma senao da erro! 
//       : select cod_module, name, link from module order by link
	$option[0][0]='--';
	$option[0][1]='------------------------------------';
	$t[0]='';
	$t[1]='';
	$k=1;
	for ($i=1;$i<=count($query);$i++):
		$last_t=$t;
		$t=explode("/",$query[$i-1][2]);
		if (!isset($t[1])):
			$t[1]="ModulesRoot";
		endif;
		if ($t[0]<>$last_t[0]):
			$option[$k][0]='optgroup';
			$option[$k][1]=$t[0];
			$k++;
		endif;
		$option[$k][0]=$query[$i-1][0];
		$option[$k][1]='&nbsp;&nbsp;&nbsp;&nbsp;'.$query[$i-1][1].' @ '.$t[1];
		$k++;
	endfor;
return $option;
};
