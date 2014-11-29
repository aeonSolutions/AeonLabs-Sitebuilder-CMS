<?php 
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
$_SESSION['contents']=array();
unset($_SESSION['contents']);
if(isset($_POST['finish'])):
	$_SESSION['contents']=true;
	session_write_close();
	header("Location: ".strip_address("step",strip_address("skin",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;
endif;
include($globvars['site']['directory'].'kernel/settings/layout.php');
include($globvars['site']['directory'].'kernel/staticvars.php');
if(isset($_GET['id'])):
	$task=$db->prepare_query($_GET['id']);
endif;
if(isset($_GET['mod'])):
	$mod=$db->prepare_query($_GET['mod']);
endif;
if(isset($_POST['skin'])):
	$skin=$db->prepare_query($_POST['skin']);
else:
	$skin=isset($_GET['skin']) ? $db->prepare_query($_GET['skin']) : '';
endif;
$query=$db->getquery("select ficheiro from skin where cod_skin='".$skin."'");
if($query[0][0]<>''):
	$file=$query[0][0];
else:
	$query=$db->getquery("select cod_skin, ficheiro from skin where active='s'");
	if($query[0][0]<>''):
		$skin=$query[0][0];
		$file=$query[0][1];
	else:
		$globvars['warnings']='layout not found on DB Server! You need to install one first to edit CMS';
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			sleep(1);
			header("Location: ".session_setup($globvars,"index.php"));
			exit;
		endif;
	endif;	
endif;
if (isset($_POST['del_full']) or isset($_POST['del_pos']) or isset($_POST['drop_add']) or isset($_POST['max_pos'])):
	include($globvars['local_root'].'update_db/layout_setup.php');
endif;
?>
<div id="simple_content2">
  <table width="90%" id="tbl_site2" onclick="javascript:document.form_skin.submit();" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
cellspacing="5" cellpadding="0" align="center" border="0">
	<tr>
	  <td><img id="site_imgfam2" src="<?=$globvars['site_path'];?>/wizard/images/simple_site.gif" /></td>
	  <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%"><h2>Continue?</h2>
		  <h4>If you have finished edditing contents click here.
		  <form action="" method="post" enctype="multipart/form-data" name="form_skin" class="form" id="form_skin">
		  <input type="hidden" name="finish" value="fin" />
		  </form></h4></td>
	  <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck2" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
	</tr>
  </table>
</div>
<h3>&nbsp;</h3>
<table style="border: 1px dotted #999999" cellpadding="0" cellspacing="0" align="center" width="90%">
    <tr>
        <td>
            <?php
            if ($layout<>'dynamic'):	
                $skin=1;
            endif;
                if ($mod<>'' and $skin<>''):
                    include($globvars['local_root'].'wizard/advanced/contents/layout_edit_cell.php');
                else:
				// develop AJAX CODE HERE
					echo'<IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="800" src="'.$globvars['site_path'].'/wizard/advanced/contents/layout_frame.php?SID='.$_GET['SID'].'&file='.$file.'&skin='.$skin.'" scrolling="auto"></IFRAME>';
                endif;
            ?>
        </td>
    </tr>
</table>