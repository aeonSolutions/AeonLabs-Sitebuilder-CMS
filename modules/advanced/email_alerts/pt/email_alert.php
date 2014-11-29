<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
include('kernel/staticvars.php');
$task=@$_GET['id'];
$messagem='';
if (isset($_POST['posted'])):
	$qw=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
	$cod_user=$qw[0][0];
	$db->setquery("delete from alerts_users where cod_user='".$cod_user."'");
	$alerts=$db->getquery("select cod_alerts from alerts");
	for ($i=0;$i<count($alerts);$i++):
		$code='cod_alert_'.$alerts[$i][0];
		if (isset($_POST[$code])):
			$db->setquery("insert into alerts_users set cod_alerts='".$alerts[$i][0]."', cod_user='".$cod_user."'");
		endif;
	endfor;
	$_SESSION['update']='Os seus avisos foram criados com sucesso.';
	$address=strip_address($staticvars['local_root'],"update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);
endif;
?>
<style>
	div.bxthdr    {
		font : 11px Verdana,Arial,Helvetica,sans-serif;
		color : #ffffff;
		background-color : #6A94CC;
		border-bottom: 0px solid #10438F;
		padding: 3px 3px 3px 5px;
		height: 20px;
		}
</style>
  
  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
	<TBODY>
	<TR>
	  <TD colspan="2" vAlign=top class="header-bk"><H3>Avisos</H3></TD>
	  </TR>
	<TR>
	  <TD vAlign=top><BR>
		<img src="<?=$staticvars['site_path'];?>/modules/email_alerts/images/alert.gif" alt="" width="34" height="34">          <BR></TD>
	  <TD vAlign=top>
		<P><BR>
		O servi&ccedil;o de avisos disponibiliza a informa&ccedil;&atilde;o que precisa - e apenas essa . &Eacute;s tu quem decide o que recebe. As newsletters simples s&atilde;o coisa do passado.<BR>
		</P></TD></TR></TBODY></TABLE>
  <BR>
  <DIV class=bxthdr>&nbsp;Avisos: N&atilde;o &eacute; uma simples Newsletter ...</DIV>
  <font class="body_text"><font color="#FF0000"><?=$message;?></font></font>
	  		<form enctype="multipart/form-data" action="<?=session($staticvars,'index.php?id='.$task);?>" method="post">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="20">&nbsp;</td>
				  <td><div align="right"><font class="form_title">Os campos marcados com <font size="1" color="#FF0000">&#8226;</font> s&atilde;o obrigatórios</font></div></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="5">
				  <td width="20"></td>
				  <td></td>
				  <td width="20"></td>
				</tr>			
				<tr>
				  <td width="20">&nbsp;</td>
				  <td><HR noShade SIZE=1></td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="5">
				  <td width="20"></td>
				  <td></td>
				  <td width="20"></td>
				</tr>			
				<tr height="15">
				  <td width="20">&nbsp;</td>
				  <td align="left" class="header_text_1">&nbsp;</td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="15">
				  <td width="20">&nbsp;</td>
				  <td align="left" class="body_text">
				  <?php
				  	$alerts=$db->getquery("select cod_alerts, titulo, descricao from alerts");
					$qw=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
					$cod_user=$qw[0][0];
					if ($alerts[0][0]<>''):
						  for ($i=0;$i<count($alerts);$i++):
							$alerts_user=$db->getquery("select cod_alerts_users from alerts_users where cod_alerts='".$alerts[$i][0]."' and cod_user='".$cod_user."'");
							?>
							<input type="checkbox" <?php if (@$alerts_user[0][0]<>''){?>checked="checked"<?php } ?>  name="cod_alert_<?=$alerts[$i][0];?>" />
							<font class="header_text_1">&nbsp;<?=$alerts[$i][1];?></font>
							<br /><font class="body_text"><?=$alerts[$i][2];?></font><br /><br />
							<?php
						  endfor;
						else:
						echo 'De momento n&atilde;o pode criar os seus avisos personalizados. Por favor, tente mais tarde. Obrigado.';
					endif;
				  ?>
				  </td>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="15">
				  <td width="20">&nbsp;</td>
				  <td></td>
				  <td width="20">&nbsp;</td>
				</tr>				<tr>
				  <td width="20">&nbsp;</td>
				  <td align="right">
				  <?php
				  if ($alerts[0][1]<>''):
					  ?>
					  <input type="hidden" name="posted" value="0" />
					  <input class="form_submit" type="submit" name="add_user" value="Gravar Dados"></td>
				  <?php
				  endif;
				  ?>
				  <td width="20">&nbsp;</td>
				</tr>			
				<tr height="15">
				  <td width="20">&nbsp;</td>
				  <td></td>
				  <td width="20">&nbsp;</td>
				</tr>			
			</table>
		</form>





