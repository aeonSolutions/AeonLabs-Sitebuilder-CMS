function goToPath(path)
{
	path=replaceRootPath(path);
	var filelistmanager=parent.document.getElementById('filelistmanager');
	var iframe=null;
	
	if(filelistmanager && filelistmanager.contentWindow && filelistmanager.contentWindow.document){
		iframe=filelistmanager.contentWindow.document.getElementById('filelist');
		var url='';
		if(iframe && iframe.contentWindow && iframe.contentWindow.location){
			url=iframe.contentWindow.location;
			if(url!=''){
				url=clearPathVarOnURL(url);
				var filesrc=url.toString().split("?");
				var file=filesrc[0];
				var query_string='';
				for(var i=1;i < filesrc.length;++i)
				query_string +='&'+filesrc[i];
				iframe.src=file+'?path='+path+query_string+'&search=0&selected_action=0';
			}
		}
	}
};

function replaceRootPath(path){var index=path.indexOf(root_path);if(index==0){var begin=root_path.length;var end=path.length;path=path.substring(begin,end);}return path;};function clearPathVarOnURL(url){if(url){var url=url.toString();var b_index,e_index,strPath;do{b_index=url.indexOf('path=');if(b_index > 0){e_index=url.indexOf('&',b_index+1);if(e_index==-1) e_index=url.length;else{++e_index;}strPath=url.substring(b_index,e_index);url=url.replace(strPath,'');}}while(b_index>0);}return url;};function addNode(parent_id,node_id,node_name){var li=document.getElementById('li_'+node_id);if(!li){var ul=document.getElementById('ul_'+parent_id);if(ul){var li=document.createElement('li');li.setAttribute('tag','complex2');li.setAttribute('id','li_'+node_id);li.innerHTML=getHtmlDirElement(node_id,node_name);ul.appendChild(li);updateChildsClass(ul);}}};function deleteNode(node_id){var li=document.getElementById('li_'+node_id);if(li){var parent_node=li.parentNode;if(parent_node){parent_node.removeChild(li);updateChildsClass(parent_node);if(parent_node.childNodes.length==0)updateParentLiIfEmpty(parent_node.parentNode);}}};function renameNode(node_id,new_node_id){var li=document.getElementById('li_'+node_id);if(li){li.setAttribute('id','li_'+new_node_id);var html=li.innerHTML;html=html.replace( new RegExp(node_id,'g'),new_node_id);li.innerHTML=html;var label=document.getElementById('label_'+new_node_id);if(label)label.innerHTML=getFileBaseName(new_node_id);}};function updateParentLiIfEmpty(li_parent){if(li_parent){var id=li_parent.getAttribute('id');id=id.substring(3,id.length);var label=document.getElementById('label_'+id);if(label){var name=label.innerHTML;li_parent.innerHTML=getHtmlDirElement(id,name);}}};function getHtmlDirElement(node_id,node_name){return '<div id="icon_line_'+node_id+'" class="tree-simple"></div>'+'<div id="icon_folder_'+node_id+'" class="tree-icon folderClosed" onClick="liAutoUpdateOnOpen_UL(\''+node_id+'\');"></div>'+'<a id="a_'+node_id+'" href="#path='+node_id+'" onClick="goToPath(\''+node_id+'\');"><label id="label_'+node_id+'" class="tree-item-unselected">'+node_name+'</label></a>';};function getFileBaseName(file_name){if(file_name.length > 0){if(file_name.substring(file_name.length-1,file_name.length)=="/") file_name=file_name.substring(0,file_name.length-1);var index=file_name.lastIndexOf("/");if(index > 0 && index < file_name.length-1) return file_name.substring(index+1,file_name.length);}return file_name;}