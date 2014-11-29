<?php
function put_preview_admin($staticvars['local_root'],$message,$subject,$option){
	include_once($staticvars['local_root'].'modules/news/system/bbcode.php');
	$txt=load_txt_admin($staticvars['local_root'],$message);
	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><font class="header_text_1"><?=$subject;?></font></td>
	  </tr>
	  <tr>
		<td>
		<?php
			$oldlocale = setlocale(LC_TIME, NULL); #save current locale
			setlocale(LC_TIME, 'pt_PT');
			echo '<font class="body_text">'.date ("l dS of F Y @ G:i").'</font>';
			setlocale(LC_TIME, $oldlocale);
		?>		</td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td><hr size="1"><br><?=$txt;?><br><hr size="1"></td>
	  </tr>
	</table>	
	<?php
};

?>