<?php
/*
File revision date: 22-nov-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;
?>

<img src="<?=$staticvars['site_path'];?>/modules/shopping/images/listagem_encomendas.gif" width="179" height="43" alt="Listagem de encomendas">
<br />
<?php
include_once($staticvars['local_root'].'modules/shopping/system/encomendas.funcs.php');
if(isset($_GET['order'])):
	$order=mysql_escape_string($_GET['order']);
	$query=$db->getquery("select data, estado, processado from shopping_encomendas where cod_encomenda='".$order."'");
	if($query[0][0]<>''):
		if(isset($_POST['estado'])):
			$notas=mysql_escape_string($_POST['notas']);
			$estado=mysql_escape_string($_POST['estado']);
			$db->setquery("update shopping_encomendas set estado='".$estado."', prcessado='".$notas."' where cod_encomenda='".$order."'");
			echo '<font color="#FF0000">Nota de Encomenda processada.</font>';
		endif;
		encomenda_detalhada($staticvars);
		?>
        <img src="<?=$staticvars['site_path'];?>/modules/shopping/images/processar_enc.gif" width="141" height="36" alt="Processar encomenda">
        <form class="form" action="<?=$_SERVER['REQUEST_URI'];?>" method="get" name="enc_state"><div align="left">
        mudar estado para: <select class="text" name="estado">
          <option <? if($query[0][1]=='c'){ echo 'selected'; }?> value="c">Cancelada</option>
          <option <? if($query[0][1]=='p'){ echo 'selected'; }?> value="p">Em processamento</option>
          <option <? if($query[0][1]=='e'){ echo 'selected'; }?> value="e">Enviada</option>
          <option <? if($query[0][1]=='cc'){ echo 'selected'; }?> value="cc">Concluida</option>
        </select><br>
		Notas:<br>
        <textarea class="text" name="notas" cols="35" rows="6" wrap="virtual"><?=$query[0][2];?></textarea>
        <br><br>
        <table width="100%" border="0">
          <tr>
            <td width="42"><img src="<?=$staticvars['site_path'];?>/modules/shopping/images/alerta.gif" width="42" height="41" alt="Alerta"></td>
            <td>
                Ser&aacute; enviado um email de confirma&ccedil;&atilde;o de processamento
                da encomenda<br>
                N&atilde;o esque&ccedil;er de imprimir a ordem de encomenda atrav&eacute;s
                dos  bot&otilde;es respectivos bot&otilde;es (ver acima)</td>
          </tr>
        </table>
		</div>
		<div align="right"><input name="submit" class="button" type="button" value="Gravar"></div>
        </form>
        <?php
	else:
		historico_encomendas_admin($staticvars);
	endif;
else:
	historico_encomendas_admin($staticvars);
endif;

function historico_encomendas_admin($staticvars){
include($staticvars['local_root'].'kernel/staticvars.php');
setlocale(LC_CTYPE, 'portuguese');
setlocale(LC_TIME, 'portuguese');
$estado['c']='cancelada';
$estado['p']='em processamento';
$estado['e']='enviada';
$estado['cc']='concluida';
if(isset($_GET['show'])):
	$many='';
else:
	$many='limit 1,3';
endif;
if(!include($staticvars['local_root'].'modules/shopping/system/settings.php')):
	$list_max_posts=10;
endif;
include_once($staticvars['local_root'].'modules/shopping/system/functions.php');

$query=$db->getquery("select cod_encomenda, data, total, sid, tipo_pagamento, portes, processado, estado from shopping_encomendas where estado='".$view_state."' ".$many);
if($query[0][0]<>''):
	$ecomendas=return_id("encomendas_management.php");
	echo '<table width="100%" border="0" cellpadding="4" cellspacing="1">';
	$color='rgb(240, 240, 240)';
	$total=(count($query)-1)>$list_max_posts ? intval(count($query)/$list_max_posts): (count($query)-1);// list_max_posts  posts per page
	if(isset($_GET['page'])):
		$page= is_numeric($_GET['page'])? $_GET['page'] : 1;
	else:
		$page=1;
	endif;
	$page_selection=select_page($page,$total,$_SERVER['REQUEST_URI']);// page starts at 1 not at 0
	$page--;
	$lower=$page*$list_max_posts;
	$uper=($lower+$list_max_posts)>(count($query)-1)? count($query)-1 : ($lower+$list_max_posts);
	for($i=$lower;$i<=$uper;$i++):
		$data=strftime('%A, %d %B %Y',$query[$i][1]);
		$estado=$estado[$query[$i][7]];// cancelada, em processamento, enviado, concluida
		$order=$query[$i][0];
		$total=$query[$i][2];
		$link=strip_address("order",$_SERVER['REQUEST_URI']).'&order='.$order;
		echo '<tr style="background-color: '.$color.'; cursor: pointer;" onclick="'.$link.'">
			<td><a href="'.$link.'"><img src="'.$staticvars['site_path'].'/modules/shopping/images/goto.png" alt="Siga este link para ver o detalhe da sua encomenda." width="32" align="center" border="0" height="32" />&nbsp;Processar</a><br /></td>
			<td><strong>Data:</strong>'.$data.'<br /><strong>Total <b>(a este total acrescem os portes de envio dos CTT)</b>:</strong> &#8364;'.$total.'</td>
			<td><strong>Estado:</strong>'.$estado.'<br /><strong>Número de Encomenda:</strong>'.$order.'</td>
		</tr>';
		$color= is_odd($i) ? 'rgb(249, 249, 249)' : 'rgb(240, 240, 240)';
	endfor;
	if(isset($_GET['show'])):
		echo $page_selection;
	else:
		echo '<br> Ver todas as encomendas <a href="'.strip_address("show",$_SERVER['REQUEST_URI']).'&show"><img src="'.$staticvars['site_path'].'/modules/shopping/images/forward.png" alt="Siga este link para ver todas as encomendas." width="16" border="0" height="16" /></a>';
	endif;
else:
	echo 'Nao tem encomendas para processar';
endif;
};
?>
