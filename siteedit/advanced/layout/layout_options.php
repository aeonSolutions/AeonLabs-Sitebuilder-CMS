<?php 
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

$link=strip_address("type",$_SERVER['REQUEST_URI']);
?>
<br />
<div id="current">
    <table width="90%" id="tbl_current" onClick="javascript:document.location.href='<?=$link.'&type=installed';?>';" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('tbl_current_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('tbl_current_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="site_imgfam" src="<?=$globvars['site_path'];?>/images/layout_sel.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
              <h2>Installed Skin Templates</h2>
              <h4>View already instaled  SBE layout templates.</h4>
      </td>
        <td style="PADDING-RIGHT: 10px"><img id="tbl_current_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
    </tr>
    </table>
</div>
<br />
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
<div id="simple_content">
    <table width="90%" id="tbl_dynsite" onClick="javascript:document.location.href='<?=$link.'&type=templates';?>';" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('dynsite_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
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