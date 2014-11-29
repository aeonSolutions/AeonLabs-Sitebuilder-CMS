function validateForm(form) {
	var filename = form.filename.value;

	if (filename == "") {
		alert('You must write a file name.');
		return false;
	}

	return true;
};

function init() {
};

function updatePermsCode(perm_person,perm_type) {
	var perms_code = document.getElementById('perms_code');
	checkbox = document.getElementById(perm_person+'_'+perm_type);
	
	if(perms_code && checkbox) {
		var perms_value = perms_code.value;
		if(perms_value == '') perms_value = '0000';
		
		var perm_value = perm_type == 'read' ? 4 : perm_type == 'write' ? 2 : perm_type == 'execute' ? 1 : 0;
		var perm_position = perm_person == 'owner' ? 3 : perm_person == 'group' ? 2 : perm_person == 'world' ? 1 : 0;
		
		var perm_person_value = parseInt( perms_value.substring( perms_value.length-perm_position, perms_value.length-perm_position+1 ) );
		perm_person_value = checkbox.checked ? perm_person_value+perm_value : perm_person_value-perm_value;
		
		var pre_perms_value = perms_value.substring(0,perms_value.length-perm_position);
		var pos_perms_value = perms_value.length > perms_value.length-perm_position+1 ? perms_value.substring(perms_value.length-perm_position+1,perms_value.length) : '';
		perms_code.value = pre_perms_value+perm_person_value+pos_perms_value;
	}
}
