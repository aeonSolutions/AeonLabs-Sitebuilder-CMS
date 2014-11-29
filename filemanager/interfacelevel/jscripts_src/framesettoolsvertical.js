/*<frameset id="filemanager_frameset" rows="*" cols="200,*,300" framespacing="0px" subframesnames="dirlist,filelistmanager,preview">
	<frame id="dirlist" name="dirlist" src="dirlist.php?path=<? echo $path;?>" frameborder="1px" scrolling="auto" marginwidth="0" marginheight="0" framecols="200" />
	<frame id="filelistmanager" name="filelistmanager" src="filelistmanager.php?path=<? echo $path;?>" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" framecols="*" />
	<frame id="preview" name="preview" src="preview.php?path=<? echo $path;?>" frameborder="1px" scrolling="no" marginwidth="0" marginheight="0" framecols="300" />
</frameset>*/

function displayInternalFrame(frameId) {
	var filemanager = parent.parent.document.getElementById('filemanager_frameset');
	var framescols = filemanager.getAttribute('cols');
	var subframesnames = filemanager.getAttribute('subframesnames');
	
	var cols = framescols.split(',');
	var subframes = subframesnames.split(',');

	var frame_i, frame_i_id, frameclosed;
	var newcols = '';
	for(var i = 0; i < subframes.length; ++i) {
		frame_i = parent.parent.document.getElementById(subframes[i]);
		frame_i_id = frame_i.getAttribute('id');
		
		if(i > 0) newcols += ',';
		
		if(frame_i_id == frameId){
			newcols += cols[i] > 10 ? '0': frame_i.getAttribute('framecols');
			frame_i.setAttribute('isclosed',cols[i] > 10 ? 1 : 0);
		}else {newcols += cols[i];}
	}
	filemanager.setAttribute('cols',newcols);
	filemanager.cols = newcols;
};

function changeFramesetImage(imgId,frameId,direction) {
	var frame = parent.parent.document.getElementById(frameId);
	var frameclosed = frame.getAttribute('isclosed');
	
	if(direction == 'left')
		direction = (frameclosed == 1) ? 'right' : 'left';
	else if(direction == 'right')
		direction = (frameclosed == 1) ? 'left' : 'right';
	
	if(direction) {
		var img = document.getElementById(imgId);
		img.className = 'tool_frame_vertical tool_frame_'+direction;
		img.onmouseout = function() { this.className = 'tool_frame_vertical tool_frame_'+direction; };
		img.onmouseover = function() { this.className = 'tool_frame_vertical tool_frame_'+direction+'_on'; };
	}
};

function resizeFileListTable() {

};