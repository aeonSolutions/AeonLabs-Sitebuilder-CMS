<?
require_once($globvars['local_root']."filemanager/logiclevel/init.php");

require_once($globvars['local_root']."filemanager/logiclevel/preview_ll.php");

if($file_type == "file") {
?><fieldset>

    <legend align="left">File information</legend>
	<div style="float: left; margin: 2px; width: 45%; overflow: hidden;">
		<div class="previewSubTitle">Filename:</div>
		<div class="previewText"><a href="<? echo $path;?>" class="downloadLink" target="_blank"><? echo $show_file_name;?></a>&nbsp;</div>
		<div class="previewSubTitle">File size:</div>
		<div class="previewText"><? echo $file_size;?>&nbsp;</div>

		<div class="previewSubTitle">File description:</div>
		<div class="previewText"><? echo strtoupper($file_type." ".$file_extension);?>&nbsp;</div>
	</div>

	<div style="float: right; margin: 2px; width: 45%;">
		<div class="previewSubTitle">Creationdate:</div>
		<div class="previewText"><? echo $creation_date;?>&nbsp;</div>

		<div class="previewSubTitle">Modificationdate:</div>
		<div class="previewText"><? echo $last_modify_date;?>&nbsp;</div>
		<div class="previewSubTitle">Access:</div>
		<div class="previewText"><? echo $file_perms_letters;?>&nbsp;</div>
	</div>

	<br style="clear: both" />

</fieldset>

<div style="float: left">
	<input type="button" id="view" name="view" value="View" onclick="window.open('readfile.php?path=<? echo $path;?>','previewWin');" class="button" <? if(!$CONFIG['file_download_permission']) echo "disabled";?> />
</div>
<div style="float: right">
	<input type="button" id="select" name="select" value="Select" onclick="parent.insertURL('<? echo $path;?>');" class="button" />
</div>
<br style="clear: both"/>
<script>
	var selectButton = document.getElementById('select');
	if(selectButton)
		selectButton.disabled = parent.fieldFileObj ? false : true;
</script>

<?  if($is_image) { ?>
<fieldset class="previewFieldSet">
    <legend align="left">Preview</legend>
	<iframe id="previewIframe" name="previewIframe" unselectable="true" atomicselection="true" src="readfile.php?path=<? echo $path;?>" width="100%" height="200" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" frameborder="0" border="0"></iframe>
</fieldset>
<? } 
}
elseif($file_type == "dir") {
?>
<fieldset>

    <legend align="left">Directory information</legend>
	<div style="margin: 2px; width: 100%; overflow: hidden;">
		<div class="previewSubTitle">Directory:</div>
		<div class="previewText"><? echo $show_file_name;?>&nbsp;</div>
	</div>
	<div style="float: left; margin: 2px; width: 45%;">
		<div class="previewSubTitle">Subdirectories:</div>

		<div class="previewText"><? echo $num_sub_dirs;?>&nbsp;</div>
		<div class="previewSubTitle">Files:</div>
		<div class="previewText"><? echo $num_sub_files;?>&nbsp;</div>
		<div class="previewSubTitle">Total file size:</div>
		<div class="previewText">>= <? echo $dir_size;?>&nbsp;</div>
	</div>

	<div style="float: right; margin: 2px; width: 45%;">
		<div class="previewSubTitle">Creationdate:</div>
		<div class="previewText"><? echo $creation_date;?>&nbsp;</div>
		<div class="previewSubTitle">Modificationdate:</div>
		<div class="previewText"><? echo $last_modify_date;?>&nbsp;</div>
		<div class="previewSubTitle">Access:</div>
		<div class="previewText"><? echo $file_perms_letters;?>&nbsp;</div>
	</div>
	<br style="clear: both" />
</fieldset>
<? }?>
