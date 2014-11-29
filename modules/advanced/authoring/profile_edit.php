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
$task=@$_GET['id'];
if (isset($_POST['add_user'])):
	include('modules/authoring/update_db/edit_profile.php');
	session_write_close();
	sleep(1);
	header("Location: ".$_SERVER['REQUEST_URI']);
endif;
if(isset($_SESSION['status'])):
	echo '<font color="red">'.$_SESSION['status'].'</font>';
	unset($_SESSION['status']);
endif;
$qw=$db->getquery("select nome, email, nick, cod_user_type,active from users where cod_user='".$staticvars['users']['code']."'");
if (isset($_POST['add_pass'])):
	include_once('general/pass_generator.php');	
	$pass=generate(7,'No','Yes','Yes');	
else:
	$pass='';
endif;
if ($qw[0][4]=='1'):// user must change password
	include($staticvars['local_root'].'modules\\authoring\\system\\first_login.php');
else:
?>
    <h2><img src="modules/authoring/images/user-profile.jpg" height="16"><?=$pe[12];?></h2>
	<p><font color="#FF0000"><?=$message;?></font></p>
		<form class="form" enctype="multipart/form-data" action="<?=session($staticvars,'index.php?id='.$task);?>" method="post">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="25">&nbsp;</td>
				  <td colspan="2"><div align="right"><font class="form_title"><?=$pe[1];?><font size="1" color="#FF0000">&#8226;</font> <?=$pe[2];?></font></div></td>
				  <td width="27">&nbsp;</td>
			  </tr>			
				<tr>
				  <td width="25">&nbsp;</td>
				  <td colspan="2" align="left" class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?=$pe[3];?></strong>&nbsp;&nbsp;<?=$qw[0][0];?></td>
				  <td width="27">&nbsp;</td>
			  </tr>			
				<tr>
				  <td width="25">&nbsp;</td>
				  <td colspan="2" align="left" class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?=$pe[4];?></strong>&nbsp;&nbsp;<?=$qw[0][1];?></td>
				  <td width="27">&nbsp;</td>
			  </tr>			
				<tr height="5">
				  <td width="25"></td>
				  <td colspan="2"></td>
				  <td width="27"></td>
			  </tr>			
				<tr>
                  <td>&nbsp;</td>
				  <td colspan="2"><hr noshade="noshade" size="1" /></td>
				  <td>&nbsp;</td>
			  </tr>
				<tr height="5">
                  <td></td>
				  <td colspan="2"></td>
				  <td></td>
			  </tr>
				
				<tr height="5">
                  <td></td>
				  <td colspan="2"></td>
				  <td></td>
			  </tr>
				<tr>
                  <td>&nbsp;</td>
				  <td colspan="2"><div align="left"><font class="header_text_1"><?=$pe[5];?></font></div></td>
				  <td>&nbsp;</td>
			  </tr>
				
							
				<tr>
				  <td width="25">&nbsp;</td>
				  <td colspan="2"><div align="left"><font class="body_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$pe[6];?>&nbsp;&nbsp;</font><font class="body_text"><?=$qw[0][2];?></font></div></td>
				  <td width="27">&nbsp;</td>
			  </tr>			
				<tr>
				  <td width="25"></td>
				  <td colspan="2"><input type="hidden" name="cod_user" value="<?=$staticvars['users']['code'];?>"><input type="hidden" name="users_edit"></td>
				  <td width="27"></td>
			  </tr>			
				<tr height="5">
				  <td width="25"></td>
				  <td colspan="2"></td>
				  <td width="27"></td>
			  </tr>			
				<tr>
				  <td width="25">&nbsp;</td>
				  <td width="302" align="right"><font class="body_text">
				    <?=$pe[7];?>
				  </font></td>
				  <td width="877"><input class="text" type="password" name="pass1" value="<?=$pass;?>" size="25" maxlength="25" /></td>
				  <td width="27">&nbsp;</td>
			  </tr>			
				<tr height="5">
				  <td width="25"></td>
				  <td colspan="2"></td>
				  <td width="27"></td>
			  </tr>			
				<tr>
				  <td width="25">&nbsp;</td>
				  <td align="right"><font class="body_text"><?=$pe[8];?>
			      </font></td>
				  <td><font class="body_text">
				    <input class="text" type="password" name="pass2" value="<?=$pass;?>" size="25" maxlength="25" />
				  </font></td>
				  <td width="27">&nbsp;</td>
			  </tr>			
				<tr>
				  <td>&nbsp;</td>
				  <td colspan="2" align="left"><font class="body_text"><?=$pe[9];?></font></td>
				  <td>&nbsp;</td>
			  </tr>
				<tr>
				  <td width="25">&nbsp;</td>
				  <td colspan="2" align="right"><input class="button" type="submit" name="add_pass" value="<?=$pe[10];?>"></td>
				  <td width="27">&nbsp;</td>
			  </tr>			
			</table>
	<?php
    // add profiles from other modules
    $dir=glob($staticvars['local_root'].'modules/*',GLOB_ONLYDIR);
    $query=$db->getquery('select link,cod_module from module');
    if ($dir[0]<>''):
        for ($j=0; $j<count($query); $j++):
            $link=explode("/",$query[$j][0]);
            $mod[$j]=$link[0];
        endfor;
        for($ix=0; $ix<count($dir); $ix++):
            $dirX=explode("/",$dir[$ix]);
            if(in_array($dirX[count($dirX)-1],$mod)):		
                if (is_dir($dir[$ix].'/system')):
                    if(is_file($dir[$ix].'/system/profile.php') ):
                        include($dir[$ix].'/system/profile.php');
                        echo '<hr size=1><br>';
                    endif;
                endif;
            endif;
        endfor;
    endif;
endif;

?>
<div align="right"><input class="button" type="submit" name="add_user" value="<?=$pe[11];?>"></div>
	</form>
