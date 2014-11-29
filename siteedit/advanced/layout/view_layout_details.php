<?php
$link2=strip_address("type",$_SERVER['REQUEST_URI']);
$dir_files = glob($globvars['local_root']."layouts/templates/".$_GET['file']."/main.*");
$fl=explode("/",$dir_files[0]);
$dir_files=$_GET['file'].'/'.$fl[count($fl)-1];	
?>
<div id="simple_content2">
  <table width="90%" id="tbl_site2" onclick="javascript:document.form_skin.submit();" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
cellspacing="5" cellpadding="0" align="center" border="0">
	<tr>
	  <td><img id="site_imgfam2" src="<?=$globvars['site_path'];?>/wizard/images/simple_site.gif" /></td>
	  <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%"><h2>Install this template?</h2>
		  <h4>Click to add this template to the website.
		  <form action="" method="post" enctype="multipart/form-data" name="form_skin" class="form" id="form_skin">
		  <input type="hidden" name="add_skin_name" value="<?=$_GET['file'];?>" />
		  </form></h4></td>
	  <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck2" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
	</tr>
  </table>
</div>
<h3>&nbsp;</h3>
<IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="1000" src="<?=session_setup($globvars,$globvars['site_path'].'/layouts/view.php?where=skin&file='.$dir_files);?>" scrolling="auto"></IFRAME></td>