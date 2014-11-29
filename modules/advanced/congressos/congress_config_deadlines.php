<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;

$task=@$_GET['id'];
$cod_category=0;
if (isset($_POST['update'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
endif;
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
if (isset($_POST['gravar'])):
	load_text($staticvars);
	session_write_close();
	sleep(1);
	//header("Location: ".$_SERVER['REQUEST_URI']);
endif;
if(isset($_SESSION['status'])):
	echo $_SESSION['status'];
	$_SESSION['status']=array();
	unset($_SESSION['status']);
endif;


if (!file_exists($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$enable_mainpage=true;
	$cell_space=0;
	$sa_ano='';
	$sa_mes='';
	$sa_dia='';
	$na_ano='';
	$na_mes='';
	$na_dia='';
	$sp_ano='';
	$sp_mes='';
	$sp_dia='';
	$np_ano='';
	$np_mes='';
	$np_dia='';
	$rp_ano='';
	$rp_mes='';
	$rp_dia='';
	$max_papers=1;
	$max_chars=3000;
	$type_file='pdf';
	$secretariat_email='@';
	$ovr_abs=false;
	$ovr_paper=false;
	$ovr_revised=false;
else:
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
	$tmp=explode("/",$sa);
	$sa_ano=$tmp[2];
	$sa_mes=$tmp[1];
	$sa_dia=$tmp[0];
	$tmp=explode("/",$na);
	$na_ano=$tmp[2];
	$na_mes=$tmp[1];
	$na_dia=$tmp[0];
	$tmp=explode("/",$sp);
	$sp_ano=$tmp[2];
	$sp_mes=$tmp[1];
	$sp_dia=$tmp[0];
	$tmp=explode("/",$np);
	$np_ano=$tmp[2];
	$np_mes=$tmp[1];
	$np_dia=$tmp[0];
	$tmp=explode("/",$rp);
	$rp_ano=$tmp[2];
	$rp_mes=$tmp[1];
	$rp_dia=$tmp[0];
endif;
$address=$_SERVER['REQUEST_URI'];
if(is_file($staticvars['local_root'].'modules/congressos/images/logo/logo.jpg')):
	$logo='<img src="'.$staticvars['site_path'].'/modules/congressos/images/logo/logo.jpg" border="0" />';
else:
	$logo='';
endif;
?>
<h2><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/icone_gestao.gif" width="20" />Datas Importantes</h2>
<br />
<form method="post" action="<?=$address;?>"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td height="15" colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="3"><strong>DeadLines</strong></td>
	</tr>
	<tr>
	  <td width="336" height="15" align="right" class="body_text">Deadline for submission of abstracts</td>
	  <td width="365" class="body_text" id="sa_dia2"><input name="sa_dia" type="text" id="sa_dia" size="2" maxlength="2" value="<?=$sa_dia;?>" />
	    /
        <input name="sa_mes" type="text" id="sa_mes" size="2" maxlength="2" value="<?=$sa_mes;?>"  />
        /
        <input name="sa_ano" type="text" id="sa_ano" size="4" maxlength="4"  value="<?=$sa_ano;?>"  /></td>
    </tr>
	<tr>
	  <td height="15" align="right" class="body_text">Notification of acceptance of abstracts</td>
	  <td class="body_text"><input name="na_dia" type="text" id="na_dia" size="2" maxlength="2"  value="<?=$na_dia;?>"  />
/
  <input name="na_mes" type="text" id="na_mes" size="2" maxlength="2"  value="<?=$na_mes;?>" />
/
<input name="na_ano" type="text" id="na_ano" size="4" maxlength="4"  value="<?=$na_ano;?>" /></td>
    </tr>
	<tr>
	  <td height="15" align="right" class="body_text">Deadline for submission of papers</td>
	  <td class="body_text"><input name="sp_dia" type="text" id="sa_dia4" size="2" maxlength="2"  value="<?=$sp_dia;?>" />
/
  <input name="sp_mes" type="text" id="sp_mes" size="2" maxlength="2"  value="<?=$sp_mes;?>"/>
/
<input name="sp_ano" type="text" id="sp_ano" size="4" maxlength="4"  value="<?=$sp_ano;?>"/></td>
    </tr>
	<tr>
	  <td height="15" align="right" class="body_text">Review and notification of acceptance of papers</td>
	  <td class="body_text"><input name="np_dia" type="text" id="sa_dia5" size="2" maxlength="2" value="<?=$np_dia;?>" />
/
  <input name="np_mes" type="text" id="np_mes" size="2" maxlength="2" value="<?=$np_mes;?>" />
/
<input name="np_ano" type="text" id="np_ano" size="4" maxlength="4" value="<?=$np_ano;?>" /></td>
    </tr>
	<tr>
	  <td height="15" align="right" class="body_text">Deadline for submission of revised papers </td>
	  <td class="body_text"><input name="rp_dia" type="text" id="sa_dia6" size="2" maxlength="2" value="<?=$rp_dia;?>" />
/
  <input name="rp_mes" type="text" id="rp_mes" size="2" maxlength="2"  value="<?=$rp_mes;?>"/>
/
<input name="rp_ano" type="text" id="rp_ano" size="4" maxlength="4"  value="<?=$rp_ano;?>"/></td>
	</tr>
	<tr>
	  <td colspan="3">&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="3"><strong>Override Deadlines</strong></td>
    </tr>
	<tr>
	  <td align="right">Submission of abstracts</td>
	  <td><select name="ovr_abs" id="ovr_abs">
	    <option value="true" <?php if ($ovr_abs==true){ echo 'selected="selected"';} ?>>Enable</option>
	    <option value="false" <?php if ($ovr_abs==false){ echo 'selected="selected"';} ?>>Disable</option>
      </select></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td align="right">Submission of papers</td>
	  <td><select name="ovr_paper" id="ovr_abs">
	    <option value="true" <?php if ($ovr_paper==true){ echo 'selected="selected"';} ?>>Enable</option>
	    <option value="false" <?php if ($ovr_paper==false){ echo 'selected="selected"';} ?>>Disable</option>
      </select></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td align="right">Submission of revised papers</td>
	  <td><select name="ovr_revised" id="ovr_abs">
	    <option value="true" <?php if ($ovr_revised==true){ echo 'selected="selected"';} ?>>Enable</option>
	    <option value="false" <?php if ($ovr_revised==false){ echo 'selected="selected"';} ?>>Disable</option>
      </select></td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="2" align="right" valign="bottom"><input name="gravar" class="form_submit" type="submit" value="Gravar" /></td>
	</tr>
  </table>
</form>
<?php	

function load_text($staticvars){
if (!file_exists($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$enable_mainpage='true';
	$cell_space='5';
	$max_papers='1';
	$max_chars='3000';
	$type_file='both';
	$event_type='congress';
else:
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
endif;
include($staticvars['local_root'].'kernel/staticvars.php');

$file_content='
<?PHP
// Congress general config
$enable_mainpage='.$enable_mainpage.';
$cell_space='.$cell_space.';
$max_papers='.$max_papers.';
$max_chars='.$max_chars.';
$type_file="'.$type_file.'";
$event_type="'.$event_type.'";
$cloaking='.$cloaking.';
$forwarding='.$forwarding.';
$secretariat_email="'.$secretariat_email.'";
$sa="'.$_POST['sa_dia'].'/'.$_POST['sa_mes'].'/'.$_POST['sa_ano'].'";
$na="'.$_POST['na_dia'].'/'.$_POST['na_mes'].'/'.$_POST['na_ano'].'";
$sp="'.$_POST['sp_dia'].'/'.$_POST['sp_mes'].'/'.$_POST['sp_ano'].'";
$np="'.$_POST['np_dia'].'/'.$_POST['np_mes'].'/'.$_POST['np_ano'].'";
$rp="'.$_POST['rp_dia'].'/'.$_POST['rp_mes'].'/'.$_POST['rp_ano'].'";
$ovr_abs='.$_POST['ovr_abs'].';
$ovr_paper='.$_POST['ovr_paper'].';
$ovr_revised='.$_POST['ovr_revised'].';
?>';
$message='';


$filename=$staticvars['local_root'].'modules/congressos/system/settings.php';
if (file_exists($filename)):
	unlink($filename);
endif;
if (!$handle = fopen($filename, 'a')):
	echo '<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
endif;
if (fwrite($handle, $file_content) === FALSE):
	echo '<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
endif;
	echo '<font class="body_text"> <font color="#FF0000">Success. Settings Saved.</font></font><br />';

$lang=explode(";",$staticvars['language']['available']);
$admin=return_id('ap_main.php');
$main=return_id('congress_main.php');
$ex=$db->getquery("select cod_category, folder from congress_category where nome='Deadlines'");
if($ex[0][0]<>''):
	$language['pt']='portuguese';
	$language['en']='english';

	for($i=0;$i<count($lang);$i++):
		$file_content=file_get_contents($staticvars['local_root'].'modules/congressos/templates/'.$lang[$i].'/important_dates.html');
		setlocale(LC_CTYPE, $language[$i]);
		setlocale(LC_TIME, $language[$i]);
		$file_content=str_replace("{sa}",date("jS F Y",mktime(0,0,0,$_POST['sa_mes'],$_POST['sa_dia'],$_POST['sa_ano'])),$file_content);
		$file_content=str_replace("{na}",date("jS F Y",mktime(0,0,0,$_POST['na_mes'],$_POST['na_dia'],$_POST['na_ano'] )),$file_content);
		$file_content=str_replace("{sp}",date("jS F Y",mktime(0,0,0,$_POST['sp_mes'],$_POST['sp_dia'],$_POST['sp_ano'] )),$file_content);
		$file_content=str_replace("{np}",date("jS F Y",mktime(0,0,0,$_POST['np_mes'],$_POST['np_dia'],$_POST['np_ano'] )),$file_content);
		$file_content=str_replace("{rp}",date("jS F Y",mktime(0,0,0,$_POST['rp_mes'],$_POST['rp_dia'],$_POST['rp_ano'] )),$file_content);
		$filename=$staticvars['local_root'].'modules/congressos/contents/'.$ex[0][1].'/'.$lang[$i].'/main.php';
		unlink($filename);
		if (!$handle = fopen($filename, 'a')):
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
		endif;
		if (fwrite($handle, $file_content) === FALSE):
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
		endif;
		fclose($handle);
	endfor;
else:
	echo 'Deadlines not found?! Problems?';
endif;


};

?>
