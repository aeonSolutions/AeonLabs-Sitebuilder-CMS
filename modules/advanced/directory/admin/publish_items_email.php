<?php
if(!isset($_POST['users_email'])):
	// navigate to main
	$_SESSION['erro']='Error (Publish) - Unauthorized file acess!';
	$link=session($staticvars,'index.php?id=error');
	?>
	<script language="javascript">
		parent.location="<?=$link;?>"
	</script>
	<?
	exit;
endif;
$user_name=$db->getquery("select cod_user, email,nick from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
$item_details=$db->getquery("select data from items where cod_item='".mysql_escape_string($_POST['code'])."'");
?>
<style>
.sobre_nos {
	FONT-SIZE: 11px;
	COLOR: #666666;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
.about_links {
	COLOR: #0056af;
	TEXT-DECORATION: none
}
</style>
<table  border="0" class="newtable" width="100%" cellspacing="0" cellpadding="5">
      <tr>
        <td height="30"></td>
      </tr>
      <tr>
		<td valign="top"><p align="justify" class="sobre_nos"><span class="sobre_nos">
		Enviar mail ao utilizador:&nbsp; <?=$user_name[0][2];?><br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?='[ '.$user_name[0][1].' ]';?><br>
		<?=$type_o;?>, colocado em <?=$item_details[0][0];?>
        </span></p>
	    </td>
  </tr>
		<tr>
		<td>
            <form method="POST" action="<?=session($staticvars,'index.php?id='.$task.'&type='.$type);?>">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
				  <tr>
				    <td colspan="2" class="sobre_nos" height="10"></td>
			      </tr>
				  <tr>
					<td width="150" class="sobre_nos">
					  <div align="right"></div></td>
					<td width="77%" class="sobre_nos">
					<input class="textfield" type="hidden" name="send_email" value="<?=$user_name[0][1];?>">
					<input class="textfield" type="hidden" name="cod_user" value="<?=$user_name[0][0];?>">
					</td>
				  </tr>
				  <tr>
                    <td colspan="2" class="sobre_nos" height="10"></td>
			      </tr>
				  <tr>
					<td width="150" class="sobre_nos">
					  <div align="right">Mensagem</div></td>
					<td width="77%" class="sobre_nos">
					<textarea class="textfield" rows="13" name="assunto" cols="50"></textarea>
					<br>
					<br>
					<div align="right"><input value="Reset" class="form_submit" id="reset1" name="reset" type="reset">
					&nbsp;&nbsp;<INPUT name="back" type="submit" value="Voltar" class="form_submit">
					&nbsp;&nbsp;<INPUT name="send_maile" type="submit" value="Enviar" class="form_submit"></div>
					</td>
				  </tr>
				</table>
				<p>&nbsp;</p>
         </form>
		</td>
      </tr>
      </table>
