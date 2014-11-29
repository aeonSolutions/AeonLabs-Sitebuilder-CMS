<?php
/*
File revision date: 23-Ago-2006
*/
$search=return_id('directory_search.php');
?>
	<form method="POST" action="<?=session($staticvars,$staticvars['site_path'].'/index.php?id='.$search);?>">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td align="center" ><font class="body_text">&nbsp;</font></td>
		  </tr>
		  <tr align="center">
			<td >
			<INPUT class="searchbt" type="textfield" name="busca">
			</td>
		  </tr>
		  <tr>
			<td height="5"></td>
		  </tr>
		  <tr>
			<td align="center">
				  <INPUT name="pesquisar" type=image src="images/buttons/pt/pesquisar.gif">
			</td>
		  </tr>
		</table>
	</form>
