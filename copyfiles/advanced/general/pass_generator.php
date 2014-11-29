<?php
/* 
	$length - nº de caracteres da password
	$use_mix: allows upper and lower case, accepts [Yes,No]
	$use_num: put number into password, accepts [Yes,No]
	$use_let: put letters into password, accepts [Yes,No]
		
*/
function generate($length,$use_mix,$use_num,$use_let){
   
   $allowable_characters = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz23456789";
   if (($use_mix == "Yes") && ($use_num == "Yes") && ($use_let == "Yes")):
     $ps_st = 0;
     $ps_len = strlen($allowable_characters);
   endif;

   if (($use_mix == "No") && ($use_num == "Yes") && ($use_let == "Yes")):
     $ps_st = 24;
     $ps_len = strlen($allowable_characters);
   endif;

   if (($use_mix == "Yes") && ($use_num == "No") && ($use_let == "Yes")):
     $ps_st = 0;
     $ps_len = 47;
   endif;

   if (($use_mix == "Yes") && ($use_num == "Yes") && ($use_let == "No")):
     $ps_st = 48;
     $ps_len = strlen($allowable_characters);
   endif;

   if (($use_mix == "No") && ($use_num == "No") && ($use_let == "Yes")):
     $ps_st = 24;
     $ps_len = 47;
   endif;

   if (($use_mix == "No") && ($use_num == "Yes") && ($use_let == "No")):
     $ps_st = 48;
     $ps_len = strlen($allowable_characters);
   endif;

   if (($use_mix == "Yes") && ($use_num == "No") && ($use_let == "No")):
     $ps_st = 0;
     $ps_len = 1;
   endif;
   
   if (($use_mix == "No") && ($use_num == "No") && ($use_let == "No")):
     $ps_st = 0;
     $ps_len = 1;
   endif;
   
   mt_srand((double)microtime()*1000000);

   $pass = "";

   for($i = 0; $i < $length; $i++):
	  $pass .= $allowable_characters[mt_rand($ps_st, $ps_len - 1)];
   endfor;
   
   return $pass;
};
//-------------------------------------------------------------------------------------------------

?>