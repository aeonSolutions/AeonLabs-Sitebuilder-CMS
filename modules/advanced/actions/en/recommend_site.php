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
	<h3>Recommend: Members</h3><br>
    
    <table border="0" cellpadding="3" width="100%">
	  <tbody><tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/recommend.gif" border="0"></td>
		<td valign="top"><p>
			Please do complete this form to send a recommendation by email. Thank you for your interest in our website!
		</p></td>
	</tr>
	</tbody></table>
<?php
else:

?>
	<h3>Recommend: Members</h3><br>
    
    <table border="0" cellpadding="3" width="100%">
	  <tbody><tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/recommend.gif" border="0"></td>
		<td valign="top"><p>
			Please do complete this form to send a recommendation by email. Thank you for your interest in our website!
		</p></td>
	</tr>
	</tbody></table>
    <br>
	
	<div class="bxthdr">Recommendation Form</div>
    <p>Mandatory fields are marked with an asterisk (<font color="#ff0000">*</font>)</p>
			
<form method="post" action="<?=session($staticvars,'index.php?id='.$task);?>">
	
	
	<table border="0" cellpadding="5" cellspacing="0">
	<tbody><tr>
		<td><p>
			Your Name: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="sendername" size="22" value="" class="form_input" type="text"><br></p>
		</td>
		<td><p>
			Your Email: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="senderemail" size="22" value="" class="form_input" type="text"><br></p>
		</td>
	</tr>
	<tr>
		<td><p>
			Receiver Name: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="receivername" size="22" value="" class="form_input" type="text"><br></p>
		</td>
		<td><p>
			Receiver Email: <font color="#ff0000">*</font><br>
			<input style="width: 210px;" name="receiveremail" size="22" value="" class="form_input" type="text"><br></p>
		</td>
	</tr>
	</tbody></table>
		<br>
	Your personal message:<br>
	<textarea rows="12" style="width: 440px;" name="message" cols="44" class="form_input"></textarea><br>
	<br>
	<input name="COPY" value="ON" checked="checked" type="checkbox">&nbsp;I like to receive a copy of my recommendation...<br>
	<br>
	<input value="Send" class="form_submit" id="submit1" name="send" type="submit">&nbsp; <input value="Reset" class="form_submit" id="reset1" name="reset" type="reset"><br>
	<br>
        Please do allow a few seconds to process your request after 
        sending the form...
</form>

<?php
endif;
?>

