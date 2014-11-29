<php
// you need to include 
	session_write_close();
// before all header();

// change code to open link DB when needed and close before all headers and exits


if():
	$globvars['warnings']='';
	add_error($globvars['warnings'],__LINE__,__FILE__);
	$globvars['error']['critical']=false; // true if critical error occurs and code execution is not allowed
	$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
    if($globvars['error']['critical']):
    	$_SESSION['cerr']=true;
        sleep(1);
        session_write_close();
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit;
    endif;
endif;


		if(fwrite($handle, $file_content)==false):
			$globvars['warnings']='Unable to write file:'.$filename;
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				header("Location: ".$_SERVER['REQUEST_URI']);
                session_write_close();
				exit;
			endif;
		endif;


		$verify=$db->getquery("");
		if ($verify[0][0]==''):
			$globvars['warnings']='Unable to insert table to  DB! <  >';
			add_error($globvars['warnings'],__LINE__,__FILE__);
			$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
			$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
			if($globvars['error']['critical']):
				$_SESSION['cerr']=true;
				header("Location: ".$_SERVER['REQUEST_URI']);
                session_write_close();
				exit;
			endif;
		endif;

?>
