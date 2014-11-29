<?php
/**
 * Image Manager configuration file.
 * @author $Author: ray $
 * @version $Id: config.inc.php 677 2007-01-19 22:24:36Z ray $
 * @package ImageManager
 *
 * @todo change all these config values to defines()
 */

// REVISION HISTORY:
//
// 2005-03-20 Yermo Lamers (www.formvista.com):
//	. unified backend.
// . created a set of defaults that make sense for bundling with Xinha.

// -------------------------------------------------------------------------

require_once($globvars['local_root']."filemanager/config/config.php");
require_once("./config.aux.php");
$root_path = $CONFIG['root_path'];
if(!empty($root_path) && substr($root_path,strlen($root_path)-1) != "/")
	$root_path .= "/";

/**
* Default backend URL
*
* URL to use for unified backend.
*
* The ?__plugin=ImageManager& is required. 
*/

$IMConfig['backend_url'] = "backend.php?__plugin=ImageManager&";

/**
* Backend Installation Directory
*
* location of backend install; these are used to link to css and js
* assets because we may have the front end installed in a different
* directory than the backend. (i.e. nothing assumes that the frontend
* and the backend are in the same directory)
*/

$IMConfig['base_dir'] = getcwd();
$IMConfig['base_url'] = '';

// ------------------------------------------------------------

/**
* Path to directory containing images.
*
* File system path to the directory you want to manage the images
* for multiple user systems, set it dynamically.
*
* NOTE: This directory requires write access by PHP. That is, 
* PHP must be able to create files in this directory.
* Able to create directories is nice, but not necessary.
*
* CHANGE THIS: for out-of-the-box demo purposes we're setting this to ./demo_images
* which has some graphics in it.
*/

// $IMConfig['images_dir'] = "/some/path/to/images/directory;

//$IMConfig['images_dir'] = "demo_images";
$IMConfig['images_dir'] = $root_path;

// -------------------------------------------------------------------------

/**
* URL of directory containing images.
*
* The URL to the above path, the web browser needs to be able to see it.
* It can be protected via .htaccess on apache or directory permissions on IIS,
* check you web server documentation for futher information on directory protection
* If this directory needs to be publicly accessiable, remove scripting capabilities
* for this directory (i.e. disable PHP, Perl, CGI). We only want to store assets
* in this directory and its subdirectories.
*
* CHANGE THIS: You need to change this to match the url where you have Xinha
* installed. If the images show up blank chances are this is not set correctly.
*/

// $IMConfig['images_url'] = "/url/to/above";

// try to figure out the URL of the sample images directory. For your installation
// you will probably want to keep images in another directory.

//$IMConfig['images_url'] = str_replace( "backend.php", "", $_SERVER["PHP_SELF"] ) . "demo_images";
//$IMConfig['images_url'] = dirname($_SERVER["PHP_SELF"]) . "/demo_images";
$IMConfig['images_url'] = dirname($_SERVER["PHP_SELF"]) . "/".$root_path;

// -------------------------------------------------------------------------

/**
* Image Library to use.
*
* Possible values: 'GD', 'IM', or 'NetPBM'
*
* The image manipulation library to use, either GD or ImageMagick or NetPBM.
* If you have safe mode ON, or don't have the binaries to other packages, 
* your choice is 'GD' only. Other packages require Safe Mode to be off.
*
* DEFAULT: GD is probably the most likely to be available. 
*/

$IMConfig['IMAGE_CLASS'] = 'GD';


// -------------------------------------------------------------------------

/**
* NetPBM or IM binary path.
*
* After defining which library to use, if it is NetPBM or IM, you need to
* specify where the binary for the selected library are. And of course
* your server and PHP must be able to execute them (i.e. safe mode is OFF).
* GD does not require the following definition.
*/

$IMConfig['IMAGE_TRANSFORM_LIB_PATH'] ='/usr/bin/';

// For windows, something like
// C:/"Program Files"/ImageMagick-5.5.7-Q16/

// -------------------------------------------------------------------------
//                OPTIONAL SETTINGS 
// -------------------------------------------------------------------------

/**
* Editor Temporary File Prefix.
*
* Image Editor temporary filename prefix.
*/

$IMConfig['tmp_prefix'] = CONFIGIMAGEMANAGER::getTmpImgEditor();


////////////////////////////////////////////////////////////////////////////////
//       ================== END OF CONFIGURATION =======================      //
////////////////////////////////////////////////////////////////////////////////


// Standard PHP Backend Data Passing
//  if data was passed using xinha_pass_to_php_backend() we merge the items
//  provided into the Config
//require_once(realpath(dirname(__FILE__) . '/../../contrib/php-xinha.php'));
require_once(realpath('contrib/php-xinha.php'));
if($passed_data = xinha_read_passed_data())
{
  $IMConfig = array_merge($IMConfig, $passed_data);
  $IMConfig['backend_url'] .= xinha_passed_data_querystring() . '&';
}
// Deprecated config passing, don't use this way any more!
elseif(isset($_REQUEST['backend_config']))
{
  if(get_magic_quotes_gpc()) {
    $_REQUEST['backend_config'] = stripslashes($_REQUEST['backend_config']);
  }
  
  // Config specified from front end, check that it's valid
  session_start();
  $secret = $_SESSION[$_REQUEST['backend_config_secret_key_location']];

  if($_REQUEST['backend_config_hash'] !== sha1($_REQUEST['backend_config'] . $secret))
  {
    die("Backend security error.");
  }

  $to_merge = unserialize($_REQUEST['backend_config']);
  if(!is_array($to_merge))
  {
    die("Backend config syntax error.");
  }

  $IMConfig = array_merge($IMConfig, $to_merge);
  $IMConfig['backend_url'] .= "backend_config=" . rawurlencode($_REQUEST['backend_config']) . '&';
  $IMConfig['backend_url'] .= "backend_config_hash=" . rawurlencode($_REQUEST['backend_config_hash']) . '&';
  $IMConfig['backend_url'] .= "backend_config_secret_key_location=" . rawurlencode($_REQUEST['backend_config_secret_key_location']) . '&';

}

define('IMAGE_CLASS', $IMConfig['IMAGE_CLASS']);
define('IMAGE_TRANSFORM_LIB_PATH', $IMConfig['IMAGE_TRANSFORM_LIB_PATH']);
define( "IM_CONFIG_LOADED", "yes" );

// bring in the debugging library

include_once( "ddt.php" );

// uncomment to send debug messages to a local file
// _setDebugLog( "/tmp/debug_log.txt" );

// turn debugging on everywhere.
// _ddtOn();

// END

?>
