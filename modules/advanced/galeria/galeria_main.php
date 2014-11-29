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
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/galeria/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/galeria/language/pt.php');
else:
	include($staticvars['local_root'].'modules/galeria/language/'.$lang.'.php');
endif;

$task=@$_GET['id'];
if (isset($_GET['cod'])): // 1 produto definido
	$cod=mysql_escape_string($_GET['cod']);
	$prod=$db->getquery("select titulo, descricao, short_descricao, imagem, preco, cod_desconto, cod_iva, stock, prazo_entrega, ref_produto, cod_categoria,cod_galeria, catalogo active from galeria where cod_galeria='".$cod."' and active='s'");
	if ($prod[0][0]<>''):
		list_on_product($staticvars['local_root'],$cod,$prod,$pmo);
	else:
		general_product_listing($staticvars['local_root'],$pmg);
	endif;
else: // listagem de galeria
	general_product_listing($staticvars['local_root'],$pmg);
endif;

function list_on_product($staticvars['local_root'],$cod,$prod,$pmo){
include($staticvars['local_root'].'kernel/staticvars.php');
if ($prod[0][12]<>'' and $prod[0][12]<>'no_cat' and is_file($upload_directory.'galeria/catalogo/'.$prod[0][12])):
	include($staticvars['local_root'].'kernel/initialize_download.php');
	$catalogo='        <STRONG>'.$pmo[9].': </STRONG>'.initialize_download('galeria/catalogo/'.$prod[0][12]).'<br>';
else:
	$catalogo='';
endif;
if($prod[0][3]<>'' and $prod[0][3]<>'no_img.jpg'):
	$img=$upload_path.'/galeria/images/'.$prod[0][3];
	$full_img=$upload_path.'/galeria/images/original/'.$prod[0][3];
	$img='<a href="'.$full_img.'" target="_blank"><img alt="'.$prod[0][0].'" src="'.$img.'" border="0" width="100" /><br>'.$pmo[0].'</a>';
else:
	$img=$staticvars['site_path'].'/modules/galeria/images/no_img.jpg';
	$img='<img alt="'.$prod[0][0].'" src="'.$img.'" border="0" width="100" />';
endif;
// optimize 
$desconto=$db->getquery("select valor from galeria_desconto where cod_desconto='".$prod[0][5]."'");
$iva=$db->getquery("select valor,descricao from galeria_iva where cod_iva='".$prod[0][6]."'");
// optimize please!!!!
if($desconto[0][0]<>'0€' and $desconto[0][0]<>'0%'):
	if (strpos("-".$desconto[0][0],"%")):
		$desconto=explode("%",$desconto[0][0]);
		$poupa=round($prod[0][4]*($desconto[0]/100),0);
		$preco=$prod[0][4]-$poupa;
	else:
		$desconto=explode("€",$desconto[0][0]);
		$preco=$prod[0][4]-$desconto[0];
		$poupa=$desconto[0];
	endif;
		$preco='<SPAN style="COLOR: red"><STRIKE>&euro;'.$prod[0][4].'</STRIKE></SPAN><br /><strong>'.$preco.' ('.$iva[0][1].')</strong><br />'.$pmo[1].' &euro;'.$poupa;
else:
	$preco='&euro;'.$prod[0][4].' ('.$iva[0][1].')';
endif;
?>
<TABLE border=0>
  <TBODY>
    <TR>
      <TD vAlign=top align=middle rowSpan=4><br><?=$img;?><br><br></TD>
      <TD width="20" rowspan="5">&nbsp;</TD>
      <TD><H1><?=$prod[0][0];?></H1></TD>
    </TR>
    <TR>
      <TD><br></TD>
    </TR>
    <TR>
      <TD><?=$preco;?></TD>
    </TR>
    <TR style="FONT-STYLE: normal">
      <TD><hr size="1" color="#006600" />
          <div align=justify><?=$prod[0][1];?>
            <br>
            <STRONG><?=$pmo[2];?></STRONG><br>
          </DIV>
        <br></TD>
    </TR>
    <TR>
      <TD>
      <?php
	  /*
      <U><STRONG><?=$pmo[3];?></STRONG></U><br>
          <br>
        <STRONG><?=$pmo[10];?> 
          <? //$pmo[4];?> </STRONG><? //$prod[0][7];?><br>
        <br> 
		*/
		?>
        <STRONG><?=$pmo[5];?>: </STRONG><?=$prod[0][8];?> (<?=$pmo[6];?>)<br>
        <br>
		<?=$catalogo;?></TD>
      <TD><br></TD>
    </TR>
    <TR>
      <TD colSpan=3></TD>
    </TR>
    <TR>
      <TD colSpan=3><hr size="1" color="#006600" /></TD>
    </TR>
  </TBODY>
</TABLE>
<?php
};

function search_products($staticvars['local_root']){
	function normalize($text){
	// eliminates special characters and convert to lower case a text string
		$dim=array("&ccedil;","&ccedil;");
		$text = str_replace($dim, "c", $text);
	
		$dim=array("&atilde;","&aacute;","à","â","&atilde;","&aacute;","À","Â");
		$text = str_replace($dim, "a", $text);
	
		$dim=array("é","ê","Ê","É");
		$text = str_replace($dim, "e", $text);
	
		$dim=array("í","Í");
		$text = str_replace($dim, "i", $text);
	
		$dim=array("&otilde;","ó","ô","&otilde;","Ó","Ô");
		$text = str_replace($dim, "o", $text);
	
		$text=strtolower($text);
	return $text;
	};


include($staticvars['local_root'].'kernel/staticvars.php');
$searching[0][0]='';

if(isset($_POST['quick_search'])):
	$search_query=$_POST['quick_search'];
	$res=$db->getquery("select titulo, descricao, short_descricao, imagem, preco, cod_desconto, cod_iva, stock, prazo_entrega, ref_produto, cod_categoria,cod_galeria, active from galeria");
elseif(isset($_POST['adv_search'])):
	$search_query=$_POST['adv_search'];
	if($_POST['pfrom']<>'' and is_numeric($_POST['pfrom'])):
		$strings='where preco>='.mysql_escape_string($_POST['pfrom']);
		if($_POST['pto']<>'' and is_numeric($_POST['pto'])):
			$strings.= ' and preco<'.mysql_escape_string($_POST['pto']);
		endif;
		if($_POST['categories']<>'TODAS'):
			$strings.=' and cod_categoria='.mysql_escape_string($_POST['categories']);
		endif;
	elseif($_POST['pto']<>'' and is_numeric($_POST['pto'])):
		$strings.= 'where preco<'.mysql_escape_string($_POST['pto']);
			if($_POST['categories']<>'TODAS'):
				$strings.=' and cod_categoria='.mysql_escape_string($_POST['categories']);
			endif;
	elseif($_POST['categories']<>'TODAS'):
		$strings='where cod_categoria='.mysql_escape_string($_POST['categories']);
	endif;
	$res=$db->getquery("select titulo, descricao, short_descricao, imagem, preco, cod_desconto, cod_iva, stock, prazo_entrega, ref_produto, cod_categoria,cod_galeria, active from galeria ".$strings);	
endif;
if ($res[0][0]<>''):
	// efectuar as pesquisa no directorio
	for($k=0;$k<count($res);$k++): // for each query entry
		$j=0;
		$t=0;
		while($j<3): // for each field table until the first find
			$isit='';
			$isit=@strpos(normalize($res[$k][$j]),normalize($search_query));
			if ($isit <> ''): // string match found
				$searching[$t]=$res[$k]; // store all the fields 
				$t++;
				$j=100;
			endif;
			$j++;
		endwhile;
	endfor;
endif;
return $searching;
};

function general_product_listing($staticvars['local_root'],$pmg) {
include($staticvars['local_root'].'kernel/staticvars.php');
if(isset($_GET['orderby'])):
	if ($_GET['orderby']=='asc'):
		$orderby='ASC';
		$order_img=$staticvars['site_path'].'/modules/galeria/images/sort_asc.png';
		$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=ASC';
		$order_txt=$pmg[2];
	else:
		$orderby='DESC';
		$order_img=$staticvars['site_path'].'/modules/galeria/images/sort_desc.png';
		$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=DESC';
		$order_txt=$pmg[3];
	endif;
else:
	$orderby='ASC';
	$order_img=$staticvars['site_path'].'/modules/galeria/images/sort_asc.png';
	$order_href=strip_address('orderby',$_SERVER['REQUEST_URI']).'&orderby=ASC';
	$order_txt=$pmg[2];
endif;

if(isset($_POST['field_orderby'])):
	if ($_POST['field_orderby']=='name'):
		$order=' order by titulo '.$orderby;
	elseif ($_POST['field_orderby']=='price'):
		$order=' order by preco '.$orderby;
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

if(isset($_POST['quick_search'])):
	$prod=search_products($staticvars['local_root']);
	$header='  <h3><img src="'.$staticvars['site_path'].'/modules/galeria/images/icon.gif" width="37" height="34" align="absbottom" />'.$pmg[0].'</h3>';
elseif(isset($_POST['adv_search'])):
	$prod=search_products($staticvars['local_root']);
	$header='  <h3><img src="'.$staticvars['site_path'].'/modules/galeria/images/icon.gif" width="37" height="34" align="absbottom" />'.$pmg[0].'</h3>';
elseif(isset($_GET['cat'])):
	$header='  <h3><img src="'.$staticvars['site_path'].'/modules/galeria/images/icon.gif" width="37" height="34" align="absbottom" />'.$pmg[1].'</h3>';
	$prod=$db->getquery("select titulo, descricao, short_descricao, imagem, preco, cod_desconto, cod_iva, stock, prazo_entrega, ref_produto, cod_categoria,cod_galeria, active from galeria where active='s' and cod_categoria='".mysql_escape_string($_GET['cat'])."'".$order);
else:
	$header='  <h3><img src="'.$staticvars['site_path'].'/modules/galeria/images/icon.gif" width="37" height="34" align="absbottom" />'.$pmg[1].'</h3>';
	$prod=$db->getquery("select titulo, descricao, short_descricao, imagem, preco, cod_desconto, cod_iva, stock, prazo_entrega, ref_produto, cod_categoria,cod_galeria, active from galeria where active='s' ".$order);
endif;

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

	echo $header;
?>
<form name="order" action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
    <table border="0">
      <tr>
        <td><?=$pmg[8];?>:
          <select class="form_input" onchange="order.submit()" name="field_orderby">
            <option value="name" <? if(@$_POST['field_orderby']<>'name' and @$_POST['field_orderby']<>'price'){ echo 'selected="selected"'; };?>><?=$pmg[10];?></option>
            <option value="name" <? if(@$_POST['field_orderby']=='name' ){ echo 'selected="selected"'; };?>><?=$pmg[11];?></option>
            <option value="price" <? if(@$_POST['field_orderby']=='price' ){ echo 'selected="selected"'; };?>><?=$pmg[12];?></option>
          </select></td>
        <td width="12"><a href="<?=$order_href;?>"><img height="12" alt="<?=$order_txt;?>" src="<?=$order_img;?>" width="12" border="0" /></a></td>
        <td><?=$pmg[9];?> #&nbsp;&nbsp;
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
	$desconto=$db->getquery("select cod_desconto, valor from galeria_desconto");
	for($i=0;$i<count($desconto);$i++):
		$descontos[$i]=$desconto[$i][0];
		$desc_valor[$i]=$desconto[$i][1];
	endfor;
	$descontos[]='end';
	$iva=$db->getquery("select cod_iva,descricao from galeria_iva");
	for($i=0;$i<count($iva);$i++):
		$ivas[$i]=$iva[$i][0];
		$iva_valor[$i]=$iva[$i][1];
	endfor;
	for ($i=($lower-1);$i<=$up;$i++):
		if($prod[$i][3]<>'' and $prod[$i][3]<>'no_img.jpg'):
			$img=$upload_path.'/galeria/images/'.$prod[$i][3];
			$full_img=$upload_path.'/galeria/images/original/'.$prod[$i][3];
			$img='<a href="'.$full_img.'" target="_blank"><img alt="'.$prod[$i][0].'" src="'.$img.'" border="0" width="100" /></a>';
		else:
			$img=$staticvars['site_path'].'/modules/galeria/images/no_img.jpg';
			$img='<img alt="'.$prod[$i][0].'" src="'.$img.'" border="0" width="100" />';
		endif;
		// desconto	
		if (in_array($prod[$i][5],$descontos)):
			$desconto=$desc_valor[array_search($prod[$i][5],$descontos)];
		else:
			$desconto='0€';
		endif;
		//iva
		if (in_array($prod[$i][6],$ivas)):
			$iva=$iva_valor[array_search($prod[$i][6],$ivas)];
		else:
			$iva='ERROR';
		endif;
		if($desconto<>'0€' and $desconto<>'0%'):
			if (strpos("-".$desconto,"%")):
				$desconto=explode("%",$desconto);
				$poupa=round($prod[$i][4]*($desconto[0]/100),0);
				$preco=$prod[$i][4]-$poupa;
			else:
				$desconto=explode("€",$desconto);
				$preco=$prod[$i][4]-$desconto[0];
				$poupa=$desconto[0];
			endif;
				$preco='<SPAN style="COLOR: red"><STRIKE>&euro;'.$prod[$i][4].'</STRIKE></SPAN><br /><strong>'.$preco.' ('.$iva.')</strong><br />'.$pmg[7].' &euro;'.$poupa;
		else:
			$preco='&euro;'.$prod[$i][4].' ('.$iva.')';
		endif;
		
		?>
		<table width="100%" border="0">
		  <tr>
			<td width="9%" rowspan="5" valign="top"><?=$img;?><br /></td>
			<td width="91%"><strong><a style="FONT-WEIGHT: bold; FONT-SIZE: 16px;color:#000000" href="<?=session($staticvars,'index.php?id='.return_id('galeria_main.php').'&cod='.$prod[$i][11]);?>"><?=normalize_chars($prod[$i][0]);?></a></strong></td>
		  </tr>
		  <tr>
			<td align="justify"><?=normalize_chars($prod[$i][2]);?></td>
		  </tr>
		  <tr>
			<td align="justify"><a style="color:#000000" href="<?=session($staticvars,'index.php?id='.return_id('galeria_main.php').'&cod='.$prod[$i][11]);?>"><?=$pmg[6];?></a></td>
		  </tr>
		  <tr>
			<td align="justify"><div align="justify"><?=$preco;?></div></td>
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
	if(isset($_POST['quick_search']) or isset($_POST['adv_search'])):
		echo '<table width="500" border="0"><tr><td>'.$pmg[4].'</td></tr></table>';
	else:
		echo '<table width="500" border="0"><tr><td>'.$pmg[5].'</td></tr></table>';
	endif;
endif;

};

function put_previous_next_page($lower,$upper,$total,$link){
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/galeria/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/galeria/language/pt.php');
else:
	include($staticvars['local_root'].'modules/galeria/language/'.$lang.'.php');
endif;


if ($lower==1 ):
  	$p_antes='<font class="body_text" ><font color="#999999">'.$pnp[0].'</font></font>';
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
  	$p_antes='<font class="body_text"><a href="'.$link.'&lower='.$lower_a.'&upper='.$upper_a.'"><font color="#000000">'.$pnp[0].'</font></a></font>';
endif;
if ($upper>=$total ):
	$p_depois='<font class="body_text" ><font color="#999999">'.$pnp[1].'</font></font>';
endif;
if ($upper<$total):
	$lower_d=$lower+5;
	$upper_d=$upper+5;
	if ($upper_d>$total):
		$upper_d=$total;
	endif;
	$p_depois='<font class="body_text"><a href="'.$link.'&lower='.$lower_d.'&upper='.$upper_d.'"><font color="#000000">'.$pnp[1].'</font></a></font>';
endif;
if ($upper<$total and $lower<>1 ):
	echo '<div align="right">'.$p_antes.'<font class="body_text" color="#000000"> | </font>'.$p_depois.'</div>';
endif;
};

?>
