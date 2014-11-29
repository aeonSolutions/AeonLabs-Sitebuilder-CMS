<?php 
/*
File revision date: 1-Set-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if (isset($_POST['backup'])):
	include($local_root.'modules/admin_panel/database/db_backup.php');
	unset($_POST['backup']);
	echo '<font class="body_text"> <font color="#FF0000">Backup efectuado com sucesso</font></font><br>';
endif;
?>
<br />
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>C&oacute;pia de seguran&ccedil;a da Base de Dados</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD width="36" vAlign=top><img src="<?=$globvars['site_path'].'/modules/admin_panel/images/odbc.jpg';?>" /><BR></TD>
      <TD vAlign=top><p>A c&oacute;pia de seguran&ccedil;a da base de dados consiste num ficheiro de recupera&ccedil;&atilde;o que &eacute; gravado numa pasta pr&oacute;pria para na eventualidade poder recuperar r&aacute;pidamente os dados.<br />
        Deve efectuar regularmente c&oacute;pias de seguran&ccedil;a da sua base de dados. </p>
      <p>Para dar inicio &agrave; c&oacute;pia de seguran&ccedil;a carregue no bot&atilde;o &quot;<em>Efectuar C&oacute;pia</em>&quot;.</p>
      <p>&nbsp;</p></TD>
    </TR>
  </TBODY>
</TABLE>
<br />
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td height="5" colspan="3" valign="bottom">
				<form method="post" enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI'];?>">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="center">
					<input type="hidden" name="backup" value="do backup">
					<input type="submit" value=" Efectuar Cópia " class="form_submit">
					</td>
				  </tr>
				</table>
				</form>
			</td>
		  </tr>
		  <tr>
		    <td height="300" colspan="3" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="3">&nbsp;</td>
  </tr>
</table>

