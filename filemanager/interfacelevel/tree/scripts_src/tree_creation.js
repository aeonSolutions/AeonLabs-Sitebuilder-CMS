function createNode(node,isRoot) {
	var content = '';

	if(node && node.nodeType == document.ELEMENT_NODE || node.nodeType == 1) {
		var childs = Array();
		var items = node.childNodes;
		for (var i = 0; i < items.length; ++i)
			if(items[i].nodeType == document.ELEMENT_NODE || items[i].nodeType == 1)
				childs[childs.length] = items[i]; 
		
		if(childs && childs.length > 0) {
			var mainUlClass = window.config['mainUlClass'];
			var display = '';
			if(isRoot) display = 'style="display:block;"';
			content = '<ul id="ul_'+node.getAttribute('id')+'" class="'+mainUlClass+'" '+display+'>';
			
			var child;
			var firstChildId = childs[0].getAttribute('id');
			var lastChildId = childs[childs.length-1].getAttribute('id');
			for (i = 0; i < childs.length; ++i) {
				child = childs[i];
				content += createChild(child,firstChildId,lastChildId,isRoot);
			}
			content += '</ul>';
		}
	}
	return content;
};

function createChild(child,firstChildId,lastChildId,isRoot) {
	var data = child.firstChild.data;
	var tag = child.nodeName;
	var id = child.getAttribute('id');

	var className = getClassName(id,firstChildId,lastChildId,isRoot,existNodeChilds(child));
	var liAttributes = getConfiguredTag(tag,'liAttributes',data,child.attributes);
	var content = '<li id="li_'+id+'" class="'+className+'" tag="'+tag+'" '+liAttributes+'>';
	content += getConfiguredTag(tag,'html',data,child.attributes);
	content += createNode(child,false);
	content += '</li>';
	
	return content;
};
