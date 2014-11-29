<?php
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

function checkEmail($email) 
{

if(!function_exists('checkdnsrr'))
{
    function checkdnsrr($hostName, $recType = '')
    {
     if(!empty($hostName)) {
       if( $recType == '' ) $recType = "MX";
       exec("nslookup -type=$recType $hostName", $result);
       // check each line to find the one that starts with the host
       // name. If it exists then the function succeeded.
       foreach ($result as $line) {
         if(@eregi("^$hostName",$line)) {
           return true;
         }
       }
       // otherwise there was no mail handler for the domain
       return false;
     }
     return false;
    }
}
if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)): 
      return FALSE;
   endif;

   list($Username, $Domain) = split("@",$email);

   if(checkdnsrr($Domain, $MXHost)):
      return TRUE;
   else:
      if(@fsockopen($Domain, 25, $errno, $errstr, 30)):
         return TRUE; 
      else:
         return FALSE; 
      endif;
   endif;
}
?>