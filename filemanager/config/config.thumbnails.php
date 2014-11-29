<?
/*
	The 'config.thumbnails.php' file contains the configuration of the thumbnails server files, like the thumbnails width and height, the available extensions, the thumbnails prefix name and path and other configurations...
	This file corresponds to the thumbnails configuration, like:
		- the thumbnails folder path and/or the thumbnail prefix name. 
		- the default image path that should be showed if the respective file isn't a gif, jpg, jpeg or png file.
		- the error image path that should be showed if the respective file is corrupt.
		- the available image extensions.
		- the thumbnails size, width and height.
*/
class CONFIGTHUMBNAILS {
	
	function getThumbnailsConfig() {
		$config['prefix_name'] = '.___tmpimgthumbnails/.___tmpimgthumbnail_';//This variable corresponds to the thumbnails folder path and/or the thumbnail prefix name.
		$config['image_default'] = './../interfacelevel/images/image.gif';//This variable corresponds to the default image path that should be shown if the respective file isn't a gif, jpg, jpeg or png file. The default image path is relative to the 'interfacelevel/' directory.
		$config['image_error'] = './../interfacelevel/images/error.gif';//This variable corresponds to the error image path that should be shown if the respective file is corrupt. The error image path is relative to the 'interfacelevel/' directory.
		$config['available_extensions'] = array('gif','jpg','jpeg','png');//This variable corresponds to the available images extension.
		$config['thumbnail_width'] = 250;//This variable corresponds to the thumbnails width.
		$config['thumbnail_height'] = 250;//This variable corresponds to the thumbnails height.
		$config['file_min_size_in_bytes'] = 1024;//This variable corresponds to the thumbnails maximum size.
		
		return $config;
	}
}

?>
