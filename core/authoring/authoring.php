<?PHP
if (isset($_POST['password']) and isset($_POST['username'])):
	include($globvars['local_root'].'core/authoring/config.php');
	if ($_POST['password']==$sbe_password and $_POST['username']==$sbe_user):
		$filename=$globvars['local_root'].'core/authoring/config.php';
		if (file_exists($filename)):
			include($filename);
			unlink($filename);
		endif;
		
		$sbe_session=md5( uniqid( rand () ) );
		
		@session_destroy();
		session_id($sbe_session);
		session_start();
		$_SESSION['user'] = $sbe_user;
		$_SESSION['session_users']='';

		
		$file_content='
		<?PHP
		// Sitebuilder User Administration
		$sbe_user="'.$sbe_user.'";
		$sbe_password="'.$sbe_password.'";
		$sbe_session="'.$sbe_session.'";
		$sbe_data="'.date('d;m;Y;H;i;s').'";
		?>';
		$handle = fopen($filename, 'a');
		fwrite($handle, $file_content);
		fclose($handle);
		
		$session_users=$sbe_user;
		$navto=@$_GET['navto'];
		if ($navto<>''):
			$navto=str_replace('@','&',$navto);
		endif;
		header("Location: ".$globvars['site_path']."/index.php?SID=".$sbe_session); 
		ob_end_flush();
		exit; 
	else:
		$globvars['warnings']='Invalid ID or incorrect passoword';
	endif;
else:
	// set errors vars
	$globvars['error']['flag']=true; // true if error occur
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
	$globvars['error']['message']='<font style="font-family:Georgia, Times, serif; font-size:12px">POST vars not set</font>';
	include($globvars['local_root'].'core/layout/'.$globvars['error']['layout']);
endif;
?>
