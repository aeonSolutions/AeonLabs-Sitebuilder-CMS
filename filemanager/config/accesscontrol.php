<?
	/*
	* This function should return the directory name, correspondent to the user configuration.
	*/
	function getUserConfiguration() {
		$username = "";//$_SESSION['username_xxxx'];
		$password = "";//$_SESSION['password_xxxx'];
		
		$group = loginCheck($username,$password);
		if(!empty($group)) {
			switch($group) {
				case "admin" : $configuration = "group1"; break;
				//case "john" : $configuration = "group2"; break;
				case "none" : $configuration = "withoutpermissions"; break;
				default: $configuration = "default";
			}
		}
		else $configuration = "withoutpermissions";
		
		return $configuration;
	}
	
	/*
	* On this function you should verify if the username is correct with the password and return the user group name.
	* The code bellow is just an example and should be replaced by real access control code.
	*/
	function loginCheck($username,$password) {
		return !isset($_GET['group_test']) || empty($_GET['group_test']) ? "default" : $_GET['group_test'];
	}
?>