<?
require_once($globvars['local_root']."filemanager/logiclevel/ThumbnailImage_ll.php");

class FileInterface {
	
	function getHtmlFileList($path,$i,$file,$url_vars,$class_name,$permission_classes) {
		$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
		include($globvars['local_root'].'core/globvars.php');
		$file_name = $file[0];
		$file_type = $file[1];
		$file_extension = $file[2];
		$file_dirname = File::cleanRootPath($path,$file[3]);
		$file_size = $file[4];
		$last_modify_date = $file[5];

		$tmp=explode("/",$path);
		$go_up=substr($path,strpos($path,$globvars['site']['name'])+strlen($globvars['site']['name'])+1,strlen($path));
		if(!empty($file_dirname)):
			$file_path = $file_dirname.'/'.$file_name;
		else:
			$file_path = $file_name;
		endif;
		$file_path= $go_up=='' ? $file_path: $go_up.'/'.$file_path;
		if(File::isFileType($file_name,'image')) 
			$html = FileInterface::getHtmlImageFileList($i,$url_vars,$class_name,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes);			
		elseif($file_type == "dir")
			$html = FileInterface::getHtmlDirFileList($i,$url_vars,$class_name,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes);			
		else
			$html = FileInterface::getHtmlNormalFileList($i,$url_vars,$class_name,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes);			
		
		return $html;
	}
	
	function getHtmlNormalFileList($i,$url_vars,$class_name,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes) {
		$html = '<tr class="'.$class_name.'" onMouseOver="this.className=\''.$class_name.'_over\'" onMouseOut="this.className=\''.$class_name.'\'" onClick="changeFileListRowClassName(this, \''.$class_name.'\',\'file_'.$i.'\');insertURL(\''.$file_path.'\');" title="'.$file_path.'">
			<td class="filelistCol1"><input type="checkbox" id="file_'.$i.'" name="file_'.$i.'" value="'.$file_path.'" onclick="triggerSelect(this);" /></td>
			<td class="filelistCol2" align="center"><div class="filetype_icon '.strtolower($file_extension).'"></div></td>
			<td class="filelistCol3 filelistFileName">';
		$html .= $permission_classes['hasRenamePermission'][0] ? '<label onclick="renameFileName(this);">'.$file_name.'</label>' : $file_name;
		$html .= '</td>
			<td class="filelistCol4" nowrap="nowrap" align="right">'.$file_size.'</td>
			<td class="filelistCol5" nowrap="nowrap" align="center">'.$last_modify_date.'</td>
			<td class="filelistCol6">
			  <div id="thc_'.$file_path.'" class="filelistCol6Tools">
				<a href="javascript:showPreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'props\',\'Properties\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_props.gif" width="16" height="16" border="0" alt="" /></a>';
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasRenamePermission'][0]) {
			$action = $permission_classes['hasRenamePermission'][0] ? "javascript:fileProps('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasRenamePermission'][1].'" onMouseOver="showToolbarItem(this,\'rename\',\'Rename\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_rename.gif" width="16" height="16" border="0" alt="" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCutPermission'][0]) {
			$action = $permission_classes['hasCutPermission'][0] ? "javascript:execFileAction('cut','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCutPermission'][1].'" onMouseOver="showToolbarItem(this,\'cut\',\'Cut\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_cut_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCopyPermission'][0]) {
			$action = $permission_classes['hasCopyPermission'][0] ? "javascript:execFileAction('copy','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCopyPermission'][1].'" onMouseOver="showToolbarItem(this,\'copy\',\'Copy\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_copy_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasDeletePermission'][0]) {
			$action = $permission_classes['hasDeletePermission'][0] ? "javascript:execFileAction('delete','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasDeletePermission'][1].'" onMouseOver="showToolbarItem(this,\'trash\',\'Delete\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_trash.gif" width="16" height="16" border="0" alt="" /></a>'; 
		}

		$html .= '<a href="javascript:openPop(\'readfile.php?path='.$file_path.'\', screen.width, screen.height);" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'preview\',\'Preview\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_preview.gif" width="16" height="16" border="0" alt="" style="margin-left:4px;" /></a> ';

		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasFileEditPermission'][0]) {
			$action = $permission_classes['hasFileEditPermission'][0] ? "javascript:fileEdit('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasFileEditPermission'][1].'" onMouseOver="showToolbarItem(this,\'edit\',\'Edit\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_edit.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasFileDownloadPermission'][0]) {
			$action = $permission_classes['hasFileDownloadPermission'][0] ? "downloadfile.php?path=".$file_path : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasFileDownloadPermission'][1].'" onMouseOver="showToolbarItem(this,\'download\',\'Download\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_download.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		$html .= '</div> 
			</td>
		</tr>';
		
		return $html;
	}
	
	function getHtmlDirFileList($i,$url_vars,$class_name,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes) {		
		$href = 'filelist.php?path='.$file_path.'&'.$url_vars;
		$onDblClick = ' onDblClick="javascript:document.location=\''.$href.'\'"';
		
		$html = '<tr class="'.$class_name.'" onMouseOver="this.className=\''.$class_name.'_over\'" onMouseOut="this.className=\''.$class_name.'\'" onClick="changeFileListRowClassName(this, \''.$class_name.'\',\'dir_'.$i.'\');" title="'.$file_path.'">
			<td class="filelistCol1"><input type="checkbox" id="dir_'.$i.'" name="dir_'.$i.'" value="'.$file_path.'" onclick="triggerSelect(this);"  /></td>
			<td class="filelistCol2" align="center"><a href="'.$href.'" onmousedown="return false;"><div class="filetype_icon folder"></div></a></td>
			<td class="filelistCol3 filelistFileName" '.$onDblClick.'>';
		$html .= $permission_classes['hasRenamePermission'][0] ? '<label onclick="renameFileName(this);">'.$file_name.'</label>' : $file_name;
		$html .= '</td>
			<td class="filelistCol4" nowrap="nowrap" align="right" '.$onDblClick.'>'.$file_size.'</td>
			<td class="filelistCol5" nowrap="nowrap" align="center" '.$onDblClick.'>'.$last_modify_date.'</td>
			<td class="filelistCol6">
			  <div id="thc_'.$file_path.'" class="filelistCol6Tools"> 
				<a href="javascript:showPreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'props\',\'Properties\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_props.gif" width="16" height="16" border="0" alt="" /></a>';
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasRenamePermission'][0]) {
			$action = $permission_classes['hasRenamePermission'][0] ? "javascript:fileProps('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasRenamePermission'][1].'" onMouseOver="showToolbarItem(this,\'rename\',\'Rename\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_rename.gif" width="16" height="16" border="0" alt="" /></a>'; 
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCutPermission'][0]) {
			$action = $permission_classes['hasCutPermission'][0] ? "javascript:execFileAction('cut','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCutPermission'][1].'" onMouseOver="showToolbarItem(this,\'cut\',\'Cut\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_cut_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCopyPermission'][0]) {
			$action = $permission_classes['hasCopyPermission'][0] ? "javascript:execFileAction('copy','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCopyPermission'][1].'" onMouseOver="showToolbarItem(this,\'copy\',\'Copy\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_copy_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasDeletePermission'][0]) {
			$action = $permission_classes['hasDeletePermission'][0] ? "javascript:execFileAction('delete','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasDeletePermission'][1].'" onMouseOver="showToolbarItem(this,\'trash\',\'Delete\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_trash.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		$html .= '<a href="'.$href.'" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'preview\',\'Open\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_preview.gif" width="16" height="16" border="0" alt="" /></a> ';
		$html .= '</div> 
			</td>
		</tr>';
		
		return $html;
	}
	
	function getHtmlImageFileList($i,$url_vars,$class_name,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes) {
		$html = '<tr class="'.$class_name.'" onMouseOver="this.className=\''.$class_name.'_over\'" onMouseOut="this.className=\''.$class_name.'\'" onClick="changeFileListRowClassName(this, \''.$class_name.'\',\'file_'.$i.'\');insertURL(\''.$file_path.'\');" title="'.$file_path.'">
			<td class="filelistCol1"><input type="checkbox" id="file_'.$i.'" name="file_'.$i.'" value="'.$file_path.'" onclick="triggerSelect(this);" /></td>
			<td class="filelistCol2" align="center"><div class="filetype_icon '.strtolower($file_extension).'"></div></td>
			<td class="filelistCol3 filelistFileName">';
		$html .= $permission_classes['hasRenamePermission'][0] ? '<label onclick="renameFileName(this);">'.$file_name.'</label>' : $file_name;
		$html .= '</td>
			<td class="filelistCol4" nowrap="nowrap" align="right">'.$file_size.'</td>
			<td class="filelistCol5" nowrap="nowrap" align="center">'.$last_modify_date.'</td>
			<td class="filelistCol6">
			  <div id="thc_'.$file_path.'" class="filelistCol6Tools"> 
				<a href="javascript:showPreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'props\',\'Properties\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_props.gif" width="16" height="16" border="0" alt="" /></a>';
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasRenamePermission'][0]) {
			$action = $permission_classes['hasRenamePermission'][0] ? "javascript:fileProps('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasRenamePermission'][1].'" onMouseOver="showToolbarItem(this,\'rename\',\'Rename\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_rename.gif" width="16" height="16" border="0" alt="" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCutPermission'][0]) {
			$action = $permission_classes['hasCutPermission'][0] ? "javascript:execFileAction('cut','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCutPermission'][1].'" onMouseOver="showToolbarItem(this,\'cut\',\'Cut\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_cut_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCopyPermission'][0]) {
			$action = $permission_classes['hasCopyPermission'][0] ? "javascript:execFileAction('copy','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCopyPermission'][1].'" onMouseOver="showToolbarItem(this,\'copy\',\'Copy\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_copy_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasDeletePermission'][0]) {
			$action = $permission_classes['hasDeletePermission'][0] ? "javascript:execFileAction('delete','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasDeletePermission'][1].'" onMouseOver="showToolbarItem(this,\'trash\',\'Delete\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_trash.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		
		$html .= '<a href="javascript:imagePreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'preview\',\'Preview\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_preview.gif" width="16" height="16" border="0" alt="" /></a> ';
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasImageEditPermission'][0]) {
			$action = $permission_classes['hasImageEditPermission'][0] ? "javascript:imageEdit('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasImageEditPermission'][1].'" onMouseOver="showToolbarItem(this,\'edit\',\'Edit\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_edit.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasFileDownloadPermission'][0]) {
			$action = $permission_classes['hasFileDownloadPermission'][0] ? "downloadfile.php?path=".$file_path : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasFileDownloadPermission'][1].'" onMouseOver="showToolbarItem(this,\'download\',\'Download\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_download.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		
		$html .= '</div> 
			</td>
		</tr>';
		
		return $html;
	}
	
	function getHtmlFileThumbnails($root_path,$i,$file,$url_vars,$permission_classes) {
		$file_name = $file[0];
		$file_type = $file[1];
		$file_extension = $file[2];
		$file_dirname = File::cleanRootPath($root_path,$file[3]);
		$file_size = $file[4];
		
		if(empty($file_size)) $file_size = 0;
		
		if(!empty($file_dirname)) $file_path = $file_dirname.'/'.$file_name;
		else $file_path = $file_name;
		
		if(File::isFileType($file_name,'image'))
			$html = FileInterface::getHtmlImageFileThumbnails($root_path,$i,$url_vars,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes);			
		elseif($file_type == 'dir')
			$html = FileInterface::getHtmlDirFileThumbnails($i,$url_vars,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes);			
		else
			$html = FileInterface::getHtmlNormalFileThumbnails($i,$url_vars,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes);			
		
		return $html;
	}
	
	function getHtmlNormalFileThumbnails($i,$url_vars,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes) {
		$file_type_big_icon = file_exists("images/filetypes/big_".$file_extension.".gif") ? "images/filetypes/big_".$file_extension.".gif" : "images/filetypes/big_undefined.gif";
		$file_attributes = 'file_type="'.$file_extension.'" file_size="'.$file_size.'"';
		
		$html = '<div class="thumbnail" id="th_'.$file_path.'" title="'.$file_path.'"> <a name="f_'.$file_path.'"></a> 
		  <div class="image loading" id="thi_'.$file_path.'"> 
			<div class="imagewrapper"> 
			  <div style="float: left;" id="thc_'.$file_path.'">';
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasRenamePermission'][0]) {
			$action = $permission_classes['hasRenamePermission'][0] ? "javascript:fileProps('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasRenamePermission'][1].'" onMouseOver="showToolbarItem(this,\'rename\',\'Rename\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_rename.gif" width="16" height="16" border="0" alt="" /></a>'; 
		}
		$html .= '<a href="javascript:openPop(\'readfile.php?path='.$file_path.'\', screen.width, screen.height);" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'preview\',\'Preview\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_preview.gif" width="16" height="16" border="0" alt="" style="margin-left:4px;" /></a> ';
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasFileEditPermission'][0]) {
			$action = $permission_classes['hasFileEditPermission'][0] ? "javascript:fileEdit('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasFileEditPermission'][1].'" onMouseOver="showToolbarItem(this,\'edit\',\'Edit\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_edit.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasFileDownloadPermission'][0]) {
			$action = $permission_classes['hasFileDownloadPermission'][0] ? "downloadfile.php?path=".$file_path : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasFileDownloadPermission'][1].'" onMouseOver="showToolbarItem(this,\'download\',\'Download\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_download.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		$html .= '<a href="javascript:void(0);" class="mceButtonNormal"><img src="images/toolbaritems/tool_info.gif" width="16" height="16" onmouseover="getFileData(\''.$file_path.'\',\''.$file_path.'\');" onmouseout="hideFileData(\''.$file_path.'\');" border="0" alt="" /></a>';
				
		$html .= '</div> 
			  <div style="float: right;">
				<div class="filetype_icon '.strtolower($file_extension).'"></div>
			  </div> 
			  <br style="clear:both;" /> 
			</div> 
			<div style="width:100%; height:100%; text-align:center; vertical-align:middle;"> 
				<table width="100%" height="100%"><tr><td valign="middle" align="center">
					<div id="file_'.$file_path.'" name="img_spacer_'.$i.'" class="filetype_big_icon big_'.$file_extension.'" '.$file_attributes.'></div> 
				</td></tr></table>
			</div> 
			<div style="position:absolute; bottom:0px; right:0px;">';
		
		$html .= '<a href="javascript:showPreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'props\',\'Properties\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_props.gif" width="16" height="16" border="0" alt="" /></a>';
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCutPermission'][0]) {
			$action = $permission_classes['hasCutPermission'][0] ? "javascript:execFileAction('cut','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCutPermission'][1].'" onMouseOver="showToolbarItem(this,\'cut\',\'Cut\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_cut_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCopyPermission'][0]) {
			$action = $permission_classes['hasCopyPermission'][0] ? "javascript:execFileAction('copy','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCopyPermission'][1].'" onMouseOver="showToolbarItem(this,\'copy\',\'Copy\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_copy_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasDeletePermission'][0]) {
			$action = $permission_classes['hasDeletePermission'][0] ? "javascript:execFileAction('delete','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasDeletePermission'][1].'" onMouseOver="showToolbarItem(this,\'trash\',\'Delete\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_trash.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		
		$html .= '<input type="checkbox" name="file_'.$i.'" value="'.$file_path.'" onclick="triggerSelect(this);insertURL(\''.$file_path.'\');" />
			</div>
		  </div> 
		  <div class="imagename" id="thn_'.$file_path.'" style="position: absolute; top: 155px; width:152px; text-align: center;">';
		$html .= $permission_classes['hasRenamePermission'][0] ? '<label onclick="renameFileName(this);">'.$file_name.'</label>' : $file_name;
		$html .= '</div> 
		</div>';
		
		return $html;
	}
	
	function getHtmlDirFileThumbnails($i,$url_vars,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes) {
		$file_type_icon = 'images/filetypes/big_folder.gif';
		$href = 'thumbnails.php?path='.$file_path.'&'.$url_vars;			
		
		$html = '<div class="thumbnail" id="th_'.$file_path.'" title="'.$file_path.'"> <a name="f_'.$file_path.'"></a> 
		  <div class="image loading" id="thi_'.$file_path.'"> 
			<div class="imagewrapper"> 
			  <div style="float: left;" id="thc_'.$file_path.'">';
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasRenamePermission'][0]) {
			$action = $permission_classes['hasRenamePermission'][0] ? "javascript:fileProps('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasRenamePermission'][1].'" onMouseOver="showToolbarItem(this,\'rename\',\'Rename\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_rename.gif" width="16" height="16" border="0" alt="" /></a>';
		}
		$html .= '<a href="'.$href.'" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'preview\',\'Open\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_preview.gif" width="16" height="16" border="0" alt="" style="margin-left:4px;" /></a> ';
		
		$html .= '</div> 
			  <br style="clear:both;" /> 
			</div> 
			<div style="width:100%; height:100%; text-align:center; vertical-align:middle;"> 
				<table width="100%" height="100%"><tr><td valign="middle" align="center">
					<a href="'.$href.'">
						<img id="dir_'.$file_path.'" name="img_spacer_'.$i.'" src="'.$file_type_icon.'" alt="'.$file_path.'" title="'.$file_type_icon.'" border="0" width="38" height="37" /> 
					</a>
				</td></tr></table>
			</div> 
			<div style="position:absolute; bottom:0px; right:0px;">';
		
		$html .= '<a href="javascript:showPreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'props\',\'Properties\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_props.gif" width="16" height="16" border="0" alt="" /></a>';
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCutPermission'][0]) {
			$action = $permission_classes['hasCutPermission'][0] ? "javascript:execFileAction('cut','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCutPermission'][1].'" onMouseOver="showToolbarItem(this,\'cut\',\'Cut\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_cut_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCopyPermission'][0]) {
			$action = $permission_classes['hasCopyPermission'][0] ? "javascript:execFileAction('copy','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCopyPermission'][1].'" onMouseOver="showToolbarItem(this,\'copy\',\'Copy\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_copy_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasDeletePermission'][0]) {
			$action = $permission_classes['hasDeletePermission'][0] ? "javascript:execFileAction('delete','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasDeletePermission'][1].'" onMouseOver="showToolbarItem(this,\'trash\',\'Delete\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_trash.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		$html .= '<input type="checkbox" name="dir_'.$i.'" value="'.$file_path.'" onclick="triggerSelect(this);" />';
		
		$html .= '</div>
		  </div> 
		  <div class="imagename" id="thn_'.$file_path.'" style="position: absolute; top: 155px; width:152px; text-align: center;">';
		$html .= $permission_classes['hasRenamePermission'][0] ? '<label onclick="renameFileName(this);">'.$file_name.'</label>' : $file_name;
		$html .= '</div> 
		</div>';
		
		return $html;
	}
	
	function getHtmlImageFileThumbnails($root_path,$i,$url_vars,$file_name,$file_type,$file_extension,$file_dirname,$file_size,$last_modify_date,$file_path,$permission_classes) {
		$thumbnail_filename = ThumbnailImageLL::getThumbnail($root_path.$file_path);
		$thumbnail_image_allowed = ThumbnailImageLL::getThumbnailImageDefault() != $thumbnail_filename ? true : false;
		
		$image_information = File::getImageFileInformation($root_path.$file_path);
		$image_width = $image_information[0];
		$image_height = $image_information[1];
		
		if($image_width > 146 || $image_height > 113)
			$scale = $image_width > $image_height ? 146/$image_width : 113/$image_height;
			
		$scale = empty($scale) ? 1 : $scale;
		$image_show_width = round($image_width*$scale,0);
		$image_show_height = round($image_height*$scale,0);
		
		$image_attributes = 'img_width="'.$image_width.' px" img_height="'.$image_height.' px" img_type="'.$file_extension.'" img_size="'.$file_size.'" img_scale="'.round($scale,2).'"';
		
		$html = '<div class="thumbnail" id="th_'.$file_path.'" title="'.$file_path.'"> <a name="f_'.$file_path.'"></a> 
		  <div class="image loading" id="thi_'.$file_path.'"> 
			<div class="imagewrapper"> 
			  <div style="float: left;" id="thc_'.$file_path.'">';
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasRenamePermission'][0]) {
			$action = $permission_classes['hasRenamePermission'][0] ? "javascript:fileProps('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasRenamePermission'][1].'" onMouseOver="showToolbarItem(this,\'rename\',\'Rename\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_rename.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		
		$html .= '<a href="javascript:imagePreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'preview\',\'Preview\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_preview.gif" width="16" height="16" border="0" alt="" /></a>';		
		
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasImageEditPermission'][0]) {
			$action = $permission_classes['hasImageEditPermission'][0] ? "javascript:imageEdit('".$file_path."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasImageEditPermission'][1].'" onMouseOver="showToolbarItem(this,\'edit\',\'Edit\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_edit.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasFileDownloadPermission'][0]) {
			$action = $permission_classes['hasFileDownloadPermission'][0] ? "downloadfile.php?path=".$file_path : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasFileDownloadPermission'][1].'" onMouseOver="showToolbarItem(this,\'download\',\'Download\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_download.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		$html .= '<a href="javascript:void(0);" class="mceButtonNormal"><img src="images/toolbaritems/tool_info.gif" width="16" height="16" onmouseover="getImageData(\''.$file_path.'\',\''.$file_path.'\');" onmouseout="hideImageData(\''.$file_path.'\');" border="0" alt="" /></a> ';		
		
		$html .= '</div> 
			  <div style="float: right;">
				  <div class="filetype_icon '.$file_extension.'"></div>
			  </div> 
			  <br style="clear:both;" /> 
			</div> 
			<div style="width:100%; height:100%; text-align:center; vertical-align:middle;"> 
			<table width="100%" height="100%"><tr><td valign="middle" align="center">';
		
		if($thumbnail_image_allowed)
			$html .= '<img id="img_'.$file_path.'" name="img_spacer_'.$i.'" src="readfile.php?path='.File::cleanRootPath($root_path,$thumbnail_filename).'" alt="'.$thumbnail_filename.'" title="'.$file_path.'" border="0" width="'.$image_show_width.'" height="'.$image_show_height.'" '.$image_attributes.'/>';
		else 
			$html .= '<table width="100%" height="100%"><tr><td valign="middle" align="center">
						<img id="img_'.$file_path.'" name="img_spacer_'.$i.'" src="readfile.php?path='.File::cleanRootPath($root_path,$thumbnail_filename).'" alt="'.$file_path.'" title="'.$file_path.'" border="0" '.$image_attributes.'/> 
					  </td></tr></table>';
		$html .= '</td></tr></table>
			</div> 
			<div style="position:absolute; bottom:0px; right:0px;">';
		
		$html .= '<a href="javascript:showPreview(\''.$file_path.'\');" class="mceButtonNormal" onMouseOver="showToolbarItem(this,\'props\',\'Properties\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_props.gif" width="16" height="16" border="0" alt="" /></a>';
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCutPermission'][0]) {
			$action = $permission_classes['hasCutPermission'][0] ? "javascript:execFileAction('cut','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCutPermission'][1].'" onMouseOver="showToolbarItem(this,\'cut\',\'Cut\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_cut_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasCopyPermission'][0]) {
			$action = $permission_classes['hasCopyPermission'][0] ? "javascript:execFileAction('copy','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasCopyPermission'][1].'" onMouseOver="showToolbarItem(this,\'copy\',\'Copy\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_copy_small.gif" width="16" height="16" border="0" /></a>';
		}
		if($permission_classes['show_tools_without_perms'] || $permission_classes['hasDeletePermission'][0]) {
			$action = $permission_classes['hasDeletePermission'][0] ? "javascript:execFileAction('delete','".$file_dirname."','".$file_name."');" : "#";
			$html .= '<a href="'.$action.'" class="'.$permission_classes['hasDeletePermission'][1].'" onMouseOver="showToolbarItem(this,\'trash\',\'Delete\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_trash.gif" width="16" height="16" border="0" alt="" /></a> ';
		}
		
		$html .= '<input type="checkbox" name="file_'.$i.'" value="'.$file_path.'" onclick="triggerSelect(this);insertURL(\''.$file_path.'\');" />
			</div>
		  </div> 
		  <div class="imagename" id="thn_'.$file_path.'" style="position: absolute; top: 155px; width:152px; text-align: center;">';
		$html .= $permission_classes['hasRenamePermission'][0] ? '<label onclick="renameFileName(this);">'.$file_name.'</label>' : $file_name;
		$html .= '</div> 
		</div>';
		
		return $html;
	}
}
?>