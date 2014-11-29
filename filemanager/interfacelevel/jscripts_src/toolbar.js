function showToolbarItem(toolbarItem,toolbarItemIconName,toolbarItemName) {
	var selectedToolbaritems = document.getElementById('selectedToolbaritems');
	if(selectedToolbaritems) {
		selectedToolbaritems.style.display = 'none';
		
		var toolbarItemClass = toolbarItem.className ? toolbarItem.className : toolbarItem.getAttribute('class');
		if(toolbarItemClass != 'mceButtonDisabled') {
			var selectedActionIcon = document.getElementById('selectedActionIcon');
			if(selectedActionIcon)
				selectedActionIcon.src = 'images/toolbaritems/selectedtoolbaritems/'+toolbarItemIconName+'.gif';
				
			var selectedActionLabel = document.getElementById('selectedActionLabel');
			if(selectedActionLabel)
				selectedActionLabel.innerHTML = toolbarItemName;
			
			selectedToolbaritems.style.display = 'block';
		}
		else {
			selectedToolbaritems.style.display = 'none';
		}
	}
};

function hideToolbarItem() {
	var selectedToolbaritems = document.getElementById('selectedToolbaritems');
	if(selectedToolbaritems)
		selectedToolbaritems.style.display = 'none';
};
