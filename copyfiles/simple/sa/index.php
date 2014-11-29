<?php
header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
header("Cache-control: private"); //IE 6 Fix for sessions
if (isset($_GET['SID'])):
	$sid=@$_GET['SID'];
	if (isset($_GET['SID'])):
		session_id($_GET['SID']);
		session_start();
	else:
		session_id('943f7a5dc10e0430c990937bb04426d8');
		session_start();
	endif;
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
	session_start();
	$sid='Null';
endif;
include('kernel/staticvars.php');
if (isset($_GET['lang'])):
	$staticvars['language']['current']=$_GET['lang'];
	if ($staticvars['language']['current']==''):
		$staticvars['language']['current']=$staticvars['language']['main'];
	endif; 
else:
	$staticvars['language']['current']=$staticvars['language']['main'];
endif;
if (isset($_GET['navigate'])):
	if(is_file($staticvars['local_root'].'modules/'.$_GET['navigate']."/auth.php")):
		include($staticvars['local_root'].'modules/'.$_GET['navigate']."/auth.php");
		if ($authoring=='Autenticated User'):
			if (isset($_SESSION['user']) and isset($auth_user) and isset($auth_pass)):
				$authorized=false;
				for($i=0;$i<count($auth_user);$i++):
					if($auth_user[$i]==$_SESSION['user']):
						$authorized=true;
						break;
					endif;
				endfor;
				if($authorized):
					$staticvars['module']['location']='modules/'.$_GET['navigate']."/main.php";
					$nav= $_GET['navigate'];
				else:
					$authorized='Não autorizado!';
					$staticvars['module']['location']='modules/login/main.php';
					$nav= $_GET['navigate'];
				endif;
			else:
				if (isset($_POST['user']) and isset($_POST['p_chave'])):
					$authorized='Não autorizado!';
				else:
					$authorized='';
				endif;
				$staticvars['module']['location']='modules/login/main.php';
				$nav= $_GET['navigate'];
			endif;
		else:
			$staticvars['module']['location']='modules/'.$_GET['navigate']."/main.php";
			$nav= $_GET['navigate'];
		endif;
	else:
		$staticvars['module']['location']='modules/'.$_GET['navigate']."/main.php";
		$nav= $_GET['navigate'];
	endif;
else:
	$staticvars['module']['location']='modules/mainpage/main.php';
	$nav='mainpage';
endif;


if(!is_file($staticvars['local_root'].$staticvars['module']['location']) or !is_file($staticvars['local_root'].'modules/'.$nav.'/language/'.$staticvars['language']['current'].'.php')):
	$staticvars['module']['location']='kernel/errors/not_found.php';
endif;


include($staticvars['local_root'].'layout/'.$staticvars['layout']['file']);
?>