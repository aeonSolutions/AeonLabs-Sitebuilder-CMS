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
    <P class="body_text"><A class="header_text_1" href="<?=session($staticvars,'index.php?id='.$publish);?>">Participa</A><BR>
	vara os teus programas, relatórios, documentos no <?=$site_name;?>... <BR>
	<BR>
	<A class="header_text_1" href="<?=session($staticvars,'index.php?id='.$linkit);?>">Coloca um Link!</A>
	<BR>
	Gostas do nosso site? Cria um link na tua página pessoal... <BR>
	<BR>
	<A class="header_text_1" href="<?=session($staticvars,'index.php?id='.$contact);?>">Contacto </A><BR>
	Queres colocar alguma questão? Clica aqui... <BR>
	<BR>
	</P></TD>
  </TR>
</TABLE>
