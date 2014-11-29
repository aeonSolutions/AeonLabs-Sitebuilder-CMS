function init() {
	var filelistmanager = parent.document.getElementById('filelistmanager');
	if(filelistmanager && filelistmanager.contentWindow) {
		var filemanager = filelistmanager.contentWindow.document.getElementById('hidepreviewframe');
		if(filemanager) {
			var img = filemanager.contentWindow.document.getElementById('img_frame_id');
			if(img) {
				img.className = 'tool_frame_vertical tool_frame_right';
				img.onmouseout = function() { this.className = 'tool_frame_vertical tool_frame_right'; };
				img.onmouseover = function() { this.className = 'tool_frame_vertical tool_frame_right_on'; };
			}
		}
	}
};

function showAndHideCont(id) {
	var element = document.getElementById(id);
	if(element)
		element.style.display = element.style.display == 'none' ? 'block' : 'none';
};

function changeImageIfContIsOpen(cont_id, img_id) {
	var cont = document.getElementById(cont_id);
	var img = document.getElementById(img_id);
	if(cont && img)
		img.src = cont.style.display == 'none' ? 'images/back_li_row_right.png' : 'images/back_li_row_down.png';
};

