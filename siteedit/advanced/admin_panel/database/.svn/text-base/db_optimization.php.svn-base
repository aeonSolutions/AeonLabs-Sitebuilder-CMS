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
?>
<br />
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Optimiza&ccedil;&atilde;o da Base de Dados</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD width="36" vAlign=top><img src="<?=$globvars['site_path'].'/modules/admin_panel/images/odbc.jpg';?>" /><BR></TD>
      <TD vAlign=top><p>Deve ser efectuada a optimiza&ccedil;&atilde;o da base de dados com alguma regularidade de modo a que a sua pagina web carregue os conte&uacute;dos mais r&aacute;pidamente.</p>
      <p>Para dar inicio &agrave; optimiza&ccedil;&atilde;o carregue no bot&atilde;o optimizar.</p>
      <p>&nbsp;</p></TD>
    </TR>
  </TBODY>
</TABLE>
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td valign="bottom" align="center">
	<?php
		if (isset($_POST['backup'])):
			unset($_POST['backup']);
			@session_start();
			$link=mysql_connect($db->host,$db->user,$db->password);
			@mysql_select_db($db->name) or die("Unable to select database.");
			$result = mysql_list_tables($db->name);
			if (!$result):
				echo "Unable to list the  tables!";
				echo 'MySQL Error: ' . mysql_error();
				exit;
			endif;
			$i=0;
			while ($row = mysql_fetch_row($result)):
				$table_name[$i]=$row[0];
				$i++;
			endwhile;
			for($i=0; $i<count($table_name); $i++):
				echo '<font class="body_text">A optimizar a tabela '.$table_name[$i].'... </font>';
				mysql_query("optimize table '".$table_name[$i]."'");
				echo '<img src="modules/admin_panel/images/check_mark.gif"><br>';
			endfor;
			mysql_close($link);
			echo '<font class="body_text">Base de dados optimizada com sucesso!</font>';
		else:
	?>
			<form method="post" enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI'];?>">
			<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td align="center">
				<input type="hidden" name="backup" value="do backup">
				<input type="submit" class="form_submit" value="Optimizar">
				</td>
			  </tr>
			</table>
			</form>
		<?php
		endif;
		?>
	</td>
  </tr>
</table>

