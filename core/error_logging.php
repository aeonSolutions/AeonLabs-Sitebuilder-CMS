  <?php
 /* we will do our own error handling. */ 
error_reporting(0); // Turns off all error reporting.   
$err='<?php'.chr(13);
$err .= "$"."datetime=array();".chr(13);   
$err .= "$"."errormsg=array();".chr(13);   
$err .= "$"."scriptname=array();".chr(13);   
$err .= "$"."scriptlinenum=array();".chr(13);
$err .='?>'.chr(13);   
$handle = fopen(substr(__FILE__,0,strpos(__FILE__,"core")).'tmp/error_log_man.php', 'a');
fwrite($handle, $err);
fclose($handle);
   
/* user defined error handling function */  
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)    
{   
    // timestamp for the error entry   
    $dt = date('Y-m-d H:i:s (T)');   
  
    // define an assoc array of error string   
    // in reality the only entries we should   
    // consider are E_WARNING, E_NOTICE, E_USER_ERROR,   
    // E_USER_WARNING and E_USER_NOTICE   
    $errortype = array (   
                E_ERROR => 'Error',   
                E_WARNING => 'Warning',   
                E_PARSE => 'Parsing Error',   
                E_NOTICE => 'Notice',   
                E_CORE_ERROR => 'Core Error',   
                E_CORE_WARNING => 'Core Warning',   
                E_COMPILE_ERROR => 'Compile Error',   
                E_COMPILE_WARNING => 'Compile Warning',   
                E_USER_ERROR => 'User Error',   
                E_USER_WARNING => 'User Warning',   
                E_USER_NOTICE => 'User Notice',   
                E_STRICT => 'Runtime Notice',  
                E_ALL => 'General Errors');   
    // set of errors for which a var trace will be saved   
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);   
    // '<?xml version="1.0" encoding="UTF-8"'
    $err = "<errorentry>".chr(13);   
    $err .= "<datetime>" .$dt. "</datetime>".chr(13);   
    $err .= "<errornum>" .$errno. "</errornum>".chr(13);   
    $err .= "<errortype>" .$errortype[$errno]. "</errortype>".chr(13);   
    $err .= "<errormsg>" .$errmsg. "</errormsg>".chr(13);   
    $err .= "<scriptname>" .$filename. "</scriptname>".chr(13);   
    $err .= "<scriptlinenum>" .$linenum. "</scriptlinenum>".chr(13);   
  
    if (in_array($errno, $user_errors)):
		$err .="<vartrace>".wddx_serialize_value($vars,'Variables')."</vartrace>".chr(13);
    endif;  
    $err .= "</errorentry>".chr(13).chr(13);   
  	add_error($errmsg,$linenum,$filename);
    // save to the error log file  
	error_log($err, 3, substr(__FILE__,0,strpos(__FILE__,"core")).'tmp/error_log.log');   

}   
$old_error_handler = set_error_handler('userErrorHandler');


function add_error($errmsg, $linenum, $filename)
{
	$err='<?php'.chr(13);
    $err .= "$"."datetime[]='".$_SERVER['REQUEST_TIME']."';".chr(13);   
    $err .= "$"."errormsg[]=".'"'.$errmsg. '";'.chr(13);   
    $err .= "$"."scriptname[]='".$filename."';".chr(13);   
    $err .= "$"."scriptlinenum[]='".$linenum."';".chr(13);
	$err .='?>'.chr(13);   
	$handle = fopen(substr(__FILE__,0,strpos(__FILE__,"core")).'tmp/error_log_man.php', 'a');
	fwrite($handle, $err);
	fclose($handle);
}   
?>  

