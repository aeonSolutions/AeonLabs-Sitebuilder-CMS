<?php 
/*
File revision date: 13-abr-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

if(isset($_POST['skin_code']) or isset($_POST['del_skin']) or isset($_POST['skin_cell']) or isset($_FILES['add_template']) or isset($_POST['add_skin_name'])):
	include($globvars['local_root'].'update_db/skin_setup.php');	
	header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;
endif;



if (isset($_GET['type'])):
	if($_GET['type']=='view'):
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
              <input type="hidden" name="auto" value="<?=$_GET['file'];?>" />
              <input type="hidden" name="add_skin_name" value="<?=$_GET['file'];?>" />
              </form></h4></td>
          <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck2" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
        </tr>
      </table>
    </div>
    <h3>&nbsp;</h3>
<IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="1000" src="<?=session_setup($globvars,$globvars['site_path'].'/layouts/view.php?where=skin&file='.$dir_files);?>" scrolling="auto"></IFRAME></td>
	<?php
	elseif($_GET['type']=='templates'):
		put_files($globvars);
	elseif($_GET['type']=='add'):
		add_template($globvars);
	else:
		options($globvars);
	endif;
else:
	options($globvars);
endif;    

function options($globvars){
$link=strip_address("type",$_SERVER['REQUEST_URI']);
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="simple_content">
    <table width="90%" id="tbl_site" onClick="javascript:document.location.href='<?=$link.'&type=add';?>';" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="site_imgfam" src="<?=$globvars['site_path'];?>/wizard/images/simple_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
      <h2>Add Layout Template</h2>
      <h4>Add a new Layout Design template to SBE database.</h4>
      </td>
        <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
    </tr>
    </table>
</div>

<br>
<div id="adv_content">
    <table width="90%" id="tbl_dynsite" onClick="javascript:document.location.href='<?=$link.'&type=templates';?>';" onmouseover="try{this.style.borderColor = 'fe4518'; document.getElementById('dynsite_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('dynsite_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="dynsite_imgfam" src="<?=$globvars['site_path'];?>/wizard/images/db_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
              <h2>View Layout templates</h2>
              <h4>View existing SBE layout templates.</h4>
      </td>
        <td style="PADDING-RIGHT: 10px"><img id="dynsite_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
    </tr>
    </table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
};

function add_template($globvars){
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
$link=strip_address("type",$_SERVER['REQUEST_URI']);
?>
<div align="right"><a href="<?=$link;?>"><img border="0" title="go to previous" src="<?=$globvars['site_path'].'/images/back.png';?>" /></a></div><h3>Add a design layout</h3>
<form class="form" method="post" enctype="multipart/form-data" name="add_template" action="">
<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" class="body_text"><p>To add a design  template, compress all the files a Zip file and name it with the template name<br />
    </p>
      </td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$globvars['site_path'];?>/images/template_example1.gif" width="294" height="66" /></td>
  </tr>
  <tr>
    <td align="left" class="body_text"><p>&nbsp;</p>
      <p>all the html, htm and php files within the root of the Zip file will be considered as layout files for this template, their names are free, however one must exist as main.html, main.htm or main.php as the main layout for the template.</p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$globvars['site_path'];?>/images/template_example2.gif" width="315" height="123" /></td>
  </tr>
  <tr>
    <td align="left" class="body_text">
      <p>&nbsp;</p>
      <p>you may include the subdirectories you would like, for images, Stylesheet files, Jscript, etc.</p>
      <p>Don't also forget to include on the root directory of the zip file a preview image of this template named  <em>preview.jpg</em></p></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  <tr>
    <td class="body_text"><strong>Template to add (ZIP)</strong> </td>
  </tr>
  <tr>
    <td><label>
      <input type="file" class="text" name="add_template" accesskey="1" size="50" />
    </label></td>
  </tr>
  <tr>
    <td height="15" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><input name="add_template" type="submit" class="button" value="Add Template" /></td>
  </tr>
</table>

</form>
<?php
};



function add_field($globvars){
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
if (isset($_GET['file'])):
	$fil=@$_GET['file'];
endif;
?>
<br />
<br />
<br />
<br />
<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="disp" maxlength="255"  value="<?=$fil;?>" size="40" disabled="disabled"><br />
			<input type="hidden" name="add_skin_name" value="<?=$fil;?>"  ></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang;?>/adicionar.gif"></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="10" colspan="2">
		<?php
		put_files($globvars);
		?>		</td>
	  </tr>
	  </table>
	  </form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top" align="center">&nbsp;</td>
    <td valign="top" align="center">&nbsp;</td>
    <td valign="top" align="center">&nbsp;</td>
  </tr>
</table>
<?php
};

function put_files($globvars){
$task=@$_GET['id'];
$link=strip_address("type",$_SERVER['REQUEST_URI']);
echo '<div align="right"><a href="'.$link.'"><img border="0" title="go to previous" src="'.$globvars['site_path'].'/images/back.png" /></a></div><h3>Existing templates</h3>Select one to view details<br /><br />';
$dir_files = glob($globvars['local_root']."layouts/templates/*",GLOB_ONLYDIR);
$j=1;
if ($dir_files[count($dir_files)-1]==''):
	$nums=count($dir_files)-1;
else:
	$nums=count($dir_files);
endif;
echo '<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">'.chr(13).'<tr>';
for($i=0; $i < $nums; $i++):
	$fl=explode("/",$dir_files[$i]);
	$name=explode(".",$fl[count($fl)-1]);
	$location=$fl[count($fl)-1];
	if(!is_file($globvars['local_root'].'layouts/templates/'.$location.'/preview.jpg')):
		$location=$globvars['site_path'].'/images/no_preview.jpg';
	else:
		$location=$globvars['site_path'].'/layouts/templates/'.$location.'/preview.jpg';	
	endif;
	$sr= '';
	$sr .= '<br><font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&file='.$fl[count($fl)-1]).'" target="_self">view</a>]&nbsp;&nbsp;[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?step=2&type=skin&file='.$fl[count($fl)-1]).'" target="_self">Edit</a>]<br>'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;".chr(13);
	echo '<td width="190" align="center" valign="bottom"><img src="'.$location.'" border="1">'.$sr.'<br><br></td>';
	$j++;
	if ($j>3):
		$j=1;
		echo '</tr>'.chr(13).'<tr>';
	endif;
endfor;
if ($j<4):
	for ($i=$j;$i<4;$i++):
		echo '<td valign="top" align="center"></td>';
	endfor;
endif;
echo '</table><br><br>';

};
?>