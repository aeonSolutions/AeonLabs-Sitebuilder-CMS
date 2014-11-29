<?php 
include_once('kernel/staticvars.php');
//////include_once('general/return_module_id.php');
$contact=return_id('c_main.php');
$linkit=return_id('referral_links.php');
$publish=return_id('ds_add_item.php');
?>

<TABLE cellSpacing=1 cellPadding=10 border=0>
  <TR>
    <TD align=left width="100%">
    <P class="body_text"><A class="header_text_1" href="<?=session($staticvars,'index.php?id='.$publish);?>">Submit</A><BR>
	Publish your programs, reports, documents and more on <?=$site_name;?>... <BR>
	<BR><A class="header_text_1" href="<?=session($staticvars,'index.php?id='.$linkit);?>">Link to us!</A>
	<BR>You like what we offer? Create a link on your website... <BR>
	<BR>
	<A class="header_text_1" href="<?=session($staticvars,'index.php?id='.$contact);?>">Contact </A><BR>Any Questions? You are welcome... <BR><BR>
	</P></TD>
  </TR>
</TABLE>
