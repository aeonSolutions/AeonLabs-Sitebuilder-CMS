<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$task=@$_GET['id'];
if (!isset($_GET['id'])):
	$task=12;
endif;
$sid=@$_GET['SID'];
$browse_id=return_id('directory_browsing.php');
?>
<table  align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5" colspan="3" >
<a href="<?=session($staticvars,'index.php?id='.$browse_id);?>"><img src="<?=$staticvars['site_path'].'/modules/directory/images/'.$lang.'/navigate.gif';?>" border="0"/></a></td>
  </tr>		
  <tr>
    <td width="20" height="20" >
	</td>
    <td height="20" align="center" valign="top" ><?php directory($sid); ?></td>
    <td width="20" height="20" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
</table>
<br>
<?php
function directory($sid){
include('kernel/staticvars.php'); 
$task=@$_GET['id'];
if (!isset($_GET['id'])):
	$task=-1;
endif;
//include_once('general/return_module_id.php');
$browse=return_id('directory_browsing.php');
$query=$db->getquery("select cod_category, name from category where cod_sub_cat=0 order by name");
if ($query[0][0]==''):
	?>
	<table align="center" width="300" align="center" valign="top"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><div align="center">N&atilde;o existem categorias de momento</div></td>
	  </tr>
	</table>
	<?php
else:
	?>
	<table align="center" width="90%" align="center" valign="top" border="0" cellspacing="0" cellpadding="0">
  	<?php
	$j=1;
	$i=0;
	while ($i<count($query)):
		?>
		<tr>
		  <td width="50%"><div align="left"><a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: smaller; font-weight:bold;" href="<?=session($staticvars,'index.php?id='.$browse.'&cod='.$query[$i][0]);?>"><?=$query[$i][1];?></a></div></td>
			<? if (isset($query[$i+1])): ?>
			  <td width="50%"><div align="left"><a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: smaller; font-weight:bold;" href="<?=session($staticvars,'index.php?id='.$browse.'&cod='.$query[$i+1][0]);?>"><?=$query[$i+1][1];?></a></div></td>
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
		$query2=$db->getquery("select cod_category, name from category where cod_sub_cat='".$query[$i][0]."' order by name asc limit 0,7");
		if ($query2[0][0]<>''):
			?>
			<td align="center" valign="top" width="50%"><div align="left">
			<?php
			for($k=0;$k<count($query2);$k++):
				?>
				<a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: xx-small; font-weight:normal;" href="<?=session($staticvars,'index.php?id='.$browse.'&cod='.$query2[$k][0]);?>"><?=$query2[$k][1];?></a>
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
			$query3=$db->getquery("select cod_category, name from category where cod_sub_cat='".$query[$i+1][0]."' order by name asc limit 0,7");
			if ($query3[0][0]<>''):
				?>
				<td align="center" valign="top" width="50%"><div align="left">
				<?php
				for($k=0;$k<count($query3);$k++):
					if ($k==count($query3)-1):
						?>
						<a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: xx-small; font-weight: normal;" href="<?=session($staticvars,'index.php?id='.$browse.'&cod='.$query3[$k][0]);?>"><?=$query3[$k][1];?></a>
						<?php
					else:
						?>
						<a style="text-decoration:underline; font:Arial; color:#0033FF; font-size: xx-small; font-weight: normal;" href="<?=session($staticvars,'index.php?id='.$browse.'&cod='.$query3[$k][0]);?>"><?=$query3[$k][1];?>,</a>&nbsp;
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
};
?>
