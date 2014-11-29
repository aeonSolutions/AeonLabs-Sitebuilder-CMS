<?
require_once($globvars['local_root']."filemanager/basiclevel/Image.php");

class ThumbnailImage {
	
	var $prefix_name;
	var $image_default;
	var $image_error;
	var $available_extensions;
	var $thumbnail_width;
	var $thumbnail_height;
	var $file_min_size_in_bytes;

	var $file_path;
	var $image;

	function ThumbnailImage($file_path,$prefix_name,$image_default,$image_error,$available_extensions,$thumbnail_width,$thumbnail_height,$file_min_size_in_bytes) {
		$this->file_path = $file_path;
		$this->prefix_name = $prefix_name;
		$this->image_default = $image_default;
		$this->image_error = $image_error;
		$this->available_extensions = $available_extensions;
		$this->thumbnail_width = $thumbnail_width;
		$this->thumbnail_height = $thumbnail_height;
		$this->file_min_size_in_bytes = $file_min_size_in_bytes;

		$this->image = new Image();
	}

	function getThumbnail() {
		$file_path = $this->file_path;

		if(file_exists($file_path)) {

			$dirname = dirname($file_path) != '.' ? dirname($file_path).'/' : '';
			
			$size = filesize($file_path);
			list($image_width,$image_height) = getimagesize($file_path);
			if($size <= $this->file_min_size_in_bytes || ($image_width <= $this->thumbnail_width && $image_height <= $this->thumbnail_height))
				return $file_path;
			
			if($this->isValid($file_path)) {
				$thumbnail_file_path = $dirname.$this->prefix_name.basename($file_path);
				if(file_exists($thumbnail_file_path)) {
					$file_modification_time = filemtime($file_path);
					$thumbnail_modification_time = filemtime($thumbnail_file_path);
					
					if($file_modification_time <= $thumbnail_modification_time)
						return $thumbnail_file_path;
				}
				return $this->createThumbnail();
			} 
			else 
				return $this->image_default;
		}
		else
			return $this->image_error;
	}
	
	function createThumbnail() {
		$image = $this->image;
		$file_path = $this->file_path;
		$dirname = dirname($file_path) != '.' ? dirname($file_path).'/' : '';
		
		$continue = $this->createDirPrefix($dirname.dirname($this->prefix_name));
		if($continue) {
			$imageInfo = $image->getImageInfo($file_path);
			if($image->loadImage($file_path)) {
				
				$width =  $imageInfo['width'];
				$height = $imageInfo['height'];
				if($width > $height && $width > $this->thumbnail_width) {
					$height = intval($this->thumbnail_width*$height/$width);
					$width =  $this->thumbnail_width;
				}elseif($height > $width && $height > $this->thumbnail_height) {
					$width =  intval($this->thumbnail_height*$width/$height);
					$height = $this->thumbnail_height;
				}
				
				if($image->resize($width, $height)) {
					$new_name = $dirname.$this->prefix_name.basename($file_path);
					if($image->saveImage($new_name) ) {
						$imageInfo = $image->getFinalImageInfo();
					}
				}
			}
			
			if(count($image->_errors) > 0) {
				return $this->image_default;
			}
			return $new_name;
		}
		return $this->image_default;
	}
	
	function isValid($file_path) {
		$ext = $this->image->_getExtension($file_path);
		$index = array_search($ext,$this->available_extensions);
		return is_numeric($index);
	}

	function createDirPrefix($dir_prefix_name) {
		if(file_exists($dir_prefix_name) || $dir_prefix_name == '.' || $dir_prefix_name == '..')
			return true;
		else {
			$basename = basename($dir_prefix_name);
			if($basename != '.' && $basename != '..') {
				$dir_dirname = dirname($dir_prefix_name);
				if($this->createDirPrefix($dir_dirname))
					return mkdir($dir_prefix_name);
			}
		}
		return false;
	}
}

/*
require_once("class.image.php");
$path = "Images/1.gif";
$image = new Image();
$imageInfo = $image->getImageInfo($path);
$originalImage = $path;
if($image->loadImage($originalImage))
	//if($image->flipVertical()) {
	//if($image->flipHorizontal()) {
	//if($image->rotate(-70)) {
	//if($image->rotate(120)) {
	//if($image->crop(20, 20, 100, 150)) {
	if($image->resize(100, 100)) {
		if($image->saveImage(dirname($path)."/xpto_".basename($path)) ) {
			$imageInfo = $image->getFinalImageInfo();
		
			$ext = $image->_getExtension($path);
			$image->showImage($ext);
		}
	}
$image->showErrors();
*/
?>
