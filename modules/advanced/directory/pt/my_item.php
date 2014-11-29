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
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
if (isset($_POST['del'])):
	$db->setquery("delete from items where cod_item='".mysql_escape_string($_POST['del'])."'");
	echo '<font class="body_text"> <font color="#FF0000">item Apagado!</font></font><br>';
endif;
$add_item=return_id('ds_add_item.php');
$user=$db->getquery("select cod_user from users where nick='".mysql_escape_string($_SESSION['user'])."'");
$query=$db->getquery("select cod_item, titulo, cod_category from items where cod_user='".$user[0][0]."'");
if ($query[0][0]<>''):
	$kl=0;
	for ($l=0;$l<count($query);$l++):
		$cat_name=$db->getquery("select name from category where cod_category='".$query[$l][2]."'");
		if (!isset($contentor[$cat_name[0][0]])):
			$contentor[$cat_name[0][0]][0]=$query[$l][1];
			$content_code[$cat_name[0][0]][0]=$query[$l][0];
			$lista[$kl]['name']=$cat_name[0][0];
			$kl++;
		else:
			$contentor[$cat_name[0][0]][count($contentor[$cat_name[0][0]])]=$query[$l][1];
			$content_code[$cat_name[0][0]][count($content_code[$cat_name[0][0]])]=$query[$l][0];
		endif;
	endfor;
endif;
$address=strip_address($staticvars['local_root'],'mod',$_SERVER['REQUEST_URI']);
?>
<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/modules/directory/system/dtree.css" type="text/css" />
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/modules/directory/system/dtree.js"></script>
<font class="header_text_3">Gest&atilde;o de Conte&uacute;dos   </font>
<br>
<table border="0" cellpadding="3" width="100%">
	 <tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/versele.gif" alt="vara&ccedil;&atilde;o de conte&uacute;dos" width="30" height="33" /></td>
		<td valign="bottom" class="header_text_2"><p>Aqui pode ver quais s&atilde;o os conte&uacute;dos que tem publicados.</p></td>
	</tr>
</table>
<table width="100%" border="0" cellPadding="15" cellSpacing="0">
<tr>
  <td>
	<div class="dtree">
		<hr class="gradient">
		<div align="center"><a href="<?=session($staticvars,'index.php?id='.$add_item.'&type=documentos');?>" target="_self"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/flash.gif" width="16" height="16" />&nbsp;Adicionar</a></div>
		<br>
		<br>
		<? include($staticvars['local_root'].'modules/directory/'.$lang.'/my_item_iframe.php');?>
		<hr class="gradient">
		<?php
		if ($query[0][0]<>''):
		
		?>
			<a href="javascript: d.openAll();"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/clip_check.gif" width="15" height="12" />&nbsp;Abrir conteúdos</a> | <img src="<?=$staticvars['site_path'];?>/modules/directory/images/cancel.gif" width="13" height="12" />&nbsp;<a href="javascript: d.closeAll();">Fechar conteúdos</a><br /><br />
			<script type="text/javascript">
				<!--
				<?php
				$j=1;
				echo "d = new dTree('d');
				";
				echo "d.add(0,-1,'Os meus programas / documentos publicados');
				";
				for($l=0; $l<count($lista);$l++):
					echo "d.add($j,0,'".$lista[$l]['name']."','');
					";
					$j++;
					for($k=0;$k<count($contentor[$lista[$l]['name']]);$k++):
						echo "d.add(".($j+$k).",".($j-1).",'".$contentor[$lista[$l]['name']][$k]."','".$address.'&mod='.$content_code[$lista[$l]['name']][$k]."','','_self');
						";
					endfor;
					$j=$j+count($contentor[$lista[$l]['name']]);
				endfor;
				?>
		
				document.write(d);
				//-->
			</script>
			<?php
		else:
			echo '<br><br>Não tem plublicações de conteúdos!';
		endif;
		?>
	</div>		  
  </td>
</tr>
</table>
