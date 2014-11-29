<?php
/**
 * ImageManager, list images, directories, and thumbnails.
 * @author $Author: ray $
 * @version $Id: ImageManager.php 709 2007-01-30 23:22:04Z ray $
 * @package ImageManager
 */
 
define('FILE_ERROR_NO_SOURCE', 100);
define('FILE_ERROR_COPY_FAILED', 101);
define('FILE_ERROR_DST_DIR_FAILED', 102);
define('FILE_COPY_OK', 103);
define('FILE_ERROR_DST_DIR_EXIST', 104);

// uncomment to turn on debugging

// _ddtOn();

/**
 * ImageManager Class.
 * @author $Author: ray $
 * @version $Id: ImageManager.php 709 2007-01-30 23:22:04Z ray $
 */
class ImageManager 
{
	/**
	 * Configuration array.
	 */
	var $config;

	/**
	 * Constructor. Create a new Image Manager instance.
	 * @param array $config configuration array, see config.inc.php
	 */
	function ImageManager($config) 
	{
		$this->config = $config;
	}

	/**
	 * Get the images base directory.
	 * @return string base dir, see config.inc.php
	 */
	function getImagesDir() 
	{
		$imagesDir = $this->config['images_dir'];
		$imagesDir = substr($imagesDir,strlen($imagesDir)-1) == "/" ? substr($imagesDir,0,strlen($imagesDir)-1) : $imagesDir;
		return $imagesDir;
	}

	/**
	 * Get the images base URL.
	 * @return string base url, see config.inc.php
	 */
	function getImagesURL() 
	{
		$imagesURL = $this->config['images_url'];
		$imagesURL = substr($imagesURL,strlen($imagesURL)-1) == "/" ? substr($imagesURL,0,strlen($imagesURL)-1) : $imagesURL;
		return $imagesURL;
	}

	/**
	 * Get the tmp file prefix.
	 * @return string tmp file prefix.
	 */
	function getTmpPrefix() 
	{
		return $this->config['tmp_prefix'];
	}

	/**
	 * Get image size information.
	 * @param string $file the image file
	 * @return array of getImageSize information, 
	 *  false if the file is not an image.
	 */
	function getImageInfo($file) 
	{
		return @getimagesize($file);
		//return @getImageSize($file);
	}

	/**
	 * Check if the given file is a tmp file.
	 * @param string $file file name
	 * @return boolean true if it is a tmp file, false otherwise
	 */
	function isTmpFile($file) 
	{
		$len = strlen($this->config['tmp_prefix']);
		if(substr($file,0,$len)==$this->config['tmp_prefix'])
			return true;
		else
			return false;	 	
	}
	
	/**
	 * Get the URL of the relative file.
	 * basically appends the relative file to the 
	 * base_url given in config.inc.php
	 * @param string $relative a file the relative to the base_dir
	 * @return string the URL of the relative file.
	 */
	function getFileURL($relative) 
	{
		return ImageManager::makeFile($this->getImagesURL(),$relative);
	}

	/**
	 * Get the fullpath to a relative file.
	 * @param string $relative the relative file.
	 * @return string the full path, .ie. the base_dir + relative.
	 */
	function getFullPath($relative) 
	{
		return ImageManager::makeFile($this->getImagesDir(),$relative);
	}

	/**
	 * Escape the filenames, any non-word characters will be
	 * replaced by an underscore.
	 * @param string $filename the orginal filename
	 * @return string the escaped safe filename
	 */
	function escape($filename)
	{
		return preg_replace('/[^\w\._]/', '_', $filename);
	}

	/**
	 * Delete a file.
	 * @param string $file file to be deleted
	 * @return boolean true if deleted, false otherwise.
	 */
	function delFile($file) 
	{
		if(is_file($file)) 
			return unlink($file);
		else
			return false;
	}

	/**
	 * Append a / to the path if required.
	 * @param string $path the path
	 * @return string path with trailing /
	 */
	function fixPath($path) 
	{
		//append a slash to the path if it doesn't exists.
		if(!(substr($path,-1) == '/'))
			$path .= '/';
		return $path;
	}

	/**
	 * Similar to makePath, but the second parameter
	 * is not only a path, it may contain say a file ending.
	 * @param string $pathA the leading path
	 * @param string $pathB the ending path with file
	 * @return string combined file path.
	 */
	function makeFile($pathA, $pathB) 
	{
		$pathA = ImageManager::fixPath($pathA);
		if(substr($pathB,0,1)=='/')
			$pathB = substr($pathB,1);
		
		return $pathA.$pathB;
	}
}

?>
