<?php
// save contents to proper file
if ( isset( $_POST['save'] ) and isset($_GET['file']) and isset($_GET['type']) ):
	$code=stripslashes($_POST['elm1']);
	$code=str_replace($globvars['site_path']."/layout/templates/","",$code);
	if (isset($code)):
		$file=$_GET['file'];
		if ($_GET['type']=='box_fx'):
			$filename=$globvars['local_root']."/layout/box_effects/fx/".$file;
		elseif ($_GET['type']=='skin'):
			$filename=$globvars['local_root']."layout/templates/".$file;
		elseif ($_GET['type']=='css'):
			$filename=$globvars['local_root']."layout/css/".$file;
		elseif ($_GET['type']=='iwfs'):
			$filename=$staticvars['local_root']."modules/iwfs/webpages/".$file;
		elseif ($_GET['type']=='advertising'):
			$filename=$staticvars['local_root']."modules/advertising/formats/".$file;
		endif;
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
		else:
			echo "<font class='style6' color='#FF0000'>File Saved! (".$filename.")</font>";
		endif;
		fclose($handle);	
	endif;
endif;

//load contents to be displayed
if (isset($_GET['file']) and isset($_GET['type'])):
	$file=$_GET['file'];
	if ($_GET['type']=='box_fx'):
		$code=file_get_contents($globvars['local_root']."/layout/box_effects/fx/".$file);
	elseif ($_GET['type']=='skin'):
		$code=file_get_contents($globvars['local_root']."layout/templates/".$file);
		$code=str_replace("url(","url(".$globvars['site_path']."/layout/templates/",$code);
		$code=str_replace('src="','src="'.$globvars['site_path'].'/layout/templates/',$code);
		
		if (strpos("-".$code,"<link")):
			$filename=explode(".",$file);
			$dirname=$filename[0];
			$init=strpos($code,"<link");
			$final=strpos($code,"/>",$init);
	
			$filename=substr($code,$init,$final-$init);

			$filename=explode("href",$filename);
			$filename=explode('"',$filename[1]);
			$filename=explode("/",$filename[1]);
			$file=$filename[count($filename)-1];
			$code = substr_replace($code,'<link rel="stylesheet" type="text/css" href="'.$globvars['site_path'].'/tmp/'.$file.'"'.chr(13),$init,$final-$init);
			
			$file_content=file_get_contents($globvars['local_root']."layout/templates/".$dirname."/".$file);
			$file_content=str_replace("background-image: url('".$dirname."/","background-image: url('".$globvars['site_path']."/layout/templates/".$dirname."/",$file_content);
			$file_content=str_replace($dirname.'/',$globvars['site_path'].'/layout/templates/'.$dirname.'/',$file_content);
			$filename=$globvars['local_root'].'tmp/'.$file;
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
	elseif ($_GET['type']=='css'):
		$code=file_get_contents($globvars['local_root']."layout/css/".$file);
	elseif ($_GET['type']=='iwfs'):
		$code=file_get_contents($staticvars['local_root']."modules/iwfs/webpages/".$file);
	elseif ($_GET['type']=='advertising'):
		$code=file_get_contents($staticvars['local_root']."modules/advertising/formats/".$file);
	endif;
else:
	$code='';
endif;
?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?=$globvars['site_path'];?>/editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "<?=$globvars['site_path'];?>/editor/lists/template_list.js",
		external_link_list_url : "<?=$globvars['site_path'];?>/editor/lists/link_list.js",
		external_image_list_url : "<?=$globvars['site_path'];?>/editor/lists/image_list.js",
		media_external_list_url : "<?=$globvars['site_path'];?>/editor/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

</script>
<!-- /TinyMCE -->


<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
	<textarea id="elm1" name="elm1" rows="40" cols="80" style="width: 100%;height: 100%;"><?=$code;?></textarea>

	<div>
		<!-- Some integration calls -->
		<a href="javascript:;" onmousedown="tinyMCE.get('elm1').show();">[Show]</a>
		<a href="javascript:;" onmousedown="tinyMCE.get('elm1').hide();">[Hide]</a>
		<a href="javascript:;" onmousedown="tinyMCE.get('elm1').execCommand('Bold');">[Bold]</a>
		<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').getContent());">[Get contents]</a>
		<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').selection.getContent());">[Get selected HTML]</a>
		<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').selection.getContent({format : 'text'}));">[Get selected text]</a>
		<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').selection.getNode().nodeName);">[Get selected element]</a>
		<a href="javascript:;" onmousedown="tinyMCE.execCommand('mceInsertContent',false,'<b>Hello world!!</b>');">[Insert HTML]</a>
		<a href="javascript:;" onmousedown="tinyMCE.execCommand('mceReplaceContent',false,'<b>{$selection}</b>');">[Replace selection]</a>
	</div>

	<br />
	<input type="submit" name="save" value="Submit" />
	<input type="reset" name="reset" value="Reset" />
</form>
