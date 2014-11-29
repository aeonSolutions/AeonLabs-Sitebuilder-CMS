<div id="toolbar"> 
  <div id="toolbaritems" class="toolbaritems"> 
    <div style="float: left"> 
		<nobr> 
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['create_folder_permission']) {?><a id="createdir" class="mceButtonDisabled" href="javascript:execFileCommand('createdir');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'createdir','Create Dir');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_folder.gif" alt="Create directory" title="Create directory" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['create_doc_permission']) {?><a id="createdoc" class="mceButtonDisabled" href="javascript:execFileCommand('createdoc');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'createdoc','Create Doc');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_new.gif" alt="Create file" title="Create file" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['create_folder_permission'] || $CONFIG['create_doc_permission']) {?><img src="images/toolbaritems/separator.gif" width="1" height="20" class="mceSeparatorLine" /><? }?>
			<a id="refresh" class="mceButtonDisabled" href="javascript:execFileCommand('refresh');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'refresh','Refresh');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_refresh.gif" alt="Refresh" title="Refresh" border="0" width="20" height="20" /></a>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['upload_permission']) {?><a id="upload" class="mceButtonDisabled" href="javascript:execFileCommand('upload');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'upload','Upload');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_upload.gif" alt="Upload new file" title="Upload new file" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['search_permission']) {?><a id="search" class="mceButtonDisabled" href="javascript:execFileCommand('search');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'search','Search');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_search.gif" alt="Search" title="Search" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['zip_permission']) {?><a id="zip" class="mceButtonDisabled" href="javascript:execFileCommand('zip');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'zip','Zip');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_zip.gif" alt="Zips the selected files/directories" title="Zips the selected files/directories" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['unzip_permission']) {?><a id="unzip" class="mceButtonDisabled" href="javascript:execFileCommand('unzip');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'unzip','Unzip');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_unzip.gif" alt="Unzips the specified file" title="Unzips the specified file" border="0" width="20" height="20" /></a><? }?>
			<img src="images/toolbaritems/separator.gif" width="1" height="20" class="mceSeparatorLine" />
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['cut_permission']) {?><a id="cut" class="mceButtonDisabled" href="javascript:execFileCommand('cut');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'cut','Cut');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_cut.gif" alt="Cut selected files/directories" title="Cut selected files/directories" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['copy_permission']) {?><a id="copy" class="mceButtonDisabled" href="javascript:execFileCommand('copy');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'copy','Copy');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_copy.gif" alt="Copy selected files/directories" title="Copy selected files/directories" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['cut_permission'] || $CONFIG['copy_permission']) {?><a id="paste" class="mceButtonDisabled" href="javascript:execFileCommand('paste');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'paste','Paste');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_paste.gif" alt="Paste files/directories" title="Paste files/directories" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['delete_permission']) {?><a id="delete" class="mceButtonDisabled" href="javascript:execFileCommand('delete');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'delete','Delete');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_del.gif" alt="Delete selected files/directories" title="Delete selected files/directories" border="0" width="20" height="20" /></a><? }?>
			<? if($CONFIG['show_tools_without_perms'] || $CONFIG['cut_permission'] || $CONFIG['copy_permission'] || $CONFIG['delete_permission']) {?><img src="images/toolbaritems/separator.gif" width="1" height="20" class="mceSeparatorLine" /><? }?>
			<a id="toggleall" class="mceButtonDisabled" href="javascript:execFileCommand('toggleall');" onmousedown="return false;" onMouseOver="showToolbarItem(this,'toggleall','Toggle All');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/box.gif" alt="Toggle all" title="Select all files"  border="0" width="20" height="20" /></a>			
			<?
			if($php_file_name != "filelist.php") {	
				echo '<a id="zoom_out" class="mceButtonDisabled" href="javascript:thumbnailsZoomOut()" onmousedown="return false;" onMouseOver="showToolbarItem(this,\'zoom_out\',\'Zoom Out\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/zoom_out.gif" alt="Zoom out" title="Zoom out"  border="0" width="20" height="20" /></a>
				<a id="zoom_in" class="mceButtonDisabled" href="javascript:thumbnailsZoomIn()" onmousedown="return false;" onMouseOver="showToolbarItem(this,\'zoom_in\',\'Zoom In\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/zoom_in.gif" alt="Zoom in" title="Zoom in"  border="0" width="20" height="20" /></a>';
				if(!empty($path))
					echo '<img src="images/toolbaritems/separator.gif" width="1" height="20" class="mceSeparatorLine" />
					<a id="upfolder" class="mceButtonDisabled" href="javascript:window.location=\''.$php_file_name.'?path='.substr($path,strlen($globvars['site']['directory']),strlen($path)).'&'.$url_vars.'\'" onmousedown="return false;" onMouseOver="showToolbarItem(this,\'upfolder\',\'Up Folder\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/upfolder.gif" alt="Up Folder" title="Up Folder"  border="0" width="20" height="20" /></a>';
			}
			?>
		</nobr> 
	</div> 
    <div style="float: right"> 
		<nobr> 
			<img src="images/toolbaritems/separator.gif" width="1" height="20" />
			<?
			if($php_file_name == "filelist.php") 
				echo '<a id="imagemanager" class="mceButtonDisabled" href="javascript:execFileCommand(\'imagemanager\',\''.substr($path,strlen($globvars['site']['directory']),strlen($path)).'\');" onmousedown="return false;" onMouseOver="showToolbarItem(this,\'imagemanager\',\'Thumbnails\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_imagemanager.gif" alt="Switch to Image Manager" title="Switch to Image Manager" border="0" width="20" height="20" /></a>';
			else
				echo '<a id="filemanager" class="mceButtonDisabled" href="javascript:execFileCommand(\'filemanager\',\''.substr($path,strlen($globvars['site']['directory']),strlen($path)).'\');" onmousedown="return false;" onMouseOver="showToolbarItem(this,\'filemanager\',\'File Details\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_filemanager.gif" alt="Switch to File Manager" title="Switch to File Manager" border="0" width="20" height="20" /></a>';
			
			if($CONFIG['filemanager_homepage'] || $CONFIG['php_log_path'] || $CONFIG['server_log_path'])
				echo '<img src="images/toolbaritems/separator.gif" width="1" height="20" />
				<a id="help" class="mceButtonDisabled" href="javascript:execFileCommand(\'help\');" onmousedown="return false;" onMouseOver="showToolbarItem(this,\'help\',\'Help\');" onMouseOut="hideToolbarItem();"><img src="images/toolbaritems/tool_help.gif" alt="Help" title="Help" border="0" width="20" height="20" /></a>';
			?>
			<img src="images/toolbaritems/separator.gif" width="1" height="20" />
		</nobr> 
	</div> 
    <br style="clear: both" /> 
  </div> 
  
  <div class="filelistPath" title="/"><? 
  	$root_path_name = $globvars['site']['directory'];
	$strrpos_index = strrpos($root_path_name,"/");
	if(is_numeric($strrpos_index) && $strrpos_index == strlen($root_path_name)-1):
		$root_path_name = substr($root_path_name,0,strlen($root_path_name)-1);
	endif;
	echo '<a href="'.$php_file_name.'?path=&'.$url_vars.'">'.$root_path_name.'</a>&nbsp;/&nbsp;';
	$explode = explode("/",$path);
	$explode_init = explode("/",$globvars['site']['directory']);
	$explode_path = '';
	for($i=0; $i < count($explode); ++$i):
		if (isset($explode_init[$i])):
			if(!empty($explode[$i]) and $explode[$i]<>$explode_init[$i]):
				$explode_path .= $explode[$i];
				echo '<a href="'.$php_file_name.'?path='.$explode_path.'&'.$url_vars.'">'.$explode[$i].'</a>&nbsp;/&nbsp;';
				$explode_path.='/';
			endif;
		else:
			$explode_path .= $explode[$i];
			echo '<a href="'.$php_file_name.'?path='.$explode_path.'&'.$url_vars.'">'.$explode[$i].'</a>&nbsp;/&nbsp;';
			$explode_path.='/';
		endif;
	endfor;
?> 
  </div> 
  
  <div id="selectedToolbaritems" class="selectedToolbaritems" onMouseOut="hideToolbarItem();">
  	<img id="selectedActionIcon" class="selectedActionIcon"/>
  	<div id="selectedActionLabel" class="selectedActionLabel"></div>
  </div>
  
</div> 

<div id="loadingbar"><div id="subloadingbar">Loading ...</div></div>

<? if($CONFIG['filemanager_homepage'] || $CONFIG['php_log_path'] || $CONFIG['server_log_path']) {?>
<div id="helpbar">
	<div id="subhelpbar">
		<img id="dotimg" src="images/back_li_dot.png"/>
		<label>Information</label>
		<div id="closehelp" onClick="document.getElementById('helpbar').style.display='none';" title="Close"></div>
	</div>
	<div id="conthelp">
		<ul>
			<? if ($CONFIG['filemanager_homepage']) echo '<li><a href="'.$CONFIG['filemanager_homepage'].'" target="_blank">See the FileManager Home Page</a></li>';?>
			<? if ($CONFIG['php_log_path']) echo '<li><a href="'.$CONFIG['php_log_path'].'" target="_blank">Download PHP Log File</a></li>';?>
			<? if ($CONFIG['server_log_path']) echo '<li><a href="'.$CONFIG['server_log_path'].'" target="_blank">Download Apache Log File</a></li>';?>
		</ul>
	</div>
</div>
<? }

if(!$CONFIG['read_permission'])
	echo "<script>alert('".str_replace("'","\'",$CONFIG['read_permission_denied_message'])."');</script>";
?>