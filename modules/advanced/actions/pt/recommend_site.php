<style>
	div.bxthdr    {
		font : 11px Verdana,Arial,Helvetica,sans-serif;
		color : #ffffff;
		background-color : #6A94CC;
		border-bottom: 0px solid #10438F;
		padding: 3px 3px 3px 5px;
		height: 20px;
		}
	H3 {
		font : bold 17px Verdana, Arial, Helvetica, sans-serif;
		margin : 0px 0px 0px 0px;
		color: #222222;
	}
</style>
<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
if (isset($_GET['id'])):
	$task=$_GET['id'];
endif;
if (isset($_POST['send']) and isset($_POST['senderemail'])):
	include($staticvars['local_root'].'modules/actions/'.$lang.'/send_mail.php');
?>
	<h3>Recomenda&ccedil;&atilde;o do site </h3>
	<br>
    
    <table border="0" cellpadding="3" width="100%">
	  <tbody><tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/recommend.gif" border="0"></td>
		<td valign="top"><p>
			A tua recomenda&ccedil;&atilde;o foi enviada. </p></td>
	</tr>
	</tbody></table>
<?php
else:

?>
	<h3>Recomenda&ccedil;&atilde;o do site </h3>
	<br>
    
    <table border="0" cellpadding="3" width="100%">
	  <tbody><tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/recommend.gif" border="0"></td>
		<td valign="top"><p>
			Para recomendares  a um amigo, preenche os campos obrigat&oacute;rios do formul&aacute;rio abaixo. Obrigado pelo teu interesse!</p></td>
	</tr>
	</tbody></table>
    <br>
	
	<div class="bxthdr">Formul&aacute;rio de recomenda&ccedil;&atilde;o do site </div>
    <p>Os campos obrigat&oacute;rios est&atilde;o marcados com um asterisco  (<font color="#ff0000">*</font>)</p>
			
    <form method="post" action="<?=session($staticvars,'index.php?id='.$task);?>">
	
	
	<table border="0" cellpadding="5" cellspacing="0">
	<tbody><tr>
		<td><p>
			O teu nome: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="sendername" size="22" value="" class="form_input" type="text"><br></p>
		</td>
		<td><p>
			O teu Email: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="senderemail" size="22" value="" class="form_input" type="text"><br></p>
		</td>
	</tr>
	<tr>
		<td><p>
			O nome do destinat&aacute;rio: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="receivername" size="22" value="" class="form_input" type="text"><br></p>
		</td>
		<td><p>
			O Email do destinat&aacute;rio: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="receiveremail" size="22" value="" class="form_input" type="text"><br></p>
		</td>
	</tr>
	</tbody></table>
		<br>
		A tua mensagem pessoal
		:<br>
	<textarea rows="12" style="width: 440px;" name="message" cols="44"></textarea><br>
	<br>
	<input name="COPY" value="ON" checked="checked" type="checkbox">
	&nbsp;Gostava de receber uma c&oacute;pia do E-mail enviado ...<br>
	<br>
	<input value="Enviar" class="form_submit" id="submit1" name="send" type="submit">
	&nbsp; <input value="Reset" class="form_submit" id="reset1" name="reset" type="reset"><br>
	<br>
        Ap&oacute;s o envio,  aguarda um momento para processarmos o teu pedido...Obrigado.
    </form>

<?php
endif;
?>

