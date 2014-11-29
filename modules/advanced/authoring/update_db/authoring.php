<?PHP
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if (isset($_GET['lang'])):
	$lang=$_GET['lang'];	
	if ($lang==''):
		$lang=$staticvars['language']['main'];
	endif;
else:
	$lang=$staticvars['language']['main'];
endif;
$message=0;
if (isset($_POST['user']) and isset($_POST['p_chave'])):
    $nome=mysql_escape_string($_POST["user"]);    
    $password=mysql_escape_string($_POST["p_chave"]);    
   	$query=$db->getquery("select cod_user,nick,active,cod_user_type from users where nick='".$nome."' and password=PASSWORD('".$password."')");   
    if ($query[0][0]<>''):
		if ($query[0][2]=='?'): //User found but not activated
			 $message=1;
		elseif ($query[0][2]=='n'): // user found but acount is disabled
			 $message=2;		
		else: // active='s'
		 	/*se encontrado e activado*/
			$SessionID = md5( uniqid( rand () ) );
			if(isset($_COOKIE['cookid'])&& !isset($_COOKIE['cookname'])):// only cookie with SID is set - ecommerce module for instante 
				$SessionID=$_COOKIE['cookid'];
			endif;
			$qw=$db->getquery("select session_id from sessions where cod_user='".$query[0][0]."'");
			if($qw[0][0]<>''): 
				$db->setquery("update sessions set data=NOW(), session_id='".$SessionID."' where cod_user='".$query[0][0]."'");				
			else:
				$db->setquery("insert into sessions set cod_user='".$query[0][0]."', data=NOW(), session_id='".$SessionID."'");
			endif;
			@session_destroy();
			session_id($SessionID);
			session_start();
			$_SESSION['user'] = $query[0][1];
			$db->setquery("update users set data=NOW() where cod_user='".$query[0][0]."'");
			if ($staticvars['cookies']['enable']):
				setcookie("cookname", $query[0][1], time()+$staticvars['cookies']['expire'], $staticvars['cookies']['path']);
				setcookie("cookid",   $SessionID,   time()+$staticvars['cookies']['expire'], $staticvars['cookies']['path']);
			endif;
			session_write_close();
			if(isset($_GET['areaid'])):
				$areaid='&areaid='.$_GET['areaid'];
			else:
				$areaid='';	
			endif;
			echo '->'.$areaid.'<br>';
			if (isset($_GET['navto'])):
				$navto=@$_GET['navto'];
				if($navto==''):
					// loading main page
					$navto=$staticvars['site_path']."/index.php?SID=".$SessionID.'&lang='.$lang.$areaid;
				else:
					$navto=str_replace('@','&',$navto);
					$navto=$staticvars['site_path']."/index.php?id=".$navto."&SID=".$SessionID.'&lang='.$lang.$areaid;
				endif;
			else:
				$navto=$staticvars['site_path']."/index.php?SID=".$SessionID.'&lang='.$lang.$areaid;
			endif;
			if ($query[0][2]=='1'): // user found but acount has default password - user must change password
				$navto=$staticvars['site_path']."/index.php?id=".return_id('profile_edit.php')."&SID=".$SessionID.'&lang='.$lang.$areaid;
			endif;
			header('HTTP/1.1 200 OK');
			header("Location: ".$navto); 
			ob_end_flush();
			exit; 
		endif;	//($query[0][2]=='?')
    else:
    	/*User Not found*/    
     	if (isset($_SESSION['user'])):
    		unset($_SESSION['user']);
		endif;
		$message=3; // user not found
	endif; //($query[0][0]<>'')
endif;
?>