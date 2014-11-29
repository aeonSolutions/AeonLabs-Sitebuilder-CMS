function loadXMLConfiguration(responseXML,funcArgs) {
	var config = Array();
	
	var node = responseXML.documentElement; 
	var config = getArrayFromXML(node);
	config = configureConfig(config['resultado']);
	window.config = config;
	
	if(funcArgs) {
		var fileDataURL_ = funcArgs[0];
		var fileDataURLQueryString_ = funcArgs[1];
		var func_ = funcArgs[2];
		var funcArgs_ = funcArgs[3];
		callAjaxEvent(fileDataURL_,fileDataURLQueryString_,func_,funcArgs_);
	}
};

function getArrayFromXML(node) {
	var data = null;
	if(node) {
		if(node.nodeType == document.ELEMENT_NODE || node.nodeType == 1) {
			data = Array();
			var childs = Array();
			childs[-1] = 0;
			var subNode = null;
			var indexSearch, childLength;
			
			var items = node.childNodes;
			var repeatedChilds = getRepeatedChilds(items);
			
			for (var i = 0; i < items.length; ++i) {
				if(items[i].nodeType == document.ELEMENT_NODE || items[i].nodeType == 1) {
					
					subNode = getArrayFromXML(items[i]);
					subNode = subNode[items[i].nodeName];

					if(subNode && subNode[-1] == 0) {
						if(subNode[0] == null) 
							subNode = '';
						else subNode = subNode[0];
					}
					
					indexSearch = arraySearch(items[i].nodeName,repeatedChilds);
					if(indexSearch != null) {
						if(!childs[items[i].nodeName])
							childs[items[i].nodeName] = Array();
						
						childLength = childs[items[i].nodeName].length > 0 ? childs[items[i].nodeName].length : 0;
						childs[items[i].nodeName][childLength] = subNode;
					}else childs[items[i].nodeName] = subNode;
					
					childs[-1] = childs[-1] + 1;
				}
				else if( (items[i].nodeType == document.TEXT_NODE || items[i].nodeType == 3 || items[i].nodeType == document.COMMENT_NODE || items[i].nodeType == 8 || items[i].nodeType == document.CDATA_SECTION_NODE || items[i].nodeType == 4) && items[i].data != '')
					childs[0] = childs[0] ? childs[0]+items[i].data : items[i].data;
			}
			
			data[node.nodeName] = childs;
		}
	}
	return data;
};

function getRepeatedChilds(childNodes) {
	var repeatedChilds = Array();
	var j, index;
	
	for (var i = 0; i < childNodes.length; ++i)
		if(childNodes[i].nodeType == document.ELEMENT_NODE || childNodes[i].nodeType == 1)
			for (j = i+1; j < childNodes.length; ++j)
				if( (childNodes[j].nodeType == document.ELEMENT_NODE || childNodes[j].nodeType == 1) && childNodes[i].nodeName == childNodes[j].nodeName) {
					index = arraySearch(childNodes[i].nodeName,repeatedChilds);
					if(index == null){
						repeatedChilds[repeatedChilds.length] = childNodes[i].nodeName;
						break;
					}
				}
	
	return repeatedChilds;
};

function configureConfig(config) {
	if(!config)
		config = Array();
		
	if(!config['tags'])
		config['tags'] = Array();	
	if(!config['tags']['row']) 
		config['tags']['row'] = Array();

	return config;
};
