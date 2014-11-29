var selectedFiles = new Array();
var selectedDirs = new Array();

var fileSrc = 'filelist.php';

function resizeColumn(name1, name2) {
	var elm1 = document.getElementById(name1);
	var elm2 = document.getElementById(name2);

	//if (elm2.clientWidth > elm1.clientWidth)
		//elm1.width = elm2.clientWidth + 2;
	elm1.width = elm2.width;
};

function resizeTable() {
	var td_width = document.body.clientWidth-document.getElementById('selectCol3').width-document.getElementById('iconCol3').width-document.getElementById('fsizeCol3').width-document.getElementById('fmodCol3').width-document.getElementById('spacerCol3').width-20;
	//document.getElementById('fnameCol1').width = td_width;
	document.getElementById('fnameCol2').width = td_width;
	document.getElementById('fnameCol3').width = td_width;
	/*
	// Setup init data
	resizeColumn('selectCol1', 'selectCol3');
	resizeColumn('iconCol1', 'iconCol3');
	resizeColumn('fnameCol1', 'fnameCol3');
	resizeColumn('fsizeCol1', 'fsizeCol3');
	resizeColumn('fmodCol1', 'fmodCol3');
	resizeColumn('spacerCol1', 'spacerCol3');
	
	document.getElementById('fileListHead').style.display = 'none';
	document.getElementById('fileListHeadReal').style.display = 'block';
	*/
};

function init(isSearchAction) {
	var isGecko = navigator.userAgent.indexOf('Gecko') != -1;

	disabledTools = disabledTools.split(',');
	
	//resizeTable();
	correctFileListDivScroll('filelist');
	
	// Lock down all tools
	setCommandEnabled('createdir', hasCreateFolderPermission);
	setCommandEnabled('createdoc', hasCreateDocPermission);
	setCommandEnabled('refresh', true);
	setCommandEnabled('upload', hasUploadPermission);
	setCommandEnabled('search', hasSearchPermission);
	//setCommandEnabled('props', false);
	setCommandEnabled('cut', false);
	setCommandEnabled('copy', false);
	setCommandEnabled('paste', hasPasteAccess);
	setCommandEnabled('delete', false);
	setCommandEnabled('unzip', false);
	setCommandEnabled('zip', false);
	setCommandEnabled('toggleall', true);
	setCommandEnabled('imagemanager', true);
	setCommandEnabled('help', true);

	fixImagesBug();

	if (errorMsg != "")
		alert(errorMsg);
	
	//if(!isSearchAction)
		//showPreview(path);
	
	hideLoadingBar();
};