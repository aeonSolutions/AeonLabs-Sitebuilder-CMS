function getNodeText(node) {
	if(node && node.firstChild)
		return node.firstChild.data;
	return '';
};

function getFirstChild(node) {
	var items = node.childNodes;
	for (var i = 0; i < items.length; ++i)
		if(items[i].nodeType == document.ELEMENT_NODE || items[i].nodeType == 1)
			return items[i];
	return null;
};

function getLastChild(node) {
	var items = node.childNodes;
	for (var i = items.length-1; i >= 0; --i)
		if(items[i].nodeType == document.ELEMENT_NODE || items[i].nodeType == 1)
			return items[i];
	return null;
};

function existNodeChilds(node) {
	if(node) {
		var items = node.childNodes;
		for (var i = 0; i < items.length; ++i)
			if(items[i].nodeType == document.ELEMENT_NODE || items[i].nodeType == 1)
				return true;
	}
	return false;
};

function swapNode(nodeX,nodeY) {
	var p = nodeY.parentNode;
	var s = nodeY.nextSibling;
	nodeX.parentNode.replaceChild(nodeY,nodeX);
	p.insertBefore(nodeX,s);
};

function isUlRoot(ul) {
	if(ul) {
		var ulId = ul.getAttribute('id');
		ulId = ulId.substr(3); /*eg: ul_32*/
		var liParent = document.getElementById('li_'+ulId);
		if(!liParent)	
			return true;
	}
	return false;
};


function arraySearch(searchObject,arrayObject) {
	for (var i = 0; i < arrayObject.length; ++i)
		if(arrayObject[i] == searchObject) {
			return i;
		}
	return null;
};

function getConfiguredTag(tag,type,data,attributes) {
	var html = getTag(tag,type);
	if(html) {
		html = html.replace(/#_DATA/g,data);
		
		var str;
		for(var i = 0; i < attributes.length; ++i) {
			str = '#_ATTRIBUTE\[+['+attributes[i].name+']+\]';
			html = html.replace( new RegExp(str,'g') ,attributes[i].value);
		}
		html = html.replace(/#_ATTRIBUTE\[+[a-zA-Z0-9_]+\]/g,'#');
		return html;
	}
	return data;
};

function getTag(tag,type) {
	var tagsRow = window.config['tags']['row'];
	for(var i = 0; i < tagsRow.length; ++i)
		if(tagsRow[i]['tag'] == tag)
			return tagsRow[i][type];
	return '';
};

function strAttributesToArray(strAttributes) {
	var attributes = Array();
	if(strAttributes) {
		var array = strAttributes.split('="');
		var attributeName,attributeValue,index;
		for(var i = 0; i < array.length; i += 2) {
			attributeName = array[i];
			attributeValue = array[i+1];
			
			if(attributeName && attributeValue) {
				index = attributeValue.indexOf('"');
				if(index == -1) index = 0;
				attributeValue = attributeValue.substr(0,index);
				attributeName = attributeName.replace(' ','');
				
				if(attributeName != '' && attributeValue != '')
					attributes[attributes.length] = Array(attributeName,attributeValue);
			}
		}
	}
	return attributes;
};

function nodeAttributesToString(attributes) {
	var strAttributes = '';
	for(var i=0; i < attributes.length; ++i)
		if(attributes[i].value && attributes[i].value != '' && attributes[i].value != 'null' && attributes[i].name != 'hideFocus' && attributes[i].name != 'contentEditable' && attributes[i].name != 'disabled' && attributes[i].name != 'tabIndex' && attributes[i].name != 'compact')
			strAttributes += ' '+attributes[i].name+'="'+attributes[i].value+'"';
	return strAttributes;
}

function getClassName(currentChildId,firstChildId,lastChildId,isRoot,existNodeChilds) {
	var className = 'tree';
	
	if(currentChildId == firstChildId && isRoot == true) {
		className += ' tree-lines-t';
	}else if(currentChildId == lastChildId) 
		className +=  ' tree-lines-b';
	else className += ' tree-lines-c';
	
	if(existNodeChilds && currentChildId != lastChildId)
		className += ' tree-lined';

	return className;
};
