<?php
/*
File revision date: 5-Apr-2007
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found(Wizard Users)';
	exit;
endif;
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
$code=mysql_escape_string(@$_GET['ut']);
if (isset($_POST['ut'])):
	$code=mysql_escape_string($_POST['ut']);
else:
	$code=mysql_escape_string(@$_GET['ut']);
endif;
if(isset($_POST['menu_nome']) or isset($_POST['add_menu_nome']) or isset($_POST['menu_code']) or isset($_POST['del_menu'])):
	include($local_root.'general/staticvars.php');
	include($local_root.'update_db/user_groups_setup.php');
endif;
?>
<link rel="StyleSheet" href="<?=$site_path;?>/core/java/dtree.css" type="text/css" />
	<?php
include($local_root.'kernel/settings/ums.php');
if($ug_type=='dynamic'):
	add_field($local_root);
else:
	 echo '<div align="center"><hr class="gradient"><img src="'.$site_path.'/images/info.png" alt="info" /><font class="body_text">The User Management System is disabled.<br />To change, go back to step nº2.</font><hr class="gradient"></div>';
	$address=strip_address($local_root,"step",$_SERVER['REQUEST_URI']);
	?>
		<div align="right"><form action="<?=$address;?>" enctype="multipart/form-data" method="post">
		<input name="continue" type="submit" class="form_submit" id="continue" value="Continue Wiz"></form></div>
	<?php
endif;
	?>

<?php
function add_field($local_root){
include($local_root.'general/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
?>
<form method="post" action="<?=session_setup($globvars,$site_path.'/index.php?id='.$task);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Name</font>&nbsp;&nbsp;
		    <input type="text" name="add_username" maxlength="255" value="" size="40">		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
	    <td align="right">
		<font class="body_text">This group is managed by</font>
		<select size="1" name="add_user_groups" class="form_input">
			<?php
			$query=$db->getquery("select cod_user_type, name from user_type");
			$disabled=0;
			for ($i=0;$i<=count($query);$i++):
				$option[$i][0]=$query[$i][0];
				$option[$i][1]=$query[$i][1];
				if ($query[$i][1]=='Authenticated Users'):
					$disabled=$i;
				endif;
			endfor;
			for ($i=0 ; $i<count($option); $i++):
				 if ($disabled==$i):
				 ?>
					<option value="<?php echo $option[$i][0];?>" selected="selected"><?=$option[$i][1]; ?></option>
				 <?php
				 else:
					?>
					<option value="<?php echo $option[$i][0];?>"><?=$option[$i][1]; ?></option>
				<?php
				endif;
			endfor; ?>
		</select>
</td>
      </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$site_path.'/images/buttons/'.$lang;?>/adicionar.gif"></td>
	  </tr>
  </table>
</form>

<?php
};

function val_ut($name){
if ($name=='Administrators' or $name=='Guests' or $name=='Default' or $name=='Authenticated Users' or $name=='Content Management'):
	return true;
else:
	return false;
endif;
};

?>
