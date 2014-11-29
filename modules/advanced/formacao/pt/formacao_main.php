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
$task=@$_GET['id'];
if (isset($_GET['cod'])): // 1 produto definido
	$cod=mysql_escape_string($_GET['cod']);
	$prod=$db->getquery("select titulo, descricao, objectivos, conteudos, regalias, destinatarios, idade, data_inicio, horario, duracao, local, habilitacoes, cod_categoria, active from formacao_curso where cod_curso='".mysql_escape_string($_GET['cod'])."'");
	if ($prod[0][0]<>''):
		list_on_product($staticvars['local_root'],$cod,$prod);
	else:
		general_product_listing($staticvars['local_root']);
	endif;
else: // listagem de produtos
	general_product_listing($staticvars['local_root']);
endif;

function list_on_product($staticvars['local_root'],$cod,$prod){
include($staticvars['local_root'].'kernel/staticvars.php');
?>
<h3>Detalhes do curso
</h3>
<table width="100%" border="0">
  <tr>
    <td width="19%" valign="top">&nbsp;</td>
    <td width="81%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="ftitulo">T&iacute;tulo:<br />
    </font></strong></td>
    <td><br />
    <?=$prod[0][0];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fdescricao">Breve Descri&ccedil;&atilde;o:</font></strong></td>
    <td><br />
    <?=$prod[0][1];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fobjectivos">Objectivos:</font></strong></td>
    <td><br />
    <?=$prod[0][2];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fconteudos">Conte&uacute;dos program&aacute;ticos:</font></strong></td>
    <td><br />
    <?=$prod[0][3];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fregalias">Regalias:</font></strong></td>
    <td align="left"><br />
    <?=$prod[0][4];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fdestinatarios">Destinat&aacute;rios&nbsp;:</font></strong></td>
    <td align="left"><br />
    <?=$prod[0][5];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fidade">Idade m&iacute;nima&nbsp;:</font></strong></td>
    <td align="left"><br />
    <?=$prod[0][6];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fdata_inicio">Data Inicio&nbsp;:</font></strong></td>
    <td align="left"><br />
    <?=$prod[0][7];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fhorario">Hor&aacute;rio:</font></strong></td>
    <td align="left"><br />
    <?=$prod[0][8];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><font id="fduracao">Dura&ccedil;&atilde;o:</font></strong></td>
    <td align="left"><br />
    <?=$prod[0][9];?></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Local:</strong></td>
    <td align="left"><br />
    <?=$prod[0][10];?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>habilita&ccedil;&otilde;es:</strong></td>
    <td align="left"><br />
    <?=$prod[0][11];?></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<?php
};

function general_product_listing($staticvars['local_root']) {
include($staticvars['local_root'].'kernel/staticvars.php');
if(isset($_GET['orderby'])):
	if ($_GET['orderby']=='asc'):
		$orderby='ASC';
		$order_img=$staticvars['site_path'].'/modules/formacao/images/sort_asc.png';
		$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=ASC';
	else:
		$orderby='DESC';
		$order_img=$staticvars['site_path'].'/modules/formacao/images/sort_desc.png';
		$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=DESC';
	endif;
else:
	$orderby='ASC';
	$order_img=$staticvars['site_path'].'/modules/formacao/images/sort_asc.png';
	$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=ASC';
endif;

if(isset($_POST['field_orderby'])):
	if ($_POST['field_orderby']=='name'):
		$order=' order by titulo '.$orderby;
	elseif ($_POST['field_orderby']=='cod_categoria'):
		$order=' order by cod_categoria '.$orderby;
	else:
		$order=' order by titulo '.$orderby;
	endif;
else:
	$order=' order by titulo '.$orderby;
endif;

if(isset($_POST['limit'])):
	if ($_POST['limit']=='5'):
		$limit=5;
	elseif ($_POST['limit']=='10'):
		$limit=10;
	elseif ($_POST['limit']=='15'):
		$limit=15;
	elseif ($_POST['limit']=='20'):
		$limit=20;
	elseif ($_POST['limit']=='25'):
		$limit=25;
	elseif ($_POST['limit']=='30'):
		$limit=30;
	else:
		$limit=50;
	endif;
else:
	$limit=50;
endif;


$prod=$db->getquery("select titulo, descricao, objectivos, conteudos, regalias, destinatarios, idade, data_inicio, horario, duracao, local, habilitacoes, cod_categoria, active, cod_curso from formacao_curso ".$order);
if($prod[0][0]<>''):
	$total=count($prod);
	$lower=@$_GET['lower'];
	$upper=@$_GET['upper'];
	if ($lower==''):
		$lower=1;
	endif;
	if ($upper==''):
		$upper=5;
	endif;
	$up=$upper;
?>
<h3>Procurar cursos</h3>
<form name="order" action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
    <table border="0">
      <tr>
        <td>Ordenar Por:
          <select class="form_input" onchange="order.submit()" name="field_orderby">
            <option value="name" <? if(@$_POST['field_orderby']<>'name' and @$_POST['field_orderby']<>'cod_categoria'){ echo 'selected="selected"'; };?>>Seleccionar</option>
            <option value="name" <? if(@$_POST['field_orderby']=='name' ){ echo 'selected="selected"'; };?>>Nome do Produto</option>
            <option value="cod_categoria" <? if(@$_POST['field_orderby']=='cod_categoria' ){ echo 'selected="selected"'; };?>>Tipo de curso</option>
          </select></td>
        <td width="12"><a href="<?=$order_href;?>"><img title="Descending order" height="12" alt="Descending order" src="<?=$order_img;?>" width="12" border="0" /></a></td>
        <td>Mostrar #&nbsp;&nbsp;
          <select class="form_input" onchange="order.submit()" size="1" name="limit">
            <option value="5" <? if(@$_POST['limit']=='5' ){ echo 'selected="selected"'; };?>>5</option>
            <option value="10" <? if(@$_POST['limit']=='10' ){ echo 'selected="selected"'; };?>>10</option>
            <option value="15" <? if(@$_POST['limit']=='15' ){ echo 'selected="selected"'; };?>>15</option>
            <option value="20" <? if(@$_POST['limit']=='20' ){ echo 'selected="selected"'; };?>>20</option>
            <option value="25" <? if(@$_POST['limit']=='25' ){ echo 'selected="selected"'; };?>>25</option>
            <option value="30" <? if(@$_POST['limit']=='30' ){ echo 'selected="selected"'; };?>>30</option>
            <option value="50" <? if(@$_POST['limit']=='50' or $limit==50 ){ echo 'selected="selected"'; };?>>50</option>
          </select></td>
      </tr>
    </table>
</form>
<?php
put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
?>
<hr size="1" color="#006600" />
<?
	if ($up > ($total-1)):
		$up=($total-1);
	endif;
	for ($i=($lower-1);$i<=$up;$i++):
		?>
		<table width="100%" border="0">
		  <tr>
			<td width="91%"><strong><a style="FONT-WEIGHT: bold; FONT-SIZE: 16px;color:#999999" href="<?=session($staticvars,$_SERVER['REQUEST_URI'].'&cod='.$prod[$i][11]);?>"><?=$prod[$i][0];?></a></strong></td>
		  </tr>
		  <tr>
			<td align="justify"><?=$prod[$i][1];?></td>
		  </tr>
		  <tr>
			<td align="justify"><a style="color:#999999" href="<?=session($staticvars,$_SERVER['REQUEST_URI'].'&cod='.$prod[$i][14]);?>">Detalhes do curso</a></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		</table>
<hr size="1" color="#006600" />
	<?php
	endfor;
	put_previous_next_page($lower,$upper,$total,$_SERVER['REQUEST_URI']);
else:
	echo '<table width="500" border="0"><tr><td>De momento n&atilde;o h&aacute; cursos dispon&iacute;veis. Tente mais tarde.</td></tr></table>';
endif;

};

function put_previous_next_page($lower,$upper,$total,$link){
if ($lower==1 ):
  	$p_antes='<font class="body_text" ><font color="#999999">P&aacute;g. Anterior</font></font>';
endif;
if ($lower<>1):
  	$lower_a=$lower-5;
  	if ($lower_a<1):
		$lower_a=1;
	endif;
	$upper_a=$upper-5;
	if ($upper_a<1):
		$upper_a=$upper-$upper_a;
	endif;
	if ($upper_a==1 && $lower_a==1):
		$upper_a=5;
	endif;
  	$p_antes='<font class="body_text"><a href="'.$link.'&lower='.$lower_a.'&upper='.$upper_a.'"><font color="#000000">P&aacute;g. Anterior</font></a></font>';
endif;
if ($upper>=$total ):
	$p_depois='<font class="body_text" ><font color="#999999">P&aacute;g. seguinte</font></font>';
endif;
if ($upper<$total):
	$lower_d=$lower+5;
	$upper_d=$upper+5;
	if ($upper_d>$total):
		$upper_d=$total;
	endif;
	$p_depois='<font class="body_text"><a href="'.$link.'&lower='.$lower_d.'&upper='.$upper_d.'"><font color="#000000">P&aacute;g. seguinte</font></a></font>';
endif;
echo '<div align="right">'.$p_antes.'<font class="body_text" color="#000000"> | </font>'.$p_depois.'</div>';
};

?>
