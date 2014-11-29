<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!isset($local_root)):
	echo 'Error: Security Not Found(db optimize)';
	exit;
endif;
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found(db optimize)';
	exit;
endif;
include($local_root.'general/staticvars.php'); 
?>
<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
  <TBODY>
  <TR>
    <TD>
      <DIV class="main-box">
      	<DIV class="main-box-title">Optimiza&ccedil;&atilde;o da Base de Dados</DIV>
		<DIV class="main-box-data">
			<TABLE width="100%" height="400" border="0" cellPadding="0" cellSpacing="0">
			  <tr>
			    <td align="center">
				  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td><div align="center"><img src="<?php echo $site_path.'/images/menus.gif'; ?>" border="0" ></div></td>
					</tr>
					<tr>
					  <td><div align="center">Optimiza&ccedil;&atilde;o da Base de Dados </div></td>
					</tr>
				  </table>
				</td>
			  </tr>
			  <tr>
				<td height="100" colspan="3" valign="bottom"><div align="center"></div></td>
			  </tr>
		  <tr>
		    <td height="5" colspan="3" valign="bottom" align="center">
			<?php
				if (isset($_POST['backup'])):
					?>
					<table width="70%"  border="0" cellspacing="0" cellpadding="0" align="center">
					<tr><td>
					<?
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
						echo '<img src="images/check_mark.gif"><br>';
					endfor;
					mysql_close($link);
					echo '<font class="body_text">Base de dados optimizada com sucesso!</font>';
					?>
					</td></tr>
					</table>
					<?php
				else:
			?>
					<form method="post" enctype="multipart/form-data" action="<?=session_setup($globvars,'index.php?id='.$task);?>">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td align="center">
						<input type="hidden" name="backup" value="do backup">
						<input type="image" src="<?=$site_path;?>/images/buttons/pt/iniciar.gif">
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
		</DIV>
	  </DIV>
      </TD>
    </TR>
	</TBODY>
</TABLE>


