<?
require_once($globvars['local_root']."filemanager/basiclevel/ThumbnailImage.php");
require_once($globvars['local_root']."filemanager/config/config.thumbnails.php");

class ThumbnailImageLL {
	
	function getThumbnail($path) {
		$config = CONFIGTHUMBNAILS::getThumbnailsConfig();
		$prefix_name = $config['prefix_name'];
		$image_default = $config['image_default'];
		$image_error = $config['image_error'];
		$available_extensions = $config['available_extensions'];
		$thumbnail_width = $config['thumbnail_width'];
		$thumbnail_height = $config['thumbnail_height'];
		$file_min_size_in_bytes = $config['file_min_size_in_bytes'];

		$ThumbnailImage = new ThumbnailImage($path,$prefix_name,$image_default,$image_error,$available_extensions,$thumbnail_width,$thumbnail_height,$file_min_size_in_bytes);
		$new_path = $ThumbnailImage->getThumbnail();

		return $new_path;
	}
	
	function getThumbnailImageDefault() {
		$config = CONFIGTHUMBNAILS::getThumbnailsConfig();
		return $config['image_default'];
	}
}

?>
