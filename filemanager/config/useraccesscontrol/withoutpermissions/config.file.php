<?
class CONFIGFILE {
	
	function isValid($file) {
		return false;
	}
	
	/*If you don't wish to limit the upload size, this function should return false.*/
	function getUploadMaxSizeInBytes() {
		return 52428800;
	}
}
?>