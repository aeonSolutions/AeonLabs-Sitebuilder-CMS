<?php
/*
File revision date: 20-Ago-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
if(isset($_GET['pos'])and  isset($_GET['menu'])):
	$alter=mysql_escape_string($_GET['pos']);
	$menu=mysql_escape_string($_GET['menu']);
	$query2=$db->getquery("select cod_menu, cod_sub_menu, priority,cod_user_type from menu where cod_menu='".$menu."'");
	if ($query2[0][0]<>''):
		if ($query2[0][1]==0):// it's a menu
			$query=$db->getquery("select cod_menu,priority from menu where cod_sub_menu='0' and cod_user_type='".$query2[0][3]."' order by priority ASC");
		else://it's a submenu
			$query=$db->getquery("select cod_menu,priority from menu where cod_sub_menu='".$query2[0][1]."' order by priority ASC");	
		endif;
		if ($query[0][0]<>''):
			for($i=0;$i<count($query);$i++):
				if ($query[$i][0]==$menu):
					$tmp=$query[$i];
					if($alter=='up' and $i>0):
						$tmp=$query[$i];
						$query[$i]=$query[$i-1];
						$query[$i]=$tmp;
					elseif($alter=='down' and $i<(count($query)-1)):
						$tmp=$query[$i];
						$query[$i]=$query[$i+1];
						$query[$i+1]=$tmp;
					endif;
				endif;
			endfor;		

			$linker=mysql_connect($db->host, $db->user, $db->password);
			if (!$linker):
			   echo 'Could not connect to mysql (menu MD-SBE)';
			   exit;
			endif;
			$result=mysql_select_db($db->name);
			for($i=0;$i<count($query);$i++):
				$result=mysql_query("update menu set priority='".$i."' where cod_menu='".$query[$i][0]."'");
			endfor;		
			mysql_close($linker);
			echo '<font class="body_text"><font color="red">Posi&ccedil;&atilde;o no menu alterada!</font></font>';		
		else:
			echo '<font class="body_text"><font color="red">Invalid menu code!</font></font>';		
		endif;
	endif;
endif;
// adicionar menu
if (!isset($_POST['menu_type']) and !isset($_POST['submenu_type']) and isset($_POST['user_type'])):
	if (isset($_POST['add_menu_name']) and isset($_POST['add_menu_link']) 
		 and isset($_POST['add_menu_module']) and $_POST['user_type']<>'none'):
		if ($_POST['add_menu_module']=='0'  or $_POST['add_menu_module']=='--' or $_POST['add_menu_module']=='none'): // option link
			$db->setquery("insert into menu set name='".mysql_escape_string($_POST['add_menu_name'])."',
			link='".mysql_escape_string($_POST['add_menu_link'])."',cod_module='0',
			 cod_user_type='".mysql_escape_string($_POST['user_type'])."',
			  aditional_params='N/A', display_name='".mysql_escape_string($_POST['add_menu_disp_name'])."'");
		else: // option module
			$db->setquery("insert into menu set name='".mysql_escape_string($_POST['add_menu_name'])."',
			cod_module='".mysql_escape_string($_POST['add_menu_module'])."',
			 cod_user_type='".mysql_escape_string($_POST['user_type'])."',
			  aditional_params='".mysql_escape_string($_POST['add_menu_params'])."', link='N/A',
			   display_name='".mysql_escape_string($_POST['add_menu_disp_name'])."'");	
		endif;
		echo '<font class="body_text"><font color="red">Novo menu criado!</font></font>';		
	else:
		echo '<font class="body_text"><font color="red">Falta preencher campos</font></font>';		
	endif;
// adicionar submenu
elseif (isset($_POST['menu_type']) and !isset($_POST['submenu_type']) and isset($_POST['user_type'])):
	if (isset($_POST['add_menu_name']) and isset($_POST['add_menu_link'])
		 and isset($_POST['add_menu_module']) and $_POST['menu_type']<>'none'):
		$cod_user_type=$db->getquery("select cod_user_type from menu where cod_menu='".mysql_escape_string($_POST['menu_type'])."'");
		if ($_POST['add_menu_module']=='0' or $_POST['add_menu_module']=='--' or $_POST['add_menu_module']=='none'): // option link
			$db->setquery("insert into menu set name='".mysql_escape_string($_POST['add_menu_name'])."',
			link='".mysql_escape_string($_POST['add_menu_link'])."',cod_module='0',
			 cod_sub_menu='".mysql_escape_string($_POST['menu_type'])."', cod_user_type='".$cod_user_type[0][0]."',
			 aditional_params='N/A', display_name='".mysql_escape_string($_POST['add_menu_disp_name'])."'");	
		else: // option module
			 $db->setquery("insert into menu set name='".mysql_escape_string($_POST['add_menu_name'])."',
			  cod_module='".mysql_escape_string($_POST['add_menu_module'])."',
			 cod_sub_menu='".mysql_escape_string($_POST['menu_type'])."', cod_user_type='".$cod_user_type[0][0]."',
			  aditional_params='".mysql_escape_string($_POST['add_menu_params'])."',
			   display_name='".mysql_escape_string($_POST['add_menu_disp_name'])."'");	
		endif;
		echo '<font class="body_text"><font color="red">Novo submenu criado!</font></font>';		
	else:
		echo '<font class="body_text"><font color="red">Falta preencher campos</font></font>';		
	endif;
endif;
if (isset($_POST['copy_menu'])):
	$copy_from=mysql_escape_string($_POST['copy_from']);
	$copy_to=mysql_escape_string($_POST['copy_menu']);
	$data=$db->getquery("select name,cod_module,cod_sub_menu,aditional_params, display_name, active, link, cod_menu from menu where cod_user_type='".$copy_from."' and cod_sub_menu='0'");
	if ($data[0][0]<>''):
		$db->setquery("delete from menu where cod_user_type='".$copy_to."'");
		for ($i=0;$i<count($data);$i++):
			 $db->setquery("insert into menu set name='".$data[$i][0]."',
			  cod_module='".$data[$i][1]."',
			 cod_sub_menu='".$data[$i][2]."', cod_user_type='".$copy_to."',
			  aditional_params='".$data[$i][3]."',
			   display_name='".$data[$i][4]."', active='".$data[$i][5]."', link='".$data[$i][6]."'");	
			$data_sub=$db->getquery("select name,cod_module,cod_sub_menu,aditional_params, display_name, active, link from menu where cod_user_type='".$copy_from."' and cod_sub_menu='".$data[$i][7]."'");
			if ($data_sub[0][0]<>''):
				$cod=$db->getquery("select cod_menu from menu where cod_user_type='".$copy_to."' and
				 name='".$data[$i][0]."' and cod_module='".$data[$i][1]."' and display_name='".$data[$i][4]."' and
				  link='".$data[$i][6]."' and aditional_params='".$data[$i][3]."'");
				for ($k=0;$k<count($data_sub);$k++):
					 $db->setquery("insert into menu set name='".$data_sub[$k][0]."',
					  cod_module='".$data_sub[$k][1]."',
					 cod_sub_menu='".$cod[0][0]."', cod_user_type='".$copy_to."',
					  aditional_params='".$data_sub[$k][3]."',
					   display_name='".$data_sub[$k][4]."', active='".$data_sub[$k][5]."', link='".$data_sub[$k][6]."'");	
				endfor;
			endif;
		endfor;
	echo '<font class="body_text"><font color="red">Menu copiado!</font></font>';
	endif;		
endif;
$menu=@$_GET['mod'];
$query=$db->getquery("select cod_user_type, cod_sub_menu from menu where cod_menu='".$menu."'");
if ($query[0][0]<>''):
	$ut=$query[0][0];
	if ($query[0][1]==0):
		$who='menu';
	else:
		$who='submenu';
	endif;
else:
	$who=$menu;
endif;
if (isset($_POST['publish'])):
	$query=$db->setquery("update menu set active='s' where cod_menu='".$menu."'");
	echo '<font class="body_text"><font color="red">Menu\SubMenu publicado!</font></font>';		
elseif (isset($_POST['unpublish'])):
	$query=$db->setquery("update menu set active='n' where cod_menu='".$menu."'");
	echo '<font class="body_text"><font color="red">Menu\SubMenu n&atilde;o publicado!</font></font>';		
elseif (isset($_POST['mod_del'])):
	$db->setquery("delete from menu where cod_menu='".$menu."'");
	$db->setquery("delete from menu where cod_sub_menu='".$menu."'");
	echo '<font class="body_text"><font color="red">Menu\SubMenu apagado!</font></font>';		
elseif ($who=='menu'):
	if (isset($_POST['edit_usertype']) and isset($_POST['edit_submenu_name'])):
		$link=mysql_escape_string($_POST['edit_submenu_link']);
		$params=mysql_escape_string($_POST['edit_submenu_params']);
		if ($_POST['edit_submenu_module']<>'0' and $_POST['edit_submenu_module']<>'--' and $_POST['edit_submenu_module']<>'none'):
			$link='N/A';
		else:
			$params='N/A';
		endif;
		$query=$db->setquery("update menu set name='".mysql_escape_string($_POST['edit_submenu_name'])."',
		 cod_module='".mysql_escape_string($_POST['edit_submenu_module'])."', link='".$link."',
		 display_name='".mysql_escape_string($_POST['edit_submenu_disp_name'])."',aditional_params='".$params."' where cod_menu='".$menu."'");
		echo '<font class="body_text"><font color="red">Menu  Editado com sucesso!</font></font>';		
	else:
		echo '<font class="body_text"><font color="red">Falta preencher campos obrigatorios (138)!</font></font>';		
	endif;
elseif ($who=='submenu'):
	if (isset($_POST['edit_submenu_name']) and isset($_POST['edit_submenu_module']) and isset($_POST['edit_submenu_link'])):
		$cmod=mysql_escape_string($_POST['edit_submenu_module']);
		$link=mysql_escape_string($_POST['edit_submenu_link']);
		$params=mysql_escape_string($_POST['edit_submenu_params']);
		if ($_POST['edit_submenu_module']<>'0' and $_POST['edit_submenu_module']<>'--' and $_POST['edit_submenu_module']<>'none'):
			$link='N/A';
		else:
			$params='N/A';
		endif;
		$db->setquery("update menu set name='".mysql_escape_string($_POST['edit_submenu_name'])."',
		link='".$link."',cod_module='".$cmod."',cod_sub_menu='".mysql_escape_string($_POST['edit_submenu_type'])."',
		 display_name='".mysql_escape_string($_POST['edit_submenu_disp_name'])."',aditional_params='".$params."'	where cod_menu='".$menu."'");
		echo '<font class="body_text"><font color="red">SubMenu  Editado com sucesso!</font></font>';		
	else:
		echo '<font class="body_text"><font color="red">Falta preencher campos obrigatorios (155)!</font></font>';		
	endif;
endif;
?>
