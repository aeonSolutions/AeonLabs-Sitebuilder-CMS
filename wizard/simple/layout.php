<?php 
/*
File revision date: 14-Ago-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

function check_files($dir,$filename){
$filename=$dir.'/'.$filename;
$files = glob($dir."/*.*");
$tmp=false;
for($i = 0; $i < count($files); $i++):
	if ($files[$i]==$filename):
		$tmp=true;
	endif;
endfor;
return $tmp;
};

function build_skin($globvars,$file){
	$code=file_get_contents($globvars['local_root']."layouts/templates/".$file);
	$filename=$_SESSION['directory'].'kernel/staticvars.php';
	include($filename);

	$filename=explode(".",$file);
	$dir_name=$filename[0];
	//update image links
	$code=str_replace('src="','src="'.$staticvars['site_path'].'/layout/',$code);
	$code=str_replace("src='","src='".$staticvars['site_path'].'/layout/',$code);
	// update background links
	$code=str_replace('background="','background="'.$staticvars['site_path'].'/layout/',$code);
	$code=str_replace("background='","background='".$staticvars['site_path'].'/layout/',$code);

	$code=str_replace("url('","url('".$staticvars['site_path']."/layout/",$code);
	$code=str_replace("url(","url(".$staticvars['site_path']."/layout/",$code);
	$code=str_replace('url("','url("'.$staticvars['site_path']."/layout/",$code);



	// update external stylesheet file - only one allowed
	if (strpos("-".$code,"<link")):
		$code = str_replace('<link rel="stylesheet" type="text/css" href="','<link rel="stylesheet" type="text/css" href="'.$staticvars['site_path'].'/layout/',$code);
		$code = str_replace('<link href="','<link href="'.$staticvars['site_path'].'/layout/',$code);
		$code = str_replace('<link type="text/css" href="','<link type="text/css" href="'.$staticvars['site_path'].'/layout/',$code);
		$style=true;
		// retrieve css file name
		$init=strpos($code,"<link");
		$final=strpos($code,"/>",$init);
		$filename=substr($code,$init,$final-$init);
		$filename=explode("href",$filename);
		$filename=explode('"',$filename[1]);
		$filename=explode("/",$filename[1]);
		$css_file=$filename[count($filename)-1];

	else:
		$style=false;	
	endif;
	// replace {main} tag
	$tmp="<?php include("."$"."staticvars['local_root']."."$"."staticvars['module']['location']); ?>";
	$code=str_replace("{main}",$tmp,$code);
	// other tags
	$code=str_replace("{date}",'<?=date("l, dS F Y ");?>',$code);
	
	$filename=$_SESSION['directory'].'layout/'.$dir_name.'.php';
	if (file_exists($filename)):
		unlink($filename);
	endif;
	if (!$handle = fopen($filename, 'a')):
		echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
		exit;
	endif;
	if (fwrite($handle, $code) === FALSE):
		echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
		exit;
	endif;
	fclose($handle);	
	if ($style):
		$file_content=file_get_contents($staticvars['local_root']."layout/".$dir_name."/".$css_file);
		$file_content=str_replace("url('","#1475777#".$staticvars['site_path']."/layout/".$dir_name."/",$file_content);
		$file_content=str_replace("url(","url(".$staticvars['site_path']."/layout/".$dir_name."/",$file_content);
		$file_content=str_replace("#1475777#","url('",$file_content);
		$file_content=str_replace("#1475778#","url('",$file_content);
		$file_content=str_replace("#1475779#","url(",$file_content);

		$filename=$_SESSION['directory']."layout/".$dir_name."/".$css_file;
		if (file_exists($filename)):
			unlink($filename);
		endif;
		if (!$handle = fopen($filename, 'a')):
			echo "<font class='style6' color='#FF0000'>Cannot open file (".$filename.")</font>";
			exit;
		endif;
		if (fwrite($handle, $file_content) === FALSE):
			echo "<font class='style6' color='#FF0000'>Cannot write to file (".$filename.")</font>";
			exit;
		endif;
		fclose($handle);	
	endif;
};
function normalize($text){
// eliminates special characters and convert to lower case a text string
	$dim=array("&ccedil;","&ccedil;");
	$text = str_replace($dim, "c", $text);

	$dim=array("&atilde;","&aacute;","à","â","&atilde;","&aacute;","À","Â");
	$text = str_replace($dim, "a", $text);

	$dim=array("é","ê","Ê","É");
	$text = str_replace($dim, "e", $text);

	$dim=array("í","Í");
	$text = str_replace($dim, "i", $text);

	$dim=array("&otilde;","ó","ô","&otilde;","Ó","Ô");
	$text = str_replace($dim, "o", $text);

	$text=strtolower($text);
	$text =str_replace(" ","",$text);
return $text;
};


if (isset($_GET['type'])):
	if($_GET['type']=='install'):
		$file=$_GET['file'];
		if(is_file($globvars['local_root'].'layouts/templates/'.$file)):
			$name=explode(".",$file);
			$filename=$_SESSION['directory'].'kernel/staticvars.php';
			include($filename);
			if ($_SESSION['type']=='shtml'):
				$file_content="
				<?PHP
				// WebPage Static Vars
				".'$'."staticvars['site_path']='".$staticvars['site_path']."';
				".'$'."staticvars['local_root']='".addslashes($staticvars['local_root'])."';
				".'$'."staticvars['site_name']='".$staticvars['site_name']."';
				".'$'."staticvars['layout']['file']='".$name[0].".php';
				";
			else:
				$file_content="
				<?PHP
				// WebPage Static Vars
				".'$'."staticvars['site_path']='".$staticvars['site_path']."';
				".'$'."staticvars['local_root']='".addslashes($staticvars['local_root'])."';
				".'$'."staticvars['site_name']='".$staticvars['site_name']."';
				".'$'."staticvars['layout']['file']='".$name[0].".php';
				".'$'."staticvars['language']['main']='".$staticvars['language']['main']."';
				".'$'."staticvars['language']['available']='".$staticvars['language']['available']."';
				";
			endif;
			$file_content.="?>";
			unlink($filename);
			$handle = fopen($filename, 'a');
			fwrite($handle, $file_content);
			fclose($handle);
			delr($globvars,$_SESSION['directory'].'layout');
			@mkdir($_SESSION['directory'].'layout', 0755, true);
			echo $globvars['local_root'].'layouts/templates/'.$name[0].'-'.$_SESSION['directory'].'layout/'.$name[0];
			if (is_dir($globvars['local_root'].'layouts/templates/'.$name[0])):
				copyr($globvars['local_root'].'layouts/templates/'.$name[0],$_SESSION['directory'].'layout/'.$name[0],$globvars);
			endif;
			build_skin($globvars,$file);
			header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));

		endif;
	endif;
endif;

if (isset($_FILES['add_template'])and $_FILES['add_template']['error']<>4)://adicionar template ao directorio via web
	include_once($globvars['local_root'].'copyfiles/advanced/general/pass_generator.php');
	$name=normalize($_FILES['add_template']['name']);
	if (check_files($temporary_directory,$name)):
		$tmp=explode(".",$name);
		$tmp[0].=generate('5','No','Yes','No');
		$extension=$tmp[1];
		$tmp1[1]=$tmp[0].'.'.$tmp[1];
		$location=$globvars['temp'].'/'.$tmp1[1];
	else:
		$location=$globvars['temp'].'/'.$name;					
		$tmp1[1]=$name;
	endif;
	if ($message==''):
		if (!move_uploaded_file($_FILES['add_template']['tmp_name'], $location)):
			$message='Upload Error. Please try again.';
		endif;
	endif;
	$dir_path = $globvars['local_root'].'/layouts/templates/';
	$zip_path = $location;
	
	if (($link = zip_open($zip_path))):
		$message=0;
		while ($zip_entry = zip_read($link)):
			if (zip_entry_open($link, $zip_entry, "r")):
				$data = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
				$dir_name = dirname(zip_entry_name($zip_entry));
				$name = zip_entry_name($zip_entry);
				$name=normalize($name);
				$error=false;
				if (check_files($upload_directory,$name)):
					$tmp=explode(".",$name);
					$tmp[0].=generate('5','No','Yes','No');
					$extension=$tmp[1];
					if (!preg_match ("# $extension #", str_replace(";"," ",$ext_allowed[0][0])) ):
						$message=$message+1;
						$error=true;
					endif;
					$tmp1[1]=$tmp[0].'.'.$tmp[1];
					$location=$globvars['local_root'].'/layouts/templates/'.$tmp1[1];
				else:
					$location=$globvars['local_root'].'/layouts/templates/'.$name;					
					$tmp1[1]=$name;
				endif;
				$tmp=explode("/",$location);
				if (!is_dir($globvars['local_root'].'/layouts/templates/'.$tmp[count($tmp)-2])):
					mkdir($globvars['local_root'].'/layouts/templates/'.$tmp[count($tmp)-2], 0755, true);
				endif;
				if (!$error):
					$stream = fopen($location, "w");
					fwrite($stream, $data);
					zip_entry_close($zip_entry);
				endif;
			else:
				$message='Error locating template file';
			endif;
		endwhile;
		if ($message<>0):
			echo 'Found '.$message.' invalid file types.';
		else:
			echo '<font class="body_text"> <font color="#FF0000">Template sucessfully installed</font></font>';		
		endif;
		zip_close($link);  
	else:
		$message = "Error unpacking file.";
	endif;
	header("Location: ".strip_address("step",strip_address("type",$_SERVER['REQUEST_URI'])));
endif;



if (isset($_GET['type'])):
	if($_GET['type']=='view'):
	$link2=strip_address("type",$_SERVER['REQUEST_URI']);
	?>
	<div align="right"><a href="<?=$link2;?>"><img border="0" title="go to previous" src="<?=$globvars['site_path'].'/images/back.png';?>" /></a></div>
    <div id="simple_content2">
      <table width="90%" id="tbl_site2" onclick="javascript:document.location.href='<?=$link2.'&type=install';?>';" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
        <tr>
          <td><img id="site_imgfam2" src="<?=$globvars['site_path'];?>/wizard/images/simple_site.gif" /></td>
          <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%"><h2>Install this template?</h2>
              <h4>Click to add this template to the website.</h4></td>
          <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck2" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
        </tr>
      </table>
    </div>
    <h3>&nbsp;</h3>
<IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="1000" src="<?=session_setup($globvars,$globvars['site_path'].'/layouts/view.php?where=skin&file='.$_GET['file']);?>" scrolling="auto"></IFRAME></td>
	<?php
	elseif($_GET['type']=='templates'):
		put_files($globvars);
	elseif($_GET['type']=='add'):
		add_template($globvars);
	else:
		options($globvars);
	endif;
else:
	options($globvars);
endif;    

function options($globvars){
$link=strip_address("type",$_SERVER['REQUEST_URI']);
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="simple_content">
    <table width="90%" id="tbl_site" onClick="javascript:document.location.href='<?=$link.'&type=add';?>';" onmouseover="try{this.style.borderColor = '#fe4518'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('site_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="site_imgfam" src="<?=$globvars['site_path'];?>/wizard/images/simple_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
      <h2>Add Layout Template</h2>
      <h4>Add a new Layout Design template to SBE database.</h4>
      </td>
        <td style="PADDING-RIGHT: 10px"><img id="site_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
    </tr>
    </table>
</div>

<br>
<div id="adv_content">
    <table width="90%" id="tbl_dynsite" onClick="javascript:document.location.href='<?=$link.'&type=templates';?>';" onmouseover="try{this.style.borderColor = 'fe4518'; document.getElementById('dynsite_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_active.gif';}catch(e){}"
    style="BORDER-RIGHT: #e3e3e3 2px solid; BORDER-TOP: #e3e3e3 2px solid; BORDER-LEFT: #e3e3e3 2px solid; CURSOR: hand; BORDER-BOTTOM: #e3e3e3 2px solid; BACKGROUND-COLOR: #ffffff" 
    onmouseout="try{this.style.borderColor = '#E3E3E3'; document.getElementById('dynsite_disabcheck').src='<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif';}catch(e){}" 
    cellspacing="5" cellpadding="0" align="center" border="0">
    <tr>
      <td><img id="dynsite_imgfam" src="<?=$globvars['site_path'];?>/wizard/images/db_site.gif" /></td>
      <td style="PADDING-RIGHT: 10px; PADDING-LEFT: 30px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px" align="left" width="100%">
              <h2>View Layout templates</h2>
              <h4>View existing SBE layout templates.</h4>
      </td>
        <td style="PADDING-RIGHT: 10px"><img id="dynsite_disabcheck" style="BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px" src="<?=$globvars['site_path'];?>/wizard/images/check_disabled.gif" align="absmiddle" /></td>
    </tr>
    </table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
};

function add_template($globvars){
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
$link=strip_address("type",$_SERVER['REQUEST_URI']);
?>
<div align="right"><a href="<?=$link;?>"><img border="0" title="go to previous" src="<?=$globvars['site_path'].'/images/back.png';?>" /></a></div><h3>Add a design layout</h3>
<form class="form" method="post" enctype="multipart/form-data" name="add_template" action="">
<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" class="body_text"><p>To add a design  template, compress in a Zip file <br />
    </p>
      </td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$globvars['site_path'];?>/images/template_example1.gif" width="294" height="66" /></td>
  </tr>
  <tr>
    <td align="left" class="body_text"><p>&nbsp;</p>
      <p>the template file along with image files and other aditional files (like CSS) on a directory with the template name</p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$globvars['site_path'];?>/images/template_example2.gif" width="315" height="123" /></td>
  </tr>
  <tr>
    <td align="left" class="body_text">
      <p>&nbsp;</p>
      <p>don't also forget to include on that directory a preview image named  preview.jpg</p></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  <tr>
    <td class="body_text"><strong>Template to add (ZIP)</strong> </td>
  </tr>
  <tr>
    <td><label>
      <input type="file" class="text" name="add_template" accesskey="1" size="50" />
    </label></td>
  </tr>
  <tr>
    <td height="15" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><input name="add_template" type="submit" class="button" value="Add Template" /></td>
  </tr>
</table>

</form>
<?php
};



function add_field($globvars){
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
if (isset($_GET['file'])):
	$fil=@$_GET['file'];
endif;
?>
<br />
<br />
<br />
<br />
<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="disp" maxlength="255"  value="<?=$fil;?>" size="40" disabled="disabled"><br />
			<input type="hidden" name="add_skin_name" value="<?=$fil;?>"  ></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/'.$lang;?>/adicionar.gif"></td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="10" colspan="2">
		<?php
		put_files($globvars);
		?>		</td>
	  </tr>
	  </table>
	  </form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top" align="center">&nbsp;</td>
    <td valign="top" align="center">&nbsp;</td>
    <td valign="top" align="center">&nbsp;</td>
  </tr>
</table>
<?php
};

function put_files($globvars){
$task=@$_GET['id'];
$link=strip_address("type",$_SERVER['REQUEST_URI']);
echo '<div align="right"><a href="'.$link.'"><img border="0" title="go to previous" src="'.$globvars['site_path'].'/images/back.png" /></a></div><h3>Existing templates</h3>Select one to view details<br /><br />';
$dir_files = array_merge(glob($globvars['local_root']."layouts/templates/*.htm"),glob($globvars['local_root']."layouts/templates/*.html"),glob($globvars['local_root']."layouts/templates/*.php")) ;
$j=1;
if ($dir_files[count($dir_files)-1]==''):
	$nums=count($dir_files)-1;
else:
	$nums=count($dir_files);
endif;
echo '<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">'.chr(13).'<tr>';
for($i=0; $i < $nums; $i++):
	$fl=explode("/",$dir_files[$i]);
	$name=explode(".",$fl[count($fl)-1]);
	$location=explode(".",$fl[count($fl)-1]);
	if(!is_file($globvars['local_root'].'layouts/templates/'.$location[0].'/preview.jpg')):
		$location=$globvars['site_path'].'/images/no_preview.jpg';
	else:
		$location=$globvars['site_path'].'/layouts/templates/'.$location[0].'/preview.jpg';	
	endif;
	$sr= '';
	$sr .= '<br><font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id='.@$_GET['id'].'&type=view&step=2&file='.$fl[count($fl)-1]).'" target="_self">view</a>]&nbsp;&nbsp;[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?id='.@$_GET['id'].'&step=2&type=skin&file='.$fl[count($fl)-1]).'" target="_self">Edit</a>]<br>'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;".chr(13);
	echo '<td width="190" align="center" valign="bottom"><img src="'.$location.'" border="1">'.$sr.'<br><br></td>';
	$j++;
	if ($j>3):
		$j=1;
		echo '</tr>'.chr(13).'<tr>';
	endif;
endfor;
if ($j<4):
	for ($i=$j;$i<4;$i++):
		echo '<td valign="top" align="center"></td>';
	endfor;
endif;
echo '</table><br><br>';

};
?>