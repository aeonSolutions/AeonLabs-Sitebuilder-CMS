<?php
/*
File revision date: 11-Mar-2008
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
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
	header("Location: ".$_SERVER['REQUEST_URI']);
endif;
if(isset($_SESSION['status'])):
	echo $_SESSION['status'];
	$_SESSION['status']=array();
	unset($_SESSION['status']);
endif;
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
	$forwarding=false;
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
if(is_file($staticvars['local_root'].'modules/congressos/system/logo/logo.jpg')):
	$logo='<img src="'.$staticvars['site_path'].'/modules/congressos/system/logo/logo.jpg" border="0" />';
else:
	$logo='';
endif;
?>
<img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/icone_gestao.gif" /><font class="Header_text_4">Configura&ccedil;&atilde;o geral </font><br />
<br />
<form method="post" action="<?=$address;?>"  enctype="multipart/form-data">
	<input type="hidden" name="ovr_abs" value="<?=$ovr_abs;?>" />
	<input type="hidden" name="ovr_paper" value="<?=$ovr_paper;?>" />
	<input type="hidden" name="ovr_revised" value="<?=$ovr_revised;?>" />
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td colspan="3"><strong>Categorias do Congresso</strong></td>
    </tr>
	<tr>
	  <td colspan="3"><strong><br />
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
	  <td colspan="3"></td>
    </tr>
	<tr>
	  <td colspan="3"><strong>MainPage</strong></td>
    </tr>
	<tr>
	  <td colspan="3"><font class="body_text">O modo mainpage permite que seja carregada uma p&aacute;gina por defeito quando n&atilde;o &eacute; especificada nenhuma p&aacute;gina.<br />
	      <br />
        Activar mainpage&nbsp;&nbsp;&nbsp;
	    <select size="1" name="mainpage" class="form_input" >
		<option value="true" <?php if ($enable_mainpage){?>selected="selected"<?php } ?>>Sim</option>
		<option value="false" <?php if (!$enable_mainpage){?>selected="selected"<?php } ?>>N&atilde;o</option>
	</select>&nbsp;&nbsp; 
	<br />
	<br />
	a p&aacute;gina ter&aacute; que se encontrar no direct&oacute;rio com o nome mainpage e o ficheiro principal ter&aacute; que ter o mesmo nome.</font></td>
	</tr>
	<tr>
	  <td height="15" colspan="2"></td>
    </tr>
	<tr>
	  <td height="15" colspan="2"><strong>CellSpacing</strong></td>
	</tr>
	<tr>
	  <td colspan="3" class="body_text">A op&ccedil;&atilde;o CellSpacing permir definir uma margem em pixeis &agrave; volta da p&aacute;gina a carregar.<br />
	    Caso pretenda controlar as margens manualmente. Introduza o valor 0.<br />
        <br />
	    CellSpacing 
	    <label>
	    <input name="cellspacing" type="text" id="cellspacing" value="<?=$cell_space;?>" size="5" maxlength="2" class="form_input" />
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">(max&iacute;mo recomendado 10)</font></label></td>
	</tr>
	<tr>
	  <td height="15" colspan="2"></td>
	</tr>
	<tr>
	  <td colspan="3" align="right">&nbsp;</td>
	</tr>
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
	  <td height="15" colspan="2">Type of file allowed in submission of Papers 
	    <select name="type_file" id="type_file">
	      <option value="pdf" <?php if($type_file=='pdf'){ echo 'selected="selected"';}?>>Pdf</option>
	      <option value="doc" <?php if($type_file=='doc'){ echo 'selected="selected"';}?>>Doc</option>
	      <option value="both" <?php if($type_file=='both'){ echo 'selected="selected"';}?>>Both</option>
      </select></td>
    </tr>
	<tr>
	  <td height="15" colspan="2"></td>
    </tr>
	<tr>
	  <td height="15" colspan="2">How many Papers can a user submit 
      <input name="max_papers" type="text" id="max_papers" size="2" maxlength="2" value="<?=$max_papers;?>" /></td>
	</tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">Max charecters allowed on Abstract submission 
      <input name="max_chars" type="text" id="max_chars" size="5" maxlength="5"  value="<?=$max_chars;?>" /></td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">Tipo de evento
	    <select name="event_type" id="event_type">
	      <option value="congress" <?php if($type_file=='congress'){ echo 'selected="selected"';}?>>Congress</option>
	      <option value="conferece" <?php if($type_file=='conferece'){ echo 'selected="selected"';}?>>Conferece</option>
	      <option value="workshop" <?php if($type_file=='workshop'){ echo 'selected="selected"';}?>>Workshop</option>
      </select></td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom"><p>Email secretariado 
	    <input name="secretariat_email" type="text" id="secretariat_email" size="40" maxlength="100" value="<?=$secretariat_email;?>" />
	  </p>
      <p><strong>
      <input type="checkbox" name="forwarding" id="forwarding" <?php if($forwarding=='on'){ echo 'checked="checked"';}?>/>
Forwarding<br />
      </strong>a op&ccedil;&atilde;o Forwarding permite que os emails enviados aos autores ap&oacute;s a submiss&atilde;o de um resumo ou artigo sejam reenviados para o secretariado. </p></td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">Logotipo<br /><?=$logo;?>
      <br /><input name="imagem" type="file" id="imagem" size="40" maxlength="255" /></td>
    </tr>
	<tr>
	  <td colspan="2" align="left" valign="bottom">&nbsp;</td>
    </tr>
	<tr>
	  <td colspan="2" align="right" valign="bottom"><input name="gravar" class="form_submit" type="submit" value="Gravar" /></td>
	</tr>
  </table>
</form>
<?php	

function load_text($staticvars){

if (!file_exists($staticvars['local_root'].'modules/congressos/system/settings.php')):
	$sa='//';
	$na='//';
	$sp='//';
	$np='//';
	$rp='//';
	$cloaking=false;
else:
	include($staticvars['local_root'].'modules/congressos/system/settings.php');
endif;
$ovr_abs= ($ovr_abs==false) ? 'false' : 'true';
$ovr_paper= ($ovr_paper==false) ? 'false' : 'true';
$ovr_revised= ($ovr_revised==false) ? 'false' : 'true';
$cloaking= ($cloaking==false) ? 'false' : 'true';
$file_content='
<?PHP
// Congress general config
$enable_mainpage='.$_POST['mainpage'].';
$cell_space='.$_POST['cellspacing'].';
$max_papers='.$_POST['max_papers'].';
$max_chars='.$_POST['max_chars'].';
$type_file="'.$_POST['type_file'].'";
$event_type="'.$_POST['event_type'].'";
$secretariat_email="'.$_POST['secretariat_email'].'";
$forwarding="'.$_POST['forwarding'].'";
$cloaking="'.$cloaking.'";
$sa="'.$_POST['sa_dia'].'/'.$_POST['sa_mes'].'/'.$_POST['sa_ano'].'";
$na="'.$_POST['na_dia'].'/'.$_POST['na_mes'].'/'.$_POST['na_ano'].'";
$sp="'.$_POST['sp_dia'].'/'.$_POST['sp_mes'].'/'.$_POST['sp_ano'].'";
$np="'.$_POST['np_dia'].'/'.$_POST['np_mes'].'/'.$_POST['np_ano'].'";
$rp="'.$_POST['rp_dia'].'/'.$_POST['rp_mes'].'/'.$_POST['rp_ano'].'";
$ovr_abs='.$ovr_abs.';
$ovr_paper='.$ovr_paper.';
$ovr_revised='.$ovr_revised.';
?>';
$message='';
$image='';
if (isset($_FILES['imagem'])):
	if (stristr($_FILES['imagem']['type'],"jpeg")or stristr($_FILES['imagem']['type'],"gif")):
		$name=$_FILES['imagem']['name'];
		$tmp=explode(".",$name);
		$location_original=$staticvars['local_root'].'modules/congressos/system/logo/original/logo.'.$tmp[1];
		$location=$staticvars['local_root'].'modules/congressos/system/logo/logo.'.$tmp[1];
		if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $location_original)):
			echo '<font class="body_text"> <font color="#FF0000">Erro no Upload. Por favor tente de novo.</font></font>';
		else:
			// Set a maximum height and width
			$width = 500;
			$height = 250;			
			// Get new dimensions
			list($width_orig, $height_orig) = getimagesize($location_original);				
			if ($width && ($width_orig < $height_orig)):
			   $width = ($height / $height_orig) * $width_orig;
			else:
			   $height = ($width / $width_orig) * $height_orig;
			endif;
			// Resample
			$image_p = imagecreatetruecolor($width, $height);
			if (stristr($_FILES['imagem']['type'],"jpeg")):
				$image = imagecreatefromjpeg($location_original);
			else:
				$image = imagecreatefromgif($location_original);
			endif;
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			// Output
			if (stristr($_FILES['imagem']['type'],"jpeg")):
				imagejpeg($image_p,$location);
			else:
				imagejpeg($image_p,$location);
			endif;
			$image=$tmp1[1];
		endif;
	endif;
endif;
// end of image upload

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

fclose($handle);
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
			@mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder, 0755, true);
		else:
			@mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder, 0755, true);	
		endif;
		
		$db->setquery("insert into congress_category set translations='en=".$v[$i]."||pt=', nome='".$v[$i]."', folder='".$folder."'");
		
		$lang=explode(";",$staticvars['language']['available']);
		$admin=return_id('ap_main.php');
		$main=return_id('congress_main.php');
		$ex=$db->getquery("select cod_category from congress_category where nome='".$v[$i]."'");
		for($j=0;$j<count($lang);$j++):
			$link=session($staticvars,$staticvars['site_path'].'/index.php?id='.$admin.'&load=categories.php&cat='.$ex[0][0].'&goto='.$main);
			mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder.'/'.$lang[$j], 0755, true);		
			$file_content='<!-- '.$v[$i].' -->'.chr(13).'<h2>'.$v[$i].'</h2><h3 align="center">Para editar este ficheiro clique <a href="'.$link.'">aqui</a></h3>';
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
if(isset($_POST['v9'])):
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
	$_SESSION['status']='Settings Saved!';
endif;
};

?>
