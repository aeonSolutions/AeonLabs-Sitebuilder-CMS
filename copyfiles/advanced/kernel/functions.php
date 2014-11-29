<?php
/*
File revision date: 6-dez-2008
*/

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

function form_validation($post,$conditions){
/* 
valid conditions:
	null
	numeric
*/
if ($post==''):
	return '#FF0000';
endif;
if($conditions=='numeric'):
	if (!is_numeric($post)):
		return '#FF0000';
	endif;
endif;
return '#000000';
};

function normalize_chars($text){
// eliminates special characters and convert to lower case a text string
	$text = str_replace("ç", "&ccedil;", $text);
	$text = str_replace("Ç", "&Ccedil;", $text);
	
	$text = str_replace("ã", "&atilde;", $text);
	$text = str_replace("â", "&acirc;", $text);
	$text = str_replace("à", "&agrave;", $text);
	$text = str_replace("á", "&aacute;", $text);
	$text = str_replace("Ã", "&Atilde;", $text);
	$text = str_replace("Â", "&Acirc;", $text);
	$text = str_replace("Á", "&Aacute;", $text);
	$text = str_replace("À", "&Agrave;", $text);

	$text = str_replace("É", "&Eacute;", $text);
	$text = str_replace("È", "&Egrave;", $text);
	$text = str_replace("Ê", "&Ecirc;", $text);
	$text = str_replace("ê", "&ecirc;", $text);
	$text = str_replace("é", "&eacute;", $text);
	$text = str_replace("è", "&egrave;", $text);

	$text = str_replace("í", "&iacute;", $text);
	$text = str_replace("ì", "&igrave;", $text);
	$text = str_replace("î", "&icirc;", $text);
	$text = str_replace("Í", "&Iacute;", $text);
	$text = str_replace("Ì", "&Igrave;", $text);
	$text = str_replace("Î", "&Icirc;", $text);

	$text = str_replace("Õ", "&otilde;", $text);
	$text = str_replace("Ô", "&Ocirc;", $text);
	$text = str_replace("Ó", "&Oacute;", $text);
	$text = str_replace("Ò", "&Ograve;", $text);
	$text = str_replace("õ", "&otilde;", $text);
	$text = str_replace("ô", "&ocirc;", $text);
	$text = str_replace("ó", "&oacute;", $text);
	$text = str_replace("ò", "&ograve;", $text);

	//$text = str_replace(" ", "&nbsp;", $text);
	$text = str_replace('\rn"', "<br>", $text);
	//$text = str_replace("-", "&#8211;", $text);
	//$text = str_replace("\'", "&quot;", $text);
	//$text = str_replace("'", "&quot;", $text);
	//$text = str_replace('\"', "&quot;", $text);
	//$text = str_replace('\\"', "&quot;", $text);
//	$text = str_replace('"', "&quot;", $text);
	$text = preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', '"&#".ord($0).";"', $text);
	

return $text;
};


function get_authorization($module_code,$staticvars){

if ($module_code==$staticvars['users']['user_type']['default']):
	return true;
endif;
if ($staticvars['users']['is_auth']==true):
	if ($module_code==$staticvars['users']['group'] or $module_code==$staticvars['users']['user_type']['auth'] or $module_code==$staticvars['users']['user_type']['cm'] or $module_code==$staticvars['users']['type']):
		return true;
	else:
		return false;
	endif;
else:// not autenticated
	if ($module_code==$staticvars['users']['user_type']['guest']):
		return true;
	else:
		return false;
	endif;
endif;
};

function is_admin($local_root){
	if (isset($_SESSION['user'])):
		include($local_root.'general/staticvars.php');
		$query=$db->getquery("select cod_user_type from users where nick='".$_SESSION['user']."'");
		$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
		if ($query[0][0]==$admin_code[0][0]):
			return true;
		else:
			return false;
		endif;
	else:
		return false;
	endif;
};


function get_user_type($local_root){
	if (isset($_SESSION['user'])):
		include($local_root.'general/staticvars.php');
		$query=$db->getquery('select cod_user_type from users where nick='.$_SESSION['user']);
		return $query[0][0];
	else:
		return 4;
	endif;
};


function strip_address($strip_var,$addr){
$tmp=explode("?",$addr);
if (isset($tmp[1])):
	$address=$tmp[0].'?';
	$tmp=$tmp[1];
else:
	$address=$addr.'?';
	$tmp=$addr;
endif;
$tmp=explode("&",$tmp);
for ($i=0;$i<count($tmp);$i++):
	$tmp2=explode("=",$tmp[$i]);
	if ($tmp2[0]<>$strip_var):
		$address.=$tmp[$i].'&';
	endif;
endfor;
$address=substr($address,0,strlen($address)-1);
return $address;
};

function session($staticvars,$url){
include($staticvars['local_root'].'kernel/staticvars.php');
$dim=array("&SID=","?SID=","&amp;SID=","&#63;SID=");
$text = str_replace($dim, "", $url);

if (isset($_SESSION['user'])): // user logged in SID must be present
	$sid=$_GET['SID'];
	if (strpos("-".$url,"?") or strpos("-".$url,"&#63;")):
		$url.= "&SID=".$sid;
	else:
		$url.= "?SID=".$sid;
	endif;
endif;
$lang=$staticvars['language']['main'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang'];
	$lg=explode(";",$staticvars['language']['available']);
	if (in_array($lang,$lg)===false):
		$lang=$staticvars['language']['main'];
	endif;
endif;
if (strpos("-".$url,"?") or strpos("-".$url,"&#63;")):
	$url.= "&lang=".$lang;
else:
	$url.= "?lang=".$lang;
endif;
if (isset($_GET['areaid'])):
	$areaid=$_GET['areaid'];
	if(is_numeric($areaid)):
		if (!strpos("-".$url,"?areaid=") and !strpos("-".$url,"&areaid=") and $areaid<>''):
			if (strpos("-".$url,"?")):
				$url.= "&areaid=".$areaid;
			else:
				$url.= "?areaid=".$areaid;
			endif;
		endif;
	endif;
endif;

return $url;
};
?>