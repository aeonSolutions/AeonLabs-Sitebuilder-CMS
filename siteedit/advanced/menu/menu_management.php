<?php
/*
File revision date: 9-jul-2007
*/
include($globvars['site']['directory'].'kernel/staticvars.php');
if (isset($_GET['type'])):
	$type=$_GET['type'];
	if ($type<>'addmenu' and $type<>'addsubmenu' and $type<>'editmenu' and $type<>'editsubmenu'):
		$type='addmenu';
	endif;
else:
	$type='addmenu';
endif;
?>
<script language="javascript">
<?php
$j=0;
$k=0;
$query=$db->getquery("select cod_user_type from user_type");
for ($i=0;$i<count($query);$i++):
	$cod_user_type[$i][1]=0;
	$cod_user_type[$i][0]=$query[$i][0];
endfor;
$menu[0][0]='undef';
$menu[0][1]=0;
$menu[0][2]=0;
$menu[0][3]=0;
$sub_menu[0][0]='undef';
$sub_menu[0][1]=0;
$sub_menu[0][2]=0;
$query=$db->getquery("select cod_menu,cod_sub_menu,name,cod_user_type,priority from menu");
if ($query[0][0]<>''):
	for($i=0;$i<count($query);$i++):
		if($query[$i][1]=='0'):// menu
			$menu[$j][0]=$query[$i][2]; //name
			$menu[$j][1]=$query[$i][0]; //cod_menu
			$menu[$j][2]=$query[$i][3]; // cod_user_type
			$menu[$j][3]=0;
			$j++;
			for($ii=0;$ii<count($cod_user_type);$ii++):
				if($cod_user_type[$ii][0]==$query[$i][3]):
					$cod_user_type[$ii][1]=$cod_user_type[$ii][1]+1;
				endif;
			endfor;
		else:
			$sub_menu[$k][0]=$query[$i][2]; //name
			$sub_menu[$k][1]=$query[$i][1]; // cod_sub_menu
			$sub_menu[$k][2]=$query[$i][0]; // cod_menu
			$k++;
			for($ii=0;$ii<count($menu);$ii++):
				if($menu[$ii][1]==$query[$i][1]):
					$menu[$ii][3]=$menu[$ii][3]+1;
				endif;
			endfor;
		endif;
	endfor;
endif;
echo 'var menu_0=new Array('.(count($menu)-1).');'.chr(13);
echo 'var menu_1=new Array('.(count($menu)-1).');'.chr(13);
echo 'var menu_2=new Array('.(count($menu)-1).');'.chr(13);
echo 'var menu_3=new Array('.(count($menu)-1).');'.chr(13);
echo 'var sub_menu_0=new Array('.(count($sub_menu)-1).');'.chr(13);
echo 'var sub_menu_1=new Array('.(count($sub_menu)-1).');'.chr(13);
echo 'var sub_menu_2=new Array('.(count($sub_menu)-1).');'.chr(13);
echo 'var cod_user_type_0=new Array('.(count($cod_user_type)-1).');'.chr(13);
echo 'var cod_user_type_1=new Array('.(count($cod_user_type)-1).');'.chr(13);
echo 'var menu_size='.(count($menu)-1).';'.chr(13);
echo 'var sub_menu_size='.(count($sub_menu)-1).';'.chr(13);
echo 'var cod_user_type_size='.(count($cod_user_type)-1).';'.chr(13);
for($i=0;$i<count($menu);$i++):
	echo 'menu_0['.$i.']="'.$menu[$i][0].'";'.chr(13);
	echo 'menu_1['.$i.']='.$menu[$i][1].';'.chr(13);
	echo 'menu_2['.$i.']='.$menu[$i][2].';'.chr(13);
	echo 'menu_3['.$i.']='.$menu[$i][3].';'.chr(13);
endfor;
for($i=0;$i<count($sub_menu);$i++):
	echo 'sub_menu_0['.$i.']="'.$sub_menu[$i][0].'";'.chr(13);
	echo 'sub_menu_1['.$i.']='.$sub_menu[$i][1].';'.chr(13);
	echo 'sub_menu_2['.$i.']='.$sub_menu[$i][2].';'.chr(13);
endfor;
for ($i=0;$i<count($cod_user_type);$i++):
	echo 'cod_user_type_0['.$i.']='.$cod_user_type[$i][0].';'.chr(13);
	echo 'cod_user_type_1['.$i.']='.$cod_user_type[$i][1].';'.chr(13);
endfor;
?>

/*Remove all the options from a dropdown menu list*/
/*Add an option from a dropdown list*/
function reload_menu()
{
var i;
var k;
menu=document.form_menu.menu_type;
user=document.form_menu.user_type;
submenu=document.form_menu.submenu_type;
<?php
if ($type<>'addsubmenu'):
	?>
	for(i=submenu.length-1;i>=0;i--)
		{
		submenu.remove(i);
		}
	submenu.options[0]=new Option("----------------","none");
	<?php
endif;
?>
for(i=menu.length-1;i>=0;i--)
	{
	menu.remove(i);
	}

var position= user.options[user.selectedIndex].value;

menu.options[0]=new Option("----------------","none");
k=1;
for(i=0;i<=menu_size;i++)
	{
	if(menu_2[i]==position)
		{
		menu.options[k]=new Option(menu_0[i],menu_1[i]);
		k=k+1;
		}
	}

menu.disabled=false;
menu.options[0].selected=true;

}

function reload_submenu()
{
var i;
var k;
menu=document.form_menu.menu_type;
submenu=document.form_menu.submenu_type;

for(i=submenu.length-1;i>=0;i--)
	{
	submenu.remove(i);
	}

var position= menu.options[menu.selectedIndex].value;
submenu.options[0]=new Option("----------------","none");
k=1;
for(i=0;i<=sub_menu_size;i++)
	{
	if(sub_menu_1[i]==position)
		{
		submenu.options[k]=new Option(sub_menu_0[i],sub_menu_1[i]);
		k=k+1;
		}
	}

submenu.disabled=false;
submenu.options[0].selected=true;

}


</script>
<?php
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
	$query=$db->getquery("select cod_module, name, link from module order by link");
	// a query tem que ser sempre nesta forma senao da erro! : select cod_module, name, link from module
	$module_option=build_drop_module($query,$task,$globvars['site_path']);
	$module_selected=0;
	/*for usertype dropbox */
	include($globvars['site']['directory'].'kernel/settings/menu.php');
	if ($menu_type=='dynamic'):
		$query=$db->getquery("select cod_user_type, name from user_type");
		$selected_ut=0;
		$user_type_options[0][0]='none';
		$user_type_options[0][1]='---------------------------------------';
		$ut=mysql_escape_string(@$_GET['ut']);
		for ($i=1;$i<=count($query);$i++):
			$user_type_options[$i][0]=$query[$i-1][0];
			$user_type_options[$i][1]=$query[$i-1][1];
			if ($query[$i-1][0]==$ut):
				$selected_ut=$i;
			endif;
		endfor;
	else:
		$selected_ut=0;
		$user_type_options[0][0]='-1';
		$user_type_options[0][1]='Static menu selected';
	endif;
	?>
	<form name="form_menu" method="post" action="<?=session_setup($globvars,$site_path.'/index.php?id='.$task);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td align="center" valign="middle">
		<font class="body_text">Visivel aos utilizadores do tipo</font>&nbsp;&nbsp;&nbsp;
		<select id="user_type" name="user_type" class="form_input" <?php if ($type<>'addmenu'){?>onChange="javascript:reload_menu();"<?php }?>>
			<?php
			for ($i=0 ; $i<count($user_type_options); $i++):?>
				<option value="<?=$user_type_options[$i][0];?>" <?php if ($selected_ut==$i){?>selected<?php } ?>>
				<?php echo $user_type_options[$i][1]; ?></option>
				<?php
			endfor; ?>
		</select>
	  </td>
	</tr>
	  <tr>
		<td height="15"></td>
	  </tr>
	<tr>
	<td align="center" valign="middle">
	<?php
	 if ($type<>'addmenu'):?>
		<font class="body_text">Pertence ao menu</font>&nbsp;&nbsp;&nbsp;
		<select id="menu_type" <? if ($selected_ut==0 and $menu_type=='dynamic'){ echo 'disabled="disabled"';}?> name="menu_type" class="form_input" <?php if($type<>'addmenu'){?>onChange="javascript:reload_submenu();"<?php }?>>
				<option value="none" selected="selected">---------------------------------------</option>
				<?php
				if (($selected_ut<>0 and $menu_type=='dynamic') or $menu_type=='static'):
					/*for menu dropbox */
					if ($menu_type=='dynamic'):
						$query=$db->getquery("select cod_menu, name from menu where cod_user_type='".$ut."' and cod_sub_menu='0'");
					else:
						$query=$db->getquery("select cod_menu, name from menu where cod_sub_menu='0'");
					endif;
					if ($query[0][0]<>''):					
						for ($i=0;$i<count($query);$i++):
							$menu_options[$i][0]=$query[$i][0];
							$menu_options[$i][1]=$query[$i][1];
						endfor;
						for ($i=0 ; $i<count($menu_options); $i++):?>
							<option value="<?=$menu_options[$i][0];?>" ><?=$menu_options[$i][1]; ?></option>
							<?php
						endfor; 
					endif;
				endif;
				?>
		</select>
	<?php
	endif;
	?>
	</td>
	</tr>
	  <tr>
		<td height="15"></td>
	  </tr>
	<tr>
	<td align="center" valign="middle">
	<?php
	 if ($type<>'addmenu' and $type<>'addsubmenu'):?>
		<font class="body_text">Pertence ao submenu</font>&nbsp;&nbsp;&nbsp;
		<select id="submenu_type" name="submenu_type" class="form_input" disabled="disabled">
				<option value="none" selected="selected">---------------------------------------</option>
		</select>
	<?php
	endif;
	?>
	</td>
	</tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td>
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input name="add_menu_name" type="text" class="body_text" size="40" maxlength="255">
		</td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td>
			<font class="body_text">Módulo</font>&nbsp;&nbsp;&nbsp;
			<select size="1" name="add_menu_module" class="form_input">
				<?php
				for ($i=0 ; $i<count($module_option); $i++):
					 if ($module_option[$i][0]=='optgroup'):
					 ?>
						<optgroup disabled label="<?=$module_option[$i][1];?>"></optgroup>
					 <?php
					 else:
						?>
						<option value="<?php echo $module_option[$i][0];?>" >
						<?php echo $module_option[$i][1]; ?></option>
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
			<input name="add_menu_params" type="text" class="body_text" size="40" maxlength="255">
		</td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td>
			<font class="body_text">Pré-definidos</font>&nbsp;&nbsp;&nbsp;
			<select name="pre_params" size="1" class="form_input"  onchange="document.form_menu.add_menu_params.value= document.form_menu.pre_params.options[document.form_menu.pre_params.selectedIndex].value">
			  <option value="&did=&goto=">&amp;did=&amp;goto=</option>
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
			<input name="add_menu_link" type="text" class="body_text" size="40" maxlength="255">
		</td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td>
			<font class="body_text">Pré-definidos</font>&nbsp;&nbsp;&nbsp;
			<select name="pre_links" size="1" class="form_input" onchange="document.form_menu.add_menu_link.value= document.form_menu.pre_links.options[document.form_menu.pre_links.selectedIndex].value">
			  <option value="index.php">index.php</option>
			  <option value="index.php?logout=-1">index.php?logout=-1</option>
			  <option selected="selected">Select one</option>
          </select>
		</td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td class="body_text" align="left">
			ex:pt=P&aacute;g.Inicial||en=Home<br>Display Name:
			<input name="add_menu_disp_name" type="text" class="body_text" size="40" maxlength="255">
		</td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_menu" type="image" src="<?=$site_path.'/images/buttons/'.$lang;?>/adicionar.gif">
		</td>
	  </tr>
	  </table>
	</form>
<?php
function build_drop_module($query,$task,$site_path){
// a query tem que ser sempre nesta forma senao da erro! 
//       : select cod_module, name, link from module order by link
	$option[0][0]='--';
	$option[0][1]='------------------------------------';
	$t[0]='';
	$t[1]='';
	$k=1;
	if (isset($query[1][2])):
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
	endif;
return $option;
};
?>