<?php 
include($globvars['site']['directory'].'kernel/staticvars.php'); 
?>
      <DIV class="main-box">
      	<DIV class="main-box-title">Add Null Index to all the directories</DIV>
		<DIV class="main-box-data">
			<TABLE width="100%" height="400" border="0" cellPadding="0" cellSpacing="0">
			  <tr>
			    <td align="center">
				  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td><div align="center"><img src="<?php echo $globvars['site_path'].'/images/menus.gif'; ?>" border="0" ></div></td>
					</tr>
					<tr>
					  <td><div align="center">Null Index</div></td>
					</tr>
				  </table>
				</td>
			  </tr>
			  <tr>
				<td height="100" colspan="3" valign="bottom"></td>
			  </tr>
		  <tr>
		    <td height="5" colspan="3" align="center">
			<?php
				if (isset($_POST['backup'])):
					?>
					<table width="70%"  border="0" cellspacing="0" cellpadding="0" align="center">
					<tr><td>
					<?
					unset($_POST['backup']);
					rename($globvars['site']['directory'].'index.php',$globvars['site']['directory'].'index_setup.php');
					replicate_file($globvars['site']['directory'],$globvars);	
					@unlink($globvars['site']['directory'].'index.php');
					rename($globvars['site']['directory'].'index_setup.php',$globvars['site']['directory'].'index.php');
					echo '<font class="body_text">Null Index file added to all Directories and Subdirectories!</font>';
					?>
					</td></tr>
					</table>
					<?php
				else:
			?>
					<form method="post" enctype="multipart/form-data" action="<?=session_setup($globvars,'index.php?id='.$task);?>">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td align="center">
						<input type="hidden" name="backup" value="do backup">
						<input type="image" src="<?=$globvars['site_path'];?>/images/buttons/pt/iniciar.gif">
						</td>
					  </tr>
					</table>
					</form>
				<?php
				endif;
				?>
			</td>
		  </tr>
			</table>
		</DIV>
	  </DIV>

<?php
function replicate_file($start_dir,$globvars){
$start_dir=str_replace("\\/","/",$start_dir);
$dir=glob($start_dir.'/*',GLOB_ONLYDIR);
$null_index=$globvars['local_root'].'siteedit/advanced/null_index/index.php';
echo '<img src="'.$globvars['site_path'].'/images/check_mark.gif" border="0">&nbsp;<font class="body_text">'.$start_dir.'</font><br>';
if(count($dir)>1):
	foreach ($dir as $dir_name):
	if($dir_name<>$globvars['local_root'] and $dir_name<>(str_replace("\\/","/",$globvars['local_root'].'/').'setup')):
		copy($null_index,$dir_name.'/index.php');
		replicate_file($dir_name,$globvars);
	endif;	
	endforeach;
else:
	return;
endif;

};
?>

