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

if (isset($_GET['type'])):
	add_user_type($staticvars['local_root']);
else:
	$code=mysql_escape_string(@$_POST['ut']);
	if ($code<>''):
		$query=$db->getquery("select titulo, cod_alerts from alerts where cod_alerts='".$code."'");
		if ($query[0][0]<>''):
			edit_user_type($staticvars['local_root'],$code);
		endif;
	else:
		no_code();
	endif;
endif;
function no_code(){
?>
<table width="100%" height="140" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center">
	<font class="body_text">Seleccione uma op&ccedil;&atilde;o na DropBox acima de modo a poder visualizar os detalhes</font>
	</td>
  </tr>
  <tr>
    <td align="center">
	</td>
  </tr>
</table>
<?php
};

function edit_user_type($staticvars['local_root'],$mod){
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
$query_a=$db->getquery("select descricao, cod_alerts, active, titulo from alerts where cod_alerts='".$mod."'");
if ($query_a[0][0]==''):
	no_code();
	exit;
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
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td>
	<form method="post" action="<?=session($staticvars,'index.php?id='.$task.'&nav=modules/email_alerts/admin/alerts_management.php');?>"  enctype="multipart/form-data">
	<input type="hidden" name="cod_alerts" value="<?=$query_a[0][1];?>">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2" align="center">
		<font class="body_text"><strong>Código do aviso: <?=$query_a[0][1];?>,&nbsp;Aviso activado: <?=$pub;?></strong></font>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="header_text_1">Titulo</font><br />
			<input type="text" name="alert_title" value="<?=$query_a[0][3];?>" maxlength="255" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="15" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="header_text_1">Descricao</font><br />
			<textarea name="alert_desc" cols="40" rows="4"><?=$query_a[0][0];?>
			</textarea>
		</td>
	  </tr>
	  <tr>
		<td height="10" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$staticvars['site_path'].'/../images/buttons/'.$lang.'/';?>gravar.gif">
		</td>
	  </tr>
	  </table>
	  </form>
    </td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session($staticvars,'index.php?id='.$task.'&nav=modules/email_alerts/admin/alerts_management.php');?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="box_code" value="<?=$name;?>">
			<input name="apagar" src="<?=$staticvars['site_path'].'/../images/buttons/'.$value.'.gif';?>" type="image">
		</form>
	</td>
    <td valign="bottom" align="left">
		<form method="POST" action="<?=session($staticvars,'index.php?id='.$task.'&nav=modules/email_alerts/admin/alerts_management.php');?>" target="_parent">
		  &nbsp;&nbsp;<input type="hidden" name="del_box" value="<?=$query_a[0][1];?>">
			<input name="apagar" src="<?=$staticvars['site_path'].'/../images/buttons/'.$lang.'/';?>apagar.gif" type="image">
		</form>
    </td>
</table>
<?php	
};

function add_user_type ($staticvars['local_root'], $mod){
include($staticvars['local_root'].'kernel/staticvars.php');
?>
	<form method="post" action="<?=session($staticvars,'index.php?id='.$task.'&nav=modules/email_alerts/admin/alerts_management.php');?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2"><font class="header_text_1">Titulo</font><br />
			<input type="text" name="add_alert_title" maxlength="255" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="header_text_1">Descri&ccedil;&atilde;o</font><br />
			<textarea name="add_alert_desc" cols="40" rows="4"></textarea>
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$staticvars['site_path'].'/../images/buttons/'.$lang.'/';?>adicionar.gif">
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

