<?php
/*
File revision date: 14-abr-2008
*/

// User management file system Installed
$query=$db->getquery("select cod_user_type, name from user_type");
for ($i=0;$i<count($query);$i++):
	if ($query[$i][1]=='Administrators'):
		$staticvars['users']['user_type']['admin']=$query[$i][0];
	elseif ($query[$i][1]=='Guests'):
		$staticvars['users']['user_type']['guest']=$query[$i][0];
	elseif ($query[$i][1]=='Default'):
		$staticvars['users']['user_type']['default']=$query[$i][0];
	elseif ($query[$i][1]=='Authenticated Users'):
		$staticvars['users']['user_type']['auth']=$query[$i][0];
	elseif ($query[$i][1]=='Content Management'):
		$staticvars['users']['user_type']['cm']=$query[$i][0];
	endif;
endfor;
$staticvars['users']['is_auth']=false;// flag true when user auth occurs

if (isset($_SESSION['user'])):
		$user=$db->getquery("select cod_user, cod_user_type,email from users where nick='".$_SESSION['user']."'");
		$group=$db->getquery("select cod_user_group from user_type where cod_user_type='".$user[0][1]."'");
		$ss=$db->getquery("select session_id from sessions where cod_user='".$user[0][0]."'");
		if ($sid<>$ss[0][0]): // tampered SID ->force logout!
			if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])):
		         setcookie("cookname", "", time()-$staticvars['cookies']['expire'], $staticvars['cookies']['path']);
		         setcookie("cookid",   "", time()-$staticvars['cookies']['expire'], $staticvars['cookies']['path']);
				 unset($_COOKIE['cookname']);
				 unset($_COOKIE['cookid']);
		    endif;
			session_destroy(); 
			$_SESSION = array(); 
			session_id(md5( uniqid( rand () ) ));
			session_start();
			header("Location: index.php?id=".return_id('login_requiered.php')."&logout=1");
			echo 'ERROR (INDEX -1) - not authenticated properly!';
			exit;
		endif;
		$staticvars['users']['is_auth']=true;// flag true when user auth occurs
		$staticvars['users']['name']= isset($_SESSION['user']) ? $_SESSION['user'] : 0;// username
		$staticvars['users']['code']=$user[0][0];
		$staticvars['users']['type']=$user[0][1];
		$staticvars['users']['group']=$group[0][0];
		$staticvars['users']['email']=$user[0][2];

else:
		$staticvars['users']['name']= isset($_SESSION['user']) ? $_SESSION['user'] : 0;// username
		$staticvars['users']['code']=0;// db user code
		$staticvars['users']['group']=0;// db user code
		$staticvars['users']['type']=$staticvars['users']['user_type']['guest'];// guest code
		$staticvars['users']['email']='';// guest code
endif;

?>