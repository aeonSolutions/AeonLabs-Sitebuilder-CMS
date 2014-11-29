<?php 
/*
File revision date: 10-Fev-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/authoring/language/pt.php');
else:
	include($staticvars['local_root'].'modules/authoring/language/'.$lang.'.php');
endif;
if (isset($_POST['mod_email'])):
	include($stativars['local_root'].'kernel/staticvars.php');
	$query=$db->getquery("select email, nick,nome, cod_user from users where email='".mysql_escape_string($_POST['mod_email'])."'");
	if ($query[0][0]==''):
		$_SESSION['msg']=$lp[7];
	else:
		// send mail
		include($stativars['local_root'].'general/pass_generator.php');
		$pass=generate(7,'No','Yes','Yes');		
		$user=$query[0][1];
		$db->setquery("Update users set password=password('".$pass."') where cod_user='".$query[0][3]."'");

		//send email to author
		include_once('email/email_engine.php');
		$email = new email_engine_class;
		$email->to=$query[0][0];
		$email->from=$staticvars['smtp']['admin_mail'];
		$email->return_path=$staticvars['smtp']['admin_mail'];
		$email->subject=$lp[6].' '.$staticvars['name'];
		$email->preview=false;
		/* valid tags:
		{title} - title of webpage;
		{site_name} -> $staticvars['name'];
		{reference} - reference code;
		*/
		if(is_file($staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/retrieve_pass.html')):
			$email->template_location=$staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/';
			$email->template='retrieve_pass';
		else:
			$email->template_location=$staticvars['local_root'].'modules/authoring/templates/emails/en/';
			$email->template='retrieve_pass';
		endif;
		if(is_file($staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/retrieve_pass_msg.html')):
			$email->message=file_get_contents($staticvars['local_root'].'modules/authoring/templates/emails/'.$lang.'/retrieve_pass_msg.html');
		else:
			$email->message=file_get_contents($staticvars['local_root'].'modules/authoring/templates/emails/en/retrieve_pass_msg.html');
		endif;
		
		$email->message=str_replace("{site_name}",$staticvars['name'],$email->message);
		$email->message=str_replace("{username}",$user,$email->message);
		$email->message=str_replace("{password}",$pass,$email->message);
		$message=$email->send_email($staticvars);
		$_SESSION['msg']='ok';	
	endif;
	//session_write_close();
	//sleep(1);
	//header("Location: ".$_SERVER['REQUEST_URI']);
endif;

if(isset($_SESSION['msg'])):
	if($_SESSION['msg']=='ok'):
		include($staticvars['local_root'].'modules/authoring/system/retrieve_pass_ok.php');
	else:
		echo $_SESSION['msg'];
		$_SESSION['msg']=array();
		unset($_SESSION['msg']);
	endif;
else:
	?>
    <H2><img src="<?=$staticvars['site_path'];?>/modules/authoring/images/user-profile.gif" alt="" width="32" height="32" align="absbottom"><?=$lp[0];?></H2>
	<p><?=$lp[1];?>	</p>
    <table width="100%" height="450"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="20" height="20" ></td>
            <td height="20" align="center" valign="top" >
            <div align='justify' ><?=$lp[2];?></div>	
            </td>
            <td width="20" height="20" ></td>
            </tr>
            <tr>
            <td width="20" height="35" ></td>
            <td height="35" >
            <font ><?=$lp[3];?></font>
            </td>
            <td width="20" height="35" ></td>
            </tr>
            <tr>
            <td width="20" height="35" ></td>
            <td height="35" >
            <div align='left' ><?=$lp[4];?></div>
            </td>
            <td width="20" height="35" ></td>
            </tr>
          <tr>
            <td width="20" height="20" >
            </td>
            <td height="20" >
            <form class="form" action="<?=session($staticvars,'index.php?id='.$task);?>" enctype="multipart/form-data" name="form_new_reg" method="post">
            <input type="text" name="mod_email" maxlength="255" size="50" class="text" />&nbsp;<input type="submit" name="mod_submit" value="<?=$lp[5];?>" class="button" />
            </form>
        </td>
        <td width="20" height="20" >&nbsp;</td>
      </tr>
      <tr>
        <td height="30" colspan="3" >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" >&nbsp;</td>
      </tr>
    </table>
	<?php
endif;


?>