<?php
// to load the contents into the editor please load into $code variable before this script
?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		
		mode : "textareas",
		theme : "advanced",
		plugins : "images,youtube,google_translations,ibrowser,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options - styles add styleselect
		theme_advanced_buttons1 : "fullscreen,|,newdocument,|,bold,italic,underline,strikethrough,|, ibrowser,|,google_translations, youtube,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,iespell,advhr,|,ltr,rtl",
		theme_advanced_buttons2 : "print,cut,copy,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,|,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,|,cleanup,code",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		<?php
		include($staticvars['local_root'].'kernel/settings/layout.php');
		if ($layout<>'static'):
			$skin=$db->getquery("select ficheiro from skin where active='s'");
			$skin=explode(".",$skin[0][0]);
			$skin=$skin[0];
			$css=glob($staticvars['local_root'].'layout/templates/'.$skin.'/*.css');
			$css=explode("/",$css[0]);
			$css=$css[count($css)-1];
			?>
			//content_css : "<?=$staticvars['site_path'].'/layout/templates/'.$skin.'/'.$css;?>",
		<?php
		endif;
		?>

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "<?=$staticvars['site_path'];?>/editor/lists/template_list.js",
		external_link_list_url : "<?=$staticvars['site_path'];?>/editor/lists/link_list.js",
		external_image_list_url : "<?=$staticvars['site_path'];?>/editor/lists/image_list.js",
		media_external_list_url : "<?=$staticvars['site_path'];?>/editor/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

</script>
<!-- /TinyMCE -->


<form class="form" action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
    <input type="hidden" id="sLang" value="en">
    <input type="hidden" id="dLang" value="pt">
   	<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
	<textarea name="elm1" style="width:98%;" rows="30" id="elm1" ><?=$code;?></textarea>

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
	<input class="button" type="submit" name="save" value="Gravar Alterações" />
	<input class="button" type="reset" name="reset" value="Apagar tudo" />
</form>
