<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

if (isset($_POST['module'])):
	include($globvars['local_root'].'update_db/module_setup.php');
	header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;
endif;

?>
<form class="form" action="<?=strip_address("step",$_SERVER['REQUEST_URI']);?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="module" value="automatic">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$site_path;?>//images/contents.jpg">&nbsp;Automatic Module Instalation<hr size="1" color="#666666" /></td>
  </tr>
</table>
<?php
$dir=glob($globvars['local_root']."modules/advanced/*",GLOB_ONLYDIR);
include($globvars['site']['directory'].'kernel/staticvars.php');
$query=$db->getquery("select link from module");
include($globvars['site']['directory'].'kernel/settings/ums.php');
if ($dir[0]<>''):
	$k=0;
	for($i=0;$i<count($dir);$i++):
		$dirX=explode("/",$dir[$i]);
		$install=true;
		$chk='';
		if (!file_exists($globvars['local_root'].'modules/advanced/'.$dirX[count($dirX)-1].'/install_module/auto_install.php')):
			$install=false;
		else:	
			if (file_exists($globvars['local_root'].'modules/advanced/'.$dirX[count($dirX)-1].'/install_module/require.php')):
				include($globvars['local_root'].'modules/advanced/'.$dirX[count($dirX)-1].'/install_module/require.php');
			else:
				$ug_type='independent';
				$ums_enable=false;
			endif;
			
			if($ug_type=='static' and $ums_enable):
				$install=true;
				$chk=' disabled="disabled"';
			else:
				for ($j=0;$j<count($query);$j++):
					$link=explode("/",$query[$j][0]);
					if ($link[0]==$dirX[count($dirX)-1]):
						$install=false;
						break;
					endif;
				endfor;
			endif;
		endif;

		if ($install):
			if($chk==''):
				$txt=$dirX[count($dirX)-1];
			else:
				$txt='<font style="color:#999999">'.$dirX[count($dirX)-1].'</font>';
			endif;
			$k=1;
			?>			
			<input type="checkbox" <?=$chk;?> name="<?=$dirX[count($dirX)-1];?>"><font class="body_text">&nbsp;<?=$txt;?></font><br/>
			<?php
		endif;
	endfor;
	if ($k==0):
		echo "There are modules in the Setup Modules Directory but they are already installed or don't have the automatic install feature.";
	else:
		if($query[0][0]<>''):
			$bt_name='Continue Wiz';
		else:
			$bt_name=' Skip ';
		endif;
		?>
		<input type="submit" name="auto_install" value="Install" class="button">
		</form>
		<?php
	endif;
else:
	echo "No modules Found in the Setup Modules Directory!";
endif;
?>
