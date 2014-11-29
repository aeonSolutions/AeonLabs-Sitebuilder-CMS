<?
class CONFIGFILEHIDDEN {
	
	/* If true, get a files list that aren't directories or else, get a directory files list.*/
	function getHiddenDirFiles() {
		return false;
	}
	
	/* If true, get a directory files list or else, get a normal files list.*/
	function getHiddenAllFilesExceptDirs() {
		return false;
	}
	
	/* get a files list of the hidden files. Each element of the list must be a text with the file full path.*/
	function getHiddenFilesWithTheFullPath() {
		$config = array();
		//$config[] = "../../exp/apagar dir/tool_cut.gif";
		return $config;
	}

	/* get a files list of the hidden files. Each element of the list must be a text with the file base name.*/
	function getHiddenFilesWithTheBaseName() {
		$config = array();
		$config[] = '';
		$config[] = '..';
		$config[] = '.';
		$config[] = 'Thumbs.db';
		return $config;
	}
	
	/* get a files list of the hidden files. Each element of the list must be a text with the begining text of the file base name.*/
	function getHiddenFilesStartWith() {
		$config = array();
		$config[] = ".__zip";
		$config[] = ".__unzip";
		return $config;
	}
	
	/* get a files list of the hidden files. Each element of the list must be a text with the end text of the file base name.*/
	function getHiddenFilesEndsWith() {
		$config = array();
		//$config[] = "png";
		return $config;
	}
}
?>