<?php
/*
File revision date: 22-nov-2008
*/
if ( !defined('ON_SiTe')):
	echo 'not for direct access';
	exit;
endif;
$conta=$db->getquery("select morada1, morada2, empresa, apelidos, nome, cidade, pais, telefone, telemovel,active, cod_postal from shopping_conta where cod_user='".$staticvars['users']['code']."'");
$user=$db->getquery("select nome, email where cod_user='".$staticvars['users']['code']."'");
$c_cliente=return_id("conta_cliente.php");
$addr=return_id("add_address.php");
include($staticvars['local_root'].'modules/shopping/system/settings.php');
if(isset($_POST['order_details'])):
	$tp=mysql_escape_string($_POST['payment_method_id']);
	$notas=mysql_escape_string($_POST['nota']);
	$sid=session_id();
	$prod=$db->getquery("select cod_produto, qtd, preco, iva, ref_prod, nome from shopping_orders where sid='".session_id()."'");
	$total=0;
	for($i=0;$i<count($prod);$i++):
		$total=$total+$prod[$i][2]*$prod[$i][1];
	endfor;
	$db->setquery("insert into shopping_encomendas set cod_user='".$staticvars['users']['code']."', total='".$total."', sid='".$sid."', tipo_pagamento='".$tp."', notas='".$notas."', estado='p'");
	$enc=$db->getquery("select cod_encomenda from shopping_encomendas where sid='".$sid."'");
	$db->setquery("update shopping_orders set cod_encomenda='".$enc[0][0]."' where sid='".$sid."'");
	if($tp=='p'):
		include($staticvars['local_root'].'modules/shopping/system/paypal.php');
	elseif($tp=='t'):
		include($staticvars['local_root'].'modules/shopping/system/transferencia.php');
	elseif($tp=='v'):
		include($staticvars['local_root'].'modules/shopping/system/visa.php');
	elseif($tp=='ctt'):
		include($staticvars['local_root'].'modules/shopping/system/ctt.php');
	endif;
else:
?>
<form action="" method="post" class="form">
  <table width="100%" border="0" cellpadding="4" cellspacing="0">
    <tbody>
      <tr>
        <th colspan="4" align="left">Informa&ccedil;&atilde;o do N&uacute;mero de Contribuinte</th>
      </tr>
      <tr>
        <td colspan="3" align="right">Por favor indique o n&uacute;mero de contribuinte para a factura:</td>
        <td><input class="text" name="customer_note" size="15" maxlength="50" value="" type="text" />
          <br /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <!-- Customer Information -->
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr >
        <th colspan="2" align="left">Informa&ccedil;&atilde;o de Cobran&ccedil;a</th>
      </tr>
      <tr>
        <td width="10%" align="right" nowrap="nowrap">Empresa: </td>
        <td width="90%"><?=$conta[0][2];?></td>
      </tr>
      <tr>
        <td width="10%" align="right" nowrap="nowrap">Nome Completo: </td>
        <td width="90%"><?=$conta[0][4].' '.$conta[0][3];?> </td>
      </tr>
      <tr>
        <td width="10%" align="right" nowrap="nowrap">Morada: </td>
        <td width="90%"><?=$conta[0][0];?><br /><?=$conta[0][1];?></td>
      </tr>
      <tr>
        <td width="10%" align="right" nowrap="nowrap">&nbsp;</td>
        <td width="90%"> <?=$conta[0][6].','.$conta[0][10].'<br>'.$conta[0][6];?></td>
      </tr>
      <tr>
        <td width="10%" align="right" nowrap="nowrap">Telefone: </td>
        <td width="90%"><?=$conta[0][7];?></td>
      </tr>
      <tr>
        <td width="10%" align="right" nowrap="nowrap">Telemovel: </td>
        <td width="90%"><?=$conta[0][8];?></td>
      </tr>
      <tr>
        <td width="10%" align="right" nowrap="nowrap">Email: </td>
        <td width="90%"> <?=$user[0][1];?> </td>
      </tr>
      <tr>
        <td colspan="2" align="center"><a href="<?=session('index.php?id='.$c_cliente);?>"> (Actualizar
            morada)</a></td>
      </tr>
  </table>
  <!-- customer information ends -->
  <br />
  <!-- Customer Ship To -->
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr >
        <th colspan="2" align="left">Informa&ccedil;&atilde;o de Envio : </th>
      </tr>
      <tr>
        <td colspan="2"> Adicionar uma nova <a href="<?=session('index.php?id='.$addr);?>"> Morada
            para envio</a>. </td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tbody>
            <tr class="sectiontableentry1">
              <td><input name="ship_to_info_id" value="ac21dfcf67491be045c561db2d13e949" checked="checked" type="radio" /></td>
              <td> - Por defeito (igual ao de factura&ccedil;&atilde;o) </td>
            </tr>
          </tbody>
        </table></td>
      </tr>
  </table>
  <!-- END Customer Ship To -->
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
    <tbody>
      <tr>
        <td colspan="2"><br />
          <br />
          <strong>M&eacute;todo de pagamento</strong></td>
      </tr>
      <tr>
        <td colspan="2">
          <input class="text" name="payment_method_id" id="Transfer&ecirc;ncia banc&aacute;ria (acresce 5&euro; de portes)" value="t" type="radio" /> 
          Transfer&ecirc;ncia banc&aacute;ria (acresce 5&#8364; de portes)<br />
          <input class="text" name="payment_method_id" id="CTT Cobran&ccedil;a" value="ctt" type="radio" /> 
          CTT Cobran&ccedil;a<br />
          <input class="text" name="payment_method_id" id="Cart&atilde;o de Cr&eacute;dito Visa / MasterCard" value="v" type="radio" />
          Cart&atilde;o de Cr&eacute;dito Visa / Mastercard<br>
          <input class="text" name="payment_method_id" id="Cart&atilde;o de Cr&eacute;dito (PayPal)" value="p" checked="checked" type="radio" />
          PayPal<br /></td>
      </tr>
    </tbody>
  </table>
  <br />
  <br />
  <div align="center"> <strong>Insira uma nota juntamente com a sua encomenda, se achar necess&aacute;rio:</strong><br />
    <textarea class="text" title="Insira uma nota juntamente com a sua encomenda, se achar necess&aacute;rio" cols="50" rows="5" name="nota"></textarea>
  </div>
  <br />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td><div align="center">
          <input class="button" name="order_details" value="Pr&oacute;ximo &gt;&gt;" type="submit" />
        </div></td>
      </tr>
    </tbody>
  </table>
</form>
<?php
endif;
?>