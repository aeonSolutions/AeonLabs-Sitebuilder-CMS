<?php
/*
File revision date: 20-Ago-2006
*/
$task=@$_GET['id'];
if(isset($_GET['pos']) or isset($_POST['menu_type']) or isset($_POST['submenu_type']) or isset($_POST['user_type']) or
 isset($_POST['mod_del']) or isset($_POST['publish']) or isset($_POST['unpublish']) or isset($_POST['gravar']) or
 isset($_POST['edit_submenu_module']) or isset($_POST['copy_menu'])):
	include($globvars['local_root']."update_db/menu_setup.php");
endif;
if (isset($_POST['user_type'])):
	$user=mysql_escape_string(@$_POST['user_type']);
elseif(isset($_GET['ut'])):
	$user=mysql_escape_string(@$_GET['ut']);
elseif(isset($_POST['ut'])):
	$user=mysql_escape_string(@$_POST['ut']);
elseif(isset($_POST['copy_menu'])):
	$user=mysql_escape_string(@$_POST['copy_menu']);
else:
	$user='';
endif;
include($globvars['site']['directory'].'kernel/settings/menu.php');
?>
<link rel="StyleSheet" href="<?=$globvars['site_path'];?>/core/java/dtree.css" type="text/css" />
		<?php
		if ($menu_type=='disabled'):
			echo '<div align="center"><img src="'.$globvars['site_path'].'/images/info.png" alt="info" /><font class="body_text">You have disabled the menu option.</font></div>';
		else:
		?>
			<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
			  <tr>
			    <td colspan="3" align="center">
				<br>
                <?php
				if ($menu_type=='dynamic'):
					$query=$db->getquery("select cod_user_type, name from user_type");
					$selected=0;
					$option[0][0]='--';
					$option[0][1]='-----------------';
					for ($i=1;$i<=count($query);$i++):
						$option[$i][0]=$query[$i-1][0];
						$option[$i][1]=$query[$i-1][1];
						if ($query[$i-1][0]==$user):
							$selected=$i;
						endif;
					endfor;
				else:
					$selected=0;
					$option[0][0]='-1';
					$option[0][1]='Static menu selected';
				endif;				
                        ?>
					<form method="post" action="<?=session_setup($globvars,'index.php?id='.$task);?>" enctype="multipart/form-data">
					  <select size="1" name="ut" class="form_input">
						<?php
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
					<input type="image" src="<?=$globvars['site_path'];?>/images/buttons/pt/ver.gif" name="user_input">
					</form>
					<?php
					if ($user<>''):?>
					<form method="post" action="<?=session_setup($globvars,'index.php?id='.$task);?>" enctype="multipart/form-data">
					<?php
					endif;
					?>
				<hr class="gradient">
				<div class="dtree">
					<a href="<?=session_setup($globvars,'index.php?type=addmenu&amp;id='.$task.'&amp;ut='.$user);?>" >Add Menu </a> | 
					<a href="<?=session_setup($globvars,'index.php?type=addsubmenu&amp;id='.$task.'&amp;ut='.$user);?>" >Add SubMenu </a>
					<?php
					if ($user<>'' and $menu_type=='dynamic'):?>
						| Copy  menu to 
						<select size="1" name="copy_menu" class="form_input">
							<?php
							$query=$db->getquery("select cod_user_type, name from user_type");
							$disabled=0;
							$option[0][0]='--';
							$option[0][1]='-----------------';
							for ($i=1;$i<=count($query);$i++):
								$option[$i][0]=$query[$i-1][0];
								$option[$i][1]=$query[$i-1][1];
								if ($query[$i-1][0]==$user):
									$disabled=$i;
								endif;
							endfor;
							for ($i=0 ; $i<count($option); $i++):
								 if ($disabled==$i):
								 ?>
									<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
								 <?php
								 else:
									?>
									<option value="<?php echo $option[$i][0];?>"><?=$option[$i][1]; ?></option>
								<?php
								endif;
							endfor; ?>
						</select>&nbsp;&nbsp;
						<input type="hidden" name="copy_from" value="<?=$user;?>" />
						<input type="image" src="<?=$globvars['site_path'];?>/images/buttons/pt/copiar.gif" name="user_input">				
				<?php
				endif;
				?>
				</div>
				<hr class="gradient">
				</form>
				</td>
			  </tr>
			  <tr>
			    <td height="14" colspan="3" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$globvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
		      </tr>
			  <tr>
			    <td width="170" valign="top" align="center"><?PHP put_menu($user,$task,$globvars); ?></td>
				<td width="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$globvars['site_path'].'/images/dividers/vert_divider.gif';?>); BACKGROUND-REPEAT: repeat-y;">&nbsp;</td>
				<td><?php
				if (isset($_GET['type'])):
					if ($_GET['type']=='editmenu' or $_GET['type']=='editsubmenu'):
						include($globvars['local_root'].'siteedit/advanced/menu/menu_edit.php');
					else:
						include($globvars['local_root'].'siteedit/advanced/menu/menu_management.php');		
					endif;
				endif;
				?>
				</td>
			  </tr>
			</table>
			<?php
			endif;
			?>
		</DIV>
	  </DIV>

<?
function put_menu($cod_user_type,$task,$globvars){
include($globvars['site']['directory'].'kernel/settings/menu.php');
if (($cod_user_type=='' or $cod_user_type=='--') and $menu_type=='dynamic'):
	?>
	<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
	  <TBODY>
	  <TR>
		<TD>
		  <DIV class="lateral-box">
			<DIV class="lateral-box-title">Menu</DIV>
			<DIV class="lateral-box-data">
			<font class="body_text">Select a user type in the above dropbox</font></DIV>
		  </DIV>
		  </TD>
		</TR></TBODY></TABLE>
	<?php
	return;
endif;
include($globvars['site']['directory'].'kernel/staticvars.php');
if ($menu_type=='dynamic'):
	$query=$db->getquery("select cod_menu, name, link, cod_module from menu where  cod_user_type='".$cod_user_type."' and cod_sub_menu='0'");    
else:
	$query=$db->getquery("select cod_menu, name, link, cod_module from menu where cod_sub_menu='0'");    
endif;
if ($query[0][0]==''):
	?>
	<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
	  <TBODY>
	  <TR>
		<TD>
		  <DIV class="lateral-box">
			<DIV class="lateral-box-title">Menu</DIV>
			<DIV class="lateral-box-data">No menu defined for this user type.</DIV>
		  </DIV>
		  </TD>
		</TR></TBODY></TABLE>
	<?php
	return;
endif;
include($globvars['local_root'].'siteedit/advanced/menu/constructor.php');
echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
$tree=build_menu_tree_config($cod_user_type);
if (count($tree)<>0):
	for($i=0; $i<count($tree); $i++):
		if ($tree[$i]['flag']=='title'):
			echo '<tr><td background="layout/menu/menu_op2.gif" height="19">';
			if ($tree[$i]['link']<>''):
				echo put_priority($cod_user_type,$tree[$i]['code'],$globvars)."<a class='header_text_1' href='".$tree[$i]['link']."' target='_top'>".$tree[$i]['name']."</a>&nbsp;&nbsp;<a href='".session_setup($globvars,'index.php?id='.$task.'&amp;type=editmenu&amp;menu='.$tree[$i]['code'].'&amp;ut='.$cod_user_type)."' class='litle_text'> Editar </a>";
			else:
				echo put_priority($cod_user_type,$tree[$i]['code'],$globvars)."<font class='header_text_1'>".$tree[$i]['name']."</font><a href='".session_setup($globvars,'index.php?id='.$task.'&amp;type=editmenu&amp;menu='.$tree[$i]['code'].'&amp;ut='.$cod_user_type)."' class='litle_text'> Editar </a>";
			endif;
		elseif($tree[$i]['flag']=='option'):
			echo '<tr><td height="5">';
			if ($tree[$i]['link']<>''):
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".put_priority($cod_user_type,$tree[$i]['code'],$globvars)."&nbsp;<a href='".$tree[$i]['link']."' target='_top' class='linkmodule' >".$tree[$i]['name']."</a>&nbsp;&nbsp;<a href='".session_setup($globvars,'index.php?id='.$task.'&amp;type=editsubmenu&amp;menu='.$tree[$i]['code'].'&amp;ut='.$cod_user_type)."' class='litle_text'> Editar </a>";
			else:
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".put_priority($cod_user_type,$tree[$i]['code'],$globvars)."&nbsp;".$tree[$i]['name']."<a href='".session_setup($globvars,'index.php?id='.$task.'&amp;type=editsubmenu&amp;menu='.$tree[$i]['code'].'&amp;ut='.$cod_user_type)."' class='litle_text'> Editar </a>";
			endif;
		endif;
		echo '</td></tr>';
	endfor;
else:
	echo '<tr><td height="5">';
	echo 'no menu defined!';
	echo '</td></tr>';	
endif;
echo '</table>';
};

function put_priority($cod_user_type,$menu,$globvars){
$task=$_GET['id'];
include($globvars['site']['directory'].'kernel/staticvars.php');
include($globvars['site']['directory'].'kernel/settings/menu.php');
$query2=$db->getquery("select cod_menu, cod_sub_menu, priority from menu where cod_menu='".$menu."'");
if ($query2[0][1]==0):// it's a menu
	if ($menu_type=='dynamic'):
		$query=$db->getquery("select cod_menu from menu where cod_sub_menu='0' and cod_user_type='".$cod_user_type."' order by priority ASC");
	else:
		$query=$db->getquery("select cod_menu from menu where cod_sub_menu='0' order by priority ASC");
	endif;
else://it's a submenu
	$query=$db->getquery("select cod_menu from menu where cod_sub_menu='".$query2[0][1]."' order by priority ASC");	
endif;
$top=count($query);
for($i=0;$i<count($query);$i++):
	if ($query[$i][0]==$menu):
		$pos=$i+1;
	endif;
endfor;		
if ($pos>1 and $pos<$top):
	return '<a class="litle_text" href="'.session_setup($globvars,'index.php?id='.$task.'&amp;ut='.$cod_user_type.'&amp;menu='.$menu.'&amp;pos=up').'" target="_top"><img src="siteedit/advanced/menu/arrow_up.gif" alt="move up" border="0"></a>&nbsp;<a class="litle_text" href="'.session_setup($globvars,'index.php?id='.$task.'&amp;ut='.$cod_user_type.'&amp;menu='.$menu.'&amp;pos=down').'" target="_top"><img src="siteedit/advanced/menu/arrow_down.gif" alt="move down" border="0"></a>';
elseif($pos==1):
	return '<a class="litle_text" href="'.session_setup($globvars,'index.php?id='.$task.'&amp;ut='.$cod_user_type.'&amp;menu='.$menu.'&amp;pos=down').'" target="_top"><img src="siteedit/advanced/menu/arrow_down.gif" alt="move down" border="0"></a><img src="siteedit/advanced/menu/arrow_empty.gif" border="0">';
else:
	return '<a class="litle_text" href="'.session_setup($globvars,'index.php?id='.$task.'&amp;ut='.$cod_user_type.'&amp;menu='.$menu.'&amp;pos=up').'" target="_top"><img src="siteedit/advanced/menu/arrow_up.gif" alt="move up" border="0"></a><img src="siteedit/advanced/menu/arrow_empty.gif" border="0">';
endif;
};
?>
