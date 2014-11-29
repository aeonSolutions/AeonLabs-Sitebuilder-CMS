<?php
/*
File revision date: 22-Set-2006
*/
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
if (isset($_GET['id'])):
	$task=$_GET['id'];
else:
	echo 'missing id';
	exit;
endif;
if(isset($_GET['cod'])):
	$cod=$_GET['cod'];
else:
	$cod=0;
endif;

if(isset($_POST['type'])):
	$type=$_POST['type'];
elseif(isset($_GET['type'])):
	$type=$_GET['type'];
// missing types verificaion
else:
	$type='';
endif;
if ($type<>''):
	$query=$db->getquery("select nome from items_types where cod_items_types='".mysql_escape_string($type)."'");
	if ($query[0][0]<>''):
		$type_name=$query[0][0];
	else:
		$type='';
	endif;
endif;
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
if (isset($_GET['step'])):
	$step=$_GET['step'];
else:
	$step='';
endif;
if (isset($_SESSION['user'])):
	$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
	if ($admin_code[0][0]<>''):
		$admin_code=$admin_code[0][0];
	else:
		$admin_code=-1;
		if ($type_name=='Modulos'):
			$type='';
			$type_name='';
		endif;
	endif;
	$user=$db->getquery("select cod_user, cod_user_type from users where nick='".$_SESSION['user']."'");
	if ($user[0][1]==$admin_code):
		$publish=return_id('ds_my_items.php');
		$admin=1;
	else:
		$admin='';
	endif;
else:
	$admin='';
endif;
?>
<style>
	div.bxthdr    {
		font : 11px Verdana,Arial,Helvetica,sans-serif;
		color : #ffffff;
		background-color : #6A94CC;
		border-bottom: 0px solid #10438F;
		height: 20px;
		}
</style>

<font class="header_text_3">Publica&ccedil;&atilde;o de Conte&uacute;dos   </font>
<br>
<table border="0" cellpadding="3" width="100%">
	  <tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/versele.gif" alt="vara&ccedil;&atilde;o de conte&uacute;dos" width="30" height="33" /></td>
		<td valign="top" class="header_text_2"><p>A Publica&ccedil;&atilde;o de conte&uacute;dos permite divulgar e partilhar recursos.</p></td>
	</tr>
</table><br />
<table border="0" cellpadding="3" width="100%" height="500">
  <tr>
	<td valign="top">
<?php
include($staticvars['local_root'].'modules/directory/system/settings.php');
if(!isset($_POST['add_item_p1']) and !isset($_POST['add_item_p3']) and !isset($_GET['cod']) or $type=='' or $step==1):
	include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p1.php');
elseif( (isset($_POST['add_item_p1']) or (isset($_POST['add_item_p3']) and $_GET['cod']=='' ) or 
(isset($_GET['cod']) and !isset($_POST['add_item_p3']) and !isset($_POST['titulo']) ) or $step==2) and $enable_directory==true ):
	include($staticvars['local_root'].'modules/directory/admin/add_item_p2.php');
elseif((isset($_POST['add_item_p3']) or $enable_directory==false or $step==3) and !isset($_POST['titulo'])):
	$message='';
		include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p3.php');
elseif(isset($_POST['titulo'])):
	if ($_POST['titulo']<>'' ):
		include($staticvars['local_root']."/modules/directory/update_db/manage.php");
		if ($message==''):
			//include($staticvars['local_root'].'modules/items/update_db/add_items_send_mail.php');
			include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_success.php');
		else:
			include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p3.php');
		endif;
	else:
		$message='<font color="#FF0000">Tem que preencher todos os campos obrigatórios!</font><br />';
		include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p3.php');
	endif;
else:
	$message='<font color="#FF0000">Tem que preencher todos os campos obrigatórios!</font><br />';
	include($staticvars['local_root'].'modules/directory/'.$lang.'/add_item_p3.php');
endif;
?>
</td></tr>
</table>
