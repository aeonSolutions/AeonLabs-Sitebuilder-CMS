<?php
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
$link=strip_address("type",$_SERVER['REQUEST_URI']);
?>
<div align="right"><a href="<?=$link;?>"><img border="0" title="go to previous" src="<?=$globvars['site_path'].'/images/back.png';?>" /></a></div><h3>Add a design layout</h3>
<form class="form" method="post" enctype="multipart/form-data" name="add_template_frm" action="">
  <table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="left" class="body_text"><p>To add a design  template, compress all the files a Zip file and name it with the template name<br />
      </p></td>
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
      <td align="left" class="body_text"><p>&nbsp;</p>
        <p>you may include the subdirectories you would like, for images, Stylesheet files, Jscript, etc.</p>
        <p>Don't also forget to include on the root directory of the zip file a preview image of this template named <em>preview.jpg</em></p></td>
    </tr>
    <tr>
      <td height="15"></td>
    </tr>
    <tr>
      <td class="body_text"><strong>Template to add (ZIP)</strong></td>
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
      <td align="right"><input name="add_template_bt" type="submit" class="button" value="Add Template" /></td>
    </tr>
  </table>
</form>