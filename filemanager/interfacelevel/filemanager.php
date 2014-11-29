<?
?>

<script type="text/javascript">
	function insertURL(url) {
		return null;
	}
</script>

<iframe height="700" width="150" id="dirlist" name="dirlist" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/dirlist.php?<? echo $_SERVER['QUERY_STRING'];?>" frameborder="1px" scrolling="auto" marginwidth="0" marginheight="0" /></iframe>
<iframe height="700" width="500" id="filelistmanager" name="filelistmanager" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/filelistmanager.php?<? echo $_SERVER['QUERY_STRING'];?>" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" framecols="*" /></iframe>
<iframe height="700" width="270" id="preview" name="preview" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/preview.php?<? echo $_SERVER['QUERY_STRING'];?>" frameborder="1px" scrolling="auto" marginwidth="0" marginheight="0"  /></iframe>



