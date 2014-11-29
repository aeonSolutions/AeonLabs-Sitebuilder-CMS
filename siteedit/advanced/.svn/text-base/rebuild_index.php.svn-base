<?php
if (isset($_POST['rebuild'])):
	include($globvars['local_root'].'buildfiles/build.php');
endif;
?>
<h3><img src="<?=$globvars['site_path'];?>/images/general.jpg">Rebuild the index file if you have made changes in the configurations of the site.</h3>
		<br>
		<table width="500" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="143"><img src="<?=$globvars['site_path'];?>/images/cables.gif"></td>
			<td align="left" valign="middle" class="body_text">
			<?php
			$img='<img src="'.$globvars['site_path'].'/images/check_mark.gif">';
			 echo $img.'&nbsp;&nbsp;Sessions environment<br>'.$img.'&nbsp;&nbsp;Global Variables<br>'.$img.'&nbsp;&nbsp;User Management System<br>'.$img.'&nbsp;&nbsp;Functions & Features initializations<br>'.$img.'&nbsp;&nbsp;Layout<br>'.$img.'&nbsp;&nbsp;Closing Script code';
			?></td>
		  </tr>
		  <tr>
			<td width="143"></td>
			<td align="right" valign="middle" class="body_text">
				<form action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" method="post">
				<input type="submit" name="rebuild" value="Rebuild Index" class="form_submit">
				</form>
			</td>
		  </tr>
		</table>
