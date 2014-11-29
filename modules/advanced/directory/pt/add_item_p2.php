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
include_once($staticvars['local_root'].'modules/directory/system/dir_functions.php');
$address=strip_address($staticvars['local_root'],'type',$_SERVER['REQUEST_URI']);
$address=strip_address($staticvars['local_root'],'cod',$address);
$address=strip_address($staticvars['local_root'],'step',$address);
?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
		<tr>
		 <td>
		   <table border="0">
			 <tr>
			   <td width="23" height="23"><a href="<?=$address.'&step=1';?>"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" alt="1º Passo" width="23" height="23" border="0" /></a></td>
			   <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_completed.jpg" alt="2º Passo" width="23" height="23" border="0" /></td>
			   <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" alt="3º Passo" width="23" height="23" border="0" /></td>
			 </tr>
		   </table>
		</td>
		</tr>
		<tr>
		<td ><div class="bxthdr">2 - Categoria onde se insere o recurso <?=$type_name;?></div></td>
		</tr>
		 <tr>
		   <td class="header_text_1">
			<?php
			directory_listing($staticvars['local_root'],$type);
			?>
		  </td>
		 </tr>
		 <tr>
		   <td>
			<?php
			load_subcategories($staticvars['local_root'],$type);
			?>
		  </td>
		 </tr>
		 <tr>
		   <td>
			<form action="<?=$address.'&type='.$type.'&cod='.@$_GET['cod'];?>" enctype="multipart/form-data" method="post">
			  <div align="right">
			  <input type="hidden" value="<?=@$_POST['user_group'];?>" name="user_group" />
				<input type="submit" name="add_item_p3" value="Continuar" class="form_submit" />
			  </div>
			</form>
		  </td>
		 </tr>
	</table>
