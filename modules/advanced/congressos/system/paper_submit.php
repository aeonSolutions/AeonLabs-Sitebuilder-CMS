<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['submit_btn'])):
	include($staticvars['local_root'].'modules/congressos/update_db/abstracts.php');
endif;

if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
if(is_file($staticvars['local_root'].'modules/congressos/system/settings.php')):
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
else:
	echo 'You need to build settings file first!';
	exit;
endif;
$maxsize=$ps[20].' '.ini_get("upload_max_filesize");

if($type_file=='both'):
	$types=$ps[12].' Doc and Pdf '.$ps[13];
else:
	$types=$ps[12].' '.$type_file.' '.$ps[13];
endif;
if(isset($_SESSION['paper'])):
	echo '<font color="red">'.$_SESSION['paper'].'</font>';
	unset($_SESSION['paper']);
endif;
if(isset($_GET['success'])):
	include($staticvars['local_root'].'modules/congressos/system/paper_success.php');
else:
$abs=$db->getquery("select cod_abstract, title from congress_abstracts where cod_user='".$staticvars['users']['code']."' and revised='s'");
if($abs[0][0]<>''):
	?>
	<script language="JavaScript" type="text/javascript"> 
	
	<!--
	function checkform ( form )
	{
	  if (form.abstract.value == "") {
		document.getElementById('u_abstract').style.color="#FF0000";
		form.abstract.focus();
		return false;
	  }
	  if (form.paper.value == "") {
		document.getElementById('u_paper').style.color="#FF0000";
		form.paper.focus();
		return false;
	  }
	
	  // ** END **
	  return true;
	}
	
	function cleanform ( form )
	{
	  if (form.abstract.value != "") {
		document.getElementById('u_abstract').style.color="#2b2b2b";
	  }
	   if (form.paper.value != "") {
		document.getElementById('u_paper').style.color="#2b2b2b";
	  }
	}
	//-->
	</script> 
	
	
	
	
	<form class="form" action="<?=$_SERVER['REQUEST_URI'];?>" onsubmit="return checkform(this)" method="post" enctype="multipart/form-data" name="paper_submition">
	  <table class="default" cellspacing="2" cellpadding="2" border="0">
		  <tr valign="top">
			<td align="left"></td>
			<td align="right"><img src="<?=$staticvars['site_path'];?>/modules/congressos/images/atencao.gif" alt="warning" width="15" height="13" /><?=$ps[0];?></td>
		  </tr>
		  <tr valign="center">
			<td colspan="2" align="left"><b><?=$ps[18];?></b></td>
		  </tr>
		  <tr valign="center">
			<td align="right"><b><div id="u_abstract"><?=$ps[2];?></div></b></td>
			<td>
			  <select class="text" onchange="cleanform(document.paper_submition);"  name="abstract" id="abstract" tabindex="0">
					<option value="">SELECT ONE</option>
				<?php
				for ($k=0 ; $k<count($abs); $k++):
					?>
					<option value="<?=$abs[$k][0];?>"><?=$abs[$k][1]; ?></option>
					<?php
				endfor; ?>
			  </select>
			</td>
		  </tr>
		  <tr valign="center">
		    <td align="right">&nbsp;</td>
		    <td>&nbsp;</td>
	    </tr>
		  <tr valign="center">
		    <td colspan="2" align="left"><b><?=$ps[1];?></b><br /><font size="-2"><?=$types;?></font>
            </td>
	    </tr>
		  <tr valign="center">
			<td align="right"><b>
	<div id="u_paper"><?=$ps[3];?></div></b></td>
			<td><input class="text" onchange="cleanform(document.paper_submition);"  name="paper" type="file" id="paper" tabindex="1" size="50" maxlength="255"/>
            <br /><font size="-2"><?=$maxsize;?></font>
            </td>
		  </tr>
		  <tr valign="top">
			<td align="left"><div id="submitted"></div></td>
			<td align="right"></td>
		  </tr>
		  <tr valign="center">
		    <td><br /></td>
		    <td align="right" valign="top"><input class="button" type="submit" value="<?=$ps[11];?>"  name="submit_btn" />
		      <br />
		      <br /></td>
	    </tr>
        <tr valign="center">
		    <td>&nbsp;</td>
		    <td align="left" valign="top">
            <?php
			echo '<img src="'.$staticvars['site_path'].'/modules/congressos/images/atencao.gif">&nbsp;'.$ps[17];
			?>
            </td>
	    </tr>
	  </table>
	</form>
	<?php
	else:
		echo 'nao submeteu um resumo. contacte o secretariado para mais informaçao!';
	endif;
endif;
?>
