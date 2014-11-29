<?php   
 /* we will do our own error handling. */  
error_reporting(0); // Turns off all error reporting.   
   
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
     
    $err = "<errorentry>".chr(13);   
    $err .= "\t<datetime>" .$dt. "</datetime>".chr(13);   
    $err .= "\t<errornum>" .$errno. "</errornum>".chr(13);   
    $err .= "\t<errortype>" .$errortype[$errno]. "</errortype>".chr(13);   
    $err .= "\t<errormsg>" .$errmsg. "</errormsg>".chr(13);   
    $err .= "\t<scriptname>" .$filename. "</scriptname>".chr(13);   
    $err .= "\t<scriptlinenum>" .$linenum. "</scriptlinenum>".chr(13);   
  
    if (in_array($errno, $user_errors)):
		$err .="\t<vartrace>".wddx_serialize_value($vars,'Variables')."</vartrace>".chr(13);
    endif;  
    $err .= "</errorentry>".chr(13).chr(13);   
  
    // save to the error log file, and e-mail me if there is a critical user error.   
    @unlink($staticvars['local_root'].'error_log.log');
	error_log($err, 3, $staticvars['local_root'].'error_log.log');   
    //if ($errno == E_USER_ERROR):
        //mail($admin_mail, 'Critical User Error', $err);   
    //endif;
}   
$old_error_handler = set_error_handler('userErrorHandler');   
?>  

