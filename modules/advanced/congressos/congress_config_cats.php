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
// criar as categorias
$v[0]='mainpage';
$v[1]='Welcome';
$v[2]='Objectives';
$v[3]='Conference Program';
$v[4]='Conference Topics';
$v[5]='Conference Invited Speakers';
$v[6]='Scientific Committee';
$v[7]='Organizing Committee';
$v[8]='Registration';
$v[9]='Deadlines';
$v[10]='Abstract Submission';
$v[11]='Paper Submission';
$v[12]='Accepted Abstracts';
$v[13]='Accepted Papers';
$v[14]='Venue';
$v[15]='Travel Advisory';
$v[16]='Hotels & Accomodations';
$v[17]='Social Program';
$v[18]='Parallel Program';
$v[19]='Exhibition';
$v[20]='Sponsors';
$v[21]='Training Courses';
$v[22]='Secretariat';
$ex=$db->getquery("select cod_category, nome from congress_category");
if($ex[0]<>''):// categoria ja existe
	for($i=0;$i<count($ex);$i++):
		for($j=1;$j<count($v);$j++):
			if($v[$j]==$ex[$i][1]):
				$v[$j]='-1';
			endif;
		endfor;
	endfor;
endif;




?>
<h2><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/icone_gestao.gif" width="20" />Categorias</h2>
<br />
Para a gestao das categorias no modo avançado carregue <a href="<?=session($staticvars,'index.php?id='.return_id('congress_config_cats_adv.php'));?>">aqui</a>.
<form method="post" action="<?=$address;?>"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td colspan="2"><strong><br />
	    General</strong><br />
	    <input type="checkbox" name="v1" <?php if($v[1]=='-1'){ echo 'disabled="disabled" checked="checked"';}?> id="v1"  /> Welcome<br />
	    <input type="checkbox" name="v2" id="v2" <?php if($v[2]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Objectives<br />
	    <strong><br />
	    Conference</strong><br />
	    <input type="checkbox" name="v3" id="v3" <?php if($v[3]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Topics <br />
	    <input type="checkbox" name="v4" id="v4" <?php if($v[4]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Program<br />
	    <input type="checkbox" name="v5" id="v5" <?php if($v[5]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Invited Speakers<br />
	    <br />
	    <strong>Committees</strong><br />
	    <input type="checkbox" name="v6" id="v6" <?php if($v[6]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  />Scientific<br />
	    <input type="checkbox" name="v7" id="v7" <?php if($v[7]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  />Organizing<br />
	    <br />
	    <strong>Authors</strong><br />
	    <input type="checkbox" name="v8" id="v8" <?php if($v[8]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Registration<br />
	    <input type="checkbox" name="v9" id="v9" <?php if($v[9]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Deadlines<br />
	    <input type="checkbox" name="v10" id="v10" <?php if($v[10]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Abstract Submission<br />
	    <input type="checkbox" name="v11" id="v11" <?php if($v[11]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Paper Submission<br />
	    <input type="checkbox" name="v12" id="v12" <?php if($v[12]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Accepted Abstracts<br />
	    <input type="checkbox" name="v13" id="v13" <?php if($v[13]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  /> Accepted Papers<br />
	    <br />        <strong>Venue</strong><br />
        <input type="checkbox" name="v14" id="v14" <?php if($v[14]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  />&nbsp;Location<br />
        <input type="checkbox" name="v15" id="v15" <?php if($v[15]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  />&nbsp;Travel Advisory<br />
        <input type="checkbox" name="v16" id="v16" <?php if($v[16]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  />&nbsp;Hotels &amp; Accomodations<br />
        <input type="checkbox" name="v17" id="v17" <?php if($v[17]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  />&nbsp;Social Program<br />
        <input type="checkbox" name="v18" id="v18" <?php if($v[18]=='-1'){ echo 'disabled="disabled" checked="checked"';}?>  />&nbsp;Parallel Program
	    <p>
	      <input type="checkbox" name="v19" id="v19"  <?php if($v[19]=='-1'){ echo 'disabled="disabled" checked="checked"';}?> /> Exhibition<br />
          <input type="checkbox" name="v20" id="v20"  <?php if($v[20]=='-1'){ echo 'disabled="disabled" checked="checked"';}?> /> Sponsors<br />
          <input type="checkbox" name="v21" id="v21"  <?php if($v[21]=='-1'){ echo 'disabled="disabled" checked="checked"';}?> /> Training Course<br />
          <input type="checkbox" name="v22" id="v22"  <?php if($v[22]=='-1'){ echo 'disabled="disabled" checked="checked"';}?> />Secretariat
	    </p>
	    <p> <br />
      </p></td>
    </tr>
	<tr>
	  <td colspan="2"></td>
    </tr>
	<tr>
	  <td width="701" align="right" valign="bottom"><input name="gravar" class="form_submit" type="submit" value="Gravar" /></td>
	</tr>
  </table>
</form>
<?php	

function load_text($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
// criar as categorias
$v[0]='';
$v[1]='Welcome';
$v[2]='Objectives';
$v[3]='Conference Program';
$v[4]='Conference Topics';
$v[5]='Conference Invited Speakers';
$v[6]='Scientific Committee';
$v[7]='Organizing Committee';
$v[8]='Registration';
$v[9]='Deadlines';
$v[10]='Abstract Submission';
$v[11]='Paper Submission';
$v[12]='Accepted Abstracts';
$v[13]='Accepted Papers';
$v[14]='Venue';
$v[15]='Travel Advisory';
$v[16]='Hotels & Accomodations';
$v[17]='Social Program';
$v[18]='Parallel Program';
$v[19]='Exhibition';
$v[20]='Sponsors';
$v[21]='Training Courses';
$v[22]='Secretariat';
//mainpage
$ex=$db->getquery("select cod_category, nome, folder from congress_category where nome='mainpage'");
if($ex[0][0]==''):
	$folder='mainpage';
	if (is_dir($staticvars['local_root'].'modules/congressos/contents/'.$folder)):
		@rmdir($staticvars['local_root'].'modules/congressos/contents/'.$folder);
	endif;
	@mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder);	
	
	$db->setquery("insert into congress_category set translations='en=mainpage||pt=mainpage', nome='mainpage', folder='mainpage'");
	
	$lang=explode(";",$staticvars['language']['available']);
	$admin=return_id('congress_config_cats_adv.php');
	$ex=$db->getquery("select cod_category from congress_category where nome='mainpage'");
	for($j=0;$j<count($lang);$j++):
		$link=session($staticvars,$staticvars['site_path'].'/index.php?id='.$admin.'&cat='.$ex[0][0]);
		mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder.'/'.$lang[$j]);		
		$file_content="<!-- mainpage -->".chr(13)."<h2>Main page</h2>
		<?php
		if(isset("."$"."_GET['lang'])):
			"."$"."lang="."$"."_GET['lang'];
		else:
			"."$"."lang="."$"."staticvars['language']['main'];
		endif;
		include("."$"."staticvars['local_root'].'modules/congressos/contents_extended/default/'."."$"."lang.'/edit_contents.php');
		?>
		";
		$filename=$staticvars['local_root'].'modules/congressos/contents/'.$folder.'/'.$lang[$j].'/main.php';
		if (!$handle = fopen($filename, 'a')):
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
		endif;
		if (fwrite($handle, $file_content) === FALSE):
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
		endif;
		fclose($handle);
	endfor;
endif;
for($i=1;$i<count($v);$i++):
	if(isset($_POST['v'.$i])):
		$ex=$db->getquery("select cod_category, nome, folder from congress_category where nome='".$v[$i]."'");
		if($ex[0][0]<>''):// categoria ja existe
			continue;
		endif;
		
		$folder=str_replace(" ","",normalize_chars($v[$i]));
		$len= strlen($folder)>10 ? 10 : strlen($folder);
		$folder=substr($folder,0,$len);
		if (is_dir($staticvars['local_root'].'modules/congressos/contents/'.$folder)):
			$folder.= rand(1,1000);
			@mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder);
		else:
			@mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder);	
		endif;
		
		$db->setquery("insert into congress_category set translations='en=".$v[$i]."||pt=', nome='".$v[$i]."', folder='".$folder."'");
		
		$lang=explode(";",$staticvars['language']['available']);
		$admin=return_id('congress_config_cats_adv.php');
		$ex=$db->getquery("select cod_category from congress_category where nome='".$v[$i]."'");
		for($j=0;$j<count($lang);$j++):
			$link=session($staticvars,$staticvars['site_path'].'/index.php?id='.$admin.'&cat='.$ex[0][0]);
			mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder.'/'.$lang[$j]);		
			$file_content="<!-- ".$v[$i]." -->".chr(13)."<h2>".$v[$i]."</h2>
			<?php
			if(isset("."$"."_GET['lang'])):
				"."$"."lang="."$"."_GET['lang'];
			else:
				"."$"."lang="."$"."staticvars['language']['main'];
			endif;
			include("."$"."staticvars['local_root'].'modules/congressos/contents_extended/default/'."."$"."lang.'/edit_contents.php');
			?>
			";
			$filename=$staticvars['local_root'].'modules/congressos/contents/'.$folder.'/'.$lang[$j].'/main.php';
			if (!$handle = fopen($filename, 'a')):
				$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
			endif;
			if (fwrite($handle, $file_content) === FALSE):
				$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
			endif;
			fclose($handle);
		endfor;
	endif;
endfor;
if(isset($_POST['v9'])):// Important Dates
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
			$file_content=str_replace("{sa}",date("j F Y",date("jS F Y",mktime(0,0,0,$_POST['sa_mes'],$_POST['sa_dia'],$_POST['sa_ano']))),$file_content);
			$file_content=str_replace("{na}",date("j F Y",date("jS F Y",mktime(0,0,0,$_POST['na_mes'],$_POST['na_dia'],$_POST['na_ano'] ))),$file_content);
			$file_content=str_replace("{sp}",date("j F Y",date("jS F Y",mktime(0,0,0,$_POST['sp_mes'],$_POST['sp_dia'],$_POST['sp_ano'] ))),$file_content);
			$file_content=str_replace("{np}",date("j F Y",date("jS F Y",mktime(0,0,0,$_POST['np_mes'],$_POST['np_dia'],$_POST['np_ano'] ))),$file_content);
			$file_content=str_replace("{rp}",date("j F Y",date("jS F Y",mktime(0,0,0,$_POST['rp_mes'],$_POST['rp_dia'],$_POST['rp_ano'] ))),$file_content);
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
	$_SESSION['status']='Settings Saved!';
endif;
if(isset($_POST['v10']))://Abstract Submission
	$lang=explode(";",$staticvars['language']['available']);
	$admin=return_id('ap_main.php');
	$main=return_id('congress_main.php');
	$ex=$db->getquery("select cod_category, folder from congress_category where nome='Abstract Submission'");
	if($ex[0][0]<>''):
		$language['pt']='portuguese';
		$language['en']='english';

		for($i=0;$i<count($lang);$i++):
			$file_content=file_get_contents($staticvars['local_root'].'modules/congressos/templates/'.$lang[$i].'/abstract_submission.html');
			setlocale(LC_CTYPE, $language[$i]);
			setlocale(LC_TIME, $language[$i]);
			$file_content=str_replace("{sa}",date("j F Y",date("jS F Y",mktime(0,0,0,$_POST['sa_mes'],$_POST['sa_dia'],$_POST['sa_ano']))),$file_content);
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
		echo 'Abstract submisison not found?! Problems?';
	endif;
	$_SESSION['status']='Settings Saved!';
endif;
};

?>
