function liExecuteBeforeUpdate(id) {
	/*alert('liExecuteBeforeUpdate');*/
	var label = document.getElementById('label_'+id);
	return label ? label.className : '';
};

function liExecuteAfterUpdate(id,xmlNode,return_value_of_func_before) {
	if(xmlNode) {
		var items = xmlNode.childNodes;
		var childsExists = false;
		for (var i = 0; i < items.length && !childsExists; ++i)
			if(items[i].nodeType == document.ELEMENT_NODE || items[i].nodeType == 1)
				childsExists = true;
	
		if(!childsExists) {
			updateLi(xmlNode);
			/*selectedLabelOfLi(xmlNode.getAttribute('id'));*/
		}
	}
	
	var label = document.getElementById('label_'+id);
	if(label) label.className = return_value_of_func_before;
	
	/*var folder_icon_plus = document.getElementById('icon_plus_'+id);
	if(folder_icon_plus) folder_icon_plus.onclick();*/
	
	hideLoadingBar();
};

function ulExecuteBeforeUpdate(id) {
	/*alert('ulExecuteBeforeUpdate');*/
};

function ulExecuteAfterUpdate(id,xmlNode,return_value_of_func_before) {
	/*alert('ulExecuteAfterUpdate');*/
	hideLoadingBar();
};

function liAutoUpdateOnOpen_UL(id) {
	var ul = document.getElementById('ul_'+id);
	if(!ul || (ul && ul.getAttribute('isOpen')) )
		liAutoUpdate(id);
};

function liAutoUpdateOnClosed_UL(id) {
	var ul = document.getElementById('ul_'+id);
	if(!ul || (ul && !ul.getAttribute('isOpen')) )
		liAutoUpdate(id);
};

function liAutoUpdate(id) {
	showLoadingBar();
	
	if(window.config == Array && window.config.length > 0)
		callAjaxEvent(fileDataURL,'id='+id,updateLiNode,Array(id,liExecuteBeforeUpdate,liExecuteAfterUpdate));
	else {
		var funcArgs = Array(fileDataURL,'id='+id,updateLiNode,Array(id,liExecuteBeforeUpdate,liExecuteAfterUpdate));
		callAjaxEvent(fileConfigURL,'',loadXMLConfiguration,funcArgs);
	}
};

function ulAutoUpdate(id) {
	showLoadingBar();
	
	if(window.config == Array && window.config.length > 0)
		callAjaxEvent(fileDataURL,'id='+id,updateUlNode,Array(id,ulExecuteBeforeUpdate,ulExecuteAfterUpdate));
	else{
		var funcArgs = Array(fileDataURL,'id='+id,updateUlNode,Array(id,ulExecuteBeforeUpdate,ulExecuteAfterUpdate));
		callAjaxEvent(fileConfigURL,'',loadXMLConfiguration,funcArgs);
	}
};

function openAndCloseNode_UL(id) {
	var ul = document.getElementById('ul_'+id);
	if(ul) {
		if(!ul.getAttribute('isOpen')) 
			openNode_UL(id);
		else closeNode_UL(id);
	}
};

function openNode_UL(id) {
	var ul = document.getElementById('ul_'+id);
	if(ul) {
		ul.className = 'ul_open';
		/*ul.setAttribute('class','ul_open');*/
		ul.setAttribute('isOpen','true');
	}
};

function closeNode_UL(id) {
	var ul = document.getElementById('ul_'+id);
	if(ul) {
		ul.className = 'ul_closed';
		/*ul.setAttribute('class','ul_closed');*/
		ul.setAttribute('isOpen',null);
	}
};

function selectedLabelOfLi(id) {
	var label;
	var lis = document.getElementsByTagName('li');
	for (var i = 0; i < lis.length; ++i) {
		var labels = lis[i].getElementsByTagName('label');
		for (var j = 0; j < labels.length; ++j) {
			label = labels[j];
			if(lis[i].getAttribute('id') == 'li_'+id)
				label.className = ' tree-item-selected';
			else label.className = ' tree-item-unselected';
		}
	}
};

function changeClassNameById(id,className) {
	var obj = document.getElementById(id);
	if(obj) { 
		obj.className = className;
		/*obj.setAttribute('class',className);*/
	}
};

function replaceClassName(id,classOut,classOver) {
	var obj = document.getElementById(id);
	if(obj) {
		var className = obj.className;
		/*var className = obj.getAttribute('class');*/
		var index = className.lastIndexOf(classOut);
		
		if(index > -1) {
			obj.className = classOver;
			/*obj.setAttribute('class',classOver);*/
		}else {
			obj.className = classOut;
			/*obj.setAttribute('class',classOut);*/
		}
	}
};

function replaceClassNameIfUlIsOpenOrClose(ulId,id,classOpen,classClose) {
	var ul = document.getElementById('ul_'+ulId);
	var obj = document.getElementById(id);
	if(ul && obj) {
		var ulClassName = ul.className;
		/*var ulClassName = ul.getAttribute('class');*/
		var index = ulClassName.indexOf('ul_closed');
		if(index > -1) {
			obj.className = classClose;
			/*obj.setAttribute('class',classClose);*/
		}else {
			obj.className = classOpen;
			/*obj.setAttribute('class',classOpen);*/
		}
	}
};

function changeImage(id,imgSrc) {
	var obj = document.getElementById(id);
	if(obj) obj.setAttribute('src',imgSrc);
};

function replaceImage(id,imgOut,imgOver) {
	var image = document.getElementById(id);
	if(image) {
		var src = image.getAttribute('src');
		var index = src.lastIndexOf(imgOut);
		if(index + imgOut.length == src.length)
			image.setAttribute('src',imgOver);
		else
			image.setAttribute('src',imgOut);
	}
};

function replaceImageIfUlIsOpenOrClose(ulId,id,imgOpen,imgClose) {
	var ul = document.getElementById('ul_'+ulId);
	var image = document.getElementById(id);
	if(ul && image) {
		var ulClassName = ul.className;
		/*var ulClassName = ul.getAttribute('class');*/
		var index = ulClassName.indexOf('ul_closed');
		if(index > -1)
			image.setAttribute('src',imgClose);
		else
			image.setAttribute('src',imgOpen);
	}
};

function showLoadingBar() {
	var loadingbar = document.getElementById('loadingbar');
	if(loadingbar)
		loadingbar.style.display = 'block';
	/*else {
		document.body.innerHTML += '<div id="loadingbar"><div id="subloadingbar">Loading ...</div></div>';
	}*/
};

function hideLoadingBar() {
	var loadingbar = document.getElementById('loadingbar');
	if(loadingbar)
		loadingbar.style.display = 'none';
};
