<?
require_once($globvars['local_root']."filemanager/logiclevel/init.php");
require_once($globvars['local_root']."filemanager/logiclevel/copiedfilespreview_ll.php");
?>
<fieldset>
    <legend align="left">Copied Files</legend>
	<div id="copiedfilesdiv" class="copiedfilesdiv">
	<?
		if(count($files_to_copy) > 0)
			for($i=0; $i < count($files_to_copy); ++$i) {
				if(!empty($files_to_copy[$i]))
					echo '<div class="fileName"><label>'.$files_to_copy[$i].'<label></div>';
				else echo '<div class="fileName">No selected files!</div>';
			}
		else
			echo '<div class="fileName">No selected files!</div>';
	?>
	</div>
</fieldset>
