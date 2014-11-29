	// Setup some variables.
	var errorMsg = "";
	var confirm_cut = "Are you sure you want to cut/move the selected files?";
	var confirm_copy = "Are you sure you want to copy the selected files?";
	var confirm_paste = "Are you sure you want to paste the files from clipboard here?";
	var confirm_delete = "Are you sure you want to delete the selected files?";
	var confirm_unzip = "Are you sure you want to unzip the selected file(s)?\nIf the total size is very large, the unzip procedure might take a while.";
	var zip_removed = "The following files were removed, because you cannot select more than one file and without a zip, gz or tar extensions:";
	
	var editNoWriteAccess = "No write access, temporary files can not be created.";
	var current = "";

	var insert_file_name_null = "The file name cannot be undefined.";
	var insert_file_name_error = "File name not renamed.";
	var insert_file_name_error_permission = "Sorry you don't have permission to rename files.";


function keepSessionAlive() {
	var img = new Image();

	img.src = "session_keepalive.php?rnd=" + new Date().getTime();

	window.setTimeout('keepSessionAlive();', 1000 * 60);
};

keepSessionAlive();

function execFileAction(selectedaction, path, filename) {
	if (confirm("Are you sure you want to "+ selectedaction +" the file "+ filename +"?")) {
		showLoadingBar();
		document.location.href = fileSrc+"?selected_action="+ selectedaction +"&path="+ path +"&filename="+ filename +"&imageaction=1" + "&"+urlVars;
	}
	else {
		return;
	}
};

function execFileCommand(command, value) {	
	//var formObj = document.forms['filelistForm'];
	var formObj = getForm('filelistForm');

	if (isDisabled(command))
		return;

	if (typeof(value) == "undefined")
		value = path;

	// If command disabled then do nothing
	if (!isCommandEnabled(command))
		return;

	switch (command) {
		case "toggleall":
			toggleAll();
			break;
			
		case "createdir":
			openPop("createdir.php?path=" + value + "&" + urlVars, 565, 420, "no", "no", "FileManagerPopup_CreateDir");
			break;

		case "createdoc":
			openPop("createdoc.php?path=" + value + "&"+urlVars, 565, 420, "no", "no", "FileManagerPopup_CreateDoc");
			break;

		case "upload":
			openPop("upload.php?path=" + value + "&"+urlVars, 400, 590, "no", "no", "FileManagerPopup_Upload");
			break;

		case "search":
			openPop("filesearch.php?path=" + value + "&"+urlVars, 565, 450, "no", "no", "FileManagerPopup_Search");
			break;

		case "filemanager":
			showLoadingBar();
			document.location.href = "filelist.php?path="+ value + "&"+urlVars;
			break;

		case "imagemanager":
			showLoadingBar();
			document.location.href = "thumbnails.php?path="+ value + "&"+urlVars;
			break;

		case "props":
			var selPath = "";

			if (selectedFiles.length > 0)
				selPath = selectedFiles[0];

			if (selectedDirs.length > 0)
				selPath = selectedDirs[0];
			
			if(selPath != "")
				openPop("fileprops.php?path=" + selPath + "&"+urlVars, 290, 370, "no", "no", "FileManagerPopup_Props");
			
			break;

		case "cut":
			if (confirm(confirm_cut)) {
				showLoadingBar();
				formObj.selected_action.value = "cut";
				formObj.submit();
			}
			break;

		case "copy":
			if (confirm(confirm_copy)) {
				showLoadingBar();
				formObj.selected_action.value = "copy";
				formObj.submit();
			}
			break;

		case "paste":
			if (confirm(confirm_paste)) {
				showLoadingBar();
				formObj.selected_action.value = "paste";
				formObj.submit();
			}
			break;

		case "delete":
			if (confirm(confirm_delete)) {
				showLoadingBar();
				formObj.selected_action.value = "delete";
				formObj.submit();
			}
			break;

		case "refresh":
			if (!formObj.x) {
				//showPreview(value);
				formObj.selected_action.value = "refresh";
				formObj.submit();
				formObj.x = true;
			}
			break;
			
		case "zip":
			openPop("zip.php?path=" + value + "&"+urlVars, 350, 350, "no", "no", "FileManagerPopup_Zip");
			break;

		case "unzip":
			var filepos;
			var filename;
			var selectedFile = "";
			var removedFiles = "";

			if (selectedFiles.length > 0) {
				for (var i=0; i<selectedFiles.length; i++) {
					filepos = selectedFiles[i].lastIndexOf("/");
					dotpos = selectedFiles[i].lastIndexOf(".");
					filename = selectedFiles[i].substring(filepos+1);
					fileext = selectedFiles[i].substring(dotpos+1);
					fileext = fileext.toLowerCase();
					
					if (selectedFile == "" && (fileext == "zip" || fileext == "gz" || fileext == "tar" || fileext == "tgz") ) {
						selectedFile = filename;
					} else {				
						removedFiles += "- " + filename + "\n";
					}
				}
				for (var i=0; i<selectedDirs.length; i++) {
					removedFiles += "- " + selectedDirs[i] + "\n";
				}
				removedFiles = removedFiles.substring(0,removedFiles.length-1);

				if (removedFiles != "")
					alert(zip_removed +"\n"+ removedFiles);

			}
			if (selectedFile != "") {
				if (confirm(confirm_unzip)) {
					openPop("unzip.php?path=" + value + "&zip_file_name="+ selectedFile + "&"+urlVars, 640, 530, "no", "no", "FileManagerPopup_Unzip");
				}
			}
	
			break;
			
		case "help":
			showHelp();
			break;
	}
};

function imagePreview(imagePath) {
	openPop("previewimage.php?imagePath="+ imagePath + "&path=" + path + "&" + urlVars, screen.availWidth, screen.availHeight, "no");
};

function imageEdit(path) {
	if (!hasImageEditPermission) {
		alert(editNoWriteAccess);
		return;
	}

	if (path != "") 
		openPop('../ImageManager/backend.php?__plugin=ImageManager&__function=editor&img=' + path + "&"+urlVars, screen.availWidth, screen.availHeight, "no", "yes", "ImageEditor");
};

function fileEdit(path) {
	if (!hasFileEditPermission) {
		alert(editNoWriteAccess);
		return;
	}

	if (path != "") 
		openPop('editfile.php?path=' + path + "&"+urlVars, screen.availWidth, screen.availHeight, "no", "yes", "fileEditor");
};

function fileProps(path) {
	if (path != "") 
		openPop('fileprops.php?path=' + path + "&"+urlVars, 290, 370, "no", "no", "FileManagerPopup_Props");
};

function isCommandEnabled(command) {
	var elm = document.getElementById(command);

	return elm && elm.commandEnabled;
};

function isDisabled(command) {
	for (var i=0; i<disabledTools.length; i++) {
		if (command == disabledTools[i])
			return true;
	}

	return false;
};

function setCommandEnabled(command, state) {
	if (isDisabled(command))
		return;

	var elm = document.getElementById(command);
	if (elm)
		elm.commandEnabled = state;

	if (state) {
		setClassLock(command, false);
		switchClass(command, 'mceButtonNormal');
	} else {
		switchClass(command, 'mceButtonDisabled');
		setClassLock(command, true);
	}
};

function buttonEventHandler(e) {
	var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
	e = isMSIE ? window.event : e;
	var srcElm = isMSIE ? e.srcElement : e.target;

	if (typeof(isDisabled) == "undefined")
		return;

	if (isDisabled(srcElm.getAttribute('id')))
		return;

	switch (e.type) {
		case "mouseover":
			switchClass(srcElm.getAttribute('id'), 'mceButtonOver');
			break;

		case "mouseup":
		case "mouseout":
			switchClass(srcElm.getAttribute('id'), 'mceButtonNormal');
			break;

		case "mousedown":
			switchClass(srcElm.getAttribute('id'), 'mceButtonDown');
			break;
	}
};

function showPreview(path) {
	if (parent.parent.frames && parent.parent.frames['preview']) {
		openPreviewFrameIfClosed();
		parent.parent.frames['preview'].document.location = "preview.php?path=" + path + "&" + urlVars;
	}
};

function previewFrameIsOpen() {
	var filemanager = parent.parent.document.getElementById('filemanager_frameset');
	var framescols = filemanager.getAttribute('cols');
	var cols = framescols.split(',');
	return cols[2] >= 10;
};

function openPreviewFrameIfClosed() {
	var filemanager = parent.parent.document.getElementById('filemanager_frameset');
	var framescols = filemanager.getAttribute('cols');
	var cols = framescols.split(',');
	if(cols[2] < 10) {
		var preview = parent.parent.document.getElementById('preview');
		cols[2] = preview.getAttribute('framecols');	
		framescols = cols.join(',');
		filemanager.setAttribute('cols',framescols);
		filemanager.cols = framescols;
	}
};

function updateCutedAndCopiedFiles(strFiles) {
	if (parent.parent.frames && parent.parent.frames['preview']) {
		var copiedfilesdiv = parent.parent.frames['preview'].document.getElementById('copiedfilesdiv');
		if(copiedfilesdiv) {
			copiedfilesdiv.innerHTML = "";
			
			var exists = false;
			if(strFiles) {
				var files = strFiles.split("|");
				if(files.length > 0) {
					var filename, index;
					for(var i = 0; i < files.length; ++i) {
						filename = files[i];
						if(filename != "") {
							copiedfilesdiv.innerHTML += '<div class="fileName"><label>'+filename+'<label></div>';
							exists = true;
						}
					}
				}
			}
			if(!exists){copiedfilesdiv.innerHTML = '<div class="fileName">No selected files!</div>';}
		}
	}
};

function updateTools() {
	selectedFiles = new Array();
	selectedDirs = new Array();
	var previewPath;

	var formElm = getForm('filelistForm');

	for (var i=0; i<formElm.elements.length; i++) {
		var element = formElm.elements[i];
		if (element.checked) {
			if (element.name.indexOf('dir_') != -1) {
				selectedDirs[selectedDirs.length] = element.value;
			} else {
				selectedFiles[selectedFiles.length] = element.value;
			}
		}
	}

	// Show hide tools
	if (selectedDirs.length > 0 || selectedFiles.length > 0) {
		setCommandEnabled('cut', hasCutPermission);
		setCommandEnabled('paste', hasPasteAccess);
		setCommandEnabled('delete', hasDeletePermission);
		setCommandEnabled('zip', hasZipPermission);
		setCommandEnabled('unzip', false);
		
		if(hasUnzipPermission) {
			var extension;
			for (var i=0; i<selectedFiles.length; i++) {
				extension = selectedFiles[i].substring(selectedFiles[i].length-3,selectedFiles[i].length);
				extension = extension.toLowerCase();
				if(extension == "zip" || extension == ".gz" || extension == "tar" || extension == "tgz") {
					setCommandEnabled('unzip', true);
					break;
				}
			}
		}

		if ((selectedDirs.length + selectedFiles.length) == 1) {
			setCommandEnabled('props', hasRenamePermission);
		} else {
			setCommandEnabled('props', false);
		}

		setCommandEnabled('copy', hasCopyPermission);
	} else {
		setCommandEnabled('cut', false);
		setCommandEnabled('copy', false);
		setCommandEnabled('paste', hasPasteAccess);
		setCommandEnabled('delete', false);
		setCommandEnabled('props', false);
		setCommandEnabled('unzip', false);
		setCommandEnabled('zip', false);
	}
};

function toggleAll() {
	showLoadingBar();
	
	var formObj = getForm('filelistForm');
	for (var i=0; i<formObj.elements.length; i++) {
		if (formObj.elements[i].type == "checkbox" && !formObj.elements[i].disabled)
			formObj.elements[i].checked = formObj.elements[i].checked ? false : true;
	}
	
	var tableObj = document.getElementById('filelisttable');
	if(tableObj)
		for (i=0; i<tableObj.rows.length; i++) {
			if(tableObj.rows[i].onclick)
				tableObj.rows[i].onclick();
		}
	
	updateTools();
	hideLoadingBar();
};

function triggerSelect(elm) {

	updateTools();

	var previewPath;
	if (selectedDirs.length == 0 && selectedFiles.length == 0) {
		previewPath = path;
	} else {previewPath = elm.value;}

	//showPreview(previewPath);
};

function changeFileListRowClassName(row, class_name, id) {
	var checkbox = document.getElementById(id);

	if(row.className != 'selectedFilelistRow') {
		row.className = 'selectedFilelistRow';
		triggerSelect(this);
		row.onmouseout = function() {
			row.className = 'selectedFilelistRow';
		};
		row.onmouseover = function() {
			row.className = 'selectedFilelistRow';
		};

		if(checkbox) {
			checkbox.checked = true;
			triggerSelect(checkbox);
		}
	}
	else {
		row.className = class_name;
		row.onmouseout = function() {
			row.className = class_name;
		};
		row.onmouseover = function() {
			row.className = class_name+'_over';
		};
		
		if(checkbox) {
			checkbox.checked = false;
			triggerSelect(checkbox);
		}
	}
};

function showHelp() {
	var help = document.getElementById('helpbar');
	if(help)
		help.style.display = 'block';
	
};

function insertURL(url) {
	parent.parent.insertURL(url);
};

function correctFileListDivScroll(div_name) {
	var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
	if(isMSIE) {
		var version = navigator.appVersion;
		if(version.indexOf("MSIE 6") > 0 || version.indexOf("MSIE 5") > 0 || version.indexOf("MSIE 4") > 0 || version.indexOf("MSIE 3") > 0) {
			var filelist = document.getElementById(div_name);
			var frame = parent.document.getElementById('filelist');
			
			var filelist_scroll_height = filelist.scrollHeight;
			var document_client_height = filelist_scroll_height+23+33+24;
			var document_scroll_height = document_client_height-frame.height;
			var filelist_client_height = filelist_scroll_height-document_scroll_height;
			
			filelist.style.height = filelist_client_height-13;
		}
	}
};

function renameFileName(label) 
{
	var input = label.getElementsByTagName('input').item(0);
	if(!input || input.nodeName != 'INPUT') {
		var value = label.innerHTML;
		label.innerHTML = '<input id="input" type="text" onblur="saveFileName(this);" onkeypress="if(event.keyCode==13){this.blur();return false;}else{this.focus();}" value="'+value+'" filename="'+value+'" onmouseover="this.focus();" onclick="this.focus();" style="z-index:200;" ;/>';
		input = label.getElementsByTagName('input').item(0);
	}
	input.focus();
};
		
function saveFileName(input) {
	if(input.value != '') {
		input.value = input.value.replace(/\//g,"");
		input.value = input.value.replace(/'/g,"");
		var filename = input.getAttribute('filename');
		var newfilename = input.value;
		var label = input.parentNode;
		
		if(newfilename != filename) {
			showLoadingBar();
			var query_string = urlVars+"&submitfilerename=1&path="+path+filename+'&filename='+newfilename;
			ajax.get('./../logiclevel/filerename_ll.php?'+query_string,updateFileRename,new Array(filename,newfilename,label),true);
		}
		else {
			label.innerHTML = newfilename;
		}
	}
	else {
		alert(insert_file_name_null);
	}
};

function updateFileRename(result,args) {
	var filename = args[0];
	var newfilename = args[1];
	var label = args[2];

	if(result == 1) {
		label.innerHTML = newfilename;
		updateRenamedFileListHtml(filename,newfilename);
		window.parent.parent.parent.frames['dirlist'].renameNode(path+filename,path+newfilename);
	}
	else {
		label.innerHTML = filename;
		
		if(result == 2) {
			alert(insert_file_name_error);
			label.innerHTML = filename;
		}
		else if(result == 3){
			alert(insert_file_name_error_permission);
		}
		else if(result != '') {
			alert(result);
		}
	}
	hideLoadingBar();
};

function updateRenamedFileListHtml(filename,newfilename) {
	var fileListDiv = document.getElementById('filelist');
	var isThumbnail = false;
	if(!fileListDiv) {
		fileListDiv = document.getElementById('thwrapperdiv');
		isThumbnail = true;
	}
	
	var html = fileListDiv.innerHTML;
	
	var regexp = new Array();
	regexp.push({oldname: '"'+path+filename+'"', newname: '"'+path+newfilename+'"'});
	regexp.push({oldname: "'"+path+filename+"'", newname: "'"+path+newfilename+"'"});
	regexp.push({oldname: '"thc_'+path+filename+'"', newname: '"thc_'+path+newfilename+'"'});		
	regexp.push({oldname: "path="+path+filename+"'", newname: "path="+path+newfilename+"'"});
	if(isThumbnail) {
		regexp.push({oldname: '"th_'+path+filename+'"', newname: '"th_'+path+newfilename+'"'});		
		regexp.push({oldname: '"f_'+path+filename+'"', newname: '"f_'+path+newfilename+'"'});		
		regexp.push({oldname: '"thi_'+path+filename+'"', newname: '"thi_'+path+newfilename+'"'});		
		regexp.push({oldname: '"file_'+path+filename+'"', newname: '"file_'+path+newfilename+'"'});		
		regexp.push({oldname: '"dir_'+path+filename+'"', newname: '"dir_'+path+newfilename+'"'});		
		regexp.push({oldname: '"img_'+path+filename+'"', newname: '"img_'+path+newfilename+'"'});		
		regexp.push({oldname: '"thn_'+path+filename+'"', newname: '"thn_'+path+newfilename+'"'});		
	}
	
	var str;
	for(var i = 0; i < regexp.length; ++i) {
		str = regexp[i].oldname;
		str = str.replace(/\./g,"\\.");
		str = str.replace(/\+/g,"\\+");
		str = str.replace(/\!/g,"\\!");
		str = str.replace(/\^/g,"\\^");
		str = str.replace(/\(/g,"\\(");
		str = str.replace(/\)/g,"\\)");
		html = html.replace(new RegExp(str,'g'), regexp[i].newname);
	}

	fileListDiv.innerHTML = html;
};
